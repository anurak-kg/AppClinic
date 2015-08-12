@extends('layout.master')
@section('title','ข้อมูลพนักงาน')
@section('headText','Employee')
@section('headDes','จัดการพนักงาน')
@section('content')

<div class="row">
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-success">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>

                <h2 class="box-title">เพิ่มพนักงาน</h2>
            </div>
            <div class="box-body">
                {!! $form !!}
            </div>

        </div>


    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>

                <h2 class="box-title">พนักงานขาย / แพทย์</h2>
            </div>

            <div class="panel-body">
                {!! $grid !!}
            </div>
        </div>
        <!-- /.box -->


    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#data-table').DataTable({
            "language": {
                "url": "/Thai.json"
            }
        });
    });
</script>

@stop
