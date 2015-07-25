@extends('layout.master')
@section('title','ประเภทสินค้า')
@section('headText','ประเภทสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-5">
            <!-- general form elements -->
            <div class="panel panel-primary">
                <div class="panel-heading with-border">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>
                <div class="panel-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <!-- general form elements -->
            <div class="panel panel-primary">
                <div class="panel-heading with-border">
                    <h2 class="panel-title">ข้อมูลประเภทสินค้า</h2>
                </div>
                <div class="panel-body">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
