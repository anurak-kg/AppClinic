@extends('layout.master')
@section('title','ชำระเงิน')
@section('headText','Payment')
@section('headDes','ชำระเงิน')
@section('content')
    <div class="row" ng-controller="newPaymentController">
        <form method="get" target="_blank" action="{{url('bill/by-course/')}}">
            <div class="col-md-12">
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

                        <div class="col-md-9 ">
                            <table class="table table-bordered">
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
                                    $type = null;$course_qty = null;
                                    if ($item->course_name != null) {
                                        $type = 'course';
                                        $course_qty = $item->course_qty;
                                    } else {
                                        $type = 'product';
                                        $course_qty = 0;
                                    }
                                    ?>
                                    <tr ng-init="init({{$index}},'full',{{ceil($item->payment_remain)}},'{{$type}}',{{ceil($item->net_price)}},{{$course_qty}})">
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
                                            ราคารวม {{ceil($item->net_price)}} บาท

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

                                        <td align="middle">
                                            @if($type == 'course')
                                                <select ng-change="changePayType({{$index}})"
                                                        ng-model="product[{{$index}}].paymentType"
                                                        ng-disabled="product[{{$index}}].type == 'product' ">
                                                    <option value="full">จ่ายเต็มจำนวน</option>
                                                    <option value="payByQty">ผ่อนจ่าย</option>
                                                </select>
                                            @else
                                                จ่ายเต็มจำนวน
                                            @endif

                                        </td>


                                        <td>
                                            {{ product[<?php echo $index ;?>].remain  }}

                                        </td>


                                        <td align="middle">
                                            <input type="checkbox" ng-model="product[{{$index}}].selected">
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text"
                                                           ng-readonly="product[{{$index}}].paymentType == 'full'"
                                                           class="form-control"
                                                           ng-model="product[{{$index}}].paymentPrice">
                                                </div>
                                            </div>


                                            <p class="minPayment"
                                               ng-show="product[{{$index}}].paymentType == 'payByQty' ">ยอดขั้นต่ำ
                                                {{ product[<?php echo $index ;?>].minPayment  }}
                                                บาท</p>
                                        </td>
                                    </tr>
                                    <?php $index++;?>
                                @endforeach

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
                                                ng-model="payment.type">
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
                                        <button ng-disabled = "payment.receivedAmount < getTotal()"
                                                style="display: block; width: 100%;"
                                                class="btn btn-success">ชำระเงิน

                                        </button>
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>

                    <div class="box-footer">

                    </div>
                </div>

            </div>
        </form>

    </div>
@stop