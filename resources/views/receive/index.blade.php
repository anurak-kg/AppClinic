@extends('layout.master')
@section('title','การรับสินค้า')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-default table-responsive no-padding  ">

                <div class="box-header ">
                    <h2 class="box-title">ข้อมูลการรับสินค้า</h2>

                </div>

                <div class="box-body ">

                    {!! $grid !!}
                </div>

            </div>

            {!! Rapyd::scripts() !!}


        </div>
    </div>


@stop
