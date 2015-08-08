@extends('layout.master')
@section('title','การสั่งซื้อสินค้า')
@section('headText','สั่งซื้อสินค้า')

@section('content')
    <div ng-controller="orderController" id="order" ng-init="setVat({{config('shop.vat')}})">
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
                        <h2 class="panel-title"><i class="fa fa-info"></i> รายละเอียด</h2>
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
                        <h2 class="panel-title"><i class="fa fa-truck"></i> Supplier</h2>
                    </div>
                    <div class="panel-body">
                        <div class="vendorSearchBox" ng-hide="boxSearch"
                                >
                            <input class="form-control typeahead input-lg vendor-input "
                                   type="search"
                                   placeholder="ระบุ ชื่อร้าน หรือ รหัสร้าน">
                        </div>
                        <div class="vendor" ng-show="boxSearch">
                            <ul>
                                <li>รหัส | <span class="vendor"><strong>@{{vendor.ven_id}}</strong></span>.</li>
                                <li>ชื่อร้าน | <span class="vendor"><strong>@{{vendor.ven_name}}</strong></span>
                                <li>ชื่อ | <span class="vendor"><strong>@{{vendor.ven_sell_name}}</strong></span>
                                </li>
                                <li>เบอร์โทร | <span
                                            class="vendor"><strong>@{{ vendor.ven_sell_tel }}</strong></span><br>
                                    <span><strong><a href="{{url('order/removevendor')}}">
                                                เปลี่ยน Supplier</a></strong></span>
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
                        <h2 class="panel-title"><i class="fa fa-medkit"></i> สินค้า</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="div row">
                                    <div class="col-md-5">
                                        <input class="form-control typeahead input-lg productInput"
                                               type="search"
                                               id="product"
                                               ng-model="productSearchBox"
                                               placeholder="ระบุ ชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค้ด ">
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-app" href="{{url('product/index')}}">
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
                                                       ng-change="update('order_de_qty',item.product.product_id,item.order_de_qty)"
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
                                            <td>@{{ getTotal() | number:2}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">Tax(7%):</td>
                                            <td>@{{ getVat() | number:2}} บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">Total:</td>
                                            <td> @{{ getTotal()+getVat() | number:2}} บาท
                                            </td>
                                        </tr>

                                    </table>
                                    <span class="pull-right col-lg-1">
                                        <a ng-click="save()" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-mail-forward "> ออกใบสั่งสินค้า </i></a>
                                    </span>

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
                var vendorDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/data/vendor_search?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });
                var empDb = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '/data/user_search?q=%QUERY',
                        wildcard: '%QUERY'
                    }
                });

                vendorDb.initialize();
                $('.vendor-input').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            displayKey: 'ven_name',
                            source: vendorDb.ttAdapter(),
                            templates: {
                                empty: [
                                    '<div class="empty-message">',
                                    'ไม่พบข้อมูล',
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile('<div>@{{ven_id}} - @{{ven_name}} - @{{ven_sell_name}} @{{ven_sell_tel}}</div>')
                            }
                        })
                        .on('typeahead:selected', function ($e, datum) {
                            //console.log(datum);
                            vendor = datum;
                            console.log(vendor);
                            angular.element(document.getElementById('order')).scope().vendorSelect(vendor);

                        })
                empDb.initialize();
                $('.emp-input').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            displayKey: 'name',
                            source: empDb.ttAdapter(),
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
                            emp =
                            {
                                id: datum.id,
                                name: datum.name,
                            }
                            console.log(emp);
                            angular.element(document.getElementById('order')).scope().empSelect(emp);

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
                                product_id: datum.product_id,
                                order_de_qty: 1,
                                order_de_price: 0,
                                product: datum
                            }

                            console.log(product);
                            angular.element(document.getElementById('order')).scope().pushProduct(product);

                        })

            });
        </script>
@stop
