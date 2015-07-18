@extends('layout.master')
@section('title','กลุ่มสินค้า')
@section('headText','Product group')
@section('headDes','กลุ่มสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary table-responsive no-padding">
                <div class="box-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary table-responsive no-padding">
                <div class="box-header with-border">
                </div>
                <div class="box-body ">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
