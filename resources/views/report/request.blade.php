@extends('layout.master')
@section('title','รายงานการเบิกสินค้า')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">รายงานการเบิกสินค้า</h2>
                    <br> <br>

                    <div class="col-md-6 col-md-offset-3">
                        <form class="form-horizontal" action="{{url('report/request')}}" method="get">
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

                    <div class="box-tools pull-right">
                        <a class="btn btn-success" href="{{url('report/index')}}">ย้อนกลับ</a>
                    </div>

                    <span class="pull-right">
                         {!! Form::open(array('url' => 'report/request?type=excel', 'class' => 'form')) !!}
                        <input type="submit" class="btn btn-block btn-info" value="Export">
                        {!! Form::close() !!}
                    </span>
                </div>
                <div class="box-body" id="datatable">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td align="middle"><b>สาขา</b></td>
                                    <td align="middle"><b>ผู้เบิก</b></td>
                                    <td align="middle"><b>เลขที่การเบิก</b></td>
                                    <td align="middle"><b>สินค้า</b></td>
                                    <td align="middle"><b>จำนวน</b></td>
                                    <td align="middle"><b>วันที่เบิก</b></td>
                                </tr>
                                </thead>
                                @foreach($data as $test)
                                    <tr>

                                        <td align="middle">{{$test->branch_name}}</td>
                                        <td align="middle">{{$test->name}}</td>
                                        <td align="middle">{{$test->order_id}}</td>
                                        <td align="middle">{{$test->product_name}}</td>
                                        <td align="middle">{{$test->order_de_qty}}</td>
                                        <td align="middle">{{$test->date}}</td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->

    <script>
        $(function () {

            $('#datatable').slimScroll({height: 500});


        });

    </script>

@stop