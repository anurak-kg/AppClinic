@extends('layout.master')
@section('title','กลุ่มสินค้า')
@section('headText','Product group')
@section('headDes','กลุ่มสินค้า')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-solid box-default table-responsive no-padding">
                <div class="box-header">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>
                <div class="box-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-solid box-default table-responsive no-padding">

                    <div class="box-header ">
                        <h2 class="box-title">ข้อมูลกลุ่มสินค้า</h2>
                    </div>

                <div class="box-body ">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
