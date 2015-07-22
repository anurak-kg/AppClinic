@extends('layout.master')
@section('title','ประวัติการรักษา')


@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="box box-solid box-default table-responsive no-padding">
                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="box-body">
                    <p>ข้อมูลลูกค้า</p>
                </div>

            </div>

            <div class="box box-solid box-default table-responsive no-padding">
                <div class="box-header with-border">
                    <h2 class="box-title">ข้อมูล คอร์ส</h2>
                </div>

                <div class="box-body">
                    <p>คอร์ส</p>
                </div>

            </div>

            <div class="box box-solid box-default table-responsive no-padding">

                <div class="box-header with-border">
                    <h2 class="box-title">ประวัติการรักษา</h2>
                </div>

                <div class="box-body ">
                    {!! $grid !!}
                </div>

            </div>

        </div>
    </div>

@stop
