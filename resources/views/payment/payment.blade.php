@extends('layout.master')
@section('title','ชำระเงิน')
@section('headText','Payment')
@section('headDes','ชำระเงิน')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default ">
                <div class="box-header with-border">
                    <h2 class="box-title">ชำระเงิน เลขที่การสั่งซื้อ #{{$quo->quo_id}}</h2>
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

                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 0;?>
                            @foreach($quo->course as $course)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$course->course_name}}</td>
                                    <td>{{$course->course_price}}</td>


                                    <td>
                                        @if($quo->quotations_detail[$index]->payment->payment_status=='REMAIN')
                                            <span>ผ่อนจ่าย</span>
                                        @elseif($quo->quotations_detail[$index]->payment->payment_status=='FULLY_PAID')
                                            <span>จ่ายเต็มจำนวน</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$quo->quotations_detail[$index]->payment_remain}}

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
                                    <?php $index++;?>


                                </tr>
                            @endforeach

                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="box-footer">

                </div>
            </div>

        </div>
    </div>
@stop