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
                            <th>สินค้า</th>
                            <th>พนักงาน</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>จำนวนเงิน</th>
                            <th>สถานะ</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td> {{$test->order_id}}</td>
                                <td> {{$test->ven_name}}</td>
                                <td> {{$test->product_name}}</td>
                                <td> {{$test->name}}</td>
                                <td> {{$test->order_date}}</td>
                                <td><?php echo number_format( $test->order_total) ,' บาท' ?></td>
                                <td>
                                    @if($test->order_status == 'PENDING')
                                        <span class="label label-warning">{{ $test->order_status  }}</span>
                                    @else
                                        <span class="label label-danger">{{ $test->order_status  }}</span>
                                    @endif
                                </td>
                                <td>@if($test->order_status == 'PENDING')
                                    <a href="{{url('order/cancelorder')}}?order_id={{$test->order_id}}" class="btn btn-primary"> ยกเลิกการสั่งซื้อ</a>
                                    @else
                                    <a href="{{url('order/cancelorder')}}?order_id={{$test->order_id}}" class="btn btn-primary" disabled>ยกเลิกการสั่งซื้อ</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Thai.json"
                },
            });
        });
    </script>
@stop
