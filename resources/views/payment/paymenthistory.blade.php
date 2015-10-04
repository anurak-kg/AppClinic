@extends('layout.master')
@section('title','ชำระเงิน')
@section('headText','Payment')
@section('headDes','ชำระเงิน')
@section('content')
    <div class="row" ng-controller="newPaymentController">

        <div class="col-md-12">
            <form method="POST" target="_blank" action="{{url('payment/pay/')}}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="customer_id"
                       value="<?php echo \Illuminate\Support\Facades\Input::get('cus_id') ?>">

                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title">ชำระเงิน เลขที่การสั่งซื้อ #{{$quo[0]->quo_id}}</h2>

                        <div class="box-tools pull-right">
                            <a class="btn btn-danger" href="{{url('quotations')}}">กลับสู่หน้าขายคอร์ส / สินค้า</a>

                            <a class="btn btn-warning" href="{{url('payment/print')}}?cus_id={{$quo->cus_id}}">พิมพ์ใบเสร็จ</a>

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

                                        <td>ประเภทการจ่าย</td>
                                        <td>ยอดค้างจ่าย</td>
                                        <td width="20px">ชำระ</td>
                                        <td width="150px">จำนวนที่จ่าย</td>


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
                                        <tr ng-init="init({{$index}},'{{$paidType}}',{{ceil($item->payment_remain)}},'{{$type}}',{{ceil($item->net_price)}},{{$course_qty}})"
                                            ng-click="trClick({{$index}})" style="cursor: pointer;">
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
                                                ราคารวม {{numberFormat(ceil($item->net_price))}} บาท
                                                @if($item->net_price > $item->payment_remain)
                                                    <span style="font-size: 12px;color: red;">ชำระไปแล้ว <strong>{{ numberFormat($item->net_price - $item->payment_remain)}} </strong> บาท</span>
                                                @endif

                                            </td>


                                            <td align="middle">
                                                @if($item->course_qty == null)
                                                    {{$item->product_qty}}
                                                @else
                                                    {{$item->course_qty}}
                                                @endif
                                                @if($item->product_unit == null)
                                                    ครั้ง
                                                @else
                                                    {{$item->product_unit }}
                                                @endif


                                            </td>
                                            <td>
                                                0
                                            </td>

                                            <td align="middle" ng-click="$event.stopPropagation()">
                                                @if($type == 'course')
                                                    <select ng-change="changePayType({{$index}})"
                                                            name="type[{{$item->quo_de_id}}]" class="form-control"
                                                            ng-model="product[{{$index}}].paymentType"
                                                            ng-disabled="product[{{$index}}].type == 'product' ">
                                                        @if($readOnly != true)
                                                            <option value="PAID_IN_FULL">จ่ายเต็มจำนวน</option>
                                                        @endif
                                                        <option value="PAY_BY_COURSE">ผ่อนจ่าย</option>
                                                    </select>
                                                @else
                                                    จ่ายเต็มจำนวน
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
                                                    ยอดขั้นต่ำ
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
                                        <td colspan="2"><h4>ชำระเงิน</h4></td>
                                    </tr>
                                    <tr>
                                        <td>ลูกค้า</td>
                                        <td class="total-price">{{$customer->cus_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>รายการที่ชำระ</td>
                                        <td class="total-price">@{{ getTotalLength() }} รายการ</td>
                                    </tr>
                                    <tr>
                                        <td>ส่วนลด</td>
                                        <td class="total-price">0</td>
                                    </tr>
                                    <tr>
                                        <td>ยอดที่ต้องชำระ</td>
                                        <td class="total-price">@{{ getTotal() }} บาท</td>

                                    </tr>
                                </table>

                                <table class="table">
                                    <tr>
                                        <td colspan="2">ประเภทการจ่าย
                                            <select class="form-control" ng-change="changeType()"
                                                    ng-model="payment.type" name="paymentType">
                                                <option value="cash">เงินสด</option>
                                                <option value="credit_card">บัตรเครดิต</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">ธนาคาร
                                            <select class="form-control" ng-model="payment.bank_id" name="bank_id">
                                                @foreach($bank as $item)
                                                    <option value="{{$item->bank_id}}">{{$item->bank_name}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">รหัสบัตรเครดิต
                                            <input type="text" class="form-control" name="card_id"
                                                   id="received_amount"
                                                   ng-model="payment.card_id"
                                                   placeholder="เลขที่บัตรเครดดิต">
                                        </td>
                                    </tr>
                                    <tr ng-show="payment.creditCardBox">
                                        <td colspan="2">รหัส EDC
                                            <input type="text" class="form-control"
                                                   id="received_amount" name="edc"
                                                   ng-model="payment.edc"
                                                   placeholder="EDC ID">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            รับเงิน
                                            <input type="number" class="form-control  total-price input-lg"
                                                   ng-model="payment.receivedAmount"
                                                   id="received_amount" name="receivedAmount" required
                                                   placeholder="เงินที่รับ">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>เงินทอน</td>
                                        <td class="total-price">@{{ getWithdrawn() }} บาท</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button ng-disabled="payment.receivedAmount < getTotal()"
                                                    style="display: block; width: 100%;"
                                                    class="btn btn-success">ชำระเงิน

                                            </button>
                                        </td>
                                    </tr>

                                </table>

                            </div>
                        @else
                            <p class="lead">ไม่พบข้อมูลการค้างชำระสินค้าหรือบริการ.</p>
                        @endif
                    </div>

                </div>
            </form>

        </div>
    </div>
@stop