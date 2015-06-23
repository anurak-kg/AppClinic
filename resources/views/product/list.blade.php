@extends('layout.master')
@section('title','Dashboard')
@section('headText','Dashboard')
@section('headDes','รายละเอียด')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('user.create')}}</h3>
                </div>

                <div class="box-body">
                    <a class="btn btn-app">
                        <i class="fa fa-plus-circle"></i> เพิ่มสินค้า
                    </a>
                    <table id="users-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>action</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url("product/listdata") }}',
                columns: [
                    {data: 0, name: 'name'},
                    {data: 1, name: 'email'},
                    {data: 2, name: 'created_at'},
                    {data: 3, name: 'updated_at'},
                    {data: 4, name: 'action'},

                ]
            });
        });
    </script>

@stop
