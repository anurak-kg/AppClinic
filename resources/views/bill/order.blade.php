<html>
<head>

</head>

<body onload="window.print();">
    <section class="invoice">
        <div class="row">
        <div align="middle">

            <div align="right">

                <b> เลขที่ใบสั่งซื้อ</b> # {{ $order->order_id }}<br>
                <b>วันที่ออกใบสั่งซื้อ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
                {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}
            </div>

        <h3 align="center">
            ใบสั่งซื้อสินค้า
        </h3>
            <div align="center">

                <b> สาขา :</b> {{ $order->branch->branch_name }} <br>
                <b> ที่อยู่ :</b> {{ $order->branch->branch_address }}


            </div>

        </div>
        </div>

            <div class="col-sm-4 invoice-col">
                <hr>
                <br>

                <b> รหัสพนักงาน :</b> {{ $order->user->id }}<br>
                <b> พนักงาน :</b> {{ $order->user->name }}


                <br><hr>

                <b> ร้านค้า :</b> {{ $order->vendor->ven_name }} <br>
                <b> ที่อยู่ :</b>  {{ $order->vendor->ven_address }}<br>
                <b> หมายเลขประจำตัวผู้เสียภาษี :</b>  {{ $order->vendor->ven_license }}


                <hr>
            </div>




        <div class="row">
            <div align="center">
                <table border="1" style="width:100%" align="center">
                    <thead>
                    <tr>
                        <td><b>ลำดับ</b></td>
                        <td><b>รหัสสินค้า</b></td>
                        <th>สินค้า</th>
                        <td align="middle"><b>จำนวน</b></td>
                        <td align="middle"><b>หน่วยนับ</b></td>
                        <td align="middle"><b>หน่วยละ</b></td>
                        <td align="middle"><b>จำนวนเงิน</b></td>

                    </tr>
                    </thead>
                    <tbody >
                    <?php $total=0 ?>
                    <?php $index=0 ?>
                        @foreach($order->product as $item)
                            <tr style="height: 1000px">

                                <td style="width: 20px"><?php echo $index=+1 ?></td>
                                <td style="width: 90px">{{$item->product_id}}</td>
                                <td style="width: 240px">{{$item->product_name}}</td>
                                <td  align="center" style="width: 70px">{{$qty = $item->pivot->order_de_qty}}</td>
                                <td  align="center" style="width: 70px">{{$item->product_unit}}</td>
                                <td align="center" style="width: 70px">{{number_format($price = $item->product_price)}}</td>
                                <td align="center" style="width: 90px" >{{number_format($sumtotal = $price*$qty)}}</td>

                            </tr>






                           <?php  $total+=($sumtotal) ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      <td align="middle" style="width: 90px"><b>ยอดเงินสุทธิ</b></td>
                        <td align="middle">{{ number_format($total) }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <br>
            <div align="right">
            <b >ผู้สั่งซื้อ </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>ผู้อนุมัติ </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> <br>
            <b>วันที่   &nbsp;&nbsp;&nbsp; /   &nbsp;&nbsp;&nbsp;  /  &nbsp;&nbsp;&nbsp;  </b> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  &nbsp;
                <b>วันที่   &nbsp;&nbsp;&nbsp; /   &nbsp;&nbsp;&nbsp;  /  &nbsp;&nbsp;&nbsp;  </b><br>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
</body>
</html>
