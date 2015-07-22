@extends('layout.master')
@section('title','ข้อมูลพนักงาน')
@section('content')

<div class="row">
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-solid box-default">
            <div class="box-header with-border">
                <h3 class="box-title">เพิ่มข้อมูล</h3>
            </div>
            <div class="box-body">
                {!! $form !!}
            </div>

        </div>


    </div>
    <div class="col-md-8">
        <div class="box box-solid box-default">
            <div class="box-header with-border">
                <h3 class="box-title">ข้อมูลพนักงาน</h3>
            </div>

            <div class="box-body">
                {!! $grid !!}
            </div>
        </div>
        <!-- /.box -->


    </div>
</div>
@stop
