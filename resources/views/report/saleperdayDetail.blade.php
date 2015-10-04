@extends('layout.master')
@section('title','Report')
@section('headText','Report')
@section('headDes','รายงาน ยอดขายพนักงาน')
@section('content')

    <p class="text-center">
        {!! Form::open(array('url' => 'report/saleperdayDetail', 'class' => 'form')) !!}
        <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
               placeholder="เลือกระยะเวลา..">
        </input> <br> <br>
        <input type="submit" class="btn btn-block btn-primary" value="แสดง">
        <br>
        {!! Form::close() !!}
    </p>



        <div class="box">
            <div class="box-header with-border" align="middle">
                <h2 class="box-title">ตารางสรุปยอดขายคอร์ส</h2>

                <div class="box-tools pull-right">
                    <a class="btn btn-success" href="{{url('report/index')}}">ย้อนกลับ</a>
                    <a class="btn btn-warning" href="{{url('report/saleperdayGraphic')}}">กราฟ</a>
                </div>
            </div>
            <div class="box-body" id="data1">
                     <span class="pull-right">
                         {!! Form::open(array('url' => 'report/saleperdayDetail?type=excel', 'class' => 'form')) !!}
                         <input type="submit" class="btn btn-block btn-info" value="Excel Export" >
                         {!! Form::close() !!}
                    </span>
                <br>
                <div class="row">
                    <p class="text-center">
                        <strong> @if( isset( $date['start']))
                                <?php echo $date['start'];?> - <?php echo $date['end'];?>
                            @else
                                <?php 'ว่าง' ?>
                            @endif</strong>
                    </p>
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td align="middle"><b>วันที่</b></td>
                                <td align="middle"><b>ยอดขาย</b></td>
                            </tr>
                            </thead>
                            @foreach($data as $test)
                                <tr>

                                    <td align="middle">{{$test->DATE}}</td>
                                    <td align="middle"><?php echo number_format($test->Total), ' บาท' ?></td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="box">
            <div class="box-header with-border" align="middle">
                <h2 class="box-title">ตารางสรุปยอดขายสินค้า</h2>
                    <span class="pull-right">
                         {!! Form::open(array('url' => 'report/saleperdayDetail?type=excel1', 'class' => 'form')) !!}
                        <input type="submit" class="btn btn-block btn-info" value="Excel Export" >
                        {!! Form::close() !!}
                    </span>
            </div>
            <div class="box-body" id="data2">
                <p class="text-center">
                    <strong> @if( isset( $date['start']))
                            <?php echo $date['start'];?>
                        @else
                            <?php 'ว่าง' ?>
                        @endif</strong>
                </p>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td align="middle"><b>วันที่</b></td>
                                <td align="middle"><b>ยอดขาย</b></td>
                            </tr>
                            </thead>
                            @foreach($datapro as $test)
                                <tr>
                                    <td align="middle">{{$test->DATE}}</td>
                                    <td align="middle"><?php echo number_format($test->Total), ' บาท' ?></td>
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

    <!-- page script -->
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