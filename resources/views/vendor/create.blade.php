@extends('layout.master')
@section('title','ร้านค้า')


@section('content')

    <div class="row">

        <div class="col-md-5">
            <div class="box box-solid box-default">

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
