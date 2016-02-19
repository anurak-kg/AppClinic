@extends('layout.master')
@section('title','สินค้าคงคลัง')
@section('headDes','สต๊อกสินค้า')
@section('headText','สินค้าคงคลัง')


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">สินค้าคงคลัง</h2>

                </div>

                <div class="panel-body">

                    <div class="row " style="    border-bottom: 1px solid #f4f4f4;">
                        <div class="col-md-6 col-md-offset-3">
                            <form class="form-horizontal" action="{{url('product/stock')}}" method="get">
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
                    <div class="row" style="    padding-top: 13px;">

                        <div class="col-md-12 table-responsive">
                            <div align="right">
                                <a href="" class="btn btn-bitbucket"> ปรับยอด</a>
                                <br>
                                <br>
                            </div>
                            <table class="table tablesorter table-bordered table-striped table-hover" id="stock_table">
                                <thead>
                                <tr>
                                    <th>สาขา</th>
                                    <th>รหัสสินค้า</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                    <th>หน่วย</th>
                                </tr>
                                </thead>
                                @foreach($stock as $item)
                                    <tr>
                                        <td>{{ $item->branch_name }}</td>

                                        <td><a href="">{{ $item->product_id }}</a></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#stock_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
