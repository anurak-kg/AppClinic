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
                                            <?php $pay_by_course = null;?>

                                            @if($quo->payment == null)
                                                <?php $pay_by_course = 0;?>

                                                <option ng-selected="true">> การชำระเงิน <</option>
                                                <option value="PAID_IN_FULL"> ชำระเต็มจำนวน</option>
                                                <option value="PAY_BY_COURSE"> แบ่งจ่ายตามจำนวนครั้งที่เข้ารักษา

                                                <option value="PAYABLE" disabled> ผ่อนจ่าย</option>
                                            @else
                                                <option value="PAY_BY_COURSE" ng-selected="true">
                                                    แบ่งจ่ายตามจำนวนครั้งที่เข้ารักษา
                                                </option>
                                                <?php $pay_by_course = 1;?>

                                            @endif
                                        </select>
                                    </div>

                                    <div ng-show="payment.boxPaidFull"
                                         ng-init="init({{ (int)$totalPrice}},'{{$quo->Quotations->vat}}',{{$quo->Quotations->vat_rate}},{{$quo->quo_id}},'{{ $quo->course_id }}',{{$quo->course->course_qty}},{{$pay_by_course}},{{$quo->quo_de_id}})">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>ประเภทการชำระ</label>
                                                <select class="form-control" ng-change="changeType()"
                                                        ng-model="payment.type" name="type">
                                                    <option ng-selected="true"
                                                            value="cash">เงินสด
                                                    </option>
                                                    <option value="transfer">โอนเงิน</option>
                                                    <option value="credit_card">บัตรเครดิต</option>
                                                </select>

                                            </div>
                                            <table class="table table-bordered form-group  col-md-12"
                                                   style="text-align: right">
                                                <tr>
                                                    <td>เวลา</td>
                                                    <td>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">ราคาคอร์ส
                                                        ทั้งหมด {{$quo->course->course_qty}} ครั้ง
                                                    </td>
                                                    <td style="width: 189px;text-align: right">{{ number_format($quo->net_price,0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>ยอดค้างชำระ</td>
                                                    <td style="font-weight: bolder;color: #FF0009;font-size: 16px;">{{ number_format($quo->payment_remain,0)}}</td>
                                                </tr>
                                                @if($quo->Quotations->vat == 'true')
                                                    <tr>
                                                        <td>ภาษีที่ต้องชำระครั้งนี้</td>
                                                        <td style="font-weight: bolder;font-size: 16px;">
                                                            @{{ vat_amount | number}}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>จำนวนเงินที่ต้องชำระครั้งนี้</td>
                                                    <td style="font-size: 24px;font-weight: bolder">@{{payment.minPrice | number}}</td>
                                                </tr>
                                                <tr ng-show="payment.creditCardBox">
                                                    <td>ธนาคาร</td>
                                                    <td>
                                                        <select class="form-control" ng-model="payment.bank_id" name="bank_id">
                                                            @foreach($bank as $item)
                                                                <option value="{{$item->bank_id}}">{{$item->bank_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr ng-show="payment.creditCardBox">
                                                    <td>รหัสบัตรเครดิต</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="card_id"
                                                               id="received_amount"
                                                               ng-model="payment.card_id"
                                                               placeholder="เลขที่บัตรเครดดิต">
                                                    </td>
                                                </tr>
                                                <tr ng-show="payment.creditCardBox">
                                                    <td>รหัส EDC</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               id="received_amount" name="edc"
                                                               ng-model="payment.edc"
                                                               placeholder="EDC ID">
                                                    </td>
                                                </tr>

                                                <tr ng-show="payment.boxTransfer">
                                                    <td>เลขที่บัญชี</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               id="account_transfer" name="id_account"
                                                               ng-model="payment.id_account"
                                                               placeholder="เลขที่บัญชี" >
                                                    </td>
                                                </tr>

                                                <tr ng-show="payment.boxTransfer">
                                                    <td>วันที่โอน</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               id="day_transfer" name="transfer_day"
                                                               ng-model="payment.transfer_day"
                                                               placeholder="วัน" datepicker>
                                                    </td>
                                                </tr>

                                                <tr ng-show="payment.boxTransfer">
                                                    <td>เวลาที่โอน(โดยประมาณ)</td>
                                                    <td>
                                                        <select style="width: 80px" id="hour_transfer" name="transfer_hour" ng-model="payment.transfer_hour" >
                                                            <option ng-selected="true">
                                                                <?php echo 'ชม.' ?>
                                                            </option>
                                                            @for($i = 01; $i<=24;$i++)
                                                                <option value="hour">
                                                                    <?php echo $i; ?>
                                                                </option>
                                                            @endfor
                                                        </select>

                                                        <select style="width: 80px" id="min_transfer"  name="transfer_min" ng-model="payment.transfer_min" >
                                                            <option ng-selected="true">
                                                                <?php echo 'นาที' ?>
                                                            </option>
                                                            @for($i = 01; $i<=60;$i++)
                                                                <option value="min">
                                                                    <?php echo $i; ?>
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>รับเงิน</td>
                                                    <td>
                                                        <input type="number" class="form-control  total-price input-lg"
                                                               id="received_amount" name="receivedAmount" required
                                                               ng-change="receiveChange()"
                                                               ng-model="payment.receivedAmount"
                                                               placeholder="เงินที่รับ">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>เงินทอน</td>
                                                    <td>@{{payment.withdawn | number}}</td>
                                                </tr>
                                            </table>

                                            <div class="col-md-12">
                                                <a class="btn btn-danger pull-left"
                                                   href="{{url('payment')}}?quo_id={{$quo->quo_id}}">
                                                    กลับหน้าชำระเงิน </a>
                                                <button class="btn btn-success pull-right"
                                                        ng-disabled="payment.buttonPay"
                                                        ng-click="saveFullPaidPayment()">ชำระเงิน
                                                </button>
                                            </div>

                                        </div>
                                    </div>


                                </form>
                            </fieldset>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

<script>
    $(function(){


    });
</script>
@stop
