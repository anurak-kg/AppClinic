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
                    <li><a href="{{url('user/logout')}}"><i class='fa fa-sign-out '></i> <span>ออกจากระบบ</span></a></li>
                </a>

            </li>
          
        </ul>
    </div>
</nav>
