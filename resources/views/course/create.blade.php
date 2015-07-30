@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','Course Management')
@section('headDes','เพิ่มคอร์ส')

@section('content')

    <div class="row" ng-controller="courseController">
        @if( Session::get('message') != null )
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4>Success!</h4>
                    <p>{{Session::get('message')}}.</p>
                </div>
            </div>
        @endif
        <div class="col-md-10 col-md-offset-1">
            {!! Form::open(['url' => 'course/create', 'class' => 'ajax']) !!}
            <div class="box  box-success">

                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>

                </div>

                <div class="box-body">

                    <div class="col-md-12">
                        <label for="course_id" class=" required">เลขที่คอร์ส</label>
                        <input class=" form-control"
                               type="text"
                               id="course_id"
                               name="course_id" >
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
                        <input class=" form-control" type="number" id="course_name" name="course_price">
                    </div>
                    <div class="col-md-6">
                        <label for="course_name" class=" required">จำนวนครั้ง</label>
                        <input class=" form-control" type="number" id="course_name" name="course_qty">
                    </div>
                    <div class="col-md-12"><br>
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td style="width: 80px">รหัสยา</td>
                                    <td>ตัวยา</td>
                                    <td style="width: 90px" >จำนวนที่ใช้</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-ng-repeat="item in course_medicine">
                                    <td>@{{ $index+1 }}</td>
                                    <td>@{{ item.product_id }}</td>
                                    <td>@{{ item.product_name }}</td>
                                    <td>@{{ item.qty }}</td>
                                </tr>
                                </tbody>

                            </table>
                            <div class="col-md-7">
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
                                        <span ng-bind-html=" item.product_id | highlight: $select.search"></span> :
                                        <span ng-bind-html=" item.product_name | highlight: $select.search"></span>

                                    </ui-select-choices>

                                </ui-select>
                                <br>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="course_name" class=" required">จำนวน</label>
                                    <input class=" form-control" ng-model="qtyValue" type="text" id="">
                                </div>
                            </div>
                            <div class="col-md-1">

                                <div class="form-group">
                                    <label class=" required">.</label>

                                    <a class="btn btn-info" ng-click="addMedicine()">เพิ่มตัวยา</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="box-footer">
                    <div class="col-md-12">
                        <input ng-value="jsonData" type="hidden" name="json">
                        <input  type="submit" class="btn btn-success btn-block" value="Save !!">
                    </div>
                </div>

            </div>
            </form>


        </div>

    </div>

@stop
