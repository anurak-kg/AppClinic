<!DOCTYPE html>

<html ng-app="application">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- ห้ามลบ -->
    <script src="/js/app.js"></script>
    <script src="/dist/js/ap-app.js"></script>
    <link href="/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="/css/app.css" rel="stylesheet" type="text/css"/>
    <!-- //ห้ามลบ -->


    <link media="all" type="text/css" rel="stylesheet"
          href="http://www.rapyd.com/packages/zofe/rapyd/assets/redactor/css/redactor.css">
    <link href="/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="/dist/js/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/dist/js/ng-table.css">
    <link href="/dist/css/typeahead.css" rel="stylesheet" type="text/css"/>
    <link href="/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
    <script src="https://rawgithub.com/cletourneau/angular-bootstrap-datepicker/master/dist/angular-bootstrap-datepicker.js" charset="utf-8"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="/dist/css/skins/skin-purple.min.css" rel="stylesheet" type="text/css"/>


</head>

<body class="skin-purple fixed sidebar-collapse sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <a href="{{url('')}}" class="logo">
            <!-- Logo -->

            <span class="logo-mini"><b>C</b>D</span>
            <span class="logo-lg"><b>Clinic </b>Demo </span>
        </a>

        <!-- Header Navbar -->
        @include('layout.head')
    </header>
    @include('layout.side')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @yield('headText')
                <small>@yield('headDes')</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0 (10000)
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">MOT</a>.</strong> All rights reserved.
    </footer>


    <div class='control-sidebar-bg'></div>
</div>


<script src="/dist/js/app.js" type="text/javascript"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
</body>
</html>