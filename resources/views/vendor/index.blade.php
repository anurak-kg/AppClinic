@extends('layout.master')
@section('title','ร้านค้า')


@section('content')

    <div class="row">

        <div class="col-md-3">
            <div class="panel panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="panel-body">
                    {!! $form !!}
                </div>

            </div>



        </div>

        <div class="col-md-9">
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading">
                    <h2 class="panel-title">ข้อมูลร้านค้า</h2>
                </div>

                <div class="panel-body">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
