@extends('layout.master')
@section('title','ซื้อคอร์ส')


@section('content')

    <div class="row">

        <div class="col-md-12">

         <div class="box box-solid box-default">
               <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="box-body">
                                   <p>ข้อมูลลูกค้า</p>
               </div>

         </div>
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ซื้อคอร์ส</h2>
                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>

            </div>

        <div align="right" >
            <button class="btn btn-lg btn-success pull-right"><i class="fa fa-credit-card " > ยืนยัน การชำระเงิน </i>  </button>
        </div><!-- /.col -->

        </div>
    </div>

@stop
