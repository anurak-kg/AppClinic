<html>
<head>
    <meta charset="UTF-8">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css" />

    <style>
        h3 {
            font-family:angsana new;
            font-size:250%;
        }
        p  {
            font-family:angsana new;
            font-size:180%;
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
                <p><?php echo zerofill($bill->quotations->bill_number) ?></p>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  <p>{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</p> <br>

        </div>
        <br> <br> <br>

       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; {{ $bill->quotations->customer->cus_name }}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
{{ $bill->quotations->customer->cus_id }} <br><br><br>


        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $bill->quotations->customer->cus_hno }}
{{ $bill->quotations->customer->cus_moo }}
  {{ $bill->quotations->customer->cus_soi }}
 {{ $bill->quotations->customer->cus_road }}
   {{ $bill->quotations->customer->cus_subdis }}
   {{ $bill->quotations->customer->cus_district }}
    {{ $bill->quotations->customer->cus_province }}
   {{ $bill->quotations->customer->cus_postal }}
   {{ $bill->quotations->customer->cus_tel }}
   {{ $bill->quotations->customer->cus_phone }}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  {{ $bill->quotations->user->id }}

         <br><br>


        <br><br>

                <table class="table " style="width: 1000px">

                    <tbody>
                    <?php $total=0 ?>
                    <?php $index=0 ?>

                    <tr>
                        <td><p><?php echo $index+=1?></p> &nbsp; &nbsp;</td>
                        <td><p>{{$bill->course->course_id }}</p> </td>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <td><p>{{ $bill->course->course_name }}</p></td>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <td><p> 1</p></td>
                        &nbsp;&nbsp;  <td><p> <?php echo number_format($subtotal = $bill->course->course_price)?></p></td> &nbsp;&nbsp;
                        <?php  number_format($dis1 = $bill->quo_de_discount,2) ?>
                        <?php  number_format($dis2 = $bill->quo_de_disamount,2) ?>
                        &nbsp;&nbsp;  <td> <p> <?php echo number_format($distotal = (($subtotal*$dis1/100)+$dis2)) ?> </p></td> &nbsp;&nbsp;
                        <?php  number_format($subtotal-$distotal,2) ?>
                        &nbsp;&nbsp;    <td><p><?php echo number_format($total+=($subtotal-$distotal)) ?></p></td> &nbsp;&nbsp;
                    </tr>


                    </tbody>

                </table>



</body>
</html>



