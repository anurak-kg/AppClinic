@extends('layout.master')
@section('title','การรักษา')
@section('headText','Treatment')
@section('headDes','เข้ารับการรักษา')

@section('content')
    <script>


    </script>
    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>


    <div class="row" ng-controller="treatmentAddController">
        <form class="form-horizontal" method="POST" action="{{url('treatment/save')}}" ng-submit="save($event)">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <div class="col-md-12" ng-init="init('{{$course_id}}',{{getConfig('product_out_stock_can_treat')}},'{{$quo->payment_remain}}')">
                <div class="col-md-6">
                    <div class="box  box-default">
                        <div class="box-header with-border" align="center">
                            <h2 class="box-title">การรักษา</h2>
                        </div>


                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <label for="cus_name" class=" required">ลูกค้า</label>
                                    <input class=" form-control" type="text"
                                           value="{{$quo->quotations->customer->cus_id}} : {{$quo->quotations->customer->cus_name}}"
                                           disabled>
                                    <br>
                                </div>
                                <div class="col-md-12">
                            <span id="div_cus_name">
                                <label class=" required">คอร์ส</label>
                                <input class=" form-control" type="text" value="{{$quo->course->course_name}}" disabled>
                            </span>
                                    <br>
                                </div>
                                <div class="col-md-6">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">หมอ</label>
                                    <select class=" form-control dr" name="doctor" ng-model="dr">
                                        <option value="" style='display:none;'>เลือกหมอ...</option>
                                        @foreach($doctor as $dr)
                                            <option value="{{$dr->id}}">{{$dr->id}}
                                                : {{$dr->name}}</option>
                                        @endforeach
                                    </select>
                            </span><br>
                                </div>

                                <div class="col-md-6">
                            <span>
                                <label class=" required" for="dr_price">ค่ามือหมอ</label>
                                <input class=" form-control" type="number" value="0" name="dr_price" id="dr_price">
                            </span>
                                    <br>
                                </div>

                                <div class="col-md-6">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">ผู้ช่วย 1</label>
                            <select class=" form-control dr" name="bt1" ng-model="bt1">
                                <option value="" style='display:none;'>เลือกผู้ช่วย...</option>
                                <option value="">ไม่มี</option>

                                @foreach($users as $user)
                                    @if($user->name != $dr->name)
                                        <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </span><br>
                                </div>

                                <div class="col-md-6">
                              <span>
                                <label class=" required" for="bt1_price">ค่ามือผู้ช่วย 1</label>
                                <input class=" form-control" type="number" value="0" name="bt1_price" id="bt1_price">
                            </span>
                                    <br>
                                </div>

                                <div class="col-md-6">
                                    <label for="cus_name" class=" required">ผู้ช่วย 2</label>
                                    <select class=" form-control dr" name="bt2" ng-model="bt2">
                                        <option value="" style='display:none;'>เลือกผู้ช่วย...</option>
                                        <option value="">ไม่มี</option>
                                        @foreach($users as $user)
                                            @if($user->name != $dr->name)
                                                <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select><br>
                                </div>
                                <div class="col-md-6">
                              <span>
                                <label class=" required" for="bt2_price">ค่ามือผู้ช่วย 2</label>
                                <input class=" form-control" type="number" value="0" name="bt2_price" id="bt2_price">
                            </span>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <label class=" required">วันที่เข้ารับการรักษา</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="treat_date" name="treat_date"
                                               value="{{date("Y-m-d")}}">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box  box-default">
                                <div class="box-header with-border" align="center">
                                    <h2 class="box-title">รายละเอียดการใช้ยา</h2>

                                    <div class="box-tools pull-right">
                                        <a href="{{url('/treatment')}}"
                                           class="btn btn-default">กลับไปที่ข้อมูลการรักษา</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <label>ตัวยาที่ใช้</label>
                                        <table class="table table-bordered" ng-table="tableParams">
                                            <tr>
                                                <th style="width: 20px">#</th>
                                                <th>ตัวยา</th>
                                                <th style="width: 60px">จำนวน</th>
                                                <th style="width: 60px">ยาในสต้อก</th>

                                                <th style="width: 120px">จำนวนที่ใช้</th>

                                            </tr>
                                            <tr ng-repeat="item in course_medicine">
                                                <td style="font-weight: bolder;text-align: center">
                                                    @{{ $index+1 }} <br> <a href="#"
                                                                            ng-click="deleteById(item.p_id)">ลบ</a>

                                                </td>
                                                <td>
                                                    @{{ item.p_id }} :
                                                    @{{ item.product_name }}
                                                </td>
                                                <td>
                                                    <span ng-show="item.qty ==null">-</span>
                                                    <span ng-show="item.qty !=null">@{{ item.qty }}</span>


                                                </td>
                                                <td>
                                                    <label class="badge badge-info alert-danger"
                                                           ng-show="item.remain == null">0</label>
                                                    <label class="badge badge-info alert-danger"
                                                           ng-show="item.remain < item.qty">@{{item.remain}}</label>
                                                    <label class="badge"
                                                           ng-show="item.remain >= item.qty">@{{item.remain}}</label>
                                                    <label class="badge"
                                                           ng-show="item.remain != null && item.qty == null">@{{item.remain}}</label>


                                                </td>
                                                <td>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="number" required
                                                               ng-model="course_medicine[$index].qty"
                                                               name="qty[@{{item.p_id}}]"
                                                               value="@{{item.qty}}"> @{{item.product_unit}}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="col-md-10">
                                            <label class=" required">ตัวยา</label>

                                            <ui-select style="width: 100%;"
                                                       sortable="true"
                                                       theme="select2"
                                                       ng-model="medicine.selected"
                                                       title="Choose a person">
                                                <ui-select-match
                                                        placeholder="เลือกหรือค้นหายาจากรายการ...">@{{$select.selected.product_name}}</ui-select-match>
                                                <ui-select-choices anchor='bottom'
                                                                   repeat="item in product | filter: $select.search">
                                                    <span ng-bind-html=" item.p_id | highlight: $select.search"></span>
                                                    :
                                                    <span ng-bind-html=" item.product_name | highlight: $select.search"></span>
                                                    - ต่อ <span style="font-weight: bolder"
                                                                ng-bind-html=" item.product_unit"></span>

                                                </ui-select-choices>

                                            </ui-select>
                                            <br>

                                        </div>
                                        <div class="col-md-1">

                                            <div class="form-group">
                                                <label class=" required">   </label>

                                                <a class="btn btn-default" ng-click="addMedicine()">เพิ่มตัวยา</a>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <input ng-value="jsonData" type="hidden" name="json">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>บันทึก หรือ ความคิดเห็นเพิ่มเติม</label>
                                <textarea class="form-control" rows="3" placeholder="ระบุรายละเอียด ..."
                                          name="comment"></textarea>
                                        <input type="hidden" name="course_id" value="{{Input::get('course_id')}}">
                                        <input type="hidden" name="quo_id" value="{{Input::get('quo_id')}}">
                                        <input type="hidden" name="quo_de_id" value="{{$quo->quo_de_id}}">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="box  box-danger">
                                <div class="box-header with-border" align="center">
                                    <h2 class="box-title">การชำระเงิน</h2>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>สถานะการชำระเงิน</td>
                                            <td>
                                                @if($quo->payment == null)
                                                    <span>ไม่พบข้อมูลการชำระเงิน</span>
                                                @elseif($quo->payment->payment_status=='FULLY_PAID')
                                                    <span class="label label-success">จ่ายเงินครบแล้ว</span>
                                                @else
                                                    <span class="label label-warning">ค้างจ่าย</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ประเภทการชำระ</td>
                                            <td>
                                                @if($quo->payment->payment_status=='REMAIN')
                                                    <span>ผ่อนจ่าย</span>
                                                @elseif($quo->payment->payment_status=='FULLY_PAID')
                                                    <span>จ่ายเต็มจำนวน</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ยอดค้างชำระ</td>
                                            <td>{{$quo->payment_remain}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="box-footer">
                                    <div ng-show="product_out_stock_can_treat == false && outOfStock()">
                                        <button type="submit" class="btn btn-danger" style="width: 100%" disabled>
                                            ยาในสต้อกไม่พอ ไม่สามารถบันทึกได้
                                        </button>
                                    </div>
                                    <div ng-hide="product_out_stock_can_treat == false && outOfStock()">
                                        <div ng-show="payment_remain > 0">
                                            <input type="hidden" name="payment" value="true">
                                            <button type="submit" class="btn btn-success" style="width: 100%">
                                                บันทึกและเข้าสู่การชำระเงิน
                                            </button>
                                        </div>
                                        <div ng-show="payment_remain == 0">
                                            <button type="submit" class="btn btn-success" style="width: 100%">บันทึก
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $(".dr").select2();
            $('#treat_date').attr('readonly', 'readonly');
        });

    </script>
@stop
