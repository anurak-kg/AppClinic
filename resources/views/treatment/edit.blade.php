@extends('layout.master')
@section('title','การรักษา')


@section('content')

    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">

            <div class="box box-solid box-default">

                <div class="box-header with-border" align="center">
                    <h2 class="box-title">แก้ไขข้อมูล</h2>
                </div>

                <div class="box-body">


                    {!! Rapyd::scripts() !!}
                    {!! $edit !!}

                </div>

            </div>

        </div>
    </div>

@stop