@extends('layout.master')
@section('title','ลงทะเบียน')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-success">

                <div class="box-header with-border">
                    <h2 class="box-title">ลงทะเบียน</h2>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6"> {!! $form->render('cus_name') !!}
                        </div>
                        <div class="col-md-6"></div>

                    </div>
                </div>

            </div>


        </div>
    </div>

@stop
