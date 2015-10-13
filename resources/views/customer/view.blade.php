@extends('layout.master')
@section('title',trans("customer.customer data"))
@section('headText',$data->cus_name)
@section('headDes',$data->cus_id)
@section('content')

    <div class="row">


        <div class="col-md-6">
            <div class="box box-soild box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans("customer.customer data")}}</h2>


                </div>

                <div class="box-body">

                    <div class="col-md-12">
                        <b>{{trans("customer.customer id")}} : </b> {{  $data->cus_id }}
                        <br> <br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.name")}} : </b> {{  $data->cus_name }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.identification Code")}} : </b> {{  $data->cus_code }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.birthday")}} : </b> {{  $data->cus_birthday_day }}
                        {{  $data->cus_birthday_month }}
                        {{  $data->cus_birthday_year }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.gender")}} : </b> {{  $data->cus_sex }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>{{trans("customer.blood")}} : </b> {{  $data->cus_blood }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.height")}} : </b> {{  $data->cus_height }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.weight")}} : </b> {{  $data->cus_weight }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.allergic")}} : </b> {{  $data->allergic }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.disease")}} : </b> {{  $data->disease }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>{{trans("customer.phone")}} : </b> {{  $data->cus_phone }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>{{trans("customer.email")}} : </b> {{  $data->cus_email }}
                        <br><br>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-soild box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans("customer.address")}}</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('/customer')}}" class="btn btn-success">{{trans("customer.back")}}</a>
                    </div>

                </div>

                <div class="box-body">

                    <div class="col-md-6">
                        <b>{{trans("customer.village no")}} : </b> {{  $data->cus_hno }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.house no")}} : </b> {{  $data->cus_moo }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.lane")}} : </b> {{  $data->cus_soi }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.road")}} : </b> {{  $data->cus_road }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.sub-district/ sub-area")}} : </b> {{  $data->cus_subdis }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.district / area")}} : </b> {{  $data->cus_district }}
                        <br><br>
                    </div>

                    <div class="col-md-6">
                        <b>{{trans("customer.province")}} : </b> {{  $data->cus_province }}
                        <br><br>
                    </div>

                    <div class="col-md-12">
                        <b>{{trans("customer.postal code")}} : </b> {{  $data->cus_postal }}
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

                <div class="box-body" id="quo">

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

                <div class="box-body" id="history">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>รหัสการรักษา</th>
                                    <th>สาขา</th>
                                    <th>ชื่อคอร์ส</th>
                                    <th>ตัวยา</th>
                                    <th>จำนวน</th>
                                    <th>แพทย์</th>
                                    <th>ผู้ช่วย1</th>
                                    <th>ผู้ช่วย2</th>
                                    <th>รายละเอียด</th>
                                    <th>วันที่รักษา</th>
                                </tr>
                                </thead>
                                @foreach($treat as $item)
                                    <tr>

                                        <td style="width: 180px;">{{ $item->treat_id }}</td>

                                        <td style="width: auto;">{{ $item->branch_name }}</td>

                                        <td>{{ $item->course_name }}</td>

                                        <td>{{ $item->product_name }}

                                        <td>{{ $item->qty }}</td>

                                        <td>
                                            <?php
                                            if($item->dr == null) {
                                                echo 'ไม่มีแพทย์';
                                            }else{
                                                echo $item->dr;
                                            }
                                            ?></td>

                                        <td>
                                            <?php
                                            if($item->bt1 == null) {
                                                echo 'ไม่มีผู้ช่วย';
                                            }else{
                                               echo $item->bt1;
                                            }
                                             ?></td>

                                        <td>
                                            <?php
                                            if($item->bt2 == null) {
                                                echo 'ไม่มีผู้ช่วย';
                                            }else{
                                                echo $item->bt2;
                                            }
                                            ?></td>

                                        <td style="width: 150px">
                                            <?php
                                            if ($item->comment != null) {
                                                echo $item->comment;
                                            } else {
                                                echo 'ไม่มีรายละเอียด';
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

                <div class="box-body" id="payment">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ลำดับที่</th>
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
                                            $bank = \App\Payment_bank::find($item->bank_id);
                                            if ($bank != null) {
                                                echo $bank->bank_name;
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
                                        <td style="width: 300px"><?php
                                            if ($item->card_id != null) {
                                                echo $item->card_id;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            }  ?></td>
                                        <td style="width: 300px"><?php
                                            if ($item->edc_id != null) {
                                                echo $item->edc_id;
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            }
                                            ?></td>
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

    <script>
        $(function ()
        {

        $('#history').slimScroll({ height: '300'});
        $('#quo').slimScroll({ height: '300'});
        $('#payment').slimScroll({ height: '300'});

        }

        );
    </script>

@stop