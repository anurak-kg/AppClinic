<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">

        <h3 align="right">
            ใบเสร็จรับเงิน
        </h3>


        <hr>
        <div align="right">

            <b> เลขที่ใบเสร็จรับเงิน</b>  #{{ $sales->sales_id }} <br>
            <b>วันที่ออกใบเสร็จ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
            {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}
            <b>พนักงาน :</b> {{ $sales->user->name }} <br>

        </div><!-- /.col -->

        <!-- info row -->
        <div class="row invoice-info">

            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    <b> สาขา {{ $sales->branch->branch_name }}</b>
                    {{ $sales->branch->branch_address }}<br>
                    โทร : {{ $sales->branch->branch_tel }}
                    <br><br>
                </address>
            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>

                    <b>รหัสลูกค้า:</b> {{ $sales->customer->cus_id }}

                    <b> ชื่อลูกค้า {{ $sales->customer->cus_name }} </b> <br>
                    {{ $sales->customer->cus_hno }}
                    {{ $sales->customer->cus_moo }}
                    {{ $sales->customer->cus_soi }}
                    {{ $sales->customer->cus_road }}
                    {{ $sales->customer->cus_subdis }}
                    {{ $sales->customer->cus_district }}
                    {{ $sales->customer->cus_province }}
                    {{ $sales->customer->cus_postal }}
                    {{ $sales->customer->cus_tel }}
                    {{ $sales->customer->cus_phone }}
                </address>
            </div><!-- /.col -->

        </div><!-- /.row -->


        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>สินค้า</th>
                        <th>จำนวน</th>
                        <th>หน่วยละ</th>
                        <th>ส่วนลด %</th>
                        <th>ส่วนลด บาท</th>
                        <th>จำนวนเงิน</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0 ?>
                    @foreach($sales->product as $sale)
                        <tr>
                            <td>{{ $sale->product_id }}</td>
                            <td>{{ $sale->product_name }}</td>
                            <td>{{$qty = $sale->pivot->sales_de_qty }}</td>
                            <td><?php echo number_format($price = $sale->pivot->sales_de_price)?></td>
                            <td><?php echo number_format($dis1 = $sale->pivot->sales_de_discount,2) ?> </td>
                            <td><?php echo number_format($dis2 = $sale->pivot->sales_de_disamount,2) ?> </td>
                            <td><?php echo number_format(($qty*$price)-(($qty*$price)*$dis1/100)-$dis2,2) ?></td>
                        </tr>
                        <?php $total+= ($qty*$price)-$dis2 ?>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>ยอดเงินสุทธิ</th>
                        <td><?php echo number_format($total,2) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->





    </section><!-- /.content -->
</div><!-- ./wrapper -->

</body>
</html>



