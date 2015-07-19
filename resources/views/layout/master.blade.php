<!DOCTYPE html>

<html ng-app="application">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/dist/js/angular.min.js"></script>
    <script src="/dist/js/angular-route.min.js"></script>

    <link media="all" type="text/css" rel="stylesheet"
          href="http://www.rapyd.com/packages/zofe/rapyd/assets/redactor/css/redactor.css">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>

    <script src="/dist/js/typeahead.bundle.min.js"></script>

    <script src="/dist/js/ng-table.js"></script>
    <link rel="stylesheet" href="/dist/js/ng-table.css">


    <link href="/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css"/>
    <link href="/dist/css/typeahead.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="/app.css" rel="stylesheet" type="text/css"/>
    <script src="/dist/js/ap-app.js"></script>

</head>

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

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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