@extends('layout.master')
@section('title',trans('product.product'))


@section('content')


    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">{{trans('product.Add')}}</h2>
                </div>

                <div class="panel-body">
                    {!! $form !!}
                </div>

            </div>



        </div>
    </div>

@stop
