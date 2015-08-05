@extends('layout.master')
@section('title','สินค้าหมดอายุ')


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-primary">

                <div class="panel-heading with-border" align="middle">
                    <h2 class="panel-title">สินค้าหมดอายุ</h2>

                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>สาขา</th>
                                    <th>รหัสสินค้า</th>
                                    <th>สินค้า</th>
                                    <th>จำนวน</th>
                                </tr>
                                </thead>
                                @foreach($stock as $item)
                                    <tr>
                                        <td>{{ $item->branch_name }}</td>
                                        <td>{{ $item->product_id }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->total }}</td>
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
            $('table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Thai.json"
                },
            });
        });
    </script>

@stop
