@extends('layout.master')
@section('title','ข้อมูลหมอ')


@section('content')

    <script src="/packages/zofe/rapyd/assets/datetimepicker/bootstrap-datetimepicker.js"></script>
    <link href="/packages/zofe/rapyd/assets/datetimepicker/datetimepicker3.css" rel="stylesheet" type="text/css"/>
    <!-- fullCalendar 2.2.5-->
    <link href="../plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print"/>

    <!-- Main content -->
    <div class="row">
        <div class="col-md-2">
            <div class="box  box-danger">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body">
                    <div id='external-events'>
                        <p>
                            <img src="/images/trashcan.png" id="trash" alt="">
                        </p>
                    </div>
                    {!! $form !!}
                    {!! Rapyd::scripts() !!}
                </div>

            </div>
        </div>
        <div class="col-md-10">
            <div class="box box-success">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div><!-- /.row -->

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="/dist/js/fullcalendar.min.js" type="text/javascript"></script>
    <script src='/locales/th.js'></script>

    <!-- Page specific script -->
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

@stop
