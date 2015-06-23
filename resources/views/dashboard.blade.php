@extends('layout.master')
@section('title','Dashboard')
@section('headText','Dashboard')
@section('headDes','รายละเอียด')
@section('content')

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-cart-plus "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{Lang::get('general.dashboard_order')}}</span>
                    <span class="info-box-number">0 ชิ้น</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-exclamation-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{Lang::get('warehouse.minimum_product_alert')}}</span>
                    <span class="info-box-number">41 ชิ้น</span>
                </div>
            </div>
        </div>
    </div>
@stop
