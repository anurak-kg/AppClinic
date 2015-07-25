@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('headText','ซื้อคอร์ส')
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
            <div class="col-md-4">
                <div class="box  box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">รายละเอียด</h2>
                    </div>

                    <div class="box-body">
                        เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-success">
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
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                </li>
                                <li>ชื่อเบอร์โทร | <span
                                            class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    <span><strong><a href="{{url('quotations/remove_customer')}}">
                                                เปลียนลูกค้า</a></strong></span>

                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box  box-danger">
                    <div class="box-header with-border">
                        <h2 class="box-title">พนักงานขาย</h2>
                    </div>

                    <div class="box-body">
                        <div class="saleSearchBox" ng-hide="SaleBoxSearch"
                                >
                            <input class="form-control typeahead input-lg sale-input "
                                   type="search"
                                   placeholder="ชื่อพนักงาน หรือ รหัสพนักงาน">
                        </div>

                        <div class="sale" ng-show="SaleBoxSearch">
                            <ul>
                                <li>รหัสพนักงาน  | <span class="sale"><strong>@{{sale.id}}</strong></span>.</li>
                                <li>ชื่อลูกค้า | <span class="sale"><strong>@{{sale.name}}</strong></span>.
                                <span><strong><a href="{{url('quotations/remove_sale')}}">
                                            เปลียนพนักงานขาย</a></strong></span>
                                </li>
                               </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">

                    <div class="box-header with-border">
                        <h2 class="box-title">คอร์ส</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="div row">
                                    <div class="col-md-5">
                                        <input class="form-control typeahead input-lg courseBtn"
                                               type="search"
                                               id="course"
                                               ng-model="courseSearchBox"
                                               placeholder="ระบุ ชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค้ด ">
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-app" href="{{url('product/update')}}">
                                            <i class="fa fa-plus-circle"></i> จัดการคอร์ส
                                        </a>
                                    </div>

                                    <div class="col-md-1">
                                        <i ng-if="dataLoading" class="fa fa-spinner fa-spin loading"></i>

                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-bordered" ng-table="tableParams" ng-init="">
                                        <tr data-ng-repeat="item in product">
                                            <td style="width: 5px">
                                                <button class="btn btn-box-tool" data-widget="remove"
                                                        ng-click="deleteById(item.course_id)"><i
                                                            class="fa fa-times"></i>
                                                </button>

                                            </td>
                                            <td data-title="'#'" style="width: 10px">
                                                @{{$index+1}}
                                            </td>

                                            <td data-title="'คอร์ส'">
                                                @{{item.course.course_name}}<br>
                                                <strong>รายละเอียดคอร์ส</strong>
                                                <ul>
                                                    <li ng-repeat="c in item.course.detail">
                                                        @{{c.course_detail_name}}
                                                        <strong>@{{c.course_detail_qty}}</strong> ครั้ง
                                                    </li>
                                                </ul>
                                            </td>
                                            <td data-title="'ราคา'">
                                                @{{item.course.course_price | number }}
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="3" class="total-price">Subtotal:</td>
                                            <td>@{{ getTotal() | number }} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="total-price">Tax(7%):</td>
                                            <td><?php echo "{{ getVat(" . config('shop.vat') . ") | number }} ";?>บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="total-price">Total:</td>
                                            <td><?php echo "{{ getTotal() + getVat(" . config('shop.vat') . ") | number }} ";?>
                                                บาท
                                            </td>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div align="right">

                    <a href="#" ng-click="save()" class="btn btn-lg btn-success pull-right"><i
                                class="fa fa-credit-card "> ยืนยัน
                            การชำระเงิน </i></a>
                </div>
                <!-- /.col -->

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            var courseDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/quotations/course_query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            var saleDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/data/user_search?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/quotations/query?q=%QUERY',
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
                            suggestion: Handlebars.compile('<div>@{{cus_id}} - @{{cus_name}} @{{cus_lastname}}</div>')
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
                        angular.element(document.getElementById('course')).scope().customerSelect(customer);

                    })
            saleDb.initialize();
            $('.sale-input').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'name',
                        source: saleDb.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลลูกค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{id}} - @{{name}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        sale =
                        {
                            id: datum.id,
                            name: datum.name
                        }
                        console.log(sale);
                        angular.element(document.getElementById('course')).scope().saleSelect(sale);

                    })

            courseDb.initialize();
            $('.courseBtn').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'course_name',
                        source: courseDb.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลสินค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{course_id}} – @{{course_name}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        course =
                        {
                            id: datum.course_id,
                            course: {
                                course_name: datum.course_name,
                                course_price: datum.course_price,
                                detail: datum.detail
                            }
                        }
                        console.log(course);
                        angular.element(document.getElementById('course')).scope().pushProduct(course);

                    })

        });
    </script>
@stop
