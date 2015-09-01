@extends('layout.master')
@section('title','ข้อมูลการเงิน')
@section('content')

    <div class="row">
        <div class="row " style="    border-bottom: 1px solid #f4f4f4;">
            <div class="col-md-6 col-md-offset-3">
                <form class="form-horizontal" action="{{url('')}}" method="get">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">เลือกสาขา</label>

                        <div class="col-sm-8">
                            <select class="form-control" name="branch">
                                <option value="0">ทุกสาขา</option>

                            </select>
                        </div>
                        <button class="col-sm-2 btn btn-default">ค้นหา</button>

                    </div>

                </form>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3">

            <form class="form-horizontal" action="{{url('')}}" method="get">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">เลือกระยะเวลา</label>
                    <div class="col-sm-8">
                    {!! Form::open(array('url' => '', 'class' => 'form')) !!}
                <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
                       placeholder="เลือกระยะเวลา..">
                </input> <br> <br>
                <input type="submit" class="btn btn-block btn-primary" value="แสดง">
                <br>
                {!! Form::close() !!}
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-12">



            <div class="box box-info">

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

            <div class="box box-success">

                <div class="box-header" align="middle">
                    <h2 class="box-title">ข้อมูลการเงินผู้ช่วย</h2>
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
    <!-- date-range-picker -->
    <script src="/dist/js/moment.min.js" type="text/javascript"></script>
    <script src="/dist/js/jquery.daterangepicker.js" type="text/javascript"></script>
    <link href="/dist/js/daterangepicker.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(function () {
            $('#daterange').dateRangePicker(
                    {
                        autoClose: true,
                        showShortcuts: true,
                        shortcuts: {
                            //'prev-days': [1,3,5,7],
                            'next-days': [3, 5, 7],
                            //'prev' : ['week','month','year'],
                            'next': ['week', 'month', 'year']
                        },
                    }
            );


        });
    </script>
@stop
