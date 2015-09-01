@extends('layout.master')
@section('title','System Log')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">System Log</h2> <br><br>
                    <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" action="{{url('log/index')}}" method="get">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">เลือกสาขา</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="branch">
                                        <option value="0">ทุกสาขา</option>
                                        @foreach($branch as $item)
                                            <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="col-sm-2 btn btn-default">ค้นหา</button>

                            </div>

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td align="middle"><b>สาขา</b></td>
                                <td align="middle"><b>รหัสผู้ใช้</b></td>
                                <td align="middle"><b>ประเภท</b></td>
                                <td align="middle"><b>รายละเอียด</b></td>
                                <td align="middle"><b>วันที่ / เวลา</b></td>
                            </tr>
                            </thead>
                            @foreach($data as $test)
                                <tr>
                                    <td align="middle"><?php
                                        $branch = \App\Branch::find($test->branch_id);
                                        if ($branch != null) {
                                            echo $branch->branch_name;
                                        } else {
                                            echo 'ไม่มีข้อมูล';
                                        } ?></td>
                                    <td align="middle"><?php
                                       if($test->emp_id != null)
                                           echo  $test->emp_id;
                                        else echo 'ไม่มีข้อมูล';
                                        ?></td>
                                    <td align="middle">{{$test->logs_type}}</td>
                                    <td align="middle">{{$test->description}}</td>
                                    <td align="middle">{{$test->date}}</td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->




    </body>

@stop