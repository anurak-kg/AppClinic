@extends('layout.master')
@section('title','หน้าหลัก')

@section('content')



            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h4>สมัครสมาชิก</h4>
                            <p>สำหรับลูกค้าใหม่</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{url('customer/create')}}" class="small-box-footer">สมัครสมาชิก   <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h4>ซื้อคอร์ส</h4>
                            <p>สำหรับสมาชิก</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-cart"></i>
                        </div>
                        <a href="{{url('quotations')}}" class="small-box-footer">ซื้อคอร์ส   <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h4>ซื้อสินค้า</h4>
                            <p>สำหรับสมาชิก/ลูกค้าทั่วไป</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cart-plus"></i>
                        </div>
                        <a href="{{url('sales')}}" class="small-box-footer">ซื้อสินค้า   <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h4>รักษา</h4>
                            <p>สำหรับสมาชิก</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-heart"></i>
                        </div>
                        <a href="{{url('treatment')}}" class="small-box-footer">รักษา   <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">

                        <div class="box  box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">คอร์สขายดี</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="chart-responsive">
                                            <canvas id="pieChart" height="150"></canvas>
                                        </div><!-- ./chart-responsive -->
                                    </div><!-- /.col -->
                                    <div class="col-md-6">

                                        <ul class="chart-legend clearfix">
                                            @foreach($data as $item)
                                                <li><i class="fa fa-circle-o" style="color:{{$item['color']}}"></i> {{ $item['label'] }}</li>
                                                <br>
                                            @endforeach
                                        </ul>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                            <div class="box-footer no-padding">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($data as $item)
                                        <li><a href="#" >{{ $item['label'] }}<span class="pull-right" style="color:{{$item['color']}}"><?php echo 'จำนวน ', number_format( $item['value']  ),' คอร์ส' ?></span></a></li>

                                    @endforeach

                                </ul>
                            </div><!-- /.footer -->
                        </div><!-- /.box -->



                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">การสั่งซื้อสินค้าล่าสุด</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>เลขทีใบสั่งซื้อ</th>
                                        <th>Supplier</th>
                                        <th>พนักงาน</th>
                                        <th>วันที่</th>
                                        <th>สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $dataorder as $item)
                                        <tr>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->ven_name  }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->order_date }}</td>
                                            <td>
                                                @if($item->order_status == 'PENDING')
                                                    <span class="label label-warning">{{ $item->order_status  }}</span>
                                                @else
                                                    <span class="label label-danger">{{ $item->order_status  }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="{{ url('order') }}" class="btn btn-sm btn-info btn-flat pull-left">สั่งซื้อสินค้าใหม่</a>
                            <a href="{{ url('order/history') }}" class=" pull-right">ดูข้อมูลทั้งหมด</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->


                        <div class="box  box-warning">
                            <div class="box-header with-border" align="middle">

                                <h3 class="box-title">ตารางการทำงานหมอ</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" ><i class="fa fa-minus"></i></button>
                                </div><!-- /.box-tools -->
                            </div>
                            <div class="box-body no-padding">
                                <!-- THE CALENDAR -->
                                <div id="calendar" height="150"></div>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->

                    <div class="box box-danger">
                        <div class="box-header with-border" align="middle">

                            <h3 class="box-title">ตารางนัดคิวลูกค้า</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" ><i class="fa fa-minus"></i></button>
                            </div><!-- /.box-tools -->
                        </div>
                        <div class="box-body no-padding">
                            <!-- THE CALENDAR -->
                            <div id="calendar_customer" ></div>
                        </div><!-- /.box-body -->
                    </div><!-- /. box -->

                </section><!-- /.Left col -->


                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">


                        <div class="box  box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">สินค้าขายดี</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="chart-responsive">
                                            <canvas id="pieChart2" height="150"></canvas>
                                        </div><!-- ./chart-responsive -->
                                    </div><!-- /.col -->
                                    <div class="col-md-6">
                                        <ul class="chart-legend clearfix">
                                            @foreach($datapro as $item)
                                                <li><i class="fa fa-circle-o"  style="color:{{$item['color']}}"></i> {{ $item['label'] }}</li>
                                                <br>
                                            @endforeach
                                        </ul>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                            <div class="box-footer no-padding">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($datapro as $item)
                                        <li><a href="#">{{ $item['label'] }}<span class="pull-right" style="color:{{$item['color']}}"><?php echo 'จำนวน ', number_format( $item['value']  ),' ' ?></span></a></li>
                                        {{--<li><a href="#">India <span class="pull-right text-red"><i class="fa fa-angle-up"></i> 4%</span></a></li>--}}
                                        {{--<li><a href="#">China <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>--}}
                                    @endforeach

                                </ul>
                            </div><!-- /.footer -->
                        </div><!-- /.box -->

                    <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">สินค้ากำลังหมดอายุ</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <li class="item">

                                    @foreach($exp as $item)
                                        <a href="{{url('product/expday')}}" class="product-title">{{ $item->product_name }}<span class="label label-danger pull-right">เหลืออีก {{ $item->day }} วัน</span></a>
                                        <span class="product-description">
                                              รหัสสินค้า {{ $item->product_id }} / วันที่หมดอายุ {{ $item->product_exp  }}
                                                </span> <br>
                                    @endforeach

                                </li><!-- /.item -->

                            </ul>
                        </div><!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{url('product/expday')}}" class="uppercase">ดูข้อมูลทั้งหมด</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                    </div>

                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">สินค้าที่ถึงจำนวนต้องสั่งซื้อ</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <ul class="products-list product-list-in-box">
                                    <li class="item">

                                        @foreach($stock as $item)
                                            <a href="{{url('product/expday')}}" class="product-title">{{ $item->product_name }}<span class="label label-danger pull-right">เหลือจำนวน {{ $item->total }} </span></a>
                                            <span class="product-description">
                                              รหัสสินค้า {{ $item->product_id }} / สาขา {{ $item->branch_name  }}
                                                </span> <br>
                                        @endforeach

                                    </li><!-- /.item -->
                                </ul>
                            </div><!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{{url('product/expday')}}" class="uppercase">ดูข้อมูลทั้งหมด</a>
                            </div><!-- /.box-footer -->
                        </div><!-- /.box -->
                    </div>





                </section><!-- right col -->
            </div><!-- /.row (main row) -->





    <script src="/dist/js/jquery-ui.js"></script>

    <!-- fullCalendar 2.2.5-->
    <link href="../plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print"/>

    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="/dist/js/fullcalendar.min.js" type="text/javascript"></script>
    <script src='/dist/calendar-lang/th.js'></script>

        {{--calendar doctor--}}
    <script type="text/javascript">
        $(function () {

            $( ".connectedSortable" ).sortable({
                cursor: "move",
                forcePlaceholderSize: true,
                helper: "clone",
                opacity: 0.7,placeholder: "sortable-placeholder",
                scrollSensitivity: 10,scrollSpeed: 40,tolerance: "pointer",
                connectWith: ".connectedSortable"
            }).disableSelection();

            var currentMousePos = {
                x: -1,
                y: -1
            };
            jQuery(document).on("mousemove", function (event) {
                currentMousePos.x = event.pageX;
                currentMousePos.y = event.pageY;
            });


            var json_events;

            $.ajax({
                url: '{{url('doctor_calender/fetch/')}}',
                type: 'GET',
                async: false,
                success: function (response) {
                    json_events = response;

                }
            });
            function freshData() {
                data = null;
                $.ajax({
                    url: '{{url('doctor_calender/fetch/')}}',
                    type: 'GET',
                    async: false,
                    success: function (response) {
                        data = response;

                    }
                });
                return data;
            }

            var date = new Date();
            var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();

            $('#calendar').fullCalendar({
                lang: 'th',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน'
                },
                axisFormat: 'HH:mm',
                timeFormat: 'HH:mm',
                events: json_events,
                slotDuration: '00:30:00',

                editable: true,
                droppable: true,
                eventDragStop: function (event, jsEvent, ui, view) {
                    if (isElemOverDiv()) {
                        var con = confirm('คุณแน่ใจว่าต้องการลบเหตุการณ์นี้');
                        if (con == true) {
                            $.ajax({
                                url: '{{url('doctor_calender/delete/')}}',
                                type: 'GET',
                                data: '&id=' + event.id,
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status == 'success')
                                        $('#calendar').fullCalendar('removeEvents');
                                    $('#calendar').fullCalendar('addEventSource', freshData);
                                    window.location = "{{url('dr/calender')}}";
                                },
                                error: function (e) {
                                    alert('Error processing your request: ' + e.responseText);
                                }
                            });
                        }
                    }
                },
                eventResize: function (event, delta, revertFunc) {
                    console.log(event);
                    var title = event.title;
                    var end = event.end.format();
                    var start = event.start.format();
                    $.ajax({
                        url: '{{url('doctor_calender/update/')}}',
                        type: 'GET',
                        data: 'title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                },
                eventDrop: function (event, delta, revertFunc) {
                    console.log('dasd');
                    var title = event.title;
                    var start = event.start.format();
                    var end = (event.end == null) ? start : event.end.format();
                    $.ajax({
                        url: '{{url('doctor_calender/update/')}}',
                        type: 'GET',
                        data: 'title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }

            });
            function isElemOverDiv() {
                var trashEl = jQuery('#trash');
                var ofs = trashEl.offset();
                var x1 = ofs.left;
                var x2 = ofs.left + trashEl.outerWidth(true);
                var y1 = ofs.top;
                var y2 = ofs.top + trashEl.outerHeight(true);
                if (currentMousePos.x >= x1 && currentMousePos.x <= x2 && currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                    return true;
                }
                return false;
            }

        });

    </script>

    <!-- calendar customer -->
    <script type="text/javascript">
        $(function () {
            var currentMousePos = {
                x: -1,
                y: -1
            };
            jQuery(document).on("mousemove", function (event) {
                currentMousePos.x = event.pageX;
                currentMousePos.y = event.pageY;
            });


            var json_events;

            $.ajax({
                url: '{{url('customer_calendar/fetch/')}}',
                type: 'GET',
                async: false,
                success: function (response) {
                    json_events = response;

                }
            });
            function freshData() {
                data = null;
                $.ajax({
                    url: '{{url('customer_calendar/fetch/')}}',
                    type: 'GET',
                    async: false,
                    success: function (response) {
                        data = response;

                    }
                });
                return data;
            }

            var date = new Date();
            var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();

            $('#calendar_customer').fullCalendar({
                lang: 'th',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน'
                },
                axisFormat: 'HH:mm',
                timeFormat: 'HH:mm',
                events: json_events,
                slotDuration: '00:30:00',

                editable: true,
                droppable: true,
                eventDragStop: function (event, jsEvent, ui, view) {
                    if (isElemOverDiv()) {
                        var con = confirm('คุณแน่ใจว่าต้องการลบเหตุการณ์นี้');
                        if (con == true) {
                            $.ajax({
                                url: '{{url('customer_calendar/delete/')}}',
                                type: 'GET',
                                data: '&id=' + event.id,
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status == 'success')
                                        $('#calendar_customer').fullCalendar('removeEvents');
                                    $('#calendar_customer').fullCalendar('addEventSource', freshData);
                                    window.location = "{{url('customer/calendar')}}";
                                },
                                error: function (e) {
                                    alert('Error processing your request: ' + e.responseText);
                                }
                            });
                        }
                    }
                },
                eventResize: function (event, delta, revertFunc) {
                    console.log(event);
                    var title = event.title;
                    var end = event.end.format();
                    var start = event.start.format();
                    $.ajax({
                        url: '{{url('customer_calendar/update/')}}',
                        type: 'GET',
                        data: 'title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                },
                eventDrop: function (event, delta, revertFunc) {
                    console.log('dasd');
                    var title = event.title;
                    var start = event.start.format();
                    var end = (event.end == null) ? start : event.end.format();
                    $.ajax({
                        url: '{{url('customer_calendar/update/')}}',
                        type: 'GET',
                        data: 'title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status != 'success')
                                revertFunc();
                        },
                        error: function (e) {
                            revertFunc();
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }

            });
            function isElemOverDiv() {
                var trashEl = jQuery('#trash');
                var ofs = trashEl.offset();
                var x1 = ofs.left;
                var x2 = ofs.left + trashEl.outerWidth(true);
                var y1 = ofs.top;
                var y2 = ofs.top + trashEl.outerHeight(true);
                if (currentMousePos.x >= x1 && currentMousePos.x <= x2 && currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                    return true;
                }
                return false;
            }

        });

    </script>



    <!-- ChartJS 1.0.1 -->
            <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

        <!-- jvectormap -->
        <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>

         <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

     <script src="../../plugins/morris/morris.min.js" type="text/javascript"></script>


    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js" type="text/javascript"></script>
         <script type="text/javascript">
               $(function () {
                 "use strict";

                  //-------------
                         //- PIE CHART -
                         //-------------
                         // Get context with jQuery - using jQuery's .get() method.
                         var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
                         var pieChart = new Chart(pieChartCanvas);
                         var PieData = {!! $dataCourse !!};
                        var pieOptions = {
                           //Boolean - Whether we should show a stroke on each segment
                           segmentShowStroke: true,
                           //String - The colour of each segment stroke
                           segmentStrokeColor: "#fff",
                           //Number - The width of each segment stroke
                           segmentStrokeWidth: 2,
                           //Number - The percentage of the chart that we cut out of the middle
                           percentageInnerCutout: 50, // This is 0 for Pie charts
                           //Number - Amount of animation steps
                           animationSteps: 100,
                           //String - Animation easing effect
                           animationEasing: "easeOutBounce",
                           //Boolean - Whether we animate the rotation of the Doughnut
                           animateRotate: true,
                           //Boolean - Whether we animate scaling the Doughnut from the centre
                           animateScale: false,
                           //Boolean - whether to make the chart responsive to window resizing
                           responsive: true,
                           // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                           maintainAspectRatio: false,
                           //String - A legend template
                           legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                         };
                         //Create pie or douhnut chart
                         // You can switch between pie and douhnut using the method below.
                         pieChart.Doughnut(PieData, pieOptions);

               //-------------
               //- PIE CHART -
               //-------------
               // Get context with jQuery - using jQuery's .get() method.
               var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
               var pieChart = new Chart(pieChartCanvas);
               var PieData = {!! $dataProduct !!};
               var pieOptions = {
                   //Boolean - Whether we should show a stroke on each segment
                   segmentShowStroke: true,
                   //String - The colour of each segment stroke
                   segmentStrokeColor: "#fff",
                   //Number - The width of each segment stroke
                   segmentStrokeWidth: 2,
                   //Number - The percentage of the chart that we cut out of the middle
                   percentageInnerCutout: 50, // This is 0 for Pie charts
                   //Number - Amount of animation steps
                   animationSteps: 100,
                   //String - Animation easing effect
                   animationEasing: "easeOutBounce",
                   //Boolean - Whether we animate the rotation of the Doughnut
                   animateRotate: true,
                   //Boolean - Whether we animate scaling the Doughnut from the centre
                   animateScale: false,
                   //Boolean - whether to make the chart responsive to window resizing
                   responsive: true,
                   // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                   maintainAspectRatio: false,
                   //String - A legend template
                   legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
               };
               //Create pie or douhnut chart
               // You can switch between pie and douhnut using the method below.
               pieChart.Doughnut(PieData, pieOptions);


               });
             </script>


@stop
