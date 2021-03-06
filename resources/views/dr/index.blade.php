@extends('layout.master')
@section('title','ข้อมูลหมอ')


@section('content')

    <div class="row">

        <div class="col-md-5" >
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('customer.add')}}</h2>
                </div>

                <div class="box-body">
                    {!! $form !!}
                </div>

            </div>
        </div>

        <div class="col-md-7">
            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('customer.doctors_information')}}</h2>
                </div>

                <div class="box-body">
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
