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

                    <span class="hidden-xs">{{Auth::user()->name}} ({{Auth::user()->roles[0]->display_name}})</span>

                </a>

            </li>
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    @if(\Illuminate\Support\Facades\Session::get('language') == "th")
                        ภาษาไทย (THAI)
                    @elseif(\Illuminate\Support\Facades\Session::get('language') == "en")
                        English
                    @endif

                </a>
                <ul class="dropdown-menu">

                    <li>
                        <ul class="menu">l
                            <li>
                                <a href="{{url("/update/lang?lang=en")}}">
                                    <img src="{{url("images/flag/flag_united_kingdom.png")}}" width="16px"
                                         height="16px"> ภาษาอังกฤษ (English)
                                </a>
                            </li>
                            <li>
                                <a href="{{url("/update/lang?lang=th")}}">
                                    <img src="{{url("images/flag/flag_thailand.png")}}" width="16px" height="16px">
                                    ภาษาไทย (Thai)
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>

            </li>

        </ul>
    </div>
</nav>
