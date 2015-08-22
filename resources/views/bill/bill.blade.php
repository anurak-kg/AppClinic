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
            #{{ $bill->quo_id }} <br>
            {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br><br>
        </div>

       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $bill->customer->cus_name }}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $bill->customer->cus_id }} <br><br>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $bill->customer->cus_hno }}
        {{ $bill->customer->cus_moo }}
        {{ $bill->customer->cus_soi }}
        {{ $bill->customer->cus_road }}
        {{ $bill->customer->cus_subdis }}
        {{ $bill->customer->cus_district }}
        {{ $bill->customer->cus_province }}
        {{ $bill->customer->cus_postal }}
        {{ $bill->customer->cus_tel }}
        {{ $bill->customer->cus_phone }}

         <br><br>


        <br><br>

            <div class="col-xs-12 table-responsive">
                <table class="table ">

                    <tbody>
                    <?php $total=0 ?>
                    <?php $index=0 ?>
                    @foreach($bill->course as $course)
                    <tr>
                        <td><?php echo $index+=1?> &nbsp; &nbsp;</td>
                        <td>{{ $course->course_id }}</td>
                        <td> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{ $course->course_name }}</td>
                        <td>1</td>
                        <td>&nbsp; <?php echo number_format($subtotal = $course->course_price)?></td>
                        <td> <?php echo number_format($dis= $bill->discount,2) ?> </td>
                        <?php echo number_format($subtotal-$dis,2) ?>
                        <td>&nbsp; &nbsp;&nbsp;&nbsp;<?php echo number_format($total+=($subtotal-$dis)) ?></td>
                    </tr>

                        @endforeach
                    </tbody>

                </table>
            </div><!-- /.col -->



</body>
</html>



