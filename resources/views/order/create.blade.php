@extends('layout.master')
@section('title','สั่งซื้อสินค้า')


@section('content')





    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />


    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ข้อมูลการสั่งซื้อ</h2>

                </div>

                <div class="box-body">
                    {!! $form !!}
                    {!! Rapyd::scripts() !!}
                </div>

            </div>

        </div>

        </div>



@stop
