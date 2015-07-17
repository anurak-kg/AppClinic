@extends('layout.master')
@section('title','ข้อมูลหมอ')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลหมอ</h2>
                </div>

                <div class="box-body table-responsive no-padding">
                    {!! $grid !!}
                </div>

            </div>



        </div>
    </div>

@stop
