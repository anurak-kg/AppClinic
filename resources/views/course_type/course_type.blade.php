@extends('layout.master')
@section('title','ประเภทคอร์ส')
@section('headText','ประเภทคอร์ส')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">
                <div class="panel-heading">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>
                <div class="panel-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading ">
                    <h2 class="panel-title">ประเภทคอร์ส</h2>
                </div>

                <div class="panel-body ">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
