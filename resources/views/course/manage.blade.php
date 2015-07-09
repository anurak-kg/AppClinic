@extends('layout.master')
@section('title','การจัดการคอร์ส')
@section('headText','Manage Course')
@section('headDes','การจัดการคอร์ส')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('course.create')}}</h3>
                </div>
                <div class="box-body">
                    {!! $form !!}
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('course.create')}}</h3>
                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
