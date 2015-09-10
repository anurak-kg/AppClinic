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
                        <h2 class="box-title">ชำระเงิน รหัสลูกค้า #{{$course[0]->cus_id}}</h2>

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
                                    <td style="width: 10px"><b>#</b></td>
                                    <td><b>คอร์ส</b></td>
                                    <td><b>ราคา</b></td>
                                    <td><b>ประเภทการจ่าย</b></td>
                                    <td><b>ยอดค้างชำระ</b></td>
                                    <td><b>สถานะการจ่ายเงิน</b></td>

                                    <td style="width: 90px"><b>ชำระเงิน</b></td>
                                    <td style="width: 20px"><b>ปริ้นบิล</b></td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 0;?>
                                @foreach($course as $item)
                                    <tr>
                                        {{--{{dd($cus->quotations[$index]->quotations_detail->course)}}--}}
                                        <td>{{$index+1}}</td>
                                        <td>{{$item->course_name}} จำนวน {{$item->course_qty}} ครั้ง</td>
                                        <td>
                                            @if($item->vat == 'false')
                                                {{$item->net_price}}
                                            @else
                                                {{$item->net_price + ($item->payment_remain * $item->vat_rate/100)}}
                                            @endif

                                        </td>

                                        <td>
                                            @if($item->payment_status=='REMAIN')
                                                <span>ผ่อนจ่าย</span>
                                            @elseif($item->payment_status=='FULLY_PAID')
                                                <span>จ่ายเต็มจำนวน</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->vat == 'false')
                                                {{$item->payment_remain}}
                                            @else
                                                {{$item->payment_remain + ($item->payment_remain * $item->vat_rate/100)}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->payment_status=='FULLY_PAID')
                                                <span class="label label-success">จ่ายเงินครบแล้ว</span>
                                            @else
                                                <span class="label label-warning">ค้างจ่าย</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->payment_status!='FULLY_PAID')
                                                <a href="{{url('payment/pay')}}?quo_de_id={{$item->quo_de_id}}"
                                                   class="btn btn-success">ชำระเงิน</a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <input type="checkbox"
                                                   @if($item->payment_status!='FULLY_PAID')
                                                   disabled
                                                   @endif
                                                   name="cus[{{$item->quo_de_id}}]">

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>

                                <thead>

                                <tr>
                                    <td style="width: 10px"><b>#</b></td>
                                    <td><b>สินค้า</b></td>
                                    <td><b>ราคา/หน่วย</b></td>
                                    <td><b>จำนวน</b></td>
                                    <td><b>Vat</b></td>
                                    <td><b>ราคารวม</b></td>
                                    <td style="width: 50px"><b>ชำระเงิน</b></td>
                                    <td style="width: 40px"><b>ปริ้นบิล</b></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 0;?>
                                @foreach($sale as $item)
                                    <tr>
                                        {{--{{dd($sal->sales[$index]->sales_detail[$index]->product->product_name)}}--}}
                                        <td>{{$index+1}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->product_price}}</td>
                                        <td>{{$item->sales_de_qty}}</td>
                                        <td> @if($item->vat == 'false')
                                                {{0}}
                                            @else
                                                {{$item->sales_total * $item->vat_rate/100}}
                                            @endif</td>
                                        <td>{{$item->sales_total + ($item->sales_total * $item->vat_rate/100)}}</td>
                                        <td><a href="{{url('payment/pay')}}?sales_id={{$item->sales_id}}"
                                               class="btn btn-success">ชำระเงิน</a></td>
                                        <td><input type="checkbox" name="sal[{{$item->sales_id}}]"></td>
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
                                    <td>
                                        <button type="submit" class="btn btn-default">พิมพ์</button>
                                    </td>

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