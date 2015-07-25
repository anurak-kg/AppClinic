@extends('layout.master')
@section('title','การสั่งซื้อสินค้า')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div align="middle">
                <h3>
                    ใบสั่งซื้อสินค้า
                </h3>
            </div>
            <div align="right">

            </div>
        </div>

        <div align="right">

            <b> เลขที่ใบสั่งซื้อ</b> #<br>
            <b>วันที่ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
        </div>

        <!-- info row -->
        <div class="row invoice-info">

            <div align="middle">

                <address>
                {{--//   {{$order->branch->branch_address}}--}}
                </address>

            </div>

        </div>
        <!-- /.row -->

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    ร้านค้า
                </address>
            </div>
            <!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    พนักงาน
                </address>
            </div>
            <!-- /.col -->


            <!-- /.col -->
        </div>
        <!-- /.row -->


        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered">

                    <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>หน่วยนับ</th>
                        <th>ราคา/หน่วย</th>
                        <th>ส่วนลด</th>
                        <th>จำนวนเงิน</th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>
                            <a class="btn " href="{{url('order/create')}}">
                                เพิ่มข้อมูล
                            </a>
                        </td>

                        <td>
                            <a class="btn " href="{{url('order/create')}}">
                                เพิ่มข้อมูล
                            </a>
                        </td>

                        <td>
                            <a class="btn " href="{{url('order/create')}}">
                                เพิ่มข้อมูล
                            </a>
                        </td>

                        <td>
                            <a class="btn " href="{{url('order/create')}}">

                            </a>
                        </td>

                        <td>

                        </td>

                        <td>

                        </td>

                        <td>

                        </td>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>รวมเงิน</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>จำนวนเงิน(หักส่วนลด)</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>ภาษีมูลค่าเพิ่ม 7 %</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>จำนวนเงินทั้งสิ้น</td>
                        <td></td>
                    </tr>

                    </tfoot>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->


        {{--   <div class="row order-info">

               <div class="col-md-12">


                       {!! $grid !!}


               </div>
           </div>--}}


@stop
