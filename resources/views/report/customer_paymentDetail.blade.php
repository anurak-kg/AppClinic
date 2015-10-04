@extends('layout.master')
@section('title','Report')
@section('headText','Report')
@section('headDes','รายงาน รายได้ทั้งหมด แบ่งเป็นประเภทการชำระเงิน')
@section('content')

    <p class="text-center">
        {!! Form::open(array('url' => 'report/customer_paymentDetail', 'class' => 'form')) !!}
        <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
               placeholder="เลือกระยะเวลา..">
        </input> <br> <br>
        <input type="submit" class="btn btn-block btn-primary" value="แสดง">
        <br>
        {!! Form::close() !!}
    </p>


    <div class="box">
        <div class="box-header with-border" align="middle">
            <h2 class="box-title">ตารางสรุปข้อมูล รายได้ทั้งหมด แบ่งเป็นประเภทการชำระเงิน</h2>

            <div class="box-tools pull-right">
                <a class="btn btn-success" href="{{url('report/index')}}">ย้อนกลับ</a>
                <a class="btn btn-warning" href="{{url('report/customer_paymentGraphic')}}">กราฟ</a>
            </div>

        </div>
        <div class="box-body" id="datatable">

                   <span class="pull-right">
                    {!! Form::open(array('url' => 'report/customer_paymentDetail?type=excel', 'class' => 'form')) !!}
                       <input type="submit" class="btn btn-block btn-info" value="Excel Export" >
                       {!! Form::close() !!}
                    </span>
            <br>
            <div class="row">
                <p class="text-center">
                    <strong> @if( isset( $date['start']))
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo  $date['start'];?> - <?php echo $date['end'];?>
                        @else
                            <?php 'ว่าง' ?>
                        @endif</strong>
                </p>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td align="middle"><b>ประเภทการชำระเงิน</b></td>
                            <td align="middle"><b>รายได้ทั้งหมด</b></td>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>

                                <td align="middle">{{$test->name}}</td>
                                <td align="middle" style="width: 850px;"><?php echo number_format($test->Total), ' บาท' ?></td>
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