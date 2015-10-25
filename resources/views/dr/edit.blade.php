@extends('layout.master')
@section('title','ข้อมูลหมอ')


@section('content')

    <div class="row">
        <div class="col-lg-3"></div>

        <div class="col-md-6">
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('customer.edit_data')}}</h2>
                </div>

                <div class="box-body" >

                    {!! $edit !!}
                </div>

            </div>



        </div>
    </div>

@stop
