@extends('layout.master')
@section('title','สินค้า')


@section('content')


    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="panel-body">
                    {!! $form !!}
                </div>

            </div>



        </div>
    </div>

@stop
