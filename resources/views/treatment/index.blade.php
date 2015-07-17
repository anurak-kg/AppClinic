@extends('layout.master')
@section('title','ประวัติการรักษา')


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="box-body">
                    <p>ข้อมูลลูกค้า</p>
                </div>

            </div>
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ประวัติการรักษา</h2>
                </div>

                <div class="box-body table-responsive no-padding">
                    {!! $grid !!}
                </div>

            </div>

        </div>
    </div>

@stop
