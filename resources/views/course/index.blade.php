@extends('layout.master')
@section('title','คอร์ส')


@section('content')

    <div class="row">


        <div class="col-md-12">
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading">
                    <h2 class="panel-title">ข้อมูลคอร์ส</h2>
                </div>

                <div class="panel-body ">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
