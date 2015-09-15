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
                        <h2 class="box-title">ชำระเงิน เลขที่การสั่งซื้อ #{{$quo->quo_id}}</h2>

                        <div class="box-tools pull-right">
                            <a class="btn btn-danger" href="{{url('quotations')}}">กลับสู่หน้าขายคอร์ส</a>

                            <a class="btn btn-warning" href="{{url('payment/history')}}?quo_de_id={{$quo->cus_id}}">พิมพ์ใบเสร็จ</a>

                        </div>
                    </div>

                    <div class="box-body">
                        @if( Session::get('message') != null )
                            <div class="alert alert-success alert-dismissable">
                                <h4><i class="icon fa fa-check"></i> {{Session::get('headTxt')}} !</h4>
                                {{Session::get('message')}}
                            </div>
                        @endif

                        <div class="col-md-12 ">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td>คอร์ส</td>
                                    <td>ราคา</td>
                                    <td>ประเภทการจ่าย</td>
                                    <td>ยอดค้างชำระ</td>
                                    <td>สถานะการจ่ายเงิน</td>

                                    <td style="width: 90px">ชำระเงิน</td>
                                    {{--<td style="widthdth: 20px">ปลิ้นบิล</td>--}}

                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 0;?>
                                @foreach($quo->course as $course)
                                    <tr>

                                        <td>{{$index+1}}</td>
                                        <td>{{$course->course_name}} จำนวน {{$course->course_qty}} ครั้ง</td>
                                        <td>
                                            @if($quo->vat == 'false')
                                                {{$quo->quotations_detail[$index]->net_price}}
                                            @else
                                                {{$quo->quotations_detail[$index]->net_price + ($quo->quotations_detail[$index]->payment_remain * $quo->vat_rate/100)}}
                                            @endif

                                        </td>


                                        <td>
                                            @if($quo->quotations_detail[$index]->payment->payment_status=='REMAIN')
                                                <span>ผ่อนจ่าย</span>
                                            @elseif($quo->quotations_detail[$index]->payment->payment_status=='FULLY_PAID')
                                                <span>จ่ายเต็มจำนวน</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($quo->vat == 'false')
                                                {{$quo->quotations_detail[$index]->payment_remain}}
                                            @else
                                                {{$quo->quotations_detail[$index]->payment_remain + ($quo->quotations_detail[$index]->payment_remain * $quo->vat_rate/100)}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($quo->quotations_detail[$index]->payment->payment_status=='FULLY_PAID')
                                                <span class="label label-success">จ่ายเงินครบแล้ว</span>
                                            @else
                                                <span class="label label-warning">ค้างจ่าย</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($quo->quotations_detail[$index]->payment->payment_status!='FULLY_PAID')
                                                <a href="{{url('payment/pay')}}?quo_de_id={{$quo->quotations_detail[$index]->quo_de_id}}"
                                                   class="btn btn-success">ชำระเงิน</a>
                                            @endif
                                        </td>
                                        {{--<td style="text-align: center">--}}
                                            {{--<input type="checkbox"--}}
                                                   {{--@if($quo->quotations_detail[$index]->payment->payment_status!='FULLY_PAID')--}}
                                                   {{--disabled--}}
                                                   {{--@endif--}}
                                                   {{--name="quo[{{$quo->quotations_detail[$index]->quo_de_id}}]">--}}

                                        {{--</td>--}}

                                        <?php $index++;?>


                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    {{--<td>--}}
                                        {{--<button type="submit" class="btn btn-default">พิมพ์</button>--}}
                                    {{--</td>--}}

                                </tr>
                                </tfoot>
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