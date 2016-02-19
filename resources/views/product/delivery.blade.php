@extends('layout.master')
@section('title','รายการส่งสินค้า')


@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading" align="middle">
            <h2 class="panel-title">รายการส่งสินค้า</h2>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered" id="history_table">
                        <thead>
                        <tr>
                            <th>เลขที่ส่ง</th>
                            <th>วันที่</th>
                            <th>สาขา</th>
                            <th>พนักงาน</th>
                            <th>สถานะ</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td><a href="">00001</a></td>
                                <td> 19/2/59</td>
                                <td> ทดสอบสาขา</td>
                                <td> ทดสอบพนักงาน</td>
                                <td> ทดสอบสถานะ</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#history_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
