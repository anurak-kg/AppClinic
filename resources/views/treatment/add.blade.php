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

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                                <label for="cus_name" class=" required">ลูกค้า</label>
                                <input class=" form-control" type="text" value="{{$quo->quotations->customer->cus_id}} : {{$quo->quotations->customer->cus_name}} {{$quo->quotations->customer->cus_lastname}}" disabled>
                        </div>
                        <div class="col-md-12">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">คอร์ส</label>
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
                                        : {{$dr->dr_name}} {{$dr->dr_lastname}}</option>
                                @endforeach
                            </select>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">ผู้ช่วย 1</label>
                            <select class=" form-control dr" name="doctor">
                                @foreach($users as $user)
                                    <option value=""></option>
                                    <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                @endforeach
                            </select>
                            </span>
                        </div>
                        <div class="col-md-12">
                                <label for="cus_name" class=" required">ผู้ช่วย 2</label>
                                <select class=" form-control dr" name="doctor">
                                    @foreach($users as $user)
                                        <option value=""></option>
                                        <option value="{{$user->id}}">{{$user->id}} : {{$user->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-md-12">
                                <label for="cus_name" class=" required">วันที่</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".dr").select2();
        });

    </script>
@stop
