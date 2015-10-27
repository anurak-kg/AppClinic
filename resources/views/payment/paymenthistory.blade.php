@extends('layout.master')
@section('title',trans('payment.Payment'))
@section('headText','Payment')
@section('content')

    <div class="row" ng-controller="newPaymentController">

        <div class="col-md-12" ng-init="paymentInit({{\Illuminate\Support\Facades\Input::get('quo_de_id')}})">
            <form method="POST" target="_blank" action="{{url('payment/pay/')}}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="customer_id"
                       value="<?php echo \Illuminate\Support\Facades\Input::get('cus_id') ?>">

                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title">{{trans('payment.Payment')}}
                            รหัสลูกค้า <?php echo \Illuminate\Support\Facades\Input::get('cus_id') ?> </h2>

                        <div class="box-tools pull-right">
                            <a class="btn btn-danger" href="{{url('quotations')}}">กลับสู่หน้าขายคอร์ส / สินค้า</a>

                            <a class="btn btn-warning" href="{{url('payment/print')}}?cus_id={{$customer->cus_id}}">{{trans('payment.Print_receipt')}}</a>

                        </div>
                    </div>

                    <div class="box-body">
                        @if( Session::get('message') != null )
                            <div class="alert alert-success alert-dismissable">
                                <h4><i class="icon fa fa-check"></i> {{Session::get('headTxt')}} !</h4>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        @if(count($quo) != 0)
                            <div class="col-md-9 ">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td style="width: 10px">#</td>
                                        <td>คอร์ส / สินค้า</td>
                                        <td>จำนวน</td>
                                        <td width="20px">เข้ารักษา</td>

                                        <td>{{trans('payment.Supply_Type')}}</td>
                                        <td>{{trans('payment.unpaid')}}</td>
                                        <td width="20px">{{trans('payment.Pay')}}</td>
                                        <td width="150px">{{trans('payment.Amount_paid')}}</td>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $index = 0;?>
                                    @foreach($quo as $item)
                                        <?php
                                        $type = null;
                                        $course_qty = null;
                                        $paidType = null;
                                        $readOnly = false;

                                        if ($item->course_name != null) {
                                            $type = 'course';
                                            $course_qty = $item->course_qty;
                                        } else {
                                            $type = 'product';
                                            $course_qty = 0;
                                        }
                                        if ($item->net_price > $item->payment_remain) {
                                            $paidType = "PAY_BY_COURSE";
                                            $readOnly = true;

                                        } else {
                                            $paidType = "PAID_IN_FULL";
                                        }

                                        ?>
                                        <tr ng-init="init({{$index}},'{{$paidType}}',{{ceil($item->payment_remain)}},'{{$type}}',{{ceil($item->net_price)}},{{$course_qty}},{{$item->quo_de_id}})"
                                            ng-click="trClick({{$index}})"
                                            style="cursor: pointer;"
                                            class="{{(Input::get('quo_de_id') == $item->quo_de_id ? "payment-current-select" : "")}}">
                                            <td>{{$index+1}}</td>
                                            <td>
                                                <strong>
                                                    @if($item->course_name == null)
                                                        {{$item->product_name}}
                                                    @else
                                                        {{$item->course_name}}
                                                    @endif
                                                </strong>
                                                <br>
                                                {{trans('course.price')}} {{numberFormat(ceil($item->net_price))}} {{trans('payment.baht')}}
                                                @if($item->net_price > $item->payment_remain)
                                                    <span style="font-size: 12px;color: red;">{{trans('payment.paid')}} <strong>{{ numberFormat($item->net_price - $item->payment_remain)}} </strong> {{trans('course.price')}}</span>
                                                @endif

                                            </td>


                                            <td align="middle">
                                                @if($item->course_qty == null)
                                                    {{$item->product_qty}}
                                                @else
                                                    {{$item->course_qty}}
                                                @endif
                                                @if($item->product_unit == null)
                                                    {{trans('payment.time')}}
                                                @else
                                                    {{$item->product_unit }}
                                                @endif


                                            </td>
                                            <td>
                                                @if($item->course_name != null)
                                                    {{$item->qty}}
                                                @endif

                                            </td>

                                            <td align="middle" ng-click="$event.stopPropagation()">
                                                @if($type == 'course')
                                                    <select ng-change="changePayType({{$index}})"
                                                            name="type[{{$item->quo_de_id}}]" class="form-control"
                                                            ng-model="product[{{$index}}].paymentType"
                                                            ng-disabled="product[{{$index}}].type == 'product' ">
                                                        @if($readOnly != true)
                                                            <option value="PAID_IN_FULL">{{trans('payment.Pay_in_full')}}</option>
                                                        @endif
                                                        <option value="PAY_BY_COURSE">{{trans('payment.installment')}}</option>
                                                    </select>
                                                @else
                                                    {{trans('payment.Pay_in_full')}}
                                                @endif

                                            </td>


                                            <td>
                                                {{ product[<?php echo $index ;?>].remain  }}

                                            </td>


                                            <td align="middle" ng-click="$event.stopPropagation()">

                                                <input type="checkbox" name="pay[{{$item->quo_de_id}}]"
                                                       ng-model="product[{{$index}}].selected">


                                            </td>

                                            <td ng-click="$event.stopPropagation()">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="value[{{$item->quo_de_id}}]"
                                                               ng-readonly="product[{{$index}}].paymentType == 'PAID_IN_FULL'"
                                                               class="form-control"
                                                               ng-model="product[{{$index}}].paymentPrice">
                                                    </div>
                                                </div>

                                                <p class="minPayment"
                                                   ng-show="product[{{$index}}].paymentType == 'PAY_BY_COURSE' ">
                                                    {{trans('payment.Minimum_balance')}}
                                                    {{ product[<?php echo $index ;?>].minPayment | number }}
                                                    บาท</p>
                                            </td>
                                        </tr>
                                        <?php $index++;?>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="checkbox" ng-model="selectedAll" ng-click="checkAll()"/>
                                            All
                                        </td>
                                        <td>@{{ getTotal() | number }}</td>
                                    </tr>

                                    </tbody>

                                </table>

                            </div>
                            <div class="col-md-3">
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><h4>{{trans('payment.Pay')}}</h4></td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('customer.customer')}}</td>
                                        <td class="total-price">{{$customer->cus_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('payment.Items_paid')}}</td>
                                        <td class="total-price">@{{ getTotalLength() }} {{trans('payment.items')}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('payment.Discount')}}</td>
                                        <td class="total-price">0</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('payment.Total_to_be_paid')}}</td>
                                        <td class="total-price">@{{ getTotal() }} {{trans('payment.baht')}}</td>

                                    </tr>
                                </table>

                                <table class="table">
                                    <tr>
                                        <td colspan="2">{{trans('payment.Supply_Type')}}
                                            <select class="form-control" ng-change="changeType()"
                                                    ng-model="payment.type" name="paymentType">
                                                <option value="CASH">{{trans('payment.cash_payment')}}</option>
                                                <option value="CREDIT">{{trans('payment.credit_payment')}}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">{{trans('payment.bank')}}
                                            <select class="form-control" ng-model="payment.bank_id" name="bank_id">
                                                @foreach($bank as $item)
                                                    <option value="{{$item->bank_id}}">{{$item->bank_name}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">{{trans('payment.Credit_card')}}
                                            <input type="text" class="form-control" name="card_id"
                                                   id="received_amount"
                                                   ng-model="payment.card_id"
                                                   placeholder="เลขที่บัตรเครดดิต">
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">{{trans('payment.EDC_ID')}}
                                            <input type="text" class="form-control"
                                                   id="received_amount" name="edc"
                                                   ng-model="payment.edc"
                                                   placeholder="EDC ID">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            {{trans('payment.cash')}}
                                            <input type="number" class="form-control  total-price input-lg"
                                                   ng-model="payment.receivedAmount"
                                                   id="received_amount" name="receivedAmount" required
                                                   placeholder="เงินที่รับ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('payment.change')}}</td>
                                        <td class="total-price">@{{ getWithdrawn() }} บาท</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button ng-disabled="payment.receivedAmount < getTotal()"
                                                    style="display: block; width: 100%;" ng-click="submit()"
                                                    class="btn btn-success">{{trans('payment.Pay')}}

                                            </button>
                                        </td>
                                    </tr>

                                </table>

                            </div>
                        @else
                            <p class="lead">{{trans('payment.None_overdue')}}.</p>
                        @endif
                    </div>

                </div>
            </form>

        </div>
    </div>
@stop