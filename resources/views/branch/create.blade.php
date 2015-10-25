@extends('layout.master')
@section('title',trans('branch.branch information'))


@section('content')

    <div class="row">

        <div class="col-md-3">
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('branch.Add')}}</h2>
                </div>
                <div class="box-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
    </div>

@stop
