@extends('layout.master')
@section('title',trans("customer.edit data"))
@section('content')

    {!! Rapyd::scripts() !!}



    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />



    <div class="row">

        <div class="col-md-2">

        </div>

        <div class="col-md-8">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">{{trans("customer.edit data")}}</h2>

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
