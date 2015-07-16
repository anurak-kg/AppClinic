@extends('layout.master')
@section('title','หน้าหลัก')

@section('content')



  <div class="row">

              <div align="middle">

                <div class="box box-solid box-default">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                      </ol>
                      <div class="carousel-inner">
                        <div class="item active">
                          <img src="http://placehold.it/900x500/39CCCC/ffffff&text=Welcome" alt="First slide">
                          <div class="carousel-caption">

                          </div>
                        </div>
                        <div class="item">
                          <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=Welcome" alt="Second slide">
                          <div class="carousel-caption">

                          </div>
                        </div>
                        <div class="item">
                          <img src="http://placehold.it/900x500/f39c12/ffffff&text=Welcome" alt="Third slide">
                          <div class="carousel-caption">

                          </div>
                        </div>
                      </div>
                      <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                      </a>
                    </div>
                    </div>

                  </div>

                </div>


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
                                        <p>สำหรับลูกค้า</p>
                                    </div>
                                 <div class="icon">
                                   <i class="ion ion-ios-cart"></i>
                                 </div>
                              <a href="{{url('')}}" class="small-box-footer">ซื้อคอร์ส   <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                          </div><!-- ./col -->

                          <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                           <div class="small-box bg-yellow">
                            <div class="inner">
                              <h4>รักษา</h4>
                              <p>สำหรับลูกค้า</p>
                             </div>
                            <div class="icon">
                               <i class="ion ion-heart"></i>
                             </div>
                            <a href="{{url('')}}" class="small-box-footer">การรักษา   <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div><!-- ./col -->

                          <div class="col-lg-3 col-xs-6">
                              <!-- small box -->
                           <div class="small-box bg-red">
                            <div class="inner">
                              <h4>ชำระเงิน</h4>
                              <p>สำหรับลูกค้า</p>
                             </div>
                            <div class="icon">
                               <i class="fa fa-money"></i>
                             </div>
                            <a href="{{url('')}}" class="small-box-footer">ชำระเงิน   <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                          </div><!-- ./col -->

     </div>

       <meta charset="UTF-8">
         <title>ตารางการทำงานหมอ</title>
         <!-- Tell the browser to be responsive to screen width -->
         <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
         <!-- Bootstrap 3.3.4 -->
         <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
         <!-- Font Awesome Icons -->
         <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
         <!-- Ionicons -->
         <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
         <!-- fullCalendar 2.2.5-->
         <link href="../plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
         <link href="../plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" />
         <!-- Theme style -->
         <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
         <!-- AdminLTE Skins. Choose a skin from the css/skins
              folder instead of downloading all of them to reduce the load. -->
         <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

         <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
         <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
         <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
         <![endif]-->


             <!-- Main content -->
               <div class="row">

                 <div class="col-md-12">
                   <div class="box box-solid box-success">
                   <div class="box-header with-border" align="middle">

                                       <h3 class="box-title">ตารางหมอ</h3>
                                       <div class="box-tools pull-right">
                                             <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="ย่อ" ><i class="fa fa-minus"></i></button>
                                             <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="ลบ"><i class="fa fa-times"></i></button>
                                           </div><!-- /.box-tools -->
                                   </div>
                     <div class="box-body no-padding">
                       <!-- THE CALENDAR -->
                       <div id="calendar"></div>
                     </div><!-- /.box-body -->
                   </div><!-- /. box -->
                 </div><!-- /.col -->
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
                 today: 'today',
                 month: 'month',
                 week: 'week',
                 day: 'day'
               },
               //Random default events
               events: [
                 {
                   title: 'All Day Event',
                   start: new Date(y, m, 1),
                   backgroundColor: "#f56954", //red
                   borderColor: "#f56954" //red
                 },
                 {
                   title: 'Long Event',
                   start: new Date(y, m, d - 5),
                   end: new Date(y, m, d - 2),
                   backgroundColor: "#f39c12", //yellow
                   borderColor: "#f39c12" //yellow
                 },
                 {
                   title: 'Meeting',
                   start: new Date(y, m, d, 10, 30),
                   allDay: false,
                   backgroundColor: "#0073b7", //Blue
                   borderColor: "#0073b7" //Blue
                 },
                 {
                   title: 'Lunch',
                   start: new Date(y, m, d, 12, 0),
                   end: new Date(y, m, d, 14, 0),
                   allDay: false,
                   backgroundColor: "#00c0ef", //Info (aqua)
                   borderColor: "#00c0ef" //Info (aqua)
                 },
                 {
                   title: 'Birthday Party',
                   start: new Date(y, m, d + 1, 19, 0),
                   end: new Date(y, m, d + 1, 22, 30),
                   allDay: false,
                   backgroundColor: "#00a65a", //Success (green)
                   borderColor: "#00a65a" //Success (green)
                 },
                 {
                   title: 'Click for Google',
                   start: new Date(y, m, 28),
                   end: new Date(y, m, 29),
                   url: 'http://google.com/',
                   backgroundColor: "#3c8dbc", //Primary (light-blue)
                   borderColor: "#3c8dbc" //Primary (light-blue)
                 }
               ],
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

@stop
