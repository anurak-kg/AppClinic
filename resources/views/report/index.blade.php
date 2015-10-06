@extends('layout.master')
@section('title','Report')
@section('headText','Report')
@section('headDes','รายงาน')
@section('content')

    <div class="row report-listing">
        <div class="col-md-6  ">
            <div class="panel">
                <div class="panel-body">
                    <div class="list-group parent-list">

                        <a href="#" class="list-group-item" id="sale"><i class="fa fa-shopping-cart"></i> ยอดขายพนักงาน</a>

                        <a href="#" class="list-group-item" id="saleperday"> <i class="fa fa-info-circle"></i> ยอดขายรายวัน	</a>

                        <a href="#" class="list-group-item" id="doctor"><i class="fa fa-user-md"></i>	ยอดขายแพทย์</a>

                        <a href="#" class="list-group-item" id="coursemonth"><i class="fa fa-calendar-o"></i>	ยอดขายคอร์สต่อเดือน</a>


                        <a href="#" class="list-group-item" id="coursehot"><i class="fa fa-star"></i>	คอร์สที่ขายดีที่สุด</a>

                        <a href="#" class="list-group-item" id="producthot"><i class="fa fa-star"></i>	สินค้าที่ขายดีที่สุด</a>

                        <a href="#" class="list-group-item" id="suplier"><i class="fa fa-reply-all"></i>	รายจ่ายจาก Suplier</a>

                        <a href="#" class="list-group-item" id="customer_payment"><i class="fa fa-share"></i>	รายได้ทั้งหมด</a>


                        <a href="#" class="list-group-item" id="commisstion"><i class="fa fa-money"></i>	Commission</a>


                        <a href="#" class="list-group-item" id="request"><i class="fa fa-reply"></i>	รายงานเบิกสินค้า</a>




                    </div>
                </div>
            </div> <!-- /panel -->
        </div>
        <div class="col-md-6" id="report_selection">
            <div class="panel">
                <div class="panel-body child-list">
                    <h3 class="page-header text-info">&laquo; เลือกรายงาน</h3>

                    <div class="list-group sale hidden">
                        <a class="list-group-item" href="{{url('report/saleGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/saleDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group saleperday hidden">
                        <a class="list-group-item" href="{{url('report/saleperdayGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/saleperdayDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group doctor hidden">
                        <a class="list-group-item" href="{{url('report/doctorGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/doctorDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group coursemonth hidden">
                        <a class="list-group-item" href="{{url('report/coursemonthGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/coursemonthDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group coursehot hidden">
                        <a class="list-group-item" href="{{url('report/coursehotGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/coursehotDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group producthot hidden">
                        <a class="list-group-item" href="{{url('report/producthotGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/producthotDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group suplier hidden">
                        <a class="list-group-item" href="{{url('report/suplierGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/suplierDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group customer_payment hidden">
                        <a class="list-group-item" href="{{url('report/customer_paymentGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/customer_paymentDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group commisstion hidden">
                        <a class="list-group-item" href="{{url('report/commisstionGraphic')}}" ><i class="fa fa-bar-chart-o"></i> กราฟ</a>
                        <a class="list-group-item" href="{{url('report/commisstionDetail')}}" ><i class="fa fa-building-o"></i> ตารางข้อมูล</a>
                    </div>

                    <div class="list-group request hidden">
                        <a class="list-group-item" href="{{url('report/request')}}" ><i class="fa fa-bar-chart-o"></i> ตารางข้อมูล</a>
                    </div>

                </div>
            </div> <!-- /panel -->
        </div>

    </div>


    <script type="text/javascript">
        $('.parent-list a').click(function(e){
            e.preventDefault();
            $('.parent-list a').removeClass('active');
            $(this).addClass('active');
            var currentClass='.child-list .'+ $(this).attr("id");
            $('.child-list .page-header').html($(this).html());
            $('.child-list .list-group').addClass('hidden');
            $(currentClass).removeClass('hidden');

            $('html, body').animate({
                scrollTop: $("#report_selection").offset().top
            }, 500);
        });
    </script>

@stop