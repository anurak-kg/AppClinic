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
            <?php echo zerofill($bill->bill_number) ?>
        </div>
        <div class="box bill_date_box">
            {{Jenssegers\Date\Date::now()->format('d/m/Y')}}
        </div>
    </div>
    <div class="detail_box">
        <div class="box customer_box">
            <div class="box cus_name_box">{{ $bill->customer->cus_name }}</div>
            <div class="box customer_address_box">
               {{ $bill->customer->cus_hno }}
               {{ $bill->customer->cus_moo }}
               {{ $bill->customer->cus_soi }}
               {{ $bill->customer->cus_road }}
               {{ $bill->customer->cus_subdis }}
               {{ $bill->customer->cus_district }}
               {{ $bill->customer->cus_province }}
               {{ $bill->customer->cus_postal }}
               {{ $bill->customer->cus_tel }}
               {{ $bill->customer->cus_phone }}           </div>

        </div>
        <div class="box sale_box">
            <div class="box customer_id_box"> {{ $bill->customer->cus_id }}</div>
            <div class="box customer_sale_box"></div>
        </div>
    </div>
    <?php $total = 0 ?>
    <?php $index = 0 ?>
    <table class="course">
        <tr>
           {{-- {{dd($bill)}}--}}
            <td  width="11.5mm"><?php echo $index += 1?></td>
            <td width="22mm">{{ $bill->product[$index]->product_id }}</td>
            <td width="95mm">{{ $bill->product[$index]->product_name }}    </td>
            <td width="18mm">{{$qty = $bill->product[$index]->pivot->sales_de_qty }}</td>
            <td width="18mm"><?php echo number_format($price = $bill->product[$index]->pivot->sales_de_price)?></td>
            <?php  number_format($dis1 = $bill->product[$index]->pivot->sales_de_discount, 2) ?>
            <?php  number_format($dis2 = $bill->product[$index]->pivot->sales_de_disamount, 2) ?>
            <td width="18mm"><?php echo number_format($distotal = (($subtotal * $dis1 / 100) + $dis2)) ?></td>
            <?php  number_format($distotal = (($price * $dis1 / 100) + $dis2))  ?>
            <td width="30mm"><?php echo number_format($bill->product[$index]->pivot->sales_de_net_price,2)  ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="30mm"><?php echo number_format($price-$distotal,2)  ?></td>
        </tr>
    </table>
</div>
</body>
</html>





