@extends('layout.master')
@section('title','ข้อมูลพนักงาน')
@section('content')

<div class="row">
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="panel panel-primary">
            <div class="panel-heading with-border">
                <h3 class="panel-title">เพิ่มข้อมูล</h3>
            </div>
            <div class="panel-body">
                {!! $form !!}
            </div>

        </div>


    </div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading with-border">
                <h3 class="panel-title">ข้อมูลพนักงาน</h3>
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
            },
        });
    });
</script>

@stop
