@extends('layout.master')
@section('title','กลุ่มสินค้า')
@section('headText','กลุ่มสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">
                <div class="panel-heading">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>
                <div class="panel-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">

                    <div class="panel-heading ">
                        <h2 class="panel-title">ข้อมูลกลุ่มสินค้า</h2>
                    </div>

                <div class="panel-body ">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
