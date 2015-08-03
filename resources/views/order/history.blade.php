@extends('layout.master')
@section('title','ประวัติการสั่งซื้อสินค้า')


@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading" align="middle">
                <h2 class="panel-title">ประวัติการสั่งซื้อสินค้า</h2>
        </div>

        <div class="panel-body">
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
                                <td>
                                    @if($test->order_status = 'PENDING')
                                        <span class="label label-warning">{{ $test->order_status  }}</span>
                                    @else
                                        <span class="label label-danger">{{ $test->order_status  }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
