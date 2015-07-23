<!DOCTYPE html>
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
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    ใบเสร็จรับเงิน
                    <small class="pull-right">วันที่ออกใบเสร็จ : <strong>{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</strong><br></small>
                </h2>
            </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">

                <address>
                    <b> สาขา {{ $bill->branch->branch_name }}</b> <br>
                    {{ $bill->branch->branch_address }}<br>
                   เบอร์โทร : {{ $bill->branch->branch_tel }}<br>
                   E-Mail : {{ $bill->branch->branch_email }}<br>
                   หมายเลขประจำตัวผู้เสียภาษี : {{ $bill->branch->branch_code }}<br><br>
                    <b> ชื่อพนักงาน : {{ $bill->user->name }}</b> <br>
                     เบอร์โทร : {{ $bill->user->tel }} <br>
                     E-Mail : {{ $bill->user->email }} <br>
                </address>

            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>
                    <b> ชื่อลูกค้า {{ $bill->customer->cus_name }} {{ $bill->customer->cus_lastname }} </b> <br>
                    @if ($bill->customer->cus_hno==null)บ้านเลขที่ : &nbsp; - &nbsp;
                    @else บ้านเลขที่ : {{ $bill->customer->cus_hno }}
                    @endif

                    @if ($bill->customer->cus_moo==null)หมู่ : &nbsp; -  &nbsp;<br>
                    @else  หมู่ : {{ $bill->customer->cus_moo }} <br>
                    @endif

                    @if ($bill->customer->cus_soi==null)ซอย :&nbsp;  - &nbsp;
                    @else ซอย : {{ $bill->customer->cus_soi }}
                    @endif

                    @if ($bill->customer->cus_road==null)ถนน :&nbsp;  - &nbsp; <br>
                    @else ถนน : {{ $bill->customer->cus_road }} <br>
                    @endif

                    @if ($bill->customer->cus_subdis==null)ตำบล/แขวง :&nbsp;  - &nbsp;
                    @else ตำบล/แขวง : {{ $bill->customer->cus_subdis }}
                    @endif

                    @if ($bill->customer->cus_district==null)อำเภอ/เขต :&nbsp;  - &nbsp; <br>
                    @else  อำเภอ/เขต : {{ $bill->customer->cus_district }} <br>
                    @endif

                    @if ($bill->customer->cus_province==null)จังหวัด :&nbsp;  - &nbsp;
                    @else จังหวัด : {{ $bill->customer->cus_province }}
                    @endif

                    @if ($bill->customer->cus_postal==null)รหัสไปรษณีย์ :&nbsp;  - &nbsp;<br>
                    @else รหัสไปรษณีย์ : {{ $bill->customer->cus_postal }} <br>
                    @endif

                    @if ($bill->customer->cus_tel==null)เบอร์โทรศัพท์มือถือ :&nbsp;  - &nbsp;<br>
                    @else เบอร์โทรศัพท์มือถือ : {{ $bill->customer->cus_tel }} <br>
                    @endif

                    @if ($bill->customer->cus_phone==null)เบอร์โทรศัพท์บ้าน :&nbsp;  - &nbsp;<br>
                    @else เบอร์โทรศัพท์บ้าน : {{ $bill->customer->cus_phone }} <br>
                    @endif

                    @if ($bill->customer->cus_email==null)E-Mail :&nbsp;  - &nbsp;
                    @else E-Mail : {{ $bill->customer->cus_email }}
                    @endif

                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b> เลขที่ใบเสร็จรับเงิน  #{{ $bill->quo_id }}</b>
                <br/>
                <b>วันที่ซื้อคอร์ส : </b> {{ $bill->created_at->format('d/m/Y') }}<br/>
                <b>รหัสลูกค้า:</b> {{ $bill->customer->cus_id }}
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
                        <th>ราคา</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bill->course as $course)
                    <tr>
                        <td>{{ $course->course_id }}</td>
                        <td>{{ $course->course_name }}</td>
                        <td>1</td>
                        <td>{{ $course->course_price }}</td>

                    </tr>

                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead">Payment Methods:</p>
                <img src="../../dist/img/credit/visa.png" alt="Visa" />
                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard" />
                <img src="../../dist/img/credit/american-express.png" alt="American Express" />
                <img src="../../dist/img/credit/paypal2.png" alt="Paypal" />

            </div><!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">วันที่ชำระเงิน : <strong>{{Jenssegers\Date\Date::now()->format('d/m/Y')}}</strong><br></small></p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Subtotal:</th>
                            <td> <?php echo number_format($bill->price,2)  ?> บาท</td>
                        </tr>
                        <tr>
                            <th>Tax(7%):</th>
                            <td> <?php echo number_format($vat = $bill->price*config('shop.vat')/100,2) ?> บาท</td>
                        </tr>

                        <tr>
                            <th>ส่วนลด:</th>
                            <td><?php echo number_format($bill->discount,2) ?> บาท</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td><?php echo number_format($bill->price+$vat,2) ?> บาท</td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row no-print">
            <div class="col-xs-12">
                <a href="{{url('bill/bill_print')}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- ./wrapper -->

<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js" type="text/javascript"></script>
</body>
</html>



