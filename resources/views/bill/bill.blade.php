<html>
<head>
    <meta charset="UTF-8">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css" />

    <style>
        h3 {
            font-family:angsana new;
            font-size:150%;
        }
        b  {
            font-family:angsana new;
            font-size:150%;
        }
        body {
            width : 22.9cm;
            height : 14cm;
        }
    </style>

</head>

<body onload="window.print();">
<br> <br> <br> <br>
<div align="right">
    <?php (Jenssegers\Date\Date::now()+543) ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        <font size="5"><?php echo  zerofill($bill->quotations->bill_number) ?></font><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
        <font size="5">{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</font> <br>

</div>
<br> <br> <br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
<font size="5">{{ $bill->quotations->customer->cus_name }}</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<font size="5">{{ $bill->quotations->customer->cus_id }} </font><br><br>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font size="5">{{ $bill->quotations->customer->cus_hno }}</font>
    <font size="5">{{ $bill->quotations->customer->cus_moo }}</font>
        <font size="5">{{ $bill->quotations->customer->cus_soi }}</font>
            <font size="5">{{ $bill->quotations->customer->cus_road }}</font>
                <font size="5">{{ $bill->quotations->customer->cus_subdis }}</font>
                    <font size="5">{{ $bill->quotations->customer->cus_district }}</font>
                        <font size="5">{{ $bill->quotations->customer->cus_province }}</font>
                            <font size="5">{{ $bill->quotations->customer->cus_postal }}</font>
                                <font size="5">{{ $bill->quotations->customer->cus_tel }}</font>
                                    <font size="5">{{ $bill->quotations->customer->cus_phone }}</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
<font size="5">{{ $bill->quotations->user->id }}</font>

<br><br> <br><br>


<br><br><br><br>

<div class="col-xs-12 table-responsive">
    <table class="table " style="width: 800px ">

        <tbody>
        <?php $total=0 ?>
        <?php $index=0 ?>

        <tr>
            <td><?php echo $index+=1?> &nbsp; &nbsp;</td>
            <td>{{$bill->course->course_id }}</td>
            <td> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;{{ $bill->course->course_name }}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</td>
            <td> 1</td>
            <td> <?php echo number_format($subtotal = $bill->course->course_price)?></td>
            <?php  number_format($dis1 = $bill->quo_de_discount,2) ?>
            <?php  number_format($dis2 = $bill->quo_de_disamount,2) ?>
            <td>  <?php echo number_format($distotal = (($subtotal*$dis1/100)+$dis2)) ?> </td>
            <?php  number_format($subtotal-$distotal,2) ?>
            <td><?php echo number_format($total+=($subtotal-$distotal)) ?></td>
        </tr>


        </tbody>

    </table>
</div><!-- /.col -->



</body>
</html>