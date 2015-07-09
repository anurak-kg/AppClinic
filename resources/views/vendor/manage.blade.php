@extends('layout.master')
@section('title','การจัดการ ข้อมูลร้านค้า')
@section('headText','Manage Vendor')
@section('headDes','การจัดการ ข้อมูลร้านค้า')
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
