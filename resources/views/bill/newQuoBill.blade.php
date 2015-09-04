<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <style>
        @page {
            sheet-size: 228.6mm 139.7mm;
        }
        body {
            font-size: 4.2mm;
        }
        .warp {
            height: 139.7mm;
            width: 228.6mm;
        }
        .box {
            border: solid;

        }

        .origin_box {
            float: right;
            width: 50mm;

        }

        .detail_box {
            width: 100%;
        }

        .customer_box {
            float: left;
            width: 124mm;
        }

        .cus_name_box {
            padding-left: 27mm;
        }

        .customer_address_box {
            padding-left: 27mm;

        }

        .sale_box {
            float: left;
            width: 73mm;
        }

        .customer_id_box {
            padding-left: 27mm;

        }

        .customer_sale_box {
            padding-left: 27mm;

        }

        .bill_number_box {
            padding-left: 20mm;

        }

        .bill_date_box {
            padding-left: 20mm;

        }
         .course{
            margin-top: 10mm;
            text-align: center;
        }
        .course tr td{
            height: 8mm;
        }


    </style>
</head>


<body>
<div class="warp">
    <div class="origin_box">
        <div class="box bill_number_box">
            <?php echo zerofill($bill->quotations->bill_number) ?>
        </div>
        <div class="box bill_date_box">
            {{Jenssegers\Date\Date::now()->format('d/m/Y')}}
        </div>
    </div>
    <div class="detail_box">
        <div class="box customer_box">
            <div class="box cus_name_box">{{ $bill->quotations->customer->cus_name }}</div>
            <div class="box customer_address_box">{{ $bill->quotations->customer->cus_hno }}
                {{ $bill->quotations->customer->cus_moo }}
                {{ $bill->quotations->customer->cus_soi }}
                {{ $bill->quotations->customer->cus_road }}
                {{ $bill->quotations->customer->cus_subdis }}
                {{ $bill->quotations->customer->cus_district }}
                {{ $bill->quotations->customer->cus_province }}
                {{ $bill->quotations->customer->cus_postal }}
                {{ $bill->quotations->customer->cus_tel }}
                {{ $bill->quotations->customer->cus_phone }}</div>

        </div>
        <div class="box sale_box">
            <div class="box customer_id_box"> {{ $bill->quotations->customer->cus_id }}</div>
            <div class="box customer_sale_box"> {{ $bill->quotations->user->id }}</div>
        </div>
    </div>


    <?php $total = 0 ?>
    <?php $index = 0 ?>
    <table border="1" class="course">
        <tr>
            <td  width="10mm"><?php echo $index += 1?></td>
            <td width="20mm">{{$bill->course->course_id }}</td>
            <td width="88.5mm">{{ $bill->course->course_name }}      </td>
            <td width="15mm">1</td>
            <td width="15mm"><?php echo number_format($subtotal = $bill->course->course_price)?></td>
            <?php  number_format($dis1 = $bill->quo_de_discount, 2) ?>
            <?php  number_format($dis2 = $bill->quo_de_disamount, 2) ?>
            <td width="15mm"><?php echo number_format($distotal = (($subtotal * $dis1 / 100) + $dis2)) ?></td>
            <?php  number_format($subtotal - $distotal, 2) ?>
            <td width="35mm"><?php echo number_format($total += ($subtotal - $distotal)) ?></td>
        </tr>
    </table>
</div>


</body>
</html>
