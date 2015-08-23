@extends('layout.master')
@section('title','ข้อมูลลูกค้า')
@section('headText',$data->cus_name)
@section('headDes',$data->cus_id)
@section('content')

    <div class="row">


        <div class="col-md-6">
            <div class="box box-soild box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>


                </div>

                <div class="box-body">

                    <div class="col-md-12">
                        <b>รหัสลูกค้า : </b> {{  $data->cus_id }}
                        <br> <br>
                    </div>

                    <div class="col-md-6">
                        <b>ชื่อลูกค้า : </b> {{  $data->cus_name }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>เลขประจำตัวประชาชน : </b> {{  $data->cus_code }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>วันเกิด : </b> {{  $data->cus_birthday_day }}
                        {{  $data->cus_birthday_month }}
                        {{  $data->cus_birthday_year }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>เพศ : </b> {{  $data->cus_sex }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>กรุ๊ปเลือด : </b> {{  $data->cus_blood }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>ส่วนสูง : </b> {{  $data->cus_height }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>น้ำหนัก : </b> {{  $data->cus_weight }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>โรคประจำตัว : </b> {{  $data->allergic }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>แพ้ยา : </b> {{  $data->disease }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>เบอร์โทร : </b> {{  $data->cus_phone }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>E-mail : </b> {{  $data->cus_email }}
                        <br><br>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-soild box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">&nbsp; ที่อยู่</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('/customer')}}" class="btn btn-success">กลับไปที่ข้อมูลลูกค้า</a>
                    </div>

                </div>

                <div class="box-body">

                    <div class="col-md-6">
                        <b>บ้านเลขที่ : </b> {{  $data->cus_hno }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>หมู่ : </b> {{  $data->cus_moo }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>ซอย/ตรอก : </b> {{  $data->cus_soi }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>ถนน : </b> {{  $data->cus_road }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>ตำบล/แขวง : </b> {{  $data->cus_subdis }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>อำเภอ/เขต : </b> {{  $data->cus_district }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>จังหวัด : </b> {{  $data->cus_province }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>รหัสไปรษณีย์ : </b> {{  $data->cus_postal }}
                        <br><br>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ข้อมูลคอร์ส</h2>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            @foreach($data->quotations as $quotations)
                                <b> รหัสการซื้อ #{{ $quotations->quo_id }} / ราคา {{ $quotations->price }} บาท</b>
                                <br>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>รหัสคอร์ส</th>
                                        <th style="width: 900px;">คอร์ส</th>
                                        <th>จำนวน</th>
                                    </tr>
                                    </thead>
                                    @foreach($quotations->course as $course)
                                        <tr>
                                            <td>{{ $course->course_id }}</td>
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->course_qty }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ประวัติการรักษา</h2>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>รหัสการรักษา</th>
                                    <th>สาขา</th>
                                    <th>ชื่อคอร์ส</th>
                                    <th>แพทย์</th>
                                    <th>ผู้ช่วย1</th>
                                    <th>ผู้ช่วย2</th>
                                    <th>ตัวยาที่ใช้</th>
                                    <th>รายละเอียด</th>
                                    <th>วันที่รักษา</th>
                                </tr>
                                </thead>
                                @foreach($treat as $item)
                                    <tr>

                                        <td style="width: 180px;">{{ $item->treat_id }}</td>

                                        <td style="width: auto;"><?php
                                            $branch = \App\Branch::find($item->branch_id);
                                            if ($branch != null) {
                                                echo $branch->branch_name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?></td>

                                        <td>{{ $item->course_name }}</td>
                                        <td><?php
                                            $dr = \App\User::find($item->dr_id);
                                            if ($dr != null) {
                                                echo $dr->name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td><?php
                                            $bt1 = \App\User::find($item->bt_user_id1);
                                            if ($bt1 != null) {
                                                echo $bt1->name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td><?php
                                            $bt2 = \App\User::find($item->bt_user_id2);
                                            if ($bt2 != null) {
                                                echo $bt2->name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td style="width: 300px">{{ $item->product_name }}</td>

                                        <td style="width: 300px">
                                            <?php
                                            if ($item->comment != null) {
                                                echo $item->comment;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td>{{ $item->treat_date }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ประวัติการจ่ายเงิน</h2>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ประเภท</th>
                                    <th>ธนาคาร</th>
                                    <th>จำนวนเงิน</th>
                                    <th>วันที่จ่าย</th>
                                    <th>สาขา</th>
                                    <th>เลขที่บัตรเครดิต</th>
                                    <th>เลขที่เครื่อง EDC</th>
                                </tr>
                                </thead>
                                @foreach($payment as $item)
                                    <tr>

                                        <td style="width: 180px;">{{ $item->payment_id }}</td>

                                        <td style="width: 180px;">{{ $item->payment_type }}</td>

                                        <td><?php
                                            $dr = \App\Payment_bank::find($item->bank_id);
                                            if ($dr != null) {
                                                echo $dr->bank_name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td style="width: 180px;">{{ $item->amount }}</td>
                                        <td style="width: 180px;">{{ $item->created_at }}</td>
                                        <td><?php
                                            $bt2 = \App\Branch::find($item->branch_id);
                                            if ($bt2 != null) {
                                                echo $bt2->branch_name;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            } ?>
                                        </td>
                                        <td style="width: 300px">{{ $item->card_id }}</td>
                                        <td style="width: 300px">{{ $item->edc_id }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-soild box-default">
                <div class="box-header with-border">
                    <h2 class="box-title" align="middle">Before</h2>

                </div>
                <div class="box-body">
                    @foreach($dataphotoBefore as $item)
                        <img src="{{ asset('/uploads/customer/'.$item->photo_file_name.'') }}" class="img-thumbnail"
                             width="304" height="236"/>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-soild box-default">
                <div class="box-header with-border">
                    <h2 class="box-title" align="middle">After</h2>

                </div>
                <div class="box-body">
                    @foreach($dataphotoAfter as $item)
                        <img src="{{ asset('/uploads/customer/'.$item->photo_file_name.'') }}" class="img-thumbnail"
                             width="304" height="236"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop