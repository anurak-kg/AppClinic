@extends('layout.master')
@section('title','ตั้งค่าระบบ')
@section('headText','Setting')
@section('headDes','ตั้งค่าทั่วไป')

@section('content')

    <div class="row">
        @if( Session::get('message') != null )
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4>Success!</h4>
                    <p>{{Session::get('message')}}.</p>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">System Configuration</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{url('setting/save')}}" novalidate>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="box-body">

                        @if ($errors->has())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="col-md-6">
                            <fieldset>
                                <legend>ทั่วไป</legend>

                                <div class="form-group">
                                    <label for="clinicName" class="col-sm-3 control-label">ชื่อร้าน</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="clinicName" name="clinicName" placeholder="..." value="{{$value['clinicName']}}">
                                        @if ($errors->has('clinicName')) <p class="help-block">{{ $errors->first('clinicName') }}</p> @endif

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">ตัวย่อร้าน</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEdb:smail3" placeholder="">
                                    </div>
                                </div>

                            </fieldset>

                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>ภาษี</legend>
                                <div class="form-group">
                                    <label for="vat_mode" class="col-sm-3 control-label">ประเภทภาษี</label>

                                    <div class="col-sm-9">
                                       {!! Form::select('vat_mode', array('none' => 'ไม่มี Vat', 'out_vat' => 'Vat นอก(Out Vat)','in_vat' => 'Vat ใน (In Vat)'), $value['vat_mode'],array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="commission_rate" class="col-sm-3 control-label">ค่าภาษี %</label>

                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="vat_rate" name="vat_rate" placeholder="..." value="{{$value['vat_rate']}}">
                                        @if ($errors->has('vat_rate')) <p class="help-block">{{ $errors->first('vat_rate') }}</p> @endif
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>การขาย</legend>
                                <div class="form-group">
                                    <label for="commission_rate" class="col-sm-3 control-label">ค่าคอมมิชชั้น</label>

                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="commission_rate" name="commission_rate" placeholder="..." value="{{$value['commission_rate']}}">
                                        @if ($errors->has('commission_rate')) <p class="help-block">{{ $errors->first('commission_rate') }}</p> @endif
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>
                                <legend>สินค้าและยา</legend>
                                <div class="form-group">
                                    <label for="vat_mode" class="col-sm-4 control-label">ลำดับการขาย</label>

                                    <div class="col-sm-8">
                                        {!! Form::select('order_sell', array('LIFO' => 'Last In,First Out [LIFO]', 'FIFO' => 'First In,First Out [FIFO]'), $value['order_sell'],array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="commission_rate" class="col-sm-4 control-label">แจ้งเตือนเมื่อสินใกล้หมดอายุ /วัน</label>

                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="product_day_expire" name="product_day_expire" placeholder="..." value="{{$value['product_day_expire']}}">
                                        @if ($errors->has('product_day_expire')) <p class="help-block">{{ $errors->first('product_day_expire') }}</p> @endif
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                            <div class="col-md-6">
                                <fieldset>
                                    <legend>ลูกค้า</legend>
                                    <div class="form-group">
                                        <label for="customer_photo_limit" class="col-sm-4 control-label">จำนวนรูปภาพที่สำมารถเก็บได้</label>

                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="customer_photo_limit" name="customer_photo_limit" placeholder="..." value="{{$value['customer_photo_limit']}}">
                                            @if ($errors->has('customer_photo_limit')) <p class="help-block">{{ $errors->first('customer_photo_limit') }}</p> @endif
                                        </div>
                                    </div>

                                </fieldset>
                            </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success pull-right">บันทึก</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>

@stop
