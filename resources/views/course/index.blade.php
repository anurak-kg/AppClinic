@extends('layout.master')
@section('title','คอร์ส')


@section('content')

    <div class="row">

        <div class="col-md-3">
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body" >

                    {!! $form !!}
                </div>

            </div>



        </div>

        <div class="col-md-9">
            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header">
                    <h2 class="box-title">ข้อมูลคอร์ส</h2>
                </div>

                <div class="box-body ">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
