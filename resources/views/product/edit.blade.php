@extends('layout.master')
@section('title',trans('product.Edit'))


@section('content')



    <div class="row">

        <div class="col-md-2">

        </div>

        <div class="col-md-8">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">{{trans('product.Edit')}}</h2>

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
