@extends('layout.master')
@section('title','คืนสินค้า')
@section('headText','คืนสินค้า')

@section('content')

    <div ng-controller="returntostockController" id="return" >
        <form method="POST" action="{{url('returntostock/save')}}" ng-submit="save($event)">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

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

                            <h2 class="panel-title"><i class="fa fa-info-circle"></i> รายละเอียด</h2>
                        </div>
                        <div class="panel-body">
                            เลขที่การคืนสินค้า : <strong>{{$data->return_id}}</strong> <br>
                            เวลา : <strong>{{Jenssegers\Date\Date::now()->format('l j F Y H:i:s')}}</strong><br>
                            สาขา : <strong>{{\App\Branch::getCurrentName()}}</strong> <br>
                            พนักงาน : <strong>{{Auth::user()->name}}</strong> <br>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-success">
                        <div class="box-header with-border">
                            <h2 class="box-title"><i class="fa fa-exchange"></i> คลังสินค้า</h2>
                        </div>
                        <div class="box-body">
                            <select class="form-control input-lg" ng-model="warehouse.id" ng-change="warehouseChange()">
                                @foreach($warehouse as $item)
                                    <option value="{{$item->branch_id}}">{{$item->branch_id}} - {{$item->branch_name}}</option>
                                @endforeach
                            </select>
                            <p ng-show="warehouse.id == 0" style="color: red;font-weight: bolder;text-align: center">กรุณาเลือกคลังสินค้าที่ต้องการเบิกก่อนคะ</p>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row" ng-hide="warehouse.id == 0">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading with-border">
                            <h2 class="panel-title"><i class="fa fa-mail-reply"></i> รายการสินค้า</h2>
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
                                    <div class="div row">
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

                                                <td data-title="'จำนวนที่คืน'" style="width: 80px">
                                                    <input type="number"
                                                           ng-model="item.return_de_qty"
                                                           ng-change="update('return_de_qty',item.product_id,item.return_de_qty)"
                                                           ng-model-options="{debounce: 750}"
                                                           class="form-control">
                                                </td>
                                                <td data-title="'เหตุผลที่คืน'">
                                                    <input type="text"
                                                           ng-model="item.return_de_text"
                                                           ng-change="update('return_de_text',item.product_id,item.return_de_text)"
                                                           ng-model-options="{debounce: 750}"
                                                           class="form-control">
                                                </td>
                                                <td data-title="'ราคาทุน'">
                                                    @{{item.return_de_price }}/ @{{ item.product.product_unit }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="total-price">Total:</td>
                                                <td> @{{ getTotal() | number:2}} บาท
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-md-10">
                                            <a href="{{url('return/save')}}"
                                               class="btn btn-md btn-success pull-right"><i
                                                        class="fa fa-credit-card "> คืนสินค้า </i></a>
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
                            url: '/return/productdata?q=%QUERY',
                            //url: '/quotations/course_query?q=%QUERY',
                            wildcard: '%QUERY'
                        }
                    });
                    var receiveDb = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        remote: {
                            url: '/return/receivesearch?q=%QUERY',
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
                                        'ไม่พบข้อมูล',
                                        '</div>'
                                    ].join('\n'),
                                    suggestion: Handlebars.compile('<div>@{{ven_id}} - @{{ven_name}}</div>')
                                }
                            })
                            .on('typeahead:selected', function ($e, datum) {
                                //console.log(datum);
                                vendor = datum;
                                console.log(vendor);
                                angular.element(document.getElementById('receive')).scope().customerSelect(vendor);

                            })
                    receiveDb.initialize();
                    $('.receive-input').typeahead({
                                hint: true,
                                highlight: true,
                                minLength: 1
                            },
                            {
                                displayKey: 'receive_id',
                                source: receiveDb.ttAdapter(),
                                templates: {
                                    empty: [
                                        '<div class="empty-message">',
                                        'ไม่พบข้อมูล',
                                        '</div>'
                                    ].join('\n'),
                                    suggestion: Handlebars.compile('<div>เลขที่การรับสินค้า @{{receive_id}} - @{{receive_date}}</div>')
                                }
                            })
                            .on('typeahead:selected', function ($e, datum) {
                                angular.element(document.getElementById('return')).scope().getReceiveData(datum.return_id);

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
                                    return_de_qty: 1,
                                    product: datum
                                }

                                console.log(product);
                                angular.element(document.getElementById('return')).scope().pushProduct(product);

                            })

                });
            </script>

@stop
