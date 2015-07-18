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
                <a href="#"><i class='fa fa-edit'></i> <span>สมาชิก</span> <i class="fa fa-angle-left pull-right"></i></a>
                 <ul class="treeview-menu">
                  <li><a href="{{url('customer/index')}}"><i class='fa fa-minus'></i>ข้อมูลสมาชิก</a></li>
                  <li><a href="{{url('customer/create')}}"><i class='fa fa-minus'></i>สมัครสมาชิก</a></li>
                  <li><a href="{{url('')}}"><i class='fa fa-minus'></i>ซื้อคอร์ส</a></li>
                     <li>
                         <a href="#"><i class="fa fa-minus"></i>การรักษา<i class="fa fa-angle-left pull-right"></i></a>
                         <ul class="treeview-menu">
                             <li><a href="{{url('treatment/index')}}">ประวัติการรักษา</a>
                         </ul>
                     </li>

                  <li><a href="{{url('')}}"><i class='fa fa-minus'></i>ตารางนัด</a></li>

                 </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-database'></i> <span>คอร์ส</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('course/index')}}"><i class='fa fa-minus'></i>ข้อมูลคอร์ส</a></li>
                </ul>
            </li>

            <li class="treeview">

                <a href="#"><i class='fa fa-medkit'></i> <span>สินค้า</span> <i class="fa fa-angle-left pull-right"></i></a>

                <ul class="treeview-menu">
                                    <li>
                                      <a href="#"><i class="fa fa-minus"></i> สินค้า <i class="fa fa-angle-left pull-right"></i></a>
                                      <ul class="treeview-menu">
                                        <li><a href="{{url('product/index')}}"><i class='fa fa-angle-double-right'></i>ข้อมูลสินค้า</a></li>
                                        <li><a href="{{url('product_group/index')}}"><i class='fa fa-angle-double-right'></i>กลุ่มสินค้า</a></li>
                                        <li><a href="{{url('product_type/index')}}"><i class='fa fa-angle-double-right'></i>ประเภทสินค้า</a></li>

                                      </ul>
                                    </li>
                          <li><a href="{{url('order/index')}}"><i class='fa fa-minus'></i>สั่งซื้อสินค้า</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-user-md'></i> <span>หมอ</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('dr/index')}}"><i class='fa fa-minus'></i>ข้อมูลหมอ</a></li>
                    <li><a href="{{url('dr/calender')}}"><i class='fa fa-minus'></i>ตารางการทำงาน หมอ</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-gears'></i> <span>การจัดการ</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('branch/index')}}"><i class='fa fa-minus'></i>จัดการ ข้อมูลสาขา</a></li>
                    <li><a href="{{url('vendor/index')}}"><i class='fa fa-minus'></i>จัดการ ข้อมูลร้านค้า</a></li>
                    <li><a href="{{url('employee/index')}}"><i class='fa fa-minus'></i>จัดการ ข้อมูลพนักงาน</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-pie-chart'></i> <span>รายงาน</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('')}}"><i class='fa fa-minus'></i>สรุปประเภทสินค้า</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-minus'></i>สรุปยอดขายประจำเดือน</a></li>
                    <li><a href="{{url('')}}"><i class='fa fa-minus'></i>สรุปยอดขายประจำปี</a></li>
                </ul>
            </li>

            <li><a href="{{url('user/logout')}}"><i class='fa fa-sign-out '></i> <span>ออกจากระบบ</span></a></li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
