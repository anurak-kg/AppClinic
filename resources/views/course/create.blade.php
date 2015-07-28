@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('HeadText','Course Management')

@section('content')

    <div class="row" ng-controller="courseController">

        <div class="col-md-12">
            <div class="box  box-success">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <label for="course_name" class=" required">ชื่อคอร์ส</label>
                        <input class=" form-control" type="text" id="course_name" name="course_name">
                    </div>
                    <div class="col-md-12">
                        <label for="course_name" class=" required">ชื่อคอร์ส</label>
                        <input class=" form-control" type="text" id="course_name" name="course_name">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>รายละเอียดเพิ่มเติม</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." name="comment"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="course_name" class=" required">ราคา</label>
                        <input class=" form-control" type="number" id="course_name" name="course_name">
                    </div>
                    <div class="col-md-6">
                        <label for="course_name" class=" required">จำนวนครั้ง</label>
                        <input class=" form-control" type="number" id="course_name" name="course_name">
                    </div>
                    <div class="col-md-12"><br>

                        <div class="panel box box-danger">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    ตัวยาที่ใช้
                                </h4>
                            </div>
                            <div class="box-body">
                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="productSelect" class=" required">ตัวยา</label>
                                            <select id="productSelect" class="form-control select2">
                                                <option  ng-repeat="item in product"
                                                        value="@{{item.product_id}}">
                                                    @{{item.product_id}} - @{{item.product_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="course_name" class=" required">จำนวนที่ใช้</label>
                                            <input class=" form-control" type="text" id="course_name"
                                                   name="course_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>ตัวยา</td>
                                            <td>จำนวนที่ใช้</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="form-control" name="productId[]" type="text"></td>
                                            <td><input class="form-control" name="qty[]"></td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="box-footer">
                    <div class="col-md-12">
                        <button class="btn btn-success">เพิ่ม</button>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <script type="text/javascript">
        $('#productSelect').select2();
    </script>
@stop
