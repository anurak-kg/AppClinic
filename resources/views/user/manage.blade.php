@extends('layout.master')
@section('title',Lang::get('user.create'))
@section('headText',Lang::get('user.create'))
@section('headDes','รายละเอียด')
@section('content')

<div class="row">
    <div class="col-md-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('user.create')}}</h3>
            </div>
            <div class="box-body">
                {!! $form !!}
            </div>

        </div>


    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('user.create')}}</h3>
            </div>

            <div class="box-body">
                {!! $grid !!}
            </div>
        </div>
        <!-- /.box -->


    </div>
</div>
@stop
