@extends('layout.master')
@section('title','ข้อมูลการเงิน')
@section('content')


    <div class="box box">
            <div class="box-header" align="middle"></div>
            <div class="box-body">
                <div class="row ">
                    <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" action="{{url('money/manage')}}" method="get">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">เลือกสาขา</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="branch">
                                        <option value="0">ทุกสาขา</option>
                                        @foreach($branch as $item)
                                            <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="col-sm-2 btn btn-default">ค้นหา</button>

                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-7 col-md-offset-3">


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">เลือกเดือน</label>

                            <div class="col-sm-8">
                                {!! Form::open(array('url' => 'money/manage', 'class' => 'form')) !!}
                                <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
                                       placeholder="เลือกระยะเวลา..">
                                </input> <br> <br>
                                <input type="submit" class="btn btn-block btn-primary" value="แสดง">
                                <br>
                                {!! Form::close() !!}
                            </div>
                        </div>
<br><br><br><br>

                    <p class="text-center">

                        <strong> @if( isset( $date['start']))
                                <?php echo $date['start'];?> - <?php echo $date['end'];?>
                            @else
                                <?php 'ว่าง' ?>
                            @endif</strong>
                    </p>
                    <br>
                </div>
            </div>
        </div>

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
                        <div class="col-xs-12 table-responsive">

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
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->n }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
                        <div class="col-xs-12 table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>รหัสผู้ช่วย</th>
                                    <th>ผู้ช่วย</th>
                                    <th>ค่ามือ</th>


                                </tr>
                                </thead>
                                @foreach($data1 as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->n }}</td>
                                        <td>{{ $item->total }}</td>

                                    </tr>


                                @endforeach
                            </table>
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
