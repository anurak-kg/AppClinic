@extends('layout.master')
@section('title','รายการรับยา')


@section('content')

    <div class="panel panel-primary">

        <div class="panel-heading" align="middle">
            <h2 class="panel-title">รายการรับยา</h2>
        </div>

        <div class="panel-body">

            <div class="col-md-12" align="right">
                <div class="row">

                    <a href="#" class="btn btn-instagram "><b>รายการรับยา</b></a>


                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table tablesorter table-bordered table-striped table-hover" id="history_table">
                        <thead>
                        <tr>
                            <th>เลขที่ใบส่ง</th>
                            <th>เลขที่ใบเบิก</th>
                            <th>วันที่</th>
                            <th>พนักงาน</th>
                        </tr>
                        </thead>
                        @foreach($data as $test)
                            <tr>
                                <td><a href="">00004</a></td>
                                <td> 00066</td>
                                <td> 19/2/59</td>
                                <td> ทดสอบพนักงาน</td>
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
