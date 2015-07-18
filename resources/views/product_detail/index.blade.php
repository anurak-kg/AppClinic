@extends('layout.master')
@section('title','ซื้อสินค้า')


@section('content')

    <div class="row">

        <div class="col-md-12">


            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header ">
                    <h2 class="box-title">ซื้อสินค้า</h2>
                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>

            </div>

        <div align="right" >
            <button class="btn btn-lg btn-success pull-right">ยืนยัน การชำระเงิน  </button>
        </div><!-- /.col -->

        </div>
    </div>

@stop
