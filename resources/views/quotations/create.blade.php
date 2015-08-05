@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('headText','ซื้อคอร์ส')
@section('content')
    <div ng-controller="quotationsController" id="course"  ng-init="setVat({{config('shop.vat')}})">
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
                        <input name="cashInput" class=" form-control input-lg" ng-model="cashInput" type="number"
                               id="cashInput"/>
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
                <button class="btn btn-success" ng-click="paymentAndPrint({{$quo->quo_id}})">ชำระเงิน พร้อมปลิ้นบิล
                </button>
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
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-info"></i>

                        <h2 class="box-title">รายละเอียด</h2>
                    </div>

                    <div class="box-body">
                        เลขที่การสั่งซื้อ : <strong>{{$quo->quo_id}}</strong> <br>
                        เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>

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
                                <li>รหัสลูกค้า | <span class="sale"><strong>@{{customer.cus_id}}</strong></span>.</li>
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.cus_name}}</strong></span>
                                </li>
                                <li>ชื่อเบอร์โทร | <span
                                            class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    <span><strong><a href="{{url('quotations/removecustomer')}}">
                                                เปลียนลูกค้า</a></strong></span>

                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <i class="fa fa-user"></i>

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
                                <li>รหัสพนักงาน | <span class="sale"><strong>@{{sale.id}}</strong></span>.</li>
                                <li>ชื่อลูกค้า | <span class="sale"><strong>@{{sale.name}}</strong></span>.
                                </li>
                                <li>ยอดขายบิลนี้ | <span class="sale"><strong>@{{getTotal()}}</strong> บาท</span>.</li>
                                <li>ค่าแนะนำ <?php echo getConfig('commission_rate');?>% | <span
                                            class="sale"><strong>{{getTotal()*<?php echo getConfig('commission_rate');?>/100}}</strong> บาท</span>.
                                </li>
                                <li><strong><a href="{{url('quotations/removesale')}}">
                                            เปลียนพนักงานขาย</a></strong></li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <i class="fa fa-cart-plus"></i>

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
                                        <a class="btn btn-app" href="{{url('course/index')}}">
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
                                            <td data-title="'ราคา'" style="width:170px;text-align: right">
                                                @{{item.course.course_price | number:2 }}
                                            </td>
                                            <td data-title="'ส่วนลดเปอร์เซ็น'" style="width: 80px">
                                                <input type="number"
                                                       ng-model="item.quo_de_discount"
                                                       ng-change="update('quo_de_discount',item.course_id,item.quo_de_discount)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="'ส่วนลดจำนวนเงิน'" style="width: 80px">
                                                <div class="input-group">
                                                    <input type="text"
                                                           ng-model="item.quo_de_disamount"
                                                           ng-change="update('quo_de_disamount',item.course_id,item.quo_de_disamount)"
                                                           ng-model-options="{debounce: 750}"
                                                           class="form-control">
                                                </div>
                                            </td>
                                            <td data-title="'จำนวนเงินที่ต้องชำระ'" style="width:170px;text-align: right">
                                                @{{ (item.quo_de_price)-(item.quo_de_price*item.quo_de_discount/100)
                                                -item.quo_de_disamount| number:2}}
                                            </td>


                                        </tr>

                                        <tr>
                                            <td colspan="6" class="total-price">Subtotal:</td>
                                            <td>@{{ getTotal() | number:2}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="total-price">Tax(7%):</td>
                                            <td>@{{ getVat() | number:2}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="total-price">Total:</td>
                                            <td> @{{ getTotal()+getVat() | number:2}} บาท</td>
                                        </tr>

                                    </table>

                                    <span class="pull-right col-lg-1">
                                        <a href="#" ng-click="save()" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-credit-card "> ยืนยันการชำระเงิน </i></a>
                                    </span>

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
                    url: '/quotations/course-list?q=%QUERY',
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
                    url: '/quotations/customer-list?q=%QUERY',
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
                            suggestion: Handlebars.compile('<div>@{{cus_id}} - @{{cus_name}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        customer =
                        {
                            cus_id: datum.cus_id,
                            cus_name: datum.cus_name,
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
                                'ไม่พบพนักงาน',
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
                        course = {
                            course_id: datum.course_id,
                            quo_de_discount: 0,
                            quo_de_disamount: 0,
                            quo_de_price:datum.course_price,
                            course : datum
                        };
                        console.log(course);
                        angular.element(document.getElementById('course')).scope().pushProduct(course);

                    })

        });
    </script>
@stop
