@extends('layout.master')
@section('title','สินค้า')


@section('content')

    {{--<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading with-border">
                            <h2 class="panel-title">คืนสินค้า</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
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
                                                           ng-model="item.receive_de_qty_return"
                                                           ng-change="update('receive_de_qty_return',item.product_id,item.receive_de_qty_return)"
                                                           ng-model-options="{debounce: 750}"
                                                           class="form-control">
                                                </td>
                                                <td data-title="'ราคาทุน'" style="width:180px;text-align: right">
                                                    <div class="input-group">
                                                        @{{item.receive_de_price }}
                                                        <div class="input-group-addon">
                                                            / @{{ item.product.product_unit }}</div>
                                                    </div>
                                                </td>

                                                <td data-title="'ราคารวม'" style="width:140px;text-align: center">
                                                    @{{ item.receive_de_qty_return*item.receive_de_price  | number}}
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-md-6">
                                            </div>
                                        <div class="col-md-6">
                                        <td colspan="5" class="total-price">เหตุผลที่คืน</td>
                                            <input type="text"
                                                   ng-model="item.receive_comment"
                                                   ng-change="update('receive_comment',item.receive_comment)"
                                                   ng-model-options="{debounce: 750}"
                                                   class="form-control">
                                        </td>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
@stop
