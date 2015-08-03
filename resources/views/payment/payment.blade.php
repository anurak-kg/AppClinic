@extends('layout.master')
@section('title','ชำระเงิน')
@section('headText','Payment')
@section('headDes','ชำระเงิน')
@section('content')

    <div ng-controller="paymentController" id="treat">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title">ชำระเงิน เลขที่การสั่งซื้อ #{{$quo->quo_id}}</h2>
                    </div>

                    <div class="box-body">

                        <div class="row">
                            @foreach($quo->course as $course)
                                <div class="col-md-12">
                                    <div class="box box-default box-solid">
                                        <div class="box-body" style="display: block;">
                                            <div class="mailbox-read-info">
                                                <h3>{{ $course->course_id }}-{{ $course->course_name }}</h3>
                                                <h5>ลูกค้า: {{$quo->customer->cus_id}} - {{$quo->customer->cus_name}}
                                                    <span class="mailbox-read-time pull-right">{{Jenssegers\Date\Date::createFromTimestamp(strtotime($quo->created_at))->format('l j F Y H:i:s')}}</span>
                                                </h5>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail1"
                                                       placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail1"
                                                       placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail1"
                                                       placeholder="Enter email">
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop