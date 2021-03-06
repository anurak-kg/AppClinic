@extends('layout.master')
@section('title','ขายสินค้า')
@section('headText','ขายสินค้า')
@section('content')
    <div ng-controller="salesController" id="sales" ng-init="init('{{$data->vat}}',{{$data->vat_rate}})">
        <script type="text/ng-template" id="payment.html">
            <div class="modal-header">
                <h3 class="modal-title">ชำระเงิน</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <label for="total">ประเภทการชำระ</label>
                            <select class="form-control" disabled ng-model="paymentType">
                                <option value="cash" selected>เงินสด</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="total">ยอดที่ต้องชำระ</label>
                            <input name="total" ng-model="finalPrice"
                                   class="form-control input-lg"
                                   type="number" id="total"
                                   value="@{{ getFinalPrice() }}"
                                   disabled/>
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
                            <button class="btn" ng-click="cashAdd(1)">+1</button>
                        </div>
                        <div class="col-md-12">
                            <label for="withdrawn">เงินทอน</label>
                            <input name="withdrawn"
                                   class="form-control input-lg"
                                   type="number" id="withdrawn"
                                   value="@{{getFinalPrice() - cashInput}}"
                                   disabled
                                    /></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button class="btn btn-success" ng-click="payment()">ชำระเงิน</button>--}}
                <button class="btn btn-success"
                        ng-disabled="cashInput<finalPrice"
                        ng-click="paymentAndPrint({{$data->sales_id}})">ชำระเงิน
                    พร้อมปลิ้นบิล
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
                <div class="panel  panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title"><i class="fa fa-info"></i> รายละเอียด</h2>
                    </div>
                    <div class="panel-body">
                        เลขที่การขายสินค้า : <strong>{{$data->sales_id}}</strong> <br>
                        เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                        สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                        พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading with-border">
                        <h2 class="panel-title"><i class="fa fa-users"></i> ข้อมูลลูกค้า</h2>
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
                        <h2 class="panel-title"><i class="fa fa-medkit"></i> สินค้า</h2>
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
                                                @{{(item.sales_de_price -((item.sales_de_price*item.sales_de_discount/100 )+stringToInt(item.sales_de_disamount))) * item.sales_de_qty | number:2}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="total-price">ยอดรวม:</td>
                                            <td>@{{ getTotal() | number:2}} บาท</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="total-price">ส่วนลด:</td>
                                            <td>@{{ getDiscount() | number:2}} บาท</td>
                                        </tr>
                                        @if($data->vat== "true")
                                            <tr>
                                                <td colspan="8" class="total-price">ภาษี ({{$data->vat_rate}}%):</td>
                                                <td>@{{ getVat() | number:2}} บาท
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="8" class="total-price">ยอดสุทธิ:</td>
                                            <td> @{{ getFinalPrice() | number:2}} บาท</td>
                                        </tr>
                                    </table>
                                        <span class="pull-right col-lg-1">
                                        <a ng-click="open()" class="btn btn-md btn-success pull-right"><i
                                                    class="fa fa-credit-card "> ชำระเงิน </i></a>
                                            </span>
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
