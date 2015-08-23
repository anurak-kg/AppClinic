<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css" />

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
    <table class="table ">

        <tbody>
        <?php $total=0 ?>
        <?php $index=1000000 ?>
        <?php $distotal =0 ?>
        @foreach($sales->product as $sale)
            <tr>
                <td><?php echo $index+=1?> &nbsp; &nbsp;</td>
                <td>{{ $sale->product_id }}</td>
                <td>{{ $sale->product_name }}</td>
                <td>{{$qty = $sale->pivot->sales_de_qty }}</td>
                <td><?php echo number_format($price = $sale->pivot->sales_de_price)?></td>
                <?php  number_format($dis1 = $sale->pivot->sales_de_discount,2) ?>
                <?php  number_format($dis2 = $sale->pivot->sales_de_disamount,2) ?>
                <td> <?php echo number_format($distotal = (($qty*$price)*$dis1/100)+$dis2,2) ?></td>
                <td><?php echo number_format($total+= ($qty*$price)-$distotal) ?></td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div><!-- /.col -->



</body>


<body>






<div id="section">


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
            </div><!-- /.col -->
        </div><!-- /.row -->





    </section><!-- /.content -->
</div><!-- ./wrapper -->

</body>
</html>



