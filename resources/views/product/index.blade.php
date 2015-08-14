@extends('layout.master')
@section('title','สินค้า')
@section('headText','Product')
@section('headDes','จัดการยาและสินค้า')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-success table-responsive no-padding">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลสินค้า</h2>
                    <div class="box-tools pull-right">
                        <a href="{{url('product/create')}}"
                           class="btn btn-success">เพิ่มข้อมูลใหม่</a>
                    </div>
                </div>

                <div class="box-body " style="    margin-top: -32px;">
                    {!! $grid !!}
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#product_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
