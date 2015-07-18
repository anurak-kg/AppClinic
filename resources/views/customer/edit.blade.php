@extends('layout.master')
@section('title','แก้ไขข้อมูล')


@section('content')

    {!! Rapyd::scripts() !!}



    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />



    <div class="row">

        <div class="col-md-3">

        </div>

        <div class="col-md-6">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">แก้ไขข้อมูลลูกค้า</h2>

                </div>

                <div class="box-body">
                    <p>
                    {!! $edit !!}
                    </p>
            </div>

            </div>


        </div>

    </div>

@stop
