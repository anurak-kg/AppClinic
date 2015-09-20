@extends('layout.master')
@section('title','พิมพ์ใบเสร็จ')
@section('headText','Payment')
@section('headDes','พิมพ์ใบเสร็จ')
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
    <div ng-controller="paymentController" id="payment">
        <div class="row">
            <form method="get" target="_blank" action="{{url('bill/print-bill/')}}">
                <div class="col-md-12">
                    <div class="box box-default ">
                        <div class="box-header with-border">
                            <h2 class="box-title">ชำระเงิน รหัสลูกค้า #{{$pay->cus_id}}</h2>
                        </div>

                        <div class="box-body">
                            @if( Session::get('message') != null )
                                <div class="alert alert-success alert-dismissable">
                                    <h4><i class="icon fa fa-check"></i> {{Session::get('headTxt')}} !</h4>
                                    {{Session::get('message')}}.
                                </div>
                            @endif
                            <div class="col-md-12 ">

                                รหัสการชำระเงิน {{$pay->payment_id}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td style="width: 10px"><b>#</b></td>
                                        <td><b>รายการสั่งซื้อ</b></td>
                                        <td><b>จำนวนเงินที่จ่าย</b></td>
                                        <td><b>วันที่</b></td>
                                        <td style="width: 20px;text-align: center">
                                            <button type="submit" class="btn btn-danger">ปลิ้นบิล</button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $index = 1;?>

                                    @foreach($pay as $item)
                                        {{--  {{dd($item->payment_detail[0]->amount)}}--}}
                                        <tr>
                                            <td>{{$index}}</td>
                                            <td>@if($item->quotations_detail!=null)
                                                    {{$item->quotations_detail->course->course_name}}
                                                @elseif($item->sales_detail!=null)
                                                    <a ng-click="open({{$item->sales_detail->sales_id}})">
                                                        {{$item->sales_detail->sales_id}}</a>
                                                @endif</td>
                                            <td>{{$item->payment_detail[0]->amount}}</td>
                                            <td>
                                                {{$item->created_at}}
                                            </td>
                                            <td align="middle">@if($item->payment_detail[0]->bill_detail===null)
                                                    <input type="checkbox"
                                                           name="pay_detail[{{$item->payment_detail[0]->payment_de_id}}]">
                                                    @elseif($item->payment_detail[0]->bill_detail!=null)
                                                    <a href="/bill/bill?bill_id={{$item->payment_detail[0]->bill_detail->bill_id}}" class="btn btn-md btn-success pull-right">เลขที่ใบเสร็จ <?php echo zerofill(($item->payment_detail[0]->bill_detail->bill_id)) ?></a>
                                                    @endif
                                            </td>
                                        </tr>
                                        <?php $index++;?>
                                    @endforeach
                                    </tbody>

                                </table>
                                **หมายเหตุ ในกรณีรายการสั่งซื้อเป็นตัวเลขให้คลิกเพื่อดูรายละเอียด
                            </div>
                        </div>
                        <div class="box-footer">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop