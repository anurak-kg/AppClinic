@extends('layout.master')
@section('title','Product')
@section('headText','Product Add')
@section('headDes','รายละเอียด')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Lang::get('user.create')}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!! $form !!}

                </div>


            </div>
            <!-- /.box -->


        </div>
    </div>
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {

            $('#body').redactor();

        });

    </script>

@stop
