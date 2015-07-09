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
                  <li><a href="{{url('customer/newcus')}}"><i class='fa fa-user-plus'></i>ลงทะเบียนคนไข้</a></li>
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
                    <li><a href="{{url('course/manage')}}"><i class='fa fa-plus'></i>จัดการ ข้อมูลคอร์ส</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-truck'></i> <span>Product</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('product_type/manage')}}"><i class='fa fa-minus'></i>ประเภทสินค้า</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-wrench'></i> <span>Manage</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('branch/manage')}}"><i class='fa fa-list'></i>จัดการ ข้อมูลสาขา</a></li>
                    <li><a href="{{url('dr/manage')}}"><i class='fa fa-user'></i>จัดการ ข้อมูลหมอ</a></li>
                    <li><a href="{{url('vendor/manage')}}"><i class='fa fa-tag'></i>จัดการ ข้อมูลร้านค้า</a></li>
                    <li><a href="#">จัดการพนักงาน</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
