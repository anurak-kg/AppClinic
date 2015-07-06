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
            <li class="active"><a href="{{url('dashboard')}}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-edit'></i> <span>Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
                 <ul class="treeview-menu">
                  <li><a href="{{url('customer')}}">ลงทะเบียนคนไข้ใหม่</a></li>
                  <li><a href="#">ซื้อคอร์ส</a></li>
                  <li><a href="#">การรักษา</a></li>
                 </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-th'></i> <span>Medical history</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   <li><a href="#">ประวัติการรักษา</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-database'></i> <span>Course</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('course')}}">จัดการคอร์ส</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-users'></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">จัดการหมอ</a></li>
                    <li><a href="#">จัดการพนักงาน</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
