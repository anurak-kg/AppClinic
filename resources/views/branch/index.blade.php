@extends('layout.master')
@section('title','ข้อมูลสาขา')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-primary table-responsive no-padding  ">

                <div class="panel-heading ">
                    <h2 class="panel-title">ข้อมูลสาขา</h2>

                </div>

                <div class="panel-body ">

                    {!! $grid !!}
                </div>

            </div>

            {!! Rapyd::scripts() !!}


        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#data-table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
