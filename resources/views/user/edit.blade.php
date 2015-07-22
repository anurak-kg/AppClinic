@extends('layout.master')
@section('title','ข้อมูลพนักงาน')


@section('content')

    <div class="row">
        <div class="col-md-5">
            <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">แก้ไขข้อมูล</h2>
                </div>

                <div class="box-body ">
                    {!! $edit !!}
                </div>
            </div>
        </div>


    </div>
    </div>

@stop
