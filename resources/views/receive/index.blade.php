@extends('layout.master')
@section('title','Receive : รับสินค้า')
@section('headText','Receive')
@section('headDes','รับสินค้า')

@section('content')
    <div ng-controller="receiveController" id="order">

        <div class="row">
            @if( Session::get('message') != null )
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4>Success!</h4>

                        <p>{{Session::get('message')}}.</p>
                    </div>
                </div>
            @endif
            <div class="col-md-5">
                <div class="panel  panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">รายละเอียด</h2>
                    </div>

                    <div class="panel-body">
                        เลขที่การสั่งซื้อ : <strong>{{$data->receive_id}}</strong> <br>
                        เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">อ้างอิง</h2>
                    </div>

                    <div class="panel-body">
                        <div class="vendorSearchBox">
                            <input class="form-control typeahead  order-input "
                                   type="search" value="{{$data->order_id}}"
                                   placeholder="รหัสการสั่งซื้อ">
                            <span class="warning">*ทำการกรอกเลขที่การสั่งซื้อ ข้อมูลสินค้าในตาราง จะถูกล้าง*</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title">Supplier</h2>
                    </div>

                    <div class="panel-body">
                        <div class="customerSearchBox" ng-hide="boxSearch"
                                >
                            <input class="form-control typeahead input-lg customer-input "
                                   type="search"
                                   placeholder="ระบุ ชื่อหรือรหัส Supplier">

                        </div>

                        <div class="customer" ng-show="boxSearch">
                            <ul>
                                <li>รหัสซัพพลายเออร์ | <span class="sale"><strong>@{{vendor.ven_id}}</strong></span>.
                                </li>
                                <li>ซัพพลายเออร์ | <span class="customer"><strong>@{{vendor.ven_name}}</strong></span>
                                </li>
                                <li>เบอร์โทร | <span
                                            class="customer"><strong>@{{ vendor.ven_sell_tel }}</strong></span><br>
                                    <span><strong><a href="{{url('receive/removecustomer')}}">
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
                                                                   id="exampleInputAmount">

                                                            <div class="input-group-addon">
                                                                / @{{ item.product.product_unit }}</div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>

                                            <td data-title="'ราคารวม'" style="width:140px;text-align: center">
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
                        url: '/receive/productdata?q=%QUERY',
                        //url: '/quotations/course_query?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });
                var orderDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/receive/ordersearch?q=%QUERY',
                        //url: '/quotations/course_query?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });

                var venderDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/data/vendor_search?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });

                venderDb.initialize();
                $('.customer-input').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            displayKey: 'ven_name',
                            source: venderDb.ttAdapter(),
                            templates: {
                                empty: [
                                    '<div class="empty-message">',
                                    'ไม่พบข้อมูลลูกค้า',
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile('<div>@{{ven_id}} - @{{ven_name}}</div>')
                            }
                        })
                        .on('typeahead:selected', function ($e, datum) {
                            //console.log(datum);
                            vendor = datum;
                            console.log(vendor);
                            angular.element(document.getElementById('order')).scope().customerSelect(vendor);

                        })
                orderDb.initialize();
                $('.order-input').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            displayKey: 'order_id',
                            source: orderDb.ttAdapter(),
                            templates: {
                                empty: [
                                    '<div class="empty-message">',
                                    'ไม่พบข้อมูลลูกค้า',
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile('<div>เลขที่การสั่งซื้อ @{{order_id}} - @{{order_date}}</div>')
                            }
                        })
                        .on('typeahead:selected', function ($e, datum) {
                            angular.element(document.getElementById('order')).scope().getOrderData(datum.order_id);

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
                                order_de_qty: 1,
                                product: datum
                            }

                            console.log(product);
                            angular.element(document.getElementById('order')).scope().pushProduct(product);

                        })

            });
        </script>

@stop
