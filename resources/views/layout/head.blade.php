<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <span class="hidden-xs">{{Auth::user()->name}} ({{Auth::user()->getRoleName()}})</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->

                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>

                </ul>
            </li>
          
        </ul>
    </div>
</nav>
