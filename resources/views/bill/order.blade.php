<html>
<head>

</head>

<body>
    <section class="invoice">
        <div class="row">
        <div align="middle">

        <h3 align="middle">
            ใบสั่งซื้อสินค้า
        </h3>

            <address>
<br>
                <b> สาขา :</b> {{ $order->branch->branch_name }} <br>
                <b> ที่อยู่ :</b> {{ $order->branch->branch_address }}

            </address>

        </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    <b> ร้านค้า :</b> {{ $order->vendor->ven_name }} <br>
                    <b> ที่อยู่ :</b> {{ $order->vendor->ven_address }} <br>


                </address>
            </div>
            <!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    <b> รหัสพนักงาน :</b> {{ $order->user->id }}<br>
                    <b> พนักงาน :</b> {{ $order->user->name }}<br>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">

                <br><br>
                <b> เลขที่ใบสั่งซื้อ</b> # {{ $order->order_id }}<br>
                <b>วันที่ออกใบสั่งซื้อ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
                {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" style="height: 1200px">
                    <thead>
                    <tr>
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
                        @foreach($order->product as $item)
                            <tr style="height: 20px">
                                <td>{{$item->product_id}}</td>
                                <td>{{$item->product_name}}</td>
                                <td  align="middle">{{$qty = $item->pivot->order_de_qty}}</td>
                                <td  align="middle">{{$item->product_unit}}</td>
                                <td align="middle">{{number_format($price = $item->product_price)}}</td>
                                <td align="middle">{{number_format($sumtotal = $price*$qty)}}</td>
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
                        <td align="middle"><b>ยอดเงินสุทธิ</b></td>
                        <td align="middle">{{ number_format($total) }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
</body>
</html>
