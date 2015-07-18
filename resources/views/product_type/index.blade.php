@extends('layout.master')
@section('title','ประเภทสินค้า')


@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid box-default">
            <div class="box-header with-border">
                <h2 class="box-title">ข้อมูลประเภทสินค้า</h2>
            </div>

            <div class="box-body table-responsive no-padding">
                {!! $form !!}
            </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลประเภทสินค้า</h2>
                </div>

                <div class="box-body table-responsive no-padding">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
