@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="box-body ">
                    ข้อมูล ลูกค้า
                </div>

            </div>

            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ซื้อคอร์ส</h2>
                </div>

                <div class="box-body ">
                    {!! $form !!}
                </div>

            </div>

        </div>
    </div>

@stop
