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
                        <canvas id="barChart" height="300"></canvas>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

    <!-- daterange picker -->
    <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js" type="text/javascript"></script>


    <!-- page script -->
    <script type="text/javascript">
        $(function () {
                    var startDate;
                    var endDate;
                    //Date range as a button
                    $('#daterange').daterangepicker(
                            {
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            },
                            function (start, end) {
                                $('#daterange').html(start.format('YYYY MM DD') + ' - ' + end.format('YYYY MM DD'));
                                startDate = start;
                                endDate = end;
                            }
                    );


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
                        data:{!! $total !!}
                    }

                ]
            };


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas);
            var barChartData = areaChartData;
            barChartData.datasets[0].fillColor = "#c2ffd5";
            barChartData.datasets[0].strokeColor = "#11ff5b";
            barChartData.datasets[0].pointColor = "#00a65a";
            var barChartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to make the chart responsive
                responsive: true,
                maintainAspectRatio: false
            };

            barChartOptions.datasetFill = false;
            barChart.Bar(barChartData, barChartOptions);
        });
    </script>
    </body>

@stop