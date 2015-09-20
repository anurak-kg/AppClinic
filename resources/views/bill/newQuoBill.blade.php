<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <style>
        @page {
            sheet-size: 228.6mm 139.7mm;
            margin-top: 13mm;
            margin-left: 3mm;
            margin-right: 5mm;
        }
        body {
            font-size: 3.2mm;
        }
        .warp {
            height: 139.7mm;
            width: 228.6mm;
        }
        .box {
            /*border: 0.1mm solid;*/
            height: 9mm;
            line-height: 9mm;

        }

        .origin_box {
            float: right;
            width: 50mm;

        }

        .detail_box {
            margin-top: 1mm;
            width: 100%;
        }

        .customer_box {
            float: left;
            width: 123mm;
        }

        .cus_name_box {
            padding-left: 30mm;
        }

        .customer_address_box {
            padding-left: 30mm;

        }

        .sale_box {
            float: right;
            width: 73mm;
        }

        .customer_id_box {
            padding-left: 30mm;

        }

        .customer_sale_box {
            padding-left: 30mm;

        }

        .bill_number_box {
            padding-left: 20mm;

        }

        .bill_date_box {
            padding-left: 20mm;

        }
         .course{
            margin-top: 16mm;
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
            <?php echo zerofill($bill->bill_id) ?>
        </div>
        <div class="box bill_date_box">
            {{Jenssegers\Date\Date::now()->format('d/m/Y')}}
        </div>
    </div>
    <div class="detail_box">
        <div class="box customer_box">
            <div class="box cus_name_box">{{ $customer->cus_name }}</div>
            <div class="box customer_address_box">{{ $customer->cus_hno }}
                {{ $customer->cus_moo }}
                {{ $customer->cus_soi }}
                {{ $customer->cus_road }}
                {{ $customer->cus_subdis }}
                {{ $customer->cus_district }}
                {{ $customer->cus_province }}
                {{ $customer->cus_postal }}
                {{ $customer->cus_tel }}
                {{ $customer->cus_phone }}</div>

        </div>
        <div class="box sale_box">
            <div class="box customer_id_box"> {{ $customer->cus_id }}</div>
            <div class="box customer_sale_box"> {{ $bill->emp_id }}</div>
        </div>
    </div>


    <?php $total = 0 ?>
    <?php $index = 0 ?>

    <table class="course">
        @foreach($bill->bill_detail as $item)

        <tr>
            <td  width="11.5mm"><?php echo $index += 1?></td>
            <td width="22mm">{{$item->payment_detail->payment->quotations_detail->course->course_id }}</td>
            <td width="95mm">{{ $item->payment_detail->payment->quotations_detail->course->course_name }}      </td>
            <td width="18mm">1</td>
            <td width="18mm"><?php echo number_format($subtotal = $item->payment_detail->payment->quotations_detail->course->course_price)?></td>
            <?php  number_format($dis1 = $item->payment_detail->payment->quotations_detail->quo_de_discount, 2) ?>
            <?php  number_format($dis2 = $item->payment_detail->payment->quotations_detail->quo_de_disamount, 2) ?>
            <td width="18mm"><?php echo number_format($distotal = (($subtotal * $dis1 / 100) + $dis2)) ?></td>
            <?php  number_format($subtotal - $distotal, 2) ?>
            <td width="30mm"><?php echo number_format($total = ($subtotal - $distotal)) ?></td>
        </tr>
       @endforeach
    </table>
</div>


</body>
</html>
