@extends('layout.master')
@section('title','ประวัติการสั่งซื้อสินค้า')


@section('content')

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
                            <th>รหัสใบสั่งซื้อ</th>
                            <th>Supplier</th>
                            <th>พนักงาน</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td> {{$test->order_id}}</td>
                                <td> {{$test->ven_name}}</td>
                                <td> {{$test->name}}</td>
                                <td> {{$test->order_date}}</td>
                                <td><?php echo number_format( $test->order_total) ,' บาท' ?></td>
                                <td> {{$test->order_status}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
