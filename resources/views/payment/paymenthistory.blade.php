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

                        <div class="col-md-12 ">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td>คอร์ส / สินค้า</td>
                                    <td>ราคา</td>
                                    <td>จำนวน</td>
                                    <td>ประเภทการจ่าย</td>
                                    <td>จำนวนที่จ่าย</td>
                                    <td>เลือกชำระเงิน</td>
                                    <td align="middle">คงเหลือ</td>


                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 0;?>
                                @foreach($quo as $item)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>
                                            @if($item->course_name == null)
                                                {{$item->product_name}}
                                            @else
                                                {{$item->course_name}} จำนวน {{$item->course_qty}} ครั้ง</td>
                                        @endif
                                        <td>
                                            @if($item->course_price == null)
                                                {{$item->product_price}}
                                            @else
                                                {{$item->course_price}}
                                            @endif
                                        </td>

                                        <td align="middle">
                                            @if($item->course_qty == null)
                                                {{$item->product_qty}}
                                            @else
                                                {{$item->course_qty}}
                                            @endif
                                        </td>

                                        <td align="middle">
                                            <select>
                                                <option value="name" id="full">จ่ายเต็มจำนวน</option>
                                                <option value="name1">ผ่อนจ่าย</option>
                                            </select>
                                        </td>



                                        <td>
                                            <?php
                                            $price = null;
                                            if($item->course_price == null){
                                                $price = $item->product_price;
                                            }else{
                                                $price = $item->course_price;
                                            }
                                            ?>
                                            <input type="text" value="{{$price}}">
                                        </td>




                                        <td align="middle">
                                            <input type="checkbox" checked>
                                        </td>

                                        <td>

                                        </td>

                                    </tr>

                                    <?php $index++;?>

                                @endforeach

                                <tr>
                                    <td colspan="7" class="total-price">ยอดรวม:</td>
                                    <td> บาท</td>
                                </tr>

                                @if($quo->vat == 'true')
                                    <tr>
                                        <td colspan="7" class="total-price">ภาษี {{getConfig('vat_rate')}}% :</td>
                                        <td> บาท</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="7" class="total-price">ยอดสุทธิ:</td>
                                    <td><strong></strong> บาท</td>
                                </tr>



                                <tr>
                                    <td colspan="7"></td>
                                    <td width="200">
                                        <input type="number" class="form-control  total-price input-lg"
                                               id="received_amount" name="receivedAmount" required
                                               ng-change=" "
                                               ng-model=" "
                                               placeholder="เงินที่รับ">
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="7"></td>

                                    <td>
                                        <button class="btn btn-success btn-block pull-right"
                                                ng-disabled=" "
                                                ng-click=" ">ชำระเงิน
                                        </button>
                                    </td>

                                </tr>

                                </tbody>

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