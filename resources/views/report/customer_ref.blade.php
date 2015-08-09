@extends('layout.master')
@section('title','แหล่งที่มาสมาชิก')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">สรุปแหล่งที่มาสมาชิก</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="areaChart" height="50"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ตารางสรุปข้อมูล</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td align="middle"><b>ประเภท</b></td>
                                <td align="middle"><b>จำนวน</b></td>
                                <td align="middle"><b>จำนวน</b></td>
                                <td align="middle"><b>จำนวน</b></td>
                            </tr>
                            </thead>
                            @foreach($ref as $test)
                                <tr>

                                    <td align="middle">{{$test->name}}</td>
                                    <td align="middle"><?php echo number_format($test->web)?></td>
                                    <td align="middle" ><?php echo number_format($test->booth)?></td>
                                    <td align="middle" ><?php echo number_format($test->offline)?></td>
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
                                fillColor: "#FF6347",
                                strokeColor: "#FF6347",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#FF6347",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: {!!$web !!}
                             },
                            {
                                label: "Electronics",
                                fillColor: "#63B8FF",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "#63B8FF",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#63B8FF",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: {!!$booth !!}
                             },
                            {
                                label: "Electronics",
                                fillColor: "#54FF9F",
                                strokeColor: "#54FF9F",
                                pointColor: "#54FF9F",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#54FF9F",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: {!!$offline !!}
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
        })
        ;
    </script>
    </body>

@stop