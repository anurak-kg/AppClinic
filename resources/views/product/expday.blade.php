@extends('layout.master')
@section('title',trans('dashboard.expired_products'))


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">{{trans('dashboard.expired_products')}}</h2>

                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                <tr>
                                    <th>{{trans('product.product_code')}}</th>
                                    <th>{{trans('product.Product_name')}}</th>
                                    <th>{{trans('dashboard.expiration_date')}}</th>
                                    <th>{{trans('dashboard.remain')}}</th>
                                </tr>
                                </thead>
                                @foreach($exp as $item)
                                    <tr>
                                        <td>{{ $item->product_id }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product_exp }}</td>
                                        <td>{{ $item->day }} {{trans('dashboard.day')}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                "language": {
                    "url": "/Thai.json"
                }
            });
        });
    </script>

@stop
