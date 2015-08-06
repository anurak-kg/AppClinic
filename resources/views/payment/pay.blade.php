@extends('layout.master')
@section('title','สินค้า')


@section('content')
    <div ng-controller="paymentController" id="treat">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-default">

                    <div class="box-header with-border">
                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            <fieldset>
                                <form class="form-horizontal" method="POST" action="{{url('payment/pay')}}">
                                    <input name="quo_de_id" value="{{$quo->quo_de_id}}" type="hidden">
                                    <input name="course_id" value="{{$quo->course_id}}" type="hidden">

                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <legend>การชำระเงิน</legend>

                                    <div class="form-group col-md-12"
                                         ng-show="payment.boxPaidMethod">
                                        <select class="form-control input-lg" name="method"
                                                ng-model="payment.boxMethod" ng-change="paymentMethod()">
                                            <option ng-selected="true">> การชำระเงิน <</option>
                                            <option value="PAID_IN_FULL"> ชำระเต็มจำนวน</option>
                                            <option value="PAY_BY_COURSE"> แบ่งจ่ายตามจำนวนครั้งที่เข้ารักษา</option>
                                            <option value="PAYABLE"> ผ่อนจ่าย</option>
                                        </select>
                                    </div>

                                    <div ng-show="payment.boxPaidFull"
                                         ng-init="init({{ (int)$quo->quo_de_price }},{{getConfig('vat_rate')}},{{$quo->quo_id}},'{{ $quo->course_id }}',{{$quo->course->course_qty}})">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>ประเภทการชำระ</label>
                                                <select class="form-control" ng-change="changeType()"
                                                        ng-model="payment.type" name="type">
                                                    <option ng-selected="true"
                                                            value="cash">เงินสด
                                                    </option>
                                                    <option value="credit_card">บัตรเครดิต</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="course-total-price">ราคาคอร์ส  ทั้งหมด {{$quo->course->course_qty}} ครั้ง </label>
                                                <input type="text" class="form-control total-price"
                                                       id="course-total-price"
                                                       ng-model="payment.paymentTotal"
                                                       value="{{ $quo->course_price }}" disabled>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="course-total-price">จำนวนเงินที่ต้องชำระครั้งนี้</label>
                                                <input type="text" class="form-control total-price"
                                                       id="course-total-price"
                                                       ng-model="payment.minPrice"
                                                       value="{{ $quo->course_price }}" disabled>
                                            </div>
                                            <div ng-show="payment.creditCardBox">
                                                <div class="form-group col-md-12">
                                                    <label>ธนาคาร</label>
                                                    <select class="form-control" ng-model="payment.bank_id"
                                                            name="bank_id">
                                                        <option value="1">กรุงศรี</option>
                                                        <option value="2">Aeon</option>
                                                        <option value="3">option 3</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="received_amount">รหัสบัตรเครดิต</label>
                                                    <input type="text" class="form-control" name="card_id"
                                                           id="received_amount"
                                                           ng-model="payment.card_id"
                                                           placeholder="เลขที่บัตรเครดดิต">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="received_amount">รหัส EDC</label>
                                                    <input type="text" class="form-control"
                                                           id="received_amount" name="edc"
                                                           ng-model="payment.edc"
                                                           placeholder="EDC ID">
                                                </div>


                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="received_amount">เงินที่รับ</label>
                                                <input type="number" class="form-control total-price"
                                                       id="received_amount" name="receivedAmount"
                                                       ng-change="receiveChange()"
                                                       ng-model="payment.receivedAmount"
                                                       placeholder="เงินที่รับ">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="withdawn">เงินถอน</label>
                                                <input type="text" class="form-control total-price"
                                                       id="withdawn"
                                                       ng-value="payment.withdawn | number"
                                                       disabled>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-success pull-right"
                                                        ng-disabled="payment.buttonPay"
                                                        ng-click="saveFullPaidPayment()">ชำระเงินเต็มจำนวน
                                                </button>
                                            </div>


                                        </div>
                                    </div>
                                    <input type="submit" value="จ่ายเงิน">

                                </form>
                            </fieldset>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@stop
