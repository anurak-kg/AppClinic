<aside class="main-sidebar">
    <section class="sidebar">

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <li class="active"><a href="{{url('dashboard')}}"><i class='fa fa-link'></i> <span>Dashboard</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{Lang::get("general.warehouse")}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{Lang::get('warehouse.dashboard')}}</a></li>
                    <li><a href="#">{{Lang::get('warehouse.add')}}</a></li>
                    <li><a href="#">{{Lang::get('warehouse.add')}}</a></li>
                    <li><a href="#">{{Lang::get('warehouse.add')}}</a></li>
                    <li><a href="#">{{Lang::get('warehouse.setting')}}</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{Lang::get("general.user_management")}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{Lang::get('user.dashboard')}}</a></li>
                    <li><a href="{{url('user/manage')}}">{{Lang::get('user.add')}}</a></li>
                    <li><a href="#">{{Lang::get('user.edit')}}</a></li>


                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{Lang::get("general.product")}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{Lang::get('general.product_managent')}}</a></li>
                    <li><a href="{{url('product/manage')}}">{{Lang::get('user.add')}}</a></li>
                    <li><a href="#">{{Lang::get('user.edit')}}</a></li>


                </ul>
            </li>
            <li><a href="#"><i class='fa fa-link'></i> <span>Link</span></a></li>
            <li><a href="#"><i class='fa fa-link'></i> <span>Another Link</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
