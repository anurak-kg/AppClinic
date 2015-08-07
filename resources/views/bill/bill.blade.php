<html>
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="/bootstrap-pdf.min.css" rel="stylesheet" type="text/css" />

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
                    <b> ชื่อลูกค้า {{ $bill->customer->cus_name }} {{ $bill->customer->cus_lastname }} </b> <br>
                      {{ $bill->customer->cus_hno }}
                      {{ $bill->customer->cus_moo }}
                      {{ $bill->customer->cus_soi }}
                      {{ $bill->customer->cus_road }}
                      {{ $bill->customer->cus_subdis }}
                      {{ $bill->customer->cus_district }}
                      {{ $bill->customer->cus_province }}
                      {{ $bill->customer->cus_postal }}
                      {{ $bill->customer->cus_tel }}
                      {{ $bill->customer->cus_phone }}
                </address>
            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
                <address>
                    <br><br>
                    <b> สาขา {{ $bill->branch->branch_name }}</b>
                    {{ $bill->branch->branch_address }}<br>
                    โทร : {{ $bill->branch->branch_tel }}
                    <br><br>
                    <b>รหัสลูกค้า:</b> {{ $bill->customer->cus_id }}

                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h3 align="right">
                    ใบเสร็จรับเงิน
                </h3>

                <b> เลขที่ใบเสร็จรับเงิน</b>  #{{ $bill->quo_id }} <br>
                <b>วันที่ออกใบเสร็จ : </b> {{Jenssegers\Date\Date::now()->format('d/m/Y')}}<br>
               {{-- <b>ใบสั่งยา :</b> {{ $bill->treatment->tre_id }} <br>--}}
                <b>พนักงาน :</b> {{ $bill->user->name }} <br>

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
                        <th>ส่วนลด</th>
                        <th>จำนวนเงิน</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0 ?>
                    @foreach($bill->course as $course)
                    <tr>
                        <td>{{ $course->course_id }}</td>
                        <td>{{ $course->course_name }}</td>
                        <td></td>
                        <td></td>
                        <td><?php echo number_format($subtotal = $course->course_price)?></td>
                        <td><?php echo number_format($dis= $bill->discount,2) ?> </td>
                        <td><?php echo number_format($subtotal-$dis,2) ?></td>
                    </tr>
                            <?php $total+=($subtotal-$dis) ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
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

</body>
</html>



