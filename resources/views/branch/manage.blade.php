@extends('layout.master')
@section('title','การจัดการ ข้อมูลสาขา')
@section('headText','Manage Branch')
@section('headDes','การจัดการ ข้อมูลสาขา')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <div class="box-body">
                    {!! $form !!}
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
