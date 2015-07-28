@extends('layout.master')
@section('title','Reset password')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title">Reset Password</h1>
                </div>
                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="box-body">
                    {!! Form::open(array('url' => 'user/resetpassword', 'class' => 'form')) !!}
                    {{$user->name}}<br>
                    <input class="form-control input-md courseBtn" type="password" id="pass" name="pass">
                     <input type="submit"  class="btn btn-block btn-primary" value="Reset">
                    <input type="hidden" value="{{$user->id}}" name="id">
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $("#cus_box").select2();
        });
    </script>
@stop
