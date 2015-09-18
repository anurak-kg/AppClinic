@extends('layout.master')
@section('title','ชำระเงิน')
@section('headText','Payment')
@section('headDes','ชำระเงิน')
@section('content')
    <style>
        /* .squaredThree */
        .squaredThree {
            width: 20px;
            position: relative;
            margin: 20px auto;
        }

        .squaredThree label {
            width: 20px;
            height: 20px;
            cursor: pointer;
            position: absolute;
            top: 0;
            left: 0;
            background: -webkit-linear-gradient(top, #222222 0%, #45484d 100%);
            background: linear-gradient(to bottom, #222222 0%, #45484d 100%);
            border-radius: 4px;
            box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px rgba(255, 255, 255, 0.4);
        }

        .squaredThree label:after {
            content: '';
            width: 9px;
            height: 5px;
            position: absolute;
            top: 4px;
            left: 4px;
            border: 3px solid #fcfff4;
            border-top: none;
            border-right: none;
            background: transparent;
            opacity: 0;
            -webkit-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .squaredThree label:hover::after {
            opacity: 0.3;
        }

        .squaredThree input[type=checkbox] {
            visibility: hidden;
        }

        .squaredThree input[type=checkbox]:checked + label:after {
            opacity: 1;
        }

        /* end .squaredThree */
    </style>
    <div class="row">
        <form method="get" target="_blank" action="{{url('bill/by-course/')}}">
            <div class="col-md-12">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title">ชำระเงิน รหัสลูกค้า #{{$item->cus_id}}</h2>

                        <div class="box-tools pull-right">
                            <a class="btn btn-danger" href="{{url('quotations')}}">กลับสู่หน้าขายคอร์ส</a>
                        </div>
                    </div>

                    <div class="box-body">
                        @if( Session::get('message') != null )
                            <div class="alert alert-success alert-dismissable">
                                <h4><i class="icon fa fa-check"></i> {{Session::get('headTxt')}} !</h4>
                                {{Session::get('message')}}.
                            </div>
                        @endif
                        <div class="col-md-12 ">
                            @foreach($quo as $item)
                                รหัสการสั่งซื้อ {{$item->quo_id}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td style="width: 10px"><b>#</b></td>
                                        <td><b>คอร์ส</b></td>
                                        <td><b>ราคา</b></td>
                                        <td><b>ประเภทการจ่าย</b></td>
                                        <td><b>ยอดค้างชำระ</b></td>
                                        <td><b>สถานะการจ่ายเงิน</b></td>
                                        <td style="width: 90px"><b>ชำระเงิน</b></td>
                                    </tr>
                                    </thead>
                                    <?php $index = 1;?>
                                    {{dd($item->quotations_detail)}}
                                    @foreach($item->quotations_detail as $detail)
                                        <tr>
                                            <td>{{$index}}</td>
                                            <td>{{$detail->course->course_name}} จำนวน {{$detail->course->course_qty}}
                                                ครั้ง
                                            </td>
                                            <td>{{$detail->course->course_price}}</td>
                                            <td>@if($detail->payment->payment_type=='PAID_IN_FULL')
                                                    <span class="label label-success">เต็มจำนวน</span>
                                                @elseif($detail->payment->payment_type=='PAYABLE')
                                                    <span class="label label-success">ผ่อนชำระ</span>
                                                @elseif($detail->payment->payment_type=='PAY_BY_COURSE')
                                                    <span class="label label-success">แบ่งตามจำนวนครั้ง@endif</span>
                                            </td>
                                            <td>{{$detail->payment_remain - $detail->payment->payment_detail->amount}}</td>
                                            <td>@if($detail->payment->payment_status=='REMAIN')
                                                    <span class="label label-warning">ค้างชำระ</span>
                                                @elseif($detail->payment->payment_status=='FULLY_PAID')
                                                    <span class="label label-success">ครบ</span>
                                                @endif</td>
                                            <td>
                                                @if($item->payment_status!='FULLY_PAID')
                                                    <a href="{{url('payment/pay')}}?quo_de_id={{$item->quo_de_id}}"
                                                       class="btn btn-success">ชำระเงิน</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <?php $index++;?>
                                    @endforeach
                                </table>
                            @endforeach
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop