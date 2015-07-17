@extends('layout.master')
@section('title','ซื้อสินค้า')


@section('content')

    <div class="row">

        <div class="col-md-12">


            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ซื้อสินค้า</h2>
                </div>

                <div class="box-body table-responsive no-padding">
                    {!! $grid !!}
                </div>

            </div>

        <div align="right" >
            <button class="btn btn-lg btn-success pull-right">ยืนยัน การชำระเงิน  </button>
        </div><!-- /.col -->

        </div>
    </div>

@stop
