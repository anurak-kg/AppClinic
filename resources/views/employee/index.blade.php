@extends('layout.master')
@section('title','ข้อมูลพนักงาน')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลพนักงาน</h2>
                </div>

                <div class="box-body">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
