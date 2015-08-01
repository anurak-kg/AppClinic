<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->

        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br><br><br><br>

                </address>
            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    <b> สาขา {{ $order->branch->branch_name }}</b>
                    {{ $order->branch->branch_address }}<br>
                    โทร : {{ $order->branch->branch_tel }}
                    <br><br>

                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h3 align="right">
                    ใบสั่งซื้อสินค้า
                </h3>

                <b> เลขที่ใบสั่งซื้อ</b>  #{{ $order->order_id }} <br>
                <b>วันที่ออกใบสั่งซื้อ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
                {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}

            </div><!-- /.col -->

        </div><!-- /.row -->


        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>รหัสคอร์ส</th>
                        <th>คอร์ส</th>
                        <th>จำนวน</th>
                        <th>หน่วยนับ</th>
                        <th>หน่วยละ</th>
                        <th>จำนวนเงิน</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0 ?>

                    @foreach($order->product as $item)
                        <tr>
                            <td>{{ $item->product_id }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $qty = $item->pivot->order_de_qty }}</td>
                            <td>{{ $item->product_unit }}</td>
                            <td><?php echo number_format($subtotal =$item->product_price)?></td>
                            <td><?php echo number_format($subtotal*$qty) ?></td>
                        </tr>
                        <?php $total+=($subtotal) ?>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>ยอดเงินสุทธิ</th>
                        <td><?php echo number_format($total,2) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

            </div><!-- /.col -->

        </div><!-- /.row -->



    </section><!-- /.content -->
</div><!-- ./wrapper -->

<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
</body>
</html>



