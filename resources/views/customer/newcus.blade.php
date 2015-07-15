@extends('layout.master')
@section('title','ลงทะเบียนลูกค้าใหม่')
@section('content')

<div class="row">
    <div class="col-md-3">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('ลงทะเบียนลูกค้าใหม่')}}</h3>
            </div>
            <div class="box-body">
                {!! $form !!}
            </div>

        </div>


    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{Lang::get('customer.create')}}</h3>
            </div>

            <div class="box-body">
                {!! $grid !!}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@stop
