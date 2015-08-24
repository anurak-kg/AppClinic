<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/dist/img/11797990_951960494863627_1141623071_n.jpg" class="img-circle" alt="User Image"/>
            </div>

            <div class="pull-left info">
                <br>

                <p>สาขา : {{\App\Branch::getCurrentName()}}</p>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <li><a href="{{url('')}}"><i class='fa fa-home'></i> <span>หน้าหลัก</span></a></li>

            @if(Auth::user()->can('quo'))
                <li><a href="{{url('quotations')}}"><i class='fa fa-shopping-cart'></i> <span>ซื้อคอร์ส</span></a></li>
            @endif

            @if(Auth::user()->can('treatment'))
                <li><a href="{{url('treatment')}}"><i class='fa fa-heartbeat'></i> <span>การรักษา</span></a></li>
            @endif

            <li class="treeview">
                <a href="#"><i class='fa fa-edit'></i> <span>สมาชิก</span> <i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if(Auth::user()->can('customer-read'))
                        <li><a href="{{url('customer')}}"><i class='fa fa-minus fa-sm'></i>ข้อมูลสมาชิก</a></li>
                    @endif
                    @if(Auth::user()->can('customer-create'))
                        <li><a href="{{url('customer/create')}}"><i class='fa fa-minus'></i>สมัครสมาชิก</a></li>
                    @endif
                    @if(Auth::user()->can('appointment'))
                        <li><a href="{{url('customer/calendar')}}"><i class='fa fa-minus'></i>ตารางนัด</a></li>
                    @endif
                </ul>
            </li>
            @if(Auth::user()->can('course-read'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-database'></i> <span>คอร์ส</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('course/index')}}"><i class='fa fa-minus'></i>ข้อมูลคอร์ส</a></li>
                    </ul>
                </li>
            @endif
            <li class="treeview">
                <a href="#"><i class='fa fa-medkit'></i> <span>สินค้า</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#"><i class="fa fa-minus"></i> สินค้า <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->can('product-read'))
                                <li><a href="{{url('product/index')}}"><i class='fa fa-angle-double-right'></i>ข้อมูลสินค้า</a>
                                </li>
                            @endif
                            @if(Auth::user()->can('product-group'))
                                <li><a href="{{url('product_group/index')}}"><i class='fa fa-angle-double-right'></i>กลุ่มสินค้า</a>
                                </li>
                            @endif
                            @if(Auth::user()->can('product'))
                                <li><a href="{{url('product/expday')}}"><i class='fa fa-angle-double-right'></i>ข้อมูลสินค้าหมดอายุ</a>
                                </li>
                                <li><a href="{{url('product/stock')}}"><i class='fa fa-angle-double-right'></i>สต๊อกสินค้า</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if(Auth::user()->can('order-order') || (Auth::user()->can('receive-return')))
                        <li>
                            <a href="#"><i class="fa fa-minus"></i> การสั่งซื้อสินค้า <i
                                        class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                @if(Auth::user()->can('order-order'))
                                    <li><a href="{{url('order')}}"><i class='fa fa-angle-double-right'></i>สั่งซื้อสินค้า</a>
                                    </li>
                                    <li><a href="{{url('order/history')}}"><i class='fa fa-angle-double-right'></i>ประวัติการสั่งซื้อ</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('receive-return'))
                                    <li><a href="{{url('receive')}}"><i class='fa fa-angle-double-right'></i>รับสินค้า</a></li>
                                    <li><a href="{{url('return')}}"><i class='fa fa-angle-double-right'></i>คืนสินค้า</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
            @if(Auth::user()->can('emp'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-user-md'></i> <span>หมอ</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('user/adddoctor')}}"><i class='fa fa-minus'></i>ข้อมูลหมอ</a></li>
                        <li><a href="{{url('dr/calender')}}"><i class='fa fa-minus'></i>ตารางการทำงาน</a></li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->can('branch') || Auth::user()->can('vendor') || Auth::user()->can('emp') || Auth::user()->can('permission'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-gears'></i> <span>การจัดการ</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('branch'))
                            <li><a href="{{url('branch/index')}}"><i class='fa fa-minus'></i>จัดการข้อมูลสาขา</a></li>
                        @endif
                        @if(Auth::user()->can('vendor'))
                            <li><a href="{{url('vendor/index')}}"><i class='fa fa-minus'></i>จัดการข้อมูลร้านค้า</a>
                            </li>
                        @endif
                        @if(Auth::user()->can('emp'))
                            <li><a href="{{url('user/manage')}}"><i class='fa fa-minus'></i>จัดการข้อมูลพนักงาน</a></li>
                        @endif
                        @if(Auth::user()->can('report'))
                            <li><a href="{{url('money/manage')}}"><i class='fa fa-minus'></i>จัดการการเงิน</a></li>
                        @endif
                        @if(Auth::user()->can('permission'))
                            <li><a href="{{url('permission')}}"><i class='fa fa-minus'></i>กำหนดสิทธ์</a></li>
                        @endif
                        @if(Auth::user()->can('setting'))
                            <li><a href="{{url('setting')}}"><i class="fa fa-gears"></i>  ตั้งค่า</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(Auth::user()->can('report'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-pie-chart'></i> <span>รายงาน</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        {{--<li><a href="{{url('report/customer_ref')}}"><i class='fa fa-minus'></i>แหล่งที่มาของสมาชิก </a></li>--}}
                        <li><a href="{{url('report/sale')}}"><i class='fa fa-minus'></i>ยอดขายพนักงาน </a></li>
                        <li><a href="{{url('report/salesperday')}}"><i class='fa fa-minus'></i>ยอดขายรายวัน</a></li>
                        <li><a href="{{url('report/doctor')}}"><i class='fa fa-minus'></i>ยอดขายแพทย์</a></li>
                        <li><a href="{{url('report/coursemonth')}}"><i class='fa fa-minus'></i>ยอดขายคอร์ส</a></li>
                        <li><a href="{{url('report/coursehot')}}"><i class='fa fa-minus'></i>คอร์สที่ขายดีที่สุด</a>
                        </li>
                        <li><a href="{{url('report/producthot')}}"><i class='fa fa-minus'></i>สินค้าที่ขายดีที่สุด</a>
                        <li><a href="{{url('report/suplier')}}"><i class='fa fa-minus'></i>รายจ่ายจาก Suplier</a>
                        <li><a href="{{url('report/customer_payment')}}"><i class='fa fa-minus'></i>รายได้ทั้งหมด</a>
                        <li><a href="{{url('report/commissionCash')}}"><i class='fa fa-minus'></i>Commission เงินสด</a>
                        <li><a href="{{url('report/commissionCredit')}}"><i class='fa fa-minus'></i>Commission
                                Credit</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li><a href="{{url('user/logout')}}"><i class='fa fa-sign-out '></i> <span>ออกจากระบบ</span></a></li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>

    <!-- /.sidebar -->

    <script type="text/javascript" src="/dist/js/jquery.slimscroll.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#side').slimScroll({
                position: 'right',
                height: '150px',
                railVisible: true,
                alwaysVisible: true
            });
        });
    </script>
</aside>
