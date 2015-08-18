@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','ข้อมูลคอร์ส')

@section('content')


        <div class="box box-default">

            <div class="box-header with-border" align="middle">
                <h2 class="box-title">ข้อมูลคอร์ส</h2>
                <div class="box-tools pull-right">
                    <a href="{{url('course/index')}}" class="btn btn-success">กลับไปที่ข้อมูลคอร์ส</a>
                </div>
            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-xs-12 table-responsive">


                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>เลขที่คอร์ส</th>
                                    <th >คอร์ส</th>
                                    <th>รายละเอียด</th>
                                    <th>ราคา</th>
                                    <th>จำนวนครั้งรักษา</th>
                                </tr>
                                </thead>



                                    <tr>
                                        <td>{{ $course->course_id }}</td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $course->course_detail }}</td>
                                        <td>{{ $course->course_price }}</td>
                                        <td>{{ $course->course_qty }}</td>
                                    </tr>



                            </table>

                    </div>
                </div>
            </div>
        </div>





    <div class="box box-info">

        <div class="box-header with-border" align="middle">
            <h2 class="box-title">ยา</h2>
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
                            <th>รหัสยา</th>
                            <th>ตัวยา</th>
                            <th>จำนวน</th>

                        </tr>
                        </thead>


                        @foreach($course->product as $product)
                            <tr>
                                <td>{{ $product->product_id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->pivot->qty }}</td>
                            </tr>
                        @endforeach

                    </table>

                </div>
            </div>
        </div>
    </div>



@stop