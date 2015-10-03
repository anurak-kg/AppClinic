@extends('layout.master')
@section('title','ตัดสต๊อกสินค้า')
@section('headDes','ตัดสต๊อกสินค้า')
@section('headText','Stock')


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ตัดสต๊อกสินค้า</h2>

                </div>

                <div class="box-body">

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
                            <table class="table table-bordered" id="stock_table" >
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>สาขา</th>
                                    <th>รหัสสินค้า</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                </tr>
                                </thead>
                                @foreach($stock as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>{{ $item->branch_name }}</td>

                                        <td>{{ $item->product_id }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->total }}</td>
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
        var rows_selected = [];

        $(document).ready(function () {
            $('#stock_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
                'rowCallback': function(row, data){
                    // Get row ID
                    var rowId = data[0];

                    // If row ID is in the list of selected row IDs
                    if($.inArray(rowId, rows_selected) !== -1){
                        $(row).find('input[type="checkbox"]').prop('checked', true);
                        $(row).addClass('selected');
                    }
                }
            });

            $('#stock_table tbody').on('click', 'input[type="checkbox"]', function(e){
                var $row = $(this).closest('tr');

                if(this.checked){
                    $row.addClass('selected');
                } else {
                    $row.removeClass('selected');
                }

            });


            $('#stock_table').on('click', 'tbody td, thead th:first-child', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

        });
    </script>

@stop
