@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('headText','ซื้อคอร์ส')
@section('content')
    <div ng-controller="quotationsController" id="course" ng-init="init({{config('shop.vat')}},{{$quo->quo_id}})">
        <script type="text/ng-template" id="payment.html">
            <div class="modal-header">
                <h3 class="modal-title">ชำระเงิน</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="total">ยอดทั้งสิ้น</label>
                        <input name="total"
                               class=" form-control input-lg"
                               type="number" id="total"
                                value="@{{getTotal() + getVat()}}"
                               disabled
                                />
                    </div>
                    <div class="col-md-12">
                        <label for="cashInput">รับเงิน</label>
                        <input name="cashInput" class=" form-control input-lg" ng-model="cashInput" type="number" id="cashInput"/>
                        <button class="btn" ng-click="cashAdd(1000)">+1000</button>
                        <button class="btn" ng-click="cashAdd(500)">+500</button>
                        <button class="btn" ng-click="cashAdd(100)">+100</button>
                        <button class="btn" ng-click="cashAdd(20)">+20</button>
                        <button class="btn" ng-click="cashAdd(10)">+10</button>
                        <button class="btn" ng-click="cashAdd(5)">+5</button>
                        <button class="btn" ng-click="cashAdd(1)">+5</button>

                    </div>

                    <div class="col-md-12">
                        <label for="withdrawn">เงินทอน</label>
                        <input name="withdrawn"
                               class=" form-control input-lg"
                               type="number" id="withdrawn"
                               value="@{{getTotal() + getVat() - cashInput}}"
                               disabled
                                />

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" ng-click="payment()">ชำระเงิน</button>
                <button class="btn btn-success" ng-click="paymentAndPrint({{$quo->quo_id}})">ชำระเงิน พร้อมปลิ้นบิล</button>
                <button class="btn btn-danger" ng-click="cancel()">ยกเลิก</button>
            </div>
        </script>
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
                <div class="panel  panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">รายละเอียด</h2>
                    </div>

                    <div class="panel-body">
                        เลขที่การสั่งซื้อ : <strong>{{$quo->quo_id}}</strong> <br>
                        เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">ข้อมูลลูกค้า</h2>
                    </div>

                    <div class="panel-body">
                        <div class="customerSearchBox" ng-hide="boxSearch"
                                >
                            <input class="form-control typeahead input-lg customer-input "
                                   type="search"
                                   placeholder="ระบุ ชื่อลูกค้า หรือ รหัสลูกค้า">
                        </div>

                        <div class="customer" ng-show="boxSearch">
                            <ul>
                                <li>รหัสลูกค้า  | <span class="sale"><strong>@{{customer.cus_id}}</strong></span>.</li>
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
                <div class="panel  panel-warning">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">พนักงานขาย</h2>
                    </div>

                    <div class="panel-body">
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
                                <span><br><strong><a href="{{url('quotations/remove_sale')}}">
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

                <div class="panel panel-info">

                    <div class="panel-heading with-border">
                        <h2 class="panel-title">คอร์ส</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
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

                                    <div class="col-md-10">
                                    <a href="#" ng-click="save()" class="btn btn-md btn-success pull-right"><i
                                                class="fa fa-credit-card "> ยืนยัน
                                            การชำระเงิน </i></a>
                                    </div>

                                </div>
                            </div>
                        </div>




                    </div>


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
