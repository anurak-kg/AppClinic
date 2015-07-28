@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','Course Management')
@section('headDes','เพิ่มคอร์ส')

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



                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td>ตัวยา</td>
                                    <td>จำนวนที่ใช้</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-ng-repeat="item in medicineTable">
                                    <td>@{{ index+1 }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                    </td>
                                    <td></td>

                                </tr>
                                </tbody>

                            </table>
                            <div class="col-md-3">
                                <label  class=" required">ตัวยา</label>

                                <ui-select sortable="true" theme="select2" ng-model="course_medicine.selected"
                                           title="Choose a person">
                                    <ui-select-match
                                            placeholder="เลือกหรือค้นหายาจากรายการ...">@{{$select.selected.product_name}}</ui-select-match>
                                    <ui-select-choices anchor='bottom'
                                                       repeat="item in product | filter: $select.search">
                                        <span ng-bind-html=" item.product_id | highlight: $select.search"></span> :
                                        <span ng-bind-html=" item.product_name | highlight: $select.search"></span>

                                    </ui-select-choices>

                                </ui-select> <br>
                                <div class="form-group">
                                    <button class="btn btn-success">เพิ่มตัวยา</button>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="course_name" class=" required">จำนวน</label>
                                    <input class=" form-control" type="text" id="course_name"
                                           name="course_name">
                                </div>
                            </div>
                            <div class="col-md-1">

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

@stop
