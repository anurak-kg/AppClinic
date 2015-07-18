@extends('layout.master')
@section('title','ใบสั่งซื้อ')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header with-border">
                    <h2 class="box-title">ใบสั่งซื้อ</h2>
                </div>

                <div class="box-body table-responsive no-padding">
                    {!! $grid !!}
                </div>

            </div>

        </div>
    </div>

@stop
