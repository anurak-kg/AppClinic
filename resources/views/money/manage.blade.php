@extends('layout.master')
@section('title','ข้อมูลการเงิน')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-header" align="middle">
                    <h2 class="box-title">ข้อมูลการเงินหมอ</h2>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive" >

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>รหัสหมอ</th>
                                        <th>หมอ</th>
                                        <th>ค่ามือ</th>

                                    </tr>
                                    </thead>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->dr_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->Total }}</td>
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

                <div class="box-header" align="middle">
                    <h2 class="box-title">ข้อมูลการเงินผู้ช่วย 1</h2>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive" >

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>รหัสผู้ช่วย</th>
                                    <th>ผู้ช่วย</th>
                                    <th>ค่ามือ1</th>
                                    <th>ค่ามือ2</th>

                                </tr>
                                </thead>
                                @foreach($data1 as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->bt1 }}</td>
                                        <td>{{ $item->bt2 }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@stop
