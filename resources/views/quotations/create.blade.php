@extends('layout.master')
@section('title','Point of Sale')
@section('headText','Point of Sale')
@section('content')
    <div ng-controller="quotationsController" id="course"
         ng-init="init({{config('shop.vat')}},{{$quo->quo_id}},'{{$quo->vat}}')">
        <div class="row">
            @if( Session::get('message') != null )
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4>{{trans("pointofsale.success")}}</h4>
                        <p>{{Session::get('message')}}.</p>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-info"></i>

                        <h2 class="box-title">{{trans("pointofsale.detail")}}</h2>
                    </div>
                    <div class="box-body">
                        {{trans("pointofsale.number_of_sale")}} : <strong>{{$quo->quo_id}}</strong> <br>
                        {{trans("pointofsale.date")}}  : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        {{trans("pointofsale.branch")}}  : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        {{trans("pointofsale.employee")}}  : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>

                </div>
            </div>

            <div class="col-md-5">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>

                        <h2 class="box-title"> {{trans("pointofsale.customer_detail")}}</h2>
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
                                <li>รหัสลูกค้า | <span class="sale"><strong>@{{customer.cus_id}}</strong></span><br>
                                </li>
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.cus_name}}</strong></span>
                                    วันเดือนปีเกิด | <span class="customer"><strong>@{{customer.day}}
                                            /@{{customer.month}}/@{{customer.year}} </strong></span>
                                </li>
                                <li>ส่วนสูง | <span class="sale"><strong>@{{customer.height}}</strong></span>
                                    น้ำหนัก | <span class="sale"><strong>@{{customer.weight}}</strong></span>
                                    โรคประจำตัว | <span class="sale"><strong>@{{customer.allergic}}</strong></span>
                                    แพ้ยา | <span class="sale"><strong>@{{customer.disease}}</strong></span></li>
                                <li>มือถือ | <span class="customer"><strong>@{{ customer.tel }}</strong></span>
                                    เบอร์โทร | <span class="customer"><strong>@{{ customer.phone }}</strong></span>
                                    E-mail | <span class="customer"><strong>@{{ customer.email }}</strong></span>
                                    <br></li>
                                <li><span><strong><a href="{{url('quotations/removecustomer')}}">
                                                เปลียนลูกค้า</a></strong></span>

                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-user"></i>

                        <h2 class="box-title"> {{trans("pointofsale.sale_and_doctor")}} </h2>                  </div>

                    <div class="box-body">
                        <div class="saleSearchBox" ng-hide="SaleBoxSearch"
                                >
                            <input class="form-control typeahead input-lg sale-input "
                                   type="search"
                                   placeholder="ชื่อพนักงาน หรือ รหัสพนักงาน">
                        </div>

                        <div class="sale" ng-show="SaleBoxSearch">
                            <ul>
                                <li>{{trans("pointofsale.emp_id")}} | <span class="sale"><strong>@{{sale.id}}</strong></span>.</li>
                                <li>ชื่อลูกค้า | <span class="sale"><strong>@{{sale.name}}</strong></span>.
                                </li>
                                <li>{{trans("pointofsale.total")}} | <span class="sale"><strong>@{{getTotal()}}</strong> บาท</span>.</li>
                                <li>{{trans("pointofsale.commission")}} | <span class="sale"><strong>@{{getCommission()}}</strong> บาท</span>.</li>
                                <li><strong><a href="{{url('quotations/removesale')}}">
                                            {{trans("pointofsale.change_customer")}}</a></strong></li>

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

                        <h2 class="box-title">Sale items</h2>
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
                                            <i class="fa fa-plus-circle"></i>  {{trans("pointofsale.course_management")}}
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
                                                        ng-click="deleteById(item.quo_de_id)"><i
                                                            class="fa fa-times"></i>
                                                </button>

                                            </td>
                                            <td data-title="'#'" style="width: 10px">
                                                @{{$index+1}}
                                            </td>

                                            <td data-title="'{{trans("pointofsale.item")}}'" style="width:380px">
                                                <strong>@{{item.name}}</strong><br>
                                                @{{item.course_detail}}

                                            </td>
                                            <td data-title="' {{trans("pointofsale.price")}}'" style="width:100px;text-align: right">
                                                @{{item.price | number:2 }}
                                            </td>
                                            <td data-title="'{{trans("pointofsale.quantity")}}'" style="width: 80px">
                                                <input type="number" class="form-control" value="1" disabled  ng-show="item.type == 'course'">

                                                <input type="number"  ng-show="item.type == 'product'"
                                                       ng-model="item.product_qty"
                                                       ng-change="update('product_qty',item.quo_de_id,item.product_qty)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>

                                            <td data-title="' {{trans("pointofsale.percent_discount")}}'" style="width: 80px">
                                                <input type="number"
                                                       ng-model="item.quo_de_discount"
                                                       ng-change="update('quo_de_discount',item.quo_de_id,item.quo_de_discount)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="' {{trans("pointofsale.discount")}}'" style="width: 80px">
                                                <div class="input-group">
                                                    <input type="text"
                                                           ng-model="item.quo_de_disamount"
                                                           ng-change="update('quo_de_disamount',item.course_id,item.quo_de_disamount)"
                                                           ng-model-options="{debounce: 750}"
                                                           class="form-control">
                                                </div>
                                            </td>
                                            <td data-title="' {{trans("pointofsale.total")}}'"
                                                style="width:170px;text-align: right">
                                                @{{ ((item.quo_de_price)-(item.quo_de_price*item.quo_de_discount/100)
                                                -item.quo_de_disamount) * item.product_qty| number:2}}
                                            </td>


                                        </tr>

                                        <tr>
                                            <td colspan="7" class="total-price"> {{trans("pointofsale.sub_total")}} : </td>
                                            <td>@{{ getTotal() | number:2}} {{trans("general.currency")}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="total-price"> {{trans("pointofsale.discount")}} : </td>
                                            <td>@{{ getDiscount() | number:2}} {{trans("general.currency")}}</td>
                                        </tr>
                                        @if($quo->vat == 'true')
                                            <tr>
                                                <td colspan="7" class="total-price"> {{trans("pointofsale.vat")}} {{getConfig('vat_rate')}}% :
                                                </td>
                                                <td>@{{ getVat() | number:2}} </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="7" class="total-price"> {{trans("pointofsale.total")}}:</td>
                                            <td><strong>@{{ getFinalTotal() | number:2}}</strong> {{trans("general.currency")}}</td>
                                        </tr>

                                    </table>

                                    <span class="pull-right col-lg-1">
                                        <a href="#" ng-click="save()" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-credit-card "> {{trans("pointofsale.confirm_and_payment")}} </i></a>
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
            var productDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/data/product_search?q=%QUERY',
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
                                ' {{trans("pointofsale.not_found_customer")}}',
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
                                ' {{trans("pointofsale.not_found_emp")}}',
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
                        name: 'product',
                        displayKey: 'product_name',
                        source: productDb.ttAdapter(),
                        templates: {
                            header: '<h4 class="league-name">{{trans("pointofsale.item_product")}}</h4>',
                            empty: [
                                '<div class="empty-message">',
                                '{{trans("pointofsale.not_found_product")}}',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{product_id}} - @{{product_name}}</div>')
                        }
                    },
                    {
                        name: 'course',
                        displayKey: 'course_name',
                        source: courseDb.ttAdapter(),
                        templates: {
                            header: '<h4 class="league-name">{{trans("pointofsale.item_course")}}</h4>',
                            empty: [
                                '<div class="empty-message">',
                                '{{trans("pointofsale.not_found_course")}}',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{course_id}} – @{{course_name}}</div>')
                        }
                    }
            ).on('typeahead:selected', function ($e, datum) {
                        var data = [];
                        if (datum.course_id != null) {
                            data.id = datum.course_id;
                            data.type = "course";

                        } else if (datum.product_id != null) {
                            data.id = datum.product_id;
                            data.type = "product";
                        }
                        angular.element(document.getElementById('course')).scope().pushCourse(data);

                    })

        });
    </script>
@stop
