@extends('layout.master')
@section('title','แก้ไขข้อมูล')


@section('content')



    <div class="row">

        <div class="col-md-2">

        </div>

        <div class="col-md-8">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">แก้ไขข้อมูล</h2>

                </div>

                <div class="box-body">
                    <p>
                        {!! $edit !!}
                    </p>
                </div>

            </div>


        </div>

    </div>

@stop
