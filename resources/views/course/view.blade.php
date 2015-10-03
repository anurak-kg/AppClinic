@extends('layout.master')
@section('title','ข้อมูลคอร์ส')

@section('content')

    <div class="row" ng-controller="courseEditController">
        @if( Session::get('message') != null )
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4>Success!</h4>

                    <p>{{Session::get('message')}}.</p>
                </div>
            </div>
        @endif
        <div class="col-md-10 col-md-offset-1" ng-init="init('{{$course->course_id}}')">
            {!! Form::open(['url' => 'course/update', 'class' => 'ajax']) !!}

            <div class="panel  panel-primary">

                <div class="panel-heading with-border">
                    <h2 class="panel-title">ข้อมูล</h2>

                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <label for="course_id" class=" required">เลขที่คอร์ส</label>
                        <input class=" form-control" required value="{{$course->course_id}}"
                               type="text"
                               id="course_id" disabled
                               name="course_id" placeholder="ระบุเลขที่คอร์ส ...">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="course_name" class=" required">ชื่อคอร์ส</label>
                        <input class=" form-control" type="text" id="course_name" name="course_name" disabled
                               placeholder="ระบุชื่อคอร์ส ..." value="{{$course->course_name}}"
                               required>
                        <br>
                    </div>
                    <div class="col-md-12">

                        <label for="ct_id" class="required">ประเภทคอร์ส</label>
                        {!! Form::select('ct_id',$ct,$course->ct_id,array('disabled','class' => 'form-control')) !!}


                        <br>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label>รายละเอียดเพิ่มเติม</label>
                                                                 <textarea class="form-control" rows="3"
                                                                           placeholder="ระบุรายละเอียด ..."
                                                                           name="course_detail" disabled>{{$course->course_detail}}</textarea>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="course_price" class=" required">ราคา</label>
                        <input class=" form-control" type="number" id="course_price" name="course_price" disabled
                               placeholder="ระบุราคา ..." required value="{{$course->course_price}}">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="course_qty" class=" required">จำนวนครั้ง</label>
                        <input class=" form-control" type="number" id="course_qty" name="course_qty" disabled
                               placeholder="ระบุจำนวนครั้ง ..." required value="{{$course->course_qty}}">
                        <br>
                    </div>
                    <div class="col-md-12"><br>

                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td style="width: 80px">รหัสยา</td>
                                    <td>ตัวยา</td>
                                    <td style="width: 90px">จำนวนที่ใช้</td>
                                    <td style="width: 20px"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-ng-repeat="item in course_medicine">
                                    <td>@{{ $index+1 }}</td>
                                    <td>@{{ item.product_id }}</td>
                                    <td>@{{ item.product_name }}</td>
                                    <td>@{{ item.qty }}</td>
                                    <td>ลบยา</td>
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
                                    <label for="course_name" class="">จำนวน</label>
                                    <input class=" form-control" ng-model="qtyValue" type="text" id="" required>
                                </div>
                            </div>
                            <div class="col-md-1">

                                <div class="form-group">
                                    <label class=" required"> </label>

                                    <a class="btn btn-info" ng-click="addMedicine()" disabled>เพิ่มตัวยา</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="panel-footer">

                    <input ng-value="jsonData" type="hidden" name="json">
                    <input type="submit" class="btn btn-primary btn-block"  disabled value="บันทึก">
                </div>

            </div>
            </form>


        </div>
    </div>

@stop