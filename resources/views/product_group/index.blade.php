@extends('layout.master')
@section('title','กลุ่มสินค้า')
@section('headText','Product group')
@section('headDes','กลุ่มสินค้า')
@section('content')

    <div class="row">

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
