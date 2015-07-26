@extends('layout.master')
@section('title','การรักษา')
@section('content')

    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>

    <div class="row">


        <div class="col-md-3">

        </div>
        <div class="col-md-7">
            <div class="box  box-warning">
                <div class="box-header with-border" align="center">
                    <h2 class="box-title">การรักษา</h2>
                </div>
                {!! Form::open(array('url'=>'treatment/save')) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                           <label for="cus_name" class=" required">ลูกค้า</label>
                            <input class=" form-control" type="text"
                                   value="{{$quo->quotations->customer->cus_id}} : {{$quo->quotations->customer->cus_name}}"
                                   disabled>
                        </div>
                        <div class="col-md-12">
                            <span id="div_cus_name">
                                <label class=" required">คอร์ส</label>
                                <input class=" form-control" type="text" value="{{$quo->course->course_name}}" disabled>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">หมอ</label>
                                    <select class=" form-control dr" name="doctor">
                                        @foreach($doctor as $dr)
                                            <option value=""></option>
                                            <option value="{{$dr->dr_id}}">{{$dr->dr_id}}
                                                : {{$dr->name}}</option>
                                        @endforeach
                                    </select>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">ผู้ช่วย 1</label>
                            <select class=" form-control dr" name="bt1">
                                @foreach($users as $user)
                                    <option value=""></option>
                                    <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                @endforeach
                            </select>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <label for="cus_name" class=" required">ผู้ช่วย 2</label>
                            <select class=" form-control dr" name="bt2">
                                @foreach($users as $user)
                                    <option value=""></option>
                                    <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class=" required">วันที่เข้ารับการรักษา</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="treat_date" name="treat_date" value="{{date("Y-m-d")}}">
                            </div>
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
                                @foreach($quo->course->medicine as $medicine)
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
                            <div class="form-group">
                                <label>รายละเอียดเพิ่มเติม</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." name="comment"></textarea>
                                <input type="hidden" name="course_id" value="{{Input::get('course_id')}}">
                                <input type="hidden" name="quo_id" value="{{Input::get('quo_id')}}">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success" style="width: 100%">บันทึก</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".dr").select2();
            $('#treat_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true,
                language: 'th'
            });
        });

    </script>
@stop
