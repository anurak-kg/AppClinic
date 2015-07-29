@extends('layout.master')
@section('title','ข้อมูลลูกค้า')
@section('content')

    <div class="row">

        <div class="col-md-2">

        </div>

        <div class="col-md-8">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>

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
