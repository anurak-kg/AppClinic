@extends('layout.master')
@section('title','การสั่งซื้อสินค้า')
@section('headText','สั่งซื้อสินค้า')
@section('headDes','ออกใบสั่งซื้อสินค้า')

@section('content')
    <div ng-controller="orderController" id="order">

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
                        เลขที่การสั่งซื้อ : <strong>{{$data->order_id}}</strong> <br>
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
                                    <span><strong><a href="{{url('order/remove_customer')}}">
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
                                                       ng-model="item.order_de_qty"
                                                       ng-change="update('order_de_qty',item.product_id,item.order_de_qty)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="'ราคาทุน'" style="width:180px">
                                                <form class="form-inline">
                                                    <div class="form-group">
                                                        <label class="sr-only" for="exampleInputAmount"></label>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   ng-model="item.order_de_price"
                                                                   ng-change="update('order_de_price',item.product.product_id,item.order_de_price)"
                                                                   ng-model-options="{debounce: 750}"
                                                                   class="form-control"
                                                                   id="exampleInputAmount" >
                                                            <div class="input-group-addon">/ @{{ item.product.product_unit }}</div>
                                                        </div>
                                                    </div>
                                                </form>                                            </td>

                                            <td data-title="'ราคารวม'"  style="width:140px;text-align: center">
                                                @{{ item.order_de_qty*item.order_de_price  | number}}
                                            </td>


                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">Subtotal:</td>
                                            <td>@{{ getTotal() | number}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">Tax(7%):</td>
                                            <td>0 บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">Total:</td>
                                            <td> @{{ getTotal() | number}} บาท
                                            </td>
                                        </tr>

                                    </table>
                                    <div class="col-md-10">
                                        <a href="{{url('order/save')}}" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-credit-card "> ออกใบสั่งสินค้า </i></a>
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
                        url: '/order/productdata?q=%QUERY',
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
                            angular.element(document.getElementById('order')).scope().customerSelect(customer);

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
                                id : datum.product_id,
                                order_de_qty :1,
                                product: datum }

                            console.log(product);
                            angular.element(document.getElementById('order')).scope().pushProduct(product);

                        })

            });
        </script>

@stop
