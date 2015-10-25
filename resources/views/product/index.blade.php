@extends('layout.master')
@section('title',trans('product.product'))
@section('headText','Product')
@section('headDes',trans('product.Medication and Product Management'))
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-success ">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('product.product')}}</h2>
                    <div class="box-tools pull-right">
                        <a href="{{url('product/create')}}"
                           class="btn btn-success">{{trans('product.Add')}}</a>
                    </div>
                </div>

                <div class="box-body " style="    margin-top: -32px;">
                    {!! $grid !!}
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#product_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
