<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="../../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css"/>


</head>

<body class="login-page">
<div class="login-box">

    <div class="login-logo">
        <a><b>Clinic</b> Demo</a>
    </div>
    <!-- /.login-logo -->

    @if($errors->any())
        <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>

    @endif
    <div class="login-box-body">
        {!! Form::open(['action' => 'UserController@auth', 'method' => 'post', 'class' => 'form-signin']) !!}
        <span id="reauth-email" class="reauth-email"></span>


      <select class="form-control n" id="names" style="color:darkgrey;">
          @foreach($data as $name)
         <option value="" disabled selected style='display:none;'>เลือกสาขา...</option>
         <option value="{{$name->branch_name}}" style="color:black;">{{$name->branch_name}} </option>
          @endforeach
       </select> <br>


        <div class="form-group has-feedback">
            {!! Form::input('text', 'username', null, ['class' =>
            'form-control','id'=>'inputEmail','placeholder'=>'โปรดระบุ Username...']) !!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            {!! Form::input('password', 'password', null, ['class' =>
            'form-control','id'=>'inputPassword','placeholder'=>'โปรดระบุ Password...']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="col-xs-">
            <button class="btn  btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </div>
        <!-- /.col -->

        </form><!-- /form -->

    </div>

</div>
</div><!-- /.login-box


<!-- Bootstrap 3.3.2 JS -->
<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script>
    $(function () {
        $(".n").select2();

    });
</script>

</body>
</html>
