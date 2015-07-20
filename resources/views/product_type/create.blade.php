@extends('layout.master')
@section('title','ประเภทสินค้า')
@section('headText','Product type')
@section('headDes','ประเภทสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-5">
            <!-- general form elements -->
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>
                <div class="box-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <!-- general form elements -->
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลประเภทสินค้า</h2>
                </div>
                <div class="box-body">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
