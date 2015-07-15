@extends('layout.master')
@section('title','ข้อมูลพนักงาน')


@section('content')

    <div class="row">

        <div class="col-md-5">
            <div class="box box-warning">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body">
                    {!! $form !!}
                </div>

            </div>



        </div>
    </div>

@stop
