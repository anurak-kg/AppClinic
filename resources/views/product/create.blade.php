@extends('layout.master')
@section('title','สินค้า')


@section('content')
    <script src="/packages/zofe/rapyd/assets/datepicker/bootstrap-datepicker.js"></script>

    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

    <div class="row">

        <div class="col-md-6">
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body">
                    {!! $form !!}
                    {!! Rapyd::scripts() !!}
                </div>

            </div>



        </div>
    </div>

@stop
