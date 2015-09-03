<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>

</head>

<body>
<div align="right">
    <font size="5"><?php echo zerofill($sales->bill_number) ?></font><br>
    <font size="5">{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</font> <br>
</div>
<br> <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size="5"> {{ $sales->customer->cus_name }}</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<font size="5">{{ $sales->customer->cus_id }}</font><br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size="5">{{ $sales->customer->cus_hno }}</font>
<font size="5">{{ $sales->customer->cus_moo }}</font>
<font size="5">{{ $sales->customer->cus_soi }}</font>
<font size="5">{{ $sales->customer->cus_road }}</font>
<font size="5">{{ $sales->customer->cus_subdis }}</font>
<font size="5">{{ $sales->customer->cus_district }}</font>
<font size="5">{{ $sales->customer->cus_province }}</font>
<font size="5">{{ $sales->customer->cus_postal }}</font>
<font size="5">{{ $sales->customer->cus_tel }}</font>
<font size="5">{{ $sales->customer->cus_phone }}</font>

<br><br> <br><br>
&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<tbody>
<?php $total = 0 ?>
<?php $index = 0 ?>
<?php $distotal = 0 ?>
@foreach($sales->product as $sale)
    <tr>
        <td><font size="5"><?php echo $index += 1?> &nbsp; &nbsp;</font></td>&nbsp;&nbsp;

        <td><font size="5">{{ $sale->product_id }}</font></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <td><font size="5">{{ $sale->product_name }}</font></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <td><font size="5">{{$qty = $sale->pivot->sales_de_qty }}</font></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <td><font size="5"><?php echo number_format($price = $sale->pivot->sales_de_price)?></font></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
        <?php  number_format($dis1 = $sale->pivot->sales_de_discount, 2) ?>
        <?php  number_format($dis2 = $sale->pivot->sales_de_disamount, 2) ?>
        <td> <font size="5"> <?php echo number_format($distotal = (($price * $dis1 / 100) + $dis2)) ?> </font></td>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
        <td><font size="5"><?php echo number_format($sale->pivot->sales_de_net_price,2) ?></font></td>&nbsp;&nbsp;&nbsp;&nbsp;
    </tr>
@endforeach
<tr>
    <td><font size="5">{{$price-$distotal}}</font></td>

</tr>
</tbody>

</body>
</html>





