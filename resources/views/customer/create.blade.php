@extends('layout.master')
@section('title','ลงทะเบียน')


@section('content')

    <div class="row">

        <div class="col-md-5" >
            <div class="box box-solid box-success">

                <div class="box-header with-border">
                    <h2 class="box-title">ลงทะเบียน</h2>
                </div>

                <div class="box-body">
                    {!! $form !!}
                </div>

            </div>



        </div>
    </div>

@stop
