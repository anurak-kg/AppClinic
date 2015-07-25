@extends('layout.master')
@section('title','คอร์สที่ขายดีที่สุด')
@section('content')


    <div class="row">

        <div class="col-md-3">
            <div class="box box-solid box-default">
                <div class="box-body">
                    <div class="form-group">
                        <label>เลือกเดือน :</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="reservation"/>
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                </div>
            </div>
        </div>

        <div class="col-md-9">


            <!-- BAR CHART -->
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h4 align="middle">คอร์สที่ขายดีที่สุด</h4>

                    <div class="box-tools pull-right">
                        <button  class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" height="700"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col (RIGHT) -->
    </div>
    </div> <!-- /.row -->


    <!-- date-picker -->
    <script src="/dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="/dist/css/bootstrap-datepicker.css" type="text/javascript"></script>
    <script src='/locales/bootstrap-datepicker.th.min.js'></script>

    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- page script -->
    <script>
        $(function () {

                    $('#reservation').datepicker({
                        todayBtn: "linked",
                        language: "th",
                        autoclose: true,
                        todayHighlight: true,
                        beforeShowMonth: function (date){
                            switch (date.getMonth()){
                                case 8:
                                    return false;
                            }
                        }
                    });

            var areaChartData = {
                labels: {!! $name !!},
                datasets: [

                    {
                        label: "Digital Goods",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: {!! $total !!}
                    }
                ]
            };

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas);
            var barChartData = areaChartData;
            barChartData.datasets[0].fillColor = "#00a65a";
            barChartData.datasets[0].strokeColor = "#00a65a";
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