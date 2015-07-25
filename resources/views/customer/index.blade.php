@extends('layout.master')
@section('title','ข้อมูลสมาชิก')
@section('content')
    <div ng-controller="quotationsController" id="course">
        <div class="row">
            @if( Session::get('message') != null )
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4>Success!</h4>

                        <p>{{Session::get('message')}}.</p>
                    </div>
                </div>
            @endif

            <div class="col-md-6">
                <div class="box box-solid box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูลลูกค้า</h2>
                    </div>
                    <div class="box-body">
                        <div class="customerSearchBox" ng-hide="boxSearch"
                                >
                            <input class="form-control typeahead input-lg customer-input "
                                   type="search"
                                   placeholder="ระบุ ชื่อลูกค้า หรือ รหัสลูกค้า">
                        </div>

                        <div class="customer" ng-show="boxSearch">
                            <ul>
                                <li>รหัสลูกค้า | <span class="customer"><strong>@{{customer.id}} </strong></span>
                                    วันที่ลงทะเบียน | <span class="customer"><strong>@{{customer.reg}} </strong></span>
                                    สาขาที่สมัคร | <span class="customer"><strong>@{{customer.branch}} </strong></span><br>
                                    ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                    รหัสบัตรประชาชน | <span class="customer"><strong>@{{ customer.id_card }}</strong></span><br>
                                    วันเดือนปีเกิด | <span class="customer"><strong>@{{ customer.birthday }}</strong></span>
                                    เพศ | <span class="customer"><strong>@{{ customer.gender }}</strong></span>
                                    กรุ๊ปเลือด | <span class="customer"><strong>@{{ customer.blood }}</strong></span><br>
                                    ส่วนสูง | <span class="customer"><strong>@{{ customer.height }}</strong></span>
                                    น้ำหนัก | <span class="customer"><strong>@{{ customer.weight }}</strong></span><br>
                                    โรคประจำตัว | <span class="customer"><strong>@{{ customer.allergic }}</strong></span><br>
                                    แพ้ยา | <span class="customer"><strong>@{{ customer.disease }}</strong></span> <br>
                                    เบอร์โทรศัพท์มือถือ | <span class="customer"><strong>@{{ customer.phone }}</strong></span>
                                    เบอร์โทรศัพท์ | <span class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    E-mail | <span class="customer"><strong>@{{ customer.email }}</strong></span><br>
                                    ที่อยู่ | <span class="customer"><strong>@{{ customer.address }}</strong></span><br>
                                    <span><strong><a href="{{url('customer/remove_customer')}}">
                                                เปลียนลูกค้า</a></strong></span>
                                </li><br>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="box box-solid box-success">
                        <div class="box-header with-border">
                            <h2 class="box-title">ประวัติการซื้อคอร์ส</h2>
                        </div>
                        <div class="box-body">
                            <div class="course" ng-show="boxSearch">
                                <ul>
                                    <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                    </li>
                                    <li>ชื่อเบอร์โทร | <span class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-solid box-warning">
                        <div class="box-header with-border">
                            <h2 class="box-title">ประวัติการรักษา</h2>
                        </div>
                        <div class="box-body">


                            <div class="course" ng-show="boxSearch">
                                <ul>
                                    <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                    </li>
                                    <li>ชื่อเบอร์โทร | <span class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/customer/query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            customerDb.initialize();
            $('.customer-input').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'cus_name',
                        source: customerDb.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลลูกค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{cus_name}} @{{cus_lastname}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        customer =
                        {
                            cus_id: datum.cus_id,
                            cus_name: datum.cus_name,
                            cus_lastname: datum.cus_lastname,
                            cus_tel: datum.cus_tel
                        }
                        console.log(customer);
                        angular.element(document.getElementById('customer')).scope().customerSelect(customer);

                    })

        });
    </script>
@stop
