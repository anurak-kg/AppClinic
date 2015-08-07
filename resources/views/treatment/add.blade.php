@extends('layout.master')
@section('title','การรักษา')
@section('content')
<script>


</script>
    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>

    <div class="row" ng-controller="treatmentAddController">


        <div class="col-md-3">

        </div>
        <div class="col-md-7">
            <div class="box  box-info">
                <div class="box-header with-border" align="center">
                    <h2 class="box-title">การรักษา</h2>
                </div>
                <form class="form-horizontal" method="POST" action="{{url('treatment/save')}}" ng-submit="save($event)">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
                                <option value="" >ไม่มี</option>

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
                                <input class=" form-control" type="number" value="0" name="bt1_price" id="bt1_price" >
                            </span>
                            <br>
                        </div>

                        <div class="col-md-6">
                            <label for="cus_name" class=" required">ผู้ช่วย 2</label>
                            <select class=" form-control dr" name="bt2" ng-model="bt2">
                                <option value="" style='display:none;'>เลือกผู้ช่วย...</option>
                                <option value="" >ไม่มี</option>

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
                                <input type="text" class="form-control" id="treat_date" name="treat_date" value="{{date("Y-m-d")}}">
                            </div><br>
                        </div>
                        <div class="col-md-12">
                            <label>ตัวยาที่ใช้</label>

                            <table class="table table-bordered" ng-table="tableParams" ng-init="">
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>ตัวยา</th>
                                    <th style="width: 80px">จำนวน</th>
                                    <th style="width: 120px">จำนวนที่ใช้</th>

                                </tr>
                                @foreach($quo->course->course_medicine as $medicine)
                                    <tr>
                                        <td>
                                            {{$medicine->product->product_id}}
                                        </td>
                                        <td>
                                            {{$medicine->product->product_name}}
                                        </td>
                                        <td>
                                            {{$medicine->qty}} {{$medicine->product->product_unit}}
                                        </td>
                                        <td>
                                            <div class="col-md-12">


                                                <input class="form-control" type="number" name="qty[{{$medicine->product->product_id}}]"
                                                       value="{{$medicine->qty}}"> {{$medicine->product->product_unit}}

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-md-12">

                                <label>รายละเอียดเพิ่มเติม</label>
                                <textarea class="form-control" rows="3" placeholder="ระบุรายละเอียด ..." name="comment"></textarea>
                                <input type="hidden" name="course_id" value="{{Input::get('course_id')}}">
                                <input type="hidden" name="quo_id" value="{{Input::get('quo_id')}}">

                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success" style="width: 100%">บันทึก</button>
                </div>
               </form>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".dr").select2();
            $('#treat_date').attr('readonly', 'readonly');;
        });

    </script>
@stop
