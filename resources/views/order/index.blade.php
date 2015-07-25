@extends('layout.master')
@section('title','การสั่งซื้อสินค้า')
@section('content')


        <section class="invoice ">

            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <br><br><br><br><br>
                        <b> ชื่อลูกค้า</b> <br>

                    </address>
                </div>
                <!-- /.col -->

                <div class="col-sm-4 invoice-col">
                    <address>
                        <br><br>
                        <b> สาขา {{ $order->branch->branch_name }}</b>
                        {{ $order->branch->branch_address }}<br>
                        โทร : {{ $order->branch->branch_tel }}


                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <h3 align="right">
                        ใบเสร็จรับเงิน
                    </h3>

                    <b> เลขที่ใบเสร็จรับเงิน</b> #<br>
                    <b>วันที่ออกใบเสร็จ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
                    {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}
                    <b>พนักงาน :</b> <br>

                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>รหัสคอร์ส</th>
                            <th>คอร์ส</th>
                            <th>จำนวน</th>
                            <th>หน่วยนับ</th>
                            <th>หน่วยละ</th>
                            <th>ส่วนลด</th>
                            <th>จำนวนเงิน</th>


                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th>ยอดเงินสุทธิ</th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>


@stop
