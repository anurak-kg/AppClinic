@extends('layout.master')
@section('title','ยอดขายรายวัน')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">
                {!! Form::open(array('url' => 'report/salesperday', 'class' => 'form')) !!}
                <input class="btn btn-default btn-block pull-right" id="daterange" name="rang"
                       placeholder="เลือกระยะเวลา..">
                </input> <br> <br>
                <input type="submit" class="btn btn-block btn-primary" value="แสดง">
                <br>
                {!! Form::close() !!}
            </p>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">สรุปยอดขายรายวัน</h3>
                    <span class="pull-right"><input type="submit" class="btn btn-block btn-success" value="Export" ></span>

                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center">
                                <strong> @if( isset( $date['start']))
                                        <?php echo $date['start'];?> - <?php echo $date['end'];?>
                                    @else
                                        <?php 'ว่าง' ?>
                                    @endif</strong>
                            </p>
                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="areaChart" height="50"></canvas>
                            </div><!-- /.chart-responsive -->
                        </div><!-- /.col -->
                        <div class="col-md-12">

                            <div class="progress-group">

                             <span class="progress-text">คอร์ส</span>
                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width: 100%"></div>
                                </div> <br>
                             <span class="progress-text"> สินค้า</span>
                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-green" style="width: 100%"></div>
                                </div>

                            </div><!-- /.progress-group -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- ./box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ตารางสรุปยอดขายคอร์ส</h2>
                </div>
                <div class="row">
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
                                    @if( $test->total_sales != 0)
                                        <td align="middle">{{$test->DATE}}</td>
                                        <td align="middle"><?php echo number_format($test->total_sales), ' บาท' ?></td>
                                        @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ตารางสรุปยอดขายสินค้า</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td align="middle"><b>วันที่</b></td>
                                <td align="middle"><b>ยอดขาย</b></td>
                            </tr>
                            </thead>
                            @foreach($datapro1 as $test)
                                <tr>
                                    @if( $test->total_sales != 0)
                                        <td align="middle">{{$test->DATE}}</td>
                                        <td align="middle"><?php echo number_format($test->total_sales), ' บาท' ?></td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->




    <!-- date-range-picker -->
    <script src="/dist/js/moment.min.js" type="text/javascript"></script>
    <script src="/dist/js/jquery.daterangepicker.js" type="text/javascript"></script>
    <link href="/dist/js/daterangepicker.css" rel="stylesheet" type="text/css"/>

    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js" type="text/javascript"></script>


    <!-- page script -->
    <script type="text/javascript">
        $(function () {
                    $('#daterange').datepicker({
                        format: "yyyy-mm",
                        startView: 2,
                        minViewMode: 1,
                        language: "th",
                        autoclose: true
                    })


                    //--------------
                    //- AREA CHART -
                    //--------------

                    // Get context with jQuery - using jQuery's .get() method.
                    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
                    // This will get the first returned node in the jQuery collection.
                    var areaChart = new Chart(areaChartCanvas);

                    var areaChartData = {
                        labels: {!! $name !!},
                datasets :
        [
            {
                label: "Electronics",
                fillColor: "#98F5FF",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "rgba(151,187,205,1)",
                data: {!! $total !!}
            },
            {
                label: "Electronics",
                        fillColor: "#98FB98",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "#00CD66",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#00CD66",
                    data: {!! $total1 !!}
            },

        ]
        };

        var areaChartOptions = {

            scaleBeginAtZero: true,
            ///Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines : true,

            //String - Colour of the grid lines
            scaleGridLineColor : "rgba(0,0,0,.05)",

            //Number - Width of the grid lines
            scaleGridLineWidth : 1,

            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,

            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,

            //Boolean - Whether the line is curved between points
            bezierCurve : true,

            //Number - Tension of the bezier curve between points
            bezierCurveTension : 0.4,

            //Boolean - Whether to show a dot for each point
            pointDot : true,

            //Number - Radius of each point dot in pixels
            pointDotRadius : 4,

            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth : 1,

            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius : 20,

            //Boolean - Whether to show a stroke for datasets
            datasetStroke : true,

            //Number - Pixel width of dataset stroke
            datasetStrokeWidth : 2,

            //Boolean - Whether to fill the dataset with a colour
            datasetFill : true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions);

        });
    </script>
    </body>

@stop