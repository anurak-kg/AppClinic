@extends('layout.master')
@section('title','ข้อมูลลูกค้า')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-primary">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
