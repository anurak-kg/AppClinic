{{--
- คอร์สที่ซื้อ
- รักษา
- สินค้าที่ซื้อ
- ประวัติ
--}}

@extends('layout.master')
@section('title','ข้อมูลลูกค้า')
@section('headText','ข้อมูลลูกค้า')
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="box box-soild box-default">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">ข้อมูล</h2>
                </div>

                <div class="box-body">

                    <div class="col-md-12">
                        {{  $data->cus_id }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_name }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_code }}
                        <br>
                    </div>

                    <div class="col-md-4">
                        {{  $data->cus_birthday_day }}
                        <br>
                    </div>

                    <div class="col-md-4">
                        {{  $data->cus_birthday_month }}
                        <br>
                    </div>

                    <div class="col-md-4">
                        {{  $data->cus_birthday_year }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_sex }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_blood }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_phone }}
                        <br>
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_email }}
                        <br>
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_height }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_weight }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->allergic }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->disease }}
                        <br>
                    </div>

                </div>
            </div>

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">ที่อยู่</h2>
                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        z {{  $data->cus_hno }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_moo }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_soi }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_road }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_subdis }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_district }}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {{  $data->cus_province }}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {{  $data->cus_postal }}
                        <br>
                    </div>

                </div>
            </div>

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">คอร์ส</h2>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            @foreach($data->quotations as $quotations)
                                รหัสการซื้อ {{ $quotations->quo_id }} ราคา {{ $quotations->price }} ชำระแล้ว .... บาท สถาน .... <br>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>รหัสคอร์ส</th>
                                        <th>คอร์ส</th>
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
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">ประวัติการรักษา</h2>
                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <br>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
@stop