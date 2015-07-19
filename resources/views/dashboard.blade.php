@extends('layout.master')
@section('title','หน้าหลัก')

@section('content')



    <div class="row">

               <div class="col-lg-3 col-xs-6">
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

                              <div class="col-lg-3 col-xs-6">
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

                          <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                           <div class="small-box bg-yellow">
                            <div class="inner">
                              <h4>ซื้อสินค้า</h4>
                              <p>สำหรับลูกค้าทั่วไป</p>
                             </div>
                            <div class="icon">
                                        <i class="fa fa-cart-plus"></i>
                             </div>
                            <a href="{{url('product_detail/index')}}" class="small-box-footer">ซื้อสินค้า   <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div><!-- ./col -->

                          <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                           <div class="small-box bg-red">
                            <div class="inner">
                              <h4>รักษา</h4>
                              <p>สำหรับสมาชิก</p>
                             </div>
                            <div class="icon">
                                <i class="ion ion-heart"></i>
                             </div>
                            <a href="{{url('treatment/index')}}" class="small-box-footer">รักษา   <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div><!-- ./col -->

     </div>



         <!-- fullCalendar 2.2.5-->
         <link href="../plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
         <link href="../plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" />


             <!-- Main content -->
               <div class="row">

                 <div class="col-md-6">
                   <div class="box box-solid box-success">
                   <div class="box-header with-border" align="middle">

                                       <h3 class="box-title">ตารางการทำงานหมอ</h3>
                                       <div class="box-tools pull-right">
                                             <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" ><i class="fa fa-minus"></i></button>

                                           </div><!-- /.box-tools -->
                                   </div>
                     <div class="box-body no-padding">
                       <!-- THE CALENDAR -->
                       <div id="calendar"></div>
                     </div><!-- /.box-body -->
                   </div><!-- /. box -->
                 </div><!-- /.col -->

                 <div class="col-md-6">

                                <div class="box box-solid box-default">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">สรุปประเภทคอร์ส</h3>
                                          <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                          </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                          <div class="row">
                                            <div class="col-md-8">
                                              <div class="chart-responsive">
                                                <canvas id="pieChart" height="150"></canvas>
                                              </div><!-- ./chart-responsive -->
                                            </div><!-- /.col -->
                                            <div class="col-md-4">
                                              <ul class="chart-legend clearfix">
                                              <hr>
                                                <li><i class="fa fa-circle-o text-red"></i> MELASMA WHITENING</li>
                                                <li><i class="fa fa-circle-o text-green"></i> ACNE</li>
                                                <li><i class="fa fa-circle-o text-yellow"></i> AGE REVERSE</li>
                                                <li><i class="fa fa-circle-o text-aqua"></i> VELA BODY</li>
                                              </ul>
                                            </div><!-- /.col -->
                                          </div><!-- /.row -->
                                        </div><!-- /.box-body -->
                                        <div class="box-footer no-padding">
                                          <ul class="nav nav-pills nav-stacked">
                                            <li><a href="#">MELASMA WHITENING<span class="pull-right text-red"><i class="fa fa-angle-down"></i> 30%</span></a></li>
                                            <li><a href="#">ACNE <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 20%</span></a></li>
                                            <li><a href="#">AGE REVERSE <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 20%</span></a></li>
                                            <li><a href="#">VELA BODY <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 30%</span></a></li>
                                          </ul>
                                        </div><!-- /.footer -->
                                      </div><!-- /.box -->

                                              <div class="box box-solid box-default">
                                                                <div class="box-header with-border">
                                                                  <h3 class="box-title">รายงานยอดขาย</h3>
                                                                  <div class="box-tools pull-right">
                                                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                                                                  </div>
                                                                </div>
                                                                <div class="box-body chart-responsive">
                                                                  <div class="chart" id="bar-chart" style="height: 300px;"></div>
                                                                </div><!-- /.box-body -->
                                                              </div><!-- /.box -->
              </div>

               </div><!-- /.row -->

         <!-- jQuery 2.1.4 -->
         <script src="../plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
         <!-- Bootstrap 3.3.2 JS -->
         <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
         <!-- jQuery UI 1.11.4 -->
         <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

         <!-- FastClick -->
         <script src="../plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

         <!-- AdminLTE for demo purposes -->
         <script src="../dist/js/demo.js" type="text/javascript"></script>
         <!-- fullCalendar 2.2.5 -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
         <script src="../plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
         <!-- Page specific script -->
         <script type="text/javascript">
           $(function () {

             /* initialize the external events
              -----------------------------------------------------------------*/
             function ini_events(ele) {
               ele.each(function () {

                 // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                 // it doesn't need to have a start or end
                 var eventObject = {
                   title: $.trim($(this).text()) // use the element's text as the event title
                 };

                 // store the Event Object in the DOM element so we can get to it later
                 $(this).data('eventObject', eventObject);

                 // make the event draggable using jQuery UI
                 $(this).draggable({
                   zIndex: 1070,
                   revert: true, // will cause the event to go back to its
                   revertDuration: 0  //  original position after the drag
                 });

               });
             }
             ini_events($('#external-events div.external-event'));

             /* initialize the calendar
              -----------------------------------------------------------------*/
             //Date for the calendar events (dummy data)
             var date = new Date();
             var d = date.getDate(),
                     m = date.getMonth(),
                     y = date.getFullYear();
             $('#calendar').fullCalendar({
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
               //Random default events

               editable: true,
               droppable: true, // this allows things to be dropped onto the calendar !!!
               drop: function (date, allDay) { // this function is called when something is dropped

                 // retrieve the dropped element's stored Event Object
                 var originalEventObject = $(this).data('eventObject');

                 // we need to copy it, so that multiple events don't have a reference to the same object
                 var copiedEventObject = $.extend({}, originalEventObject);

                 // assign it the date that was reported
                 copiedEventObject.start = date;
                 copiedEventObject.allDay = allDay;
                 copiedEventObject.backgroundColor = $(this).css("background-color");
                 copiedEventObject.borderColor = $(this).css("border-color");

                 // render the event on the calendar
                 // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                 $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                 // is the "remove after drop" checkbox checked?
                 if ($('#drop-remove').is(':checked')) {
                   // if so, remove the element from the "Draggable Events" list
                   $(this).remove();
                 }

               }
             });

             /* ADDING EVENTS */
             var currColor = "#3c8dbc"; //Red by default
             //Color chooser button
             var colorChooser = $("#color-chooser-btn");
             $("#color-chooser > li > a").click(function (e) {
               e.preventDefault();
               //Save color
               currColor = $(this).css("color");
               //Add color effect to button
               $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
             });
             $("#add-new-event").click(function (e) {
               e.preventDefault();
               //Get value and make sure it is not null
               var val = $("#new-event").val();
               if (val.length == 0) {
                 return;
               }

               //Create events
               var event = $("<div />");
               event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
               event.html(val);
               $('#external-events').prepend(event);

               //Add draggable funtionality
               ini_events(event);

               //Remove event from text input
               $("#new-event").val("");
             });
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
                         var PieData = [
                           {
                             value: 700,
                             color: "#f56954",
                             highlight: "#f56954",
                             label: "Chrome"
                           },
                           {
                             value: 500,
                             color: "#00a65a",
                             highlight: "#00a65a",
                             label: "IE"
                           },
                           {
                             value: 400,
                             color: "#f39c12",
                             highlight: "#f39c12",
                             label: "FireFox"
                           },
                           {
                             value: 600,
                             color: "#00c0ef",
                             highlight: "#00c0ef",
                             label: "Safari"
                           },

                         ];
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

                 //BAR CHART
                 var bar = new Morris.Bar({
                   element: 'bar-chart',
                   resize: true,
                   data: [
                     {y: '2549', a: 100, b: 90},
                     {y: '2550', a: 75, b: 65},
                     {y: '2551', a: 50, b: 40},
                     {y: '2552', a: 75, b: 65},
                     {y: '2553', a: 50, b: 40},
                     {y: '2554', a: 75, b: 65},
                     {y: '2555', a: 100, b: 90}
                   ],
                   barColors: ['#00a65a', '#f56954'],
                   xkey: 'y',
                   ykeys: ['a', 'b'],
                   labels: ['CPU', 'DISK'],
                   hideHover: 'auto'
                 });
               });
             </script>


@stop
