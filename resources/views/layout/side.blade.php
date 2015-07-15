<aside class="main-sidebar">
    <section class="sidebar">

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="ค้นหา..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <li class="active"><a href="{{url('dashboard')}}"><i class='fa fa-home'></i> <span>หน้าหลัก</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-edit'></i> <span>ลูกค้า</span> <i class="fa fa-angle-left pull-right"></i></a>
                 <ul class="treeview-menu">
                  <li><a href="{{url('customer/newcus')}}"><i class='fa fa-plus'></i>ลงทะเบียน</a></li>
                     <li><a href="{{url('')}}"><i class='fa fa-shopping-cart'></i>ซื้อ คอร์ส</a></li>
                     <li><a href="{{url('')}}"><i class='fa fa-stethoscope'></i>การรักษา</a></li>
                 </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-history'></i> <span>ประวัติ</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('')}}"><i class='fa fa-heartbeat'></i>ประวัติการรักษา</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-database'></i> <span>คอร์ส</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('course/manage')}}"><i class='fa fa-plus'></i>จัดการ ข้อมูลคอร์ส</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-medkit'></i> <span>สินค้า</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('product_type/manage')}}"><i class='fa fa-minus'></i>สินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-minus'></i>ประเภทสินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-minus'></i>กลุ่มสินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-cart-plus'></i>สั่งซื้อ สินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-money'></i>ชำระเงิน</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-user-md'></i> <span>หมอ</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('dr/manage')}}"><i class='fa fa-user'></i>ข้อมูลหมอ</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-table'></i>ตารางการทำงาน หมอ</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-gears'></i> <span>การจัดการ</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('branch/manage')}}"><i class='fa fa-list'></i>จัดการ ข้อมูลสาขา</a></li>

                    <li><a href="{{url('vendor/manage')}}"><i class='fa fa-tag'></i>จัดการ ข้อมูลร้านค้า</a></li>
                    <li><a href="{{url('employee/index')}}"><i class='fa fa-users'></i>จัดการ ข้อมูลพนักงาน</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-line-chart'></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('')}}"><i class='fa fa-area-chart'></i>สรุปประเภทสินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-area-chart'></i>สรุปยอดขายประจำเดือน</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-area-chart'></i>สรุปยอดขายประจำปี</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
