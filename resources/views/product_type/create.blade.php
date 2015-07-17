@extends('layout.master')
@section('title','ประเภทสินค้า')
@section('headText','Product type')
@section('headDes','ประเภทสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <div class="box-body">
                    {!! $form !!}

                </div>

            </div>
        </div>

    </div>
@stop
