@extends('layout.master')
@section('title','สินค้า')


@section('content')

    <script src="/packages/zofe/rapyd/assets/datepicker/bootstrap-datepicker.js"></script>

    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="panel-body">
                    {!! $form !!}
                    {!! Rapyd::scripts() !!}
                </div>

            </div>



        </div>
    </div>

@stop
