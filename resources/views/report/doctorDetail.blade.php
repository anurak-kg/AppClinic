@extends('layout.master')
@section('title','Report')
@section('headText','Report')
@section('headDes',trans('report.doctor'))
@section('content')

    <p class="text-center">
        {!! Form::open(array('url' => 'report/doctorDetail', 'class' => 'form')) !!}
        <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
               placeholder="..">
        </input> <br> <br>
        <input type="submit" class="btn btn-block btn-primary" value="{{trans('report.show')}}">
        <br>
        {!! Form::close() !!}
    </p>


    <div class="box">
        <div class="box-header with-border" align="middle">
            <h2 class="box-title">{{trans('report.table')}}</h2>

            <div class="box-tools pull-right">
                <a class="btn btn-success" href="{{url('report/index')}}">{{trans('report.back')}}</a>
                <a class="btn btn-warning" href="{{url('report/doctorGraphic')}}">{{trans('report.graph')}}</a>
            </div>
        </div>
        <div class="box-body" id="datatable">
                  <span class="pull-right">
                         {!! Form::open(array('url' => 'report/doctorDetail?type=excel', 'class' => 'form')) !!}
                      <input type="submit" class="btn btn-block btn-info" value="Excel Export" >
                      {!! Form::close() !!}
                    </span>

            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td align="middle"><b>{{trans('report.doctor')}}</b></td>
                            <td align="middle"><b>{{trans('report.sale')}}</b></td>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>

                                <td align="middle">{{$test->name}}</td>
                                <td align="middle" style="width: 850px;"><?php echo number_format($test->Total), trans('report.baht') ?></td>
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