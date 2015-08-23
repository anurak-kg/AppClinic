<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css"/>

</head>

<body onload="window.print();">
<div align="right">
    #{{ $sales->sales_id }} <br>
    {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br><br>
</div>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $sales->customer->cus_name }}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sales->customer->cus_id }} <br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $sales->customer->cus_hno }}
{{ $sales->customer->cus_moo }}
{{ $sales->customer->cus_soi }}
{{ $sales->customer->cus_road }}
{{ $sales->customer->cus_subdis }}
{{ $sales->customer->cus_district }}
{{ $sales->customer->cus_province }}
{{ $sales->customer->cus_postal }}
{{ $sales->customer->cus_tel }}
{{ $sales->customer->cus_phone }}

<br><br>


<br><br>

<div class="col-xs-12 table-responsive">

</div>
<!-- /.col -->


<div id="section">


    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
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
                <tbody>
                <?php $total = 0 ?>
                <?php $index = 1000000 ?>
                <?php $distotal = 0 ?>
                @foreach($sales->product as $sale)
                    <tr>
                        <td><?php echo $index += 1?> &nbsp; &nbsp;</td>
                        <td>{{ $sale->product_id }}</td>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{$qty = $sale->pivot->sales_de_qty }}</td>
                        <td><?php echo number_format($price = $sale->pivot->sales_de_price)?></td>
                        <td><?php echo number_format($sale->pivot->sales_de_discount) ?></td>
                        <td><?php echo number_format($sale->pivot->sales_de_disamount,2) ?></td>
                        <td><?php echo number_format($sale->pivot->sales_de_net_price,2) ?></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7" style="text-align: right">ยอดสุทธิ</td>
                    <td>{{$sales->sales_total}}</td>

                </tr>
                </tbody>


            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


</div>
<!-- ./wrapper -->

</body>
</html>



