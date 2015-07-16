<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <link media="all" type="text/css" rel="stylesheet" href="http://www.rapyd.com/packages/zofe/rapyd/assets/redactor/css/redactor.css">

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <link href="/app.css" rel="stylesheet" type="text/css" />

    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue  sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <a href="{{url('dashboard')}}" class="logo">
        <!-- Logo -->

            <span class="logo-mini"><b>C</b>D</span>
            <span class="logo-lg"><b>Clinic</b> Demo</span>
        </a>

        <!-- Header Navbar -->
        @include('layout.head')
    </header>
   @include('layout.side')
    <div class="content-wrapper">
        <section class="content-header">


        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Contact : 087-5430262
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">FIIN Tech</a>.</strong> All rights reserved.
    </footer>


    <div class='control-sidebar-bg'></div>
</div>


<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/dist/js/app.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="http://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
<script src="http://datatables.yajrabox.com/js/handlebars.js"></script>
<script src="http://www.rapyd.com/packages/zofe/rapyd/assets/redactor/jquery.browser.min.js"></script>
<script src="http://www.rapyd.com/packages/zofe/rapyd/assets/redactor/redactor.min.js"></script>
</body>
</html>