@extends('layout.master')
@section('title','รายการเบิกสินค้า')
@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading" align="middle">
            <h2 class="panel-title">รายการเบิกสินค้า</h2>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table tablesorter table-bordered table-striped table-hover" id="history_table">
                        <thead>
                        <tr>
                            <th>เลขที่เบิก</th>
                            <th>วันที่</th>
                            <th>สาขา</th>
                            <th>พนักงาน</th>
                            <th>สถานะ</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td><a href="">00000</a></td>
                                <td> 19/2/59</td>
                                <td> ทดสอบสาขา</td>
                                <td> ทดสอบพนักงาน</td>
                                <td> ทดสอบสถานะ</td>
                                <td> ทดสอบ Action</td>
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
