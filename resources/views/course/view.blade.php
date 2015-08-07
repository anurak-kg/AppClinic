@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','ข้อมูลคอร์ส')

@section('content')

    <div class="col-md-6">

        <div class="box box-default">

            <div class="box-header with-border" align="middle">
                <h2 class="box-title">ข้อมูลคอร์ส</h2>
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
                                    <th>เลขที่คอร์ส</th>
                                    <th >คอร์ส</th>
                                    <th>รายละเอียด</th>
                                    <th>ราคา</th>
                                    <th>จำนวนครั้งรักษา</th>
                                </tr>
                                </thead>
                                @foreach($data as $item)


                                     @if($item->course_id == $item->course_id)
                                    <tr>
                                        <td>{{ $item->course_id }}</td>
                                        <td>{{ $item->course_name }}</td>
                                        <td>{{ $item->course_detail }}</td>
                                        <td>{{ $item->course_price }}</td>
                                        <td>{{ $item->course_qty }}</td>
                                    </tr>
                                      @elseif($item->course_id == $item->course_id)

                                        <?php  ?>
                                    @endif
                                @endforeach
                            </table>

                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="col-md-6">
    <div class="box box-default">

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
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->product_id }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->qty }}</td>

                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>


@stop