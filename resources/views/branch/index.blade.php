@extends('layout.master')
@section('title','ข้อมูลสาขา')


@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="panel-body" >

                    {!! $form !!}

                </div>

            </div>



        </div>

        <div class="col-md-9">
            <div class="panel panel-primary table-responsive no-padding  ">

                <div class="panel-heading ">
                    <h2 class="panel-title">ข้อมูลสาขา</h2>

                </div>

                <div class="panel-body ">

                    {!! $grid !!}
                </div>

            </div>

            {!! Rapyd::scripts() !!}


        </div>
    </div>


@stop
