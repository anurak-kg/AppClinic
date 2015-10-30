<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/uploads/logo/logo.JPG" class="img-circle" alt="User Image"/>
            </div>

            <div class="pull-left info">
                <br>

                <p>สาขา : {{\App\Branch::getCurrentName()}}</p>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <li><a href="{{url('')}}"><i class='fa fa-home'></i> <span>{{trans('dashboard.home')}}</span></a></li>

            @if(Auth::user()->can('quo'))
                <li><a href="{{url('quotations')}}"><i class='fa fa-shopping-cart'></i> <span>{{trans('dashboard.sales')}}</span></a></li>
            @endif

            @if(Auth::user()->can('treatment'))
                <li><a href="{{url('treatment')}}"><i class='fa fa-heartbeat'></i> <span>{{trans('dashboard.treatment')}}</span></a></li>
            @endif

            <li class="treeview">
                <a href="#"><i class='fa fa-edit'></i> <span>{{trans('dashboard.member')}}</span> <i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if(Auth::user()->can('customer-read'))
                        <li><a href="{{url('customer')}}"><i class='fa fa-minus fa-sm'></i>{{trans('dashboard.member_information')}}</a></li>
                    @endif
                    @if(Auth::user()->can('customer-create'))
                        <li><a href="{{url('customer/create')}}"><i class='fa fa-minus'></i>{{trans('dashboard.register')}}</a></li>
                    @endif
                    @if(Auth::user()->can('appointment'))
                        <li><a href="{{url('customer/calendar')}}"><i class='fa fa-minus'></i>{{trans('customer.appointment')}}</a></li>
                    @endif
                </ul>
            </li>
            @if(Auth::user()->can('course-read'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-database'></i> <span>{{trans('dashboard.course')}}</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('course/index')}}"><i class='fa fa-minus'></i>{{trans('course.Course_Management')}}</a></li>
                        <li><a href="{{url('course_type')}}"><i class='fa fa-minus'></i>{{trans('course.course_type')}}</a></li>
                    </ul>
                </li>
            @endif
            <li class="treeview">
                <a href="#"><i class='fa fa-medkit'></i> <span>{{trans('product.product')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if(Auth::user()->can('product-read'))
                        <li><a href="{{url('product/index')}}"><i class='fa fa-minus'> </i> {{trans('product.product_list')}}</a>
                        </li>
                    @endif
                    <li>
                        <a href="#"><i class="fa fa-minus"></i> {{trans('product.product')}} <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            @if(Auth::user()->can('product-group'))
                                <li><a href="{{url('product_group/index')}}"><i class='fa fa-angle-double-right'></i>{{trans('product.Product_groups')}}</a>
                                </li>
                            @endif
                            @if(Auth::user()->can('product'))
                                <li><a href="{{url('product/expday')}}"><i class='fa fa-angle-double-right'></i>{{trans('dashboard.expired_products')}}</a>
                                </li>
                                <li><a href="{{url('product/stock')}}"><i class='fa fa-angle-double-right'></i>{{trans('stock.stock')}}</a>
                                </li>
                                <li><a href="{{url('product/stockmanage')}}"><i class='fa fa-angle-double-right'></i>ตัดสต๊อกสินค้า</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if(Auth::user()->can('order-order') || (Auth::user()->can('receive-return')))
                        <li>
                            <a href="#"><i class="fa fa-minus"></i> การเบิก - รับสินค้าเข้าร้าน <i
                                        class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                @if(Auth::user()->can('order-order'))

                                    <li><a href="{{url('order/history')}}"><i class='fa fa-angle-double-right'></i>ประวัติการสั่งซื้อ</a>
                                    </li>
                                @endif
                                @if(Auth::user()->can('receive-return'))
                                    <li><a href="{{url('receive-request')}}"><i
                                                    class='fa fa-angle-double-right'></i>รับสินค้า</a></li>
                                    <li><a href="{{url('request')}}"><i
                                                    class='fa fa-angle-double-right'></i>เบิกสินค้า</a></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-exchange "></i> จัดการคลังสินค้า <i
                                        class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{url('order')}}"><i
                                                class='fa fa-angle-double-right'></i>สั่งซื้อสินค้า</a>
                                </li>
                                <li>
                                    <a href="{{url('receive')}}"><i class='fa fa-angle-double-right'></i>รับสินค้า</a>
                                </li>
                                <li>
                                    <a href="{{url('return')}}"><i class='fa fa-angle-double-right'></i>คืนสินค้า</a>
                                </li>
                                <li>
                                    <a href="{{url('request/history')}}"><i class='fa fa-angle-double-right'></i>รายการเบิกสินค้า</a>
                                </li>
                                <li>
                                    <a href="{{url('order/history')}}"><i class='fa fa-angle-double-right'></i>ประวัติการสั่งสินค้า</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </li>
            @if(Auth::user()->can('emp'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-user-md'></i> <span>{{trans('customer.doctor')}}</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('user/adddoctor')}}"><i class='fa fa-minus'></i>{{trans('customer.doctors_information')}}</a></li>
                        <li><a href="{{url('dr/calender')}}"><i class='fa fa-minus'></i>{{trans('customer.work_schedule')}}</a></li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->can('branch') || Auth::user()->can('vendor') || Auth::user()->can('emp') || Auth::user()->can('permission'))
                <li class="treeview">
                    <a href="#"><i class='fa fa-gears'></i> <span>{{trans('dashboard.Management')}}</span> <i
                                class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('branch'))
                            <li><a href="{{url('branch/index')}}"><i class='fa fa-minus'></i>{{trans('dashboard.Information_Management_Branch')}}</a></li>
                        @endif
                        @if(Auth::user()->can('vendor'))
                            <li><a href="{{url('vendor/index')}}"><i class='fa fa-minus'></i>{{trans('dashboard.Management_information_stores')}}</a>
                            </li>
                        @endif
                        @if(Auth::user()->can('emp'))
                            <li><a href="{{url('user/manage')}}"><i class='fa fa-minus'></i>{{trans('dashboard.Management_Information_Officer')}}</a></li>
                        @endif
                        @if(Auth::user()->can('report'))
                            <li><a href="{{url('money/manage')}}"><i class='fa fa-minus'></i>{{trans('dashboard.financial_management')}}</a></li>
                        @endif
                        @if(Auth::user()->can('permission'))
                            <li><a href="{{url('permission')}}"><i class='fa fa-minus'></i>{{trans('dashboard.securable')}}</a></li>
                        @endif
                        @if(Auth::user()->can('permission'))
                            <li><a href="{{url('log/index')}}"><i class="fa fa-server"></i>System Log</a></li>
                        @endif
                        @if(Auth::user()->can('setting'))
                            <li><a href="{{url('setting')}}"><i class="fa fa-gears"></i>{{trans('dashboard.setting')}}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(Auth::user()->can('report') || Auth::user()->can('customer-create'))
                <li><a href="{{url('report/index')}}"><i class='fa fa-pie-chart'></i> <span>{{trans('dashboard.report')}}</span></a></li>

                {{--<li class="treeview">--}}
                    {{--<a href="#"><i class='fa fa-pie-chart'></i> <span>รายงาน</span> <i--}}
                                {{--class="fa fa-angle-left pull-right"></i></a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{url('report/customer_ref')}}"><i class='fa fa-minus'></i>แหล่งที่มาของสมาชิก </a></li>--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/sale')}}"><i class='fa fa-minus'></i>ยอดขายพนักงาน </a></li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/salesperday')}}"><i class='fa fa-minus'></i>ยอดขายรายวัน</a></li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/doctor')}}"><i class='fa fa-minus'></i>ยอดขายแพทย์</a></li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/coursemonth')}}"><i class='fa fa-minus'></i>ยอดขายคอร์สต่อเดือน</a></li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/coursehot')}}"><i class='fa fa-minus'></i>คอร์สที่ขายดีที่สุด</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/producthot')}}"><i--}}
                                            {{--class='fa fa-minus'></i>สินค้าที่ขายดีที่สุด</a>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/suplier')}}"><i class='fa fa-minus'></i>รายจ่ายจาก Suplier</a>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report'))--}}
                            {{--<li><a href="{{url('report/customer_payment')}}"><i--}}
                                            {{--class='fa fa-minus'></i>รายได้ทั้งหมด</a>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/commissionCash')}}"><i class='fa fa-minus'></i>Commission เงินสด</a>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/commissionCredit')}}"><i class='fa fa-minus'></i>Commission--}}
                                    {{--Credit</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/commission')}}"><i class='fa fa-minus'></i>Commission</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/commissionTransfer')}}"><i class='fa fa-minus'></i>Commission--}}
                                    {{--โอนเงิน</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                        {{--@if(Auth::user()->can('report') || Auth::user()->can('customer-create'))--}}
                            {{--<li><a href="{{url('report/request')}}"><i class='fa fa-minus'></i>รายงานเบิกสินค้า</a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                    {{--</ul>--}}
                {{--</li>--}}
            @endif

            <li><a href="{{url('user/logout')}}"><i class='fa fa-sign-out '></i> <span>{{trans('dashboard.Sign_out')}}</span></a></li>

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
