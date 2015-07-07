@extends('layout.master')
@section('title','ลงทะเบียนลูกค้าใหม่')
@section('headText','Register Customer')
@section('headDes','ลงทะเบียนลูกค้าใหม่')
@section('content')

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
    <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">ประวัติทั่วไป</h3>
                </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="CodeCustomer">รหัสลูกค้า</label>
                                <input type="tel" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" id="exampleInputFile">
                                <p class="help-block">Example block-level help text here.</p>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Check me out
                                </label>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->
        </div><!-- /.box-body -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
@stop
