@extends('layout.master')
@section('title','ประเภทสินค้า')

@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading">
                    <h2 class="box-title">ข้อมูลประเภทสินค้า</h2>
                </div>

                <div class="panel-body ">
                    {!! $grid !!}
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
