@extends('layout.master')
@section('title','ข้อมูลพนักงาน')

@section('headDes','รายละเอียด')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">เพิ่มข้อมูล</h3>
                </div>
                <div class="box-body">
                    {!! $edit !!}
                </div>
            </div>
        </div>
    </div>
@stop
