@extends('layout.master')
@section('title','สั่งซื้อสินค้า - คลังสินค้า')
@section('headDes','คลังสินค้า')
@section('headText','สั่งซื้อสินค้า')

@section('content')
    <div ng-controller="orderController" id="order"
         ng-init="init('{{$data->vat}}',{{$data->vat_rate}},{{$data->order_id}})">

        @if( Session::get('message') != null )
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4>Success!</h4>

                    <p>{{Session::get('message')}}.</p>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-md-4">
                <div class="panel  panel-default">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title"><i class="fa fa-info-circle"></i> รายละเอียด</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table tablesorter table-bordered table-striped table-hover">
                            <tr>
                                <td> เลขที่การสั่งซื้อ :</td>
                                <td><strong>{{$data->order_id}}</strong></td>
                            </tr>
                            <tr>
                                <td> วัน/เวลา :</td>
                                <td><strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong></td>
                            </tr>
                            <tr>
                                <td>สาขา :</td>
                                <td><strong>{{\App\Branch::getCurrentName()}}</strong></td>
                            </tr>
                            <tr>
                                <td>พนักงาน :</td>
                                <td><strong>{{Auth::user()->name}}</strong></td>
                            </tr>
                            <tr>
                                <td>
                                    ภาษี :
                                </td>
                                <td>
                                    <input type="checkbox"
                                           ng-model="vat_enable"
                                           ng-change="vatChange()">
                                </td>
                            </tr>
                        </table>


                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" align="right">
                                <div class="col-md-12">
                                    <a href="{{url('order')}}" class="btn btn-dropbox "><b>สั่งซื้อสินค้า</b></a>
                                    <a href="{{url('receive')}}" class="btn btn-instagram "><b>รับสินค้าเข้าคลัง</b></a>
                                    <a href="{{url('return')}}" class="btn btn-instagram "><b>คืนสินค้า</b></a>
                                    <a href="{{url('product/stock')}}" class="btn btn-instagram "><b>สินค้าคงคลัง</b></a>
                                    <a href="{{url('product/expday')}}" class="btn btn-instagram "><b>สินค้าใกล้หมดอายุ</b></a>
                                    <a href="{{url('request/history')}}" class="btn btn-instagram "><b>รายการเบิกสินค้า</b></a>
                                    <a href="{{url('product/delivery')}}" class="btn btn-instagram "><b>รายการส่งสินค้า</b></a>
                                    <a href="{{url('order/history')}}" class="btn btn-instagram "><b>รายการสั่งซื้อ</b></a>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel  panel-default">
                                    <div class="panel-heading with-border">
                                        <h2 class="panel-title"><i class="fa fa-exchange"></i> คลังสินค้า</h2>
                                    </div>
                                    <div class="panel-body">
                                        <select class="form-control input-lg" ng-model="warehouse.id"
                                                ng-change="warehouseChange()">
                                            @foreach($warehouse as $item)
                                                <option value="{{$item->branch_id}}">{{$item->branch_id}}
                                                    - {{$item->branch_name}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <p ng-show="warehouse.id == 0"
                                           style="color: red;font-weight: bolder;text-align: center">
                                            กรุณาเลือกคลังสินค้าที่ต้องการสั่ง</p>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel  panel-default">
                                    <div class="panel-heading with-border">
                                        <h2 class="panel-title"><i class="fa fa-user"></i> พนักงาน</h2>
                                    </div>
                                    <div class="panel-body">

                                        <input class="form-control typeahead input-md "
                                               value="{{Auth::user()->name}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel  panel-default">
                                    <div class="panel-heading with-border">
                                        <h2 class="panel-title"><i class="fa fa-truck"></i> Supplier</h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="search">
                                            <div class="vendorSearchBox" ng-hide="boxSearch">

                                                <input class="form-control typeahead input-md vendor-input "
                                                       type="search"
                                                       placeholder="ระบุ ชื่อร้าน หรือ รหัสร้าน">
                                            </div>
                                        </div>
                                        <div class="vendor" ng-show="boxSearch">
                                            <ul>
                                                <li>รหัส | <span
                                                            class="vendor"><strong>@{{vendor.ven_id}}</strong></span>.
                                                </li>
                                                <li>ชื่อร้าน | <span
                                                            class="vendor"><strong>@{{vendor.ven_name}}</strong></span>
                                                <li>ชื่อ | <span
                                                            class="vendor"><strong>@{{vendor.ven_sell_name}}</strong></span>
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
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading with-border">
                        <h2 class="panel-title"><i class="fa fa-th"></i> รายการสินค้า</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="div row">
                                    <div class="col-md-5">
                                        <input class="form-control typeahead input-md productInput"
                                               type="search"
                                               id="product"
                                               ng-model="productSearchBox"
                                               placeholder="ระบุ ชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค้ด ">
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-bitbucket" href="{{url('product/index')}}">
                                            <i class="fa fa-plus-circle"></i> จัดการสินค้า
                                        </a>
                                    </div>

                                    <div class="col-md-1">
                                        <i ng-if="dataLoading" class="fa fa-spinner fa-spin loading"></i>

                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <table class="table tablesorter table-bordered table-striped table-hover"
                                           ng-table="tableParams">
                                        <thead>

                                        <th></th>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 50%">สินค้า</th>
                                        <th style="width: 10%">จำนวน</th>
                                        <th style="width: 10%">ราคาทุน</th>
                                        <th style="width: 30%">ราคารวม</th>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in product">
                                            <td style="width: 5px">
                                                <button class="btn btn-box-tool" data-widget="remove"
                                                        ng-click="deleteById(item.product_id)"><i
                                                            class="fa fa-times"></i>
                                                </button>

                                            </td>
                                            <td data-title="'#'">
                                                @{{$index+1}}
                                            </td>
                                            <td>
                                                <a href="#product_name"> @{{item.product.product_name }}</a>
                                            </td>
                                            <td data-title="'จำนวน'">
                                                <input type="number"
                                                       ng-model="item.order_de_qty"
                                                       ng-change="update('order_de_qty',item.product.product_id,item.order_de_qty)"
                                                       ng-model-options="{debounce: 750}"
                                                       class="form-control">
                                            </td>
                                            <td data-title="'ราคาทุน'">
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
                                            <td colspan="5" class="total-price">ยอดรวม:</td>
                                            <td>@{{ getTotal() | number:2}} บาท</td>
                                        </tr>
                                        {{--<tr>--}}
                                        {{--<td colspan="5" class="total-price">ส่วนลด:</td>--}}
                                        {{--<td>0 บาท</td>--}}
                                        {{--</tr>--}}
                                        <tr ng-show="vat_enable">
                                            <td colspan="5" class="total-price">ภาษี ( {{$data->vat_rate}}%):</td>
                                            <td>@{{ getVat() | number:2}} บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price">ยอดสุทธิ:</td>
                                            <td> @{{ getFinalTotal() | number:2}} บาท
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="total-price"></td>
                                            <td><a ng-click="save({{$data->order_id}})"
                                                   class="btn btn-md btn-bitbucket btn-block pull-right">
                                                    ออกใบสั่งสินค้า</a></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
