<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>

</head>

<body>
<div align="right">
    <font size="4"><?php echo zerofill($bill->quotations->bill_number) ?></font><br>
    <font size="4">{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</font> <br>
</div>
<br> <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size="4">{{ $bill->quotations->customer->cus_name }}</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<font size="4">{{ $bill->quotations->customer->cus_id }} </font><br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size="4">{{ $bill->quotations->customer->cus_hno }}</font>
<font size="4">{{ $bill->quotations->customer->cus_moo }}</font>
<font size="4">{{ $bill->quotations->customer->cus_soi }}</font>
<font size="4">{{ $bill->quotations->customer->cus_road }}</font>
<font size="4">{{ $bill->quotations->customer->cus_subdis }}</font>
<font size="4">{{ $bill->quotations->customer->cus_district }}</font>
<font size="4">{{ $bill->quotations->customer->cus_province }}</font>
<font size="4">{{ $bill->quotations->customer->cus_postal }}</font>
<font size="4">{{ $bill->quotations->customer->cus_tel }}</font>
<font size="4">{{ $bill->quotations->customer->cus_phone }}</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<font size="4">{{ $bill->quotations->user->id }}</font>
<br><br> <br><br>
&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
<tbody>
<?php $total = 0 ?>
<?php $index = 0 ?>

<tr>
    <td><font size="4"><?php echo $index += 1?> &nbsp; &nbsp;</font></td>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
    <td><font size="4">{{$bill->course->course_id }}</font></td>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
    <td> <font size="4">{{ $bill->course->course_name }} &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</font></td>
    <td><font size="4"> 1</font></td>&nbsp; &nbsp;&nbsp;&nbsp;
    <td><font size="4"> <?php echo number_format($subtotal = $bill->course->course_price)?></font></td> &nbsp;&nbsp; &nbsp;
    <?php  number_format($dis1 = $bill->quo_de_discount, 2) ?>&nbsp; &nbsp;&nbsp;
    <?php  number_format($dis2 = $bill->quo_de_disamount, 2) ?>&nbsp; &nbsp;&nbsp;
    <td> <font size="4"> <?php echo number_format($distotal = (($subtotal * $dis1 / 100) + $dis2)) ?> </font></td>&nbsp; &nbsp;&nbsp;
    <?php  number_format($subtotal - $distotal, 2) ?>&nbsp; &nbsp;&nbsp;
    <td><font size="4"><?php echo number_format($total += ($subtotal - $distotal)) ?></font> </td>
</tr>

<br><br><br>

</tbody>

</body>
</html>
