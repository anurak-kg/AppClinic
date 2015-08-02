@extends('layout.master')
@section('title','ขายสินค้า')
@section('headText','ขายสินค้า')
@section('headDes','ออกใบขายสินค้า')
@section('content')
    <div ng-controller="SalesController" id="sales" ng-init="setVat({{config('shop.vat')}})">
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
                        เลขที่การสั่งซื้อ : <strong>{{$data->sales_id}}</strong> <br>
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
                                <li>รหัสลูกค้า | <span class="sale"><strong>@{{customer.cus_id}}</strong></span>.</li>
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                </li>
                                <li>ชื่อเบอร์โทร | <span
                                            class="customer"><strong>@{{ customer.tel }}</strong></span><br>
                                    <span><strong><a href="{{url('sales/removecustomer')}}">
                                                เปลียนลูกค้า</a></strong></span>

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
                        <h2 class="panel-title">สินค้า</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="div row">
                                    <div class="col-md-5">
                                        <input class="form-control typeahead input-lg productInput"
                                               type="search"
                                               id="product"
                                               ng-model="productSearchBox"
                                               placeholder="ระบุ ชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค้ด ">
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-app" href="{{url('product')}}">
                                            <i class="fa fa-plus-circle"></i> จัดการสินค้า
                                        </a>
                                    </div>

                                    <div class="col-md-1">
                                        <i ng-if="dataLoading" class="fa fa-spinner fa-spin loading"></i>

                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-bordered" ng-table="tableParams">
                                        <tr ng-repeat="item in product">
                                            <td style="width: 5px">
                                                <button class="btn btn-box-tool" data-widget="remove"
                                                        ng-click="deleteById(item.product_id)"><i
                                                            class="fa fa-times"></i>
                                                </button>

                                            </td>
                                            <td data-title="'#'" style="width: 10px">
                                                @{{$index+1}}
                                            </td>
                                            <td data-title="'สินค้า'">
                                                @{{item.product.product_name }}
                                            </td>
                                            <td data-title="'จำนวน'" style="width: 80px">
                                                <input type="number"
                                                       ng-model="item.sales_de_qty"
                                                       ng-change="update('sales_de_qty',item.product_id,item.sales_de_qty)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>

                                            <td data-title="'ราคา'" align="right" style="width: 100px">
                                                @{{item.product.product_price }}
                                            </td>
                                            <td data-title="'ส่วนลดเปอร์เซ็น'" style="width: 100px">
                                                <input type="number"
                                                       ng-model="item.sales_de_discount"
                                                       ng-change="update('sales_de_discount',item.product_id,item.sales_de_discount)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="'ส่วนลดจำนวนเงิน'" style="width: 100px">
                                                <input type="text"
                                                       ng-model="item.sales_de_disamount"
                                                       ng-change="update('sales_de_disamount',item.product_id,item.sales_de_disamount)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="'ราคารวม'" style="width:140px;text-align: center">
                                                @{{ (item.sales_de_qty*item.sales_de_price)-((item.sales_de_qty*item.sales_de_price)*item.sales_de_discount/100)-item.sales_de_disamount  | number:2}}
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="7" class="total-price">Subtotal:</td>
                                            <td>@{{ getTotal() | number:2}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="total-price">Tax(7%):</td>
                                            <td>@{{ getVat() | number:2}} บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="total-price">Total:</td>
                                            <td> @{{ getTotal()+getVat() | number:2}} บาท
                                            </td>
                                        </tr>

                                    </table>
                                    <div class="col-md-10">
                                        <a href="{{url('sales/save')}}" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-credit-card "> ชำระเงิน </i></a>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>


                </div>


                <!-- /.col -->

            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {

                var productDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/sales/productdata?q=%QUERY',
                        //url: '/quotations/course_query?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });
                var customerDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/data/customer_search?q=%QUERY',
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
                            angular.element(document.getElementById('sales')).scope().customerSelect(customer);

                        })
                productDb.initialize();
                $('.productInput').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            displayKey: 'product_name',
                            source: productDb.ttAdapter(),
                            templates: {
                                empty: [
                                    '<div class="empty-message">',
                                    'ไม่พบข้อมูลสินค้า',
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile('<div>@{{product_id}} – @{{product_name}}</div>')
                            }
                        })
                        .on('typeahead:selected', function ($e, datum) {
                            product = {
                                id: datum.product_id,
                                product_id: datum.product_id,
                                sales_de_price: datum.product_price,
                                sales_de_discount: 0,
                                sales_de_disamount: 0,
                                sales_de_qty: 1,
                                product: datum
                            }
                            console.log(product);
                            angular.element(document.getElementById('sales')).scope().pushProduct(product);

                        })

            });
        </script>
@stop
