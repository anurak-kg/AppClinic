@extends('layout.master')
@section('title','ลูกค้ารับการรักษา')


@section('content')
    {!! Rapyd::scripts() !!}



    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">

            <div class="box box-solid box-default">

                <div class="box-header with-border" align="center">
                    <h2 class="box-title">ลูกค้ารับการรักษา</h2>
                </div>

                <div class="box-body">



                    {!! $form !!}

                </div>

            </div>

        </div>
    </div>

@stop
