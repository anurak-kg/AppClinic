@extends('layout.master')
@section('title','ยอดขายพนักงาน')
@section('content')


    <div class="row">

        <div class="col-md-12">


            <!-- BAR CHART -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 align="middle">ยอดขายพนักงาน</h4>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    {!! Form::open(array('url' => 'report/sale', 'class' => 'form')) !!}
                    <div class="form-group">
                        <div class="input-group">
                            <label>กำหนดระยะเวลา</label><br>
                            <input class="btn btn-default pull-right" id="daterange" name="rang" placeholder="เลือกระยะเวลา..">
                            </input><br><br>
                            <div align="left"> <input type="submit"  class="btn btn-block btn-primary" value="แสดง"></div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    <div class="chart">
                        <canvas id="areaChart" height="300"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col (RIGHT) -->
    </div>

    <div class="box box-primary">

        <div class="box-header" align="middle">
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
                            <th>พนักงาน</th>
                            <th>ยอดขาย</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td> {{$test->name}}</td>
                                <td><?php echo number_format( $test->Total) ,' บาท' ?></td>
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

    <!-- daterange picker -->
    <link href="/dist/js/daterangepicker.css" rel="stylesheet" type="text/css" />

    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js" type="text/javascript"></script>


    <!-- page script -->
    <script type="text/javascript">
        $(function () {

                    $('#daterange').dateRangePicker(
                            {
                                autoClose: true,
                                showShortcuts: true,
                                shortcuts:
                                {
                                    //'prev-days': [1,3,5,7],
                                    'next-days': [3,5,7],
                                    //'prev' : ['week','month','year'],
                                    'next' : ['week','month','year']
                                },
                            }

                    );

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(areaChartCanvas);

            var areaChartData = {
                labels:{!! $name !!},
                datasets: [
                    {
                        label: "Electronics",
                        fillColor: "rgba(210, 214, 222, 1)",
                        strokeColor: "rgba(210, 214, 222, 1)",
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: {!! $total !!}
                    },
                ]
            };

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
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