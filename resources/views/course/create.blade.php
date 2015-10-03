@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','Course Management')
@section('headDes','เพิ่มข้อมูลคอร์ส')
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
        {!! Form::open(['url' => 'course/create', 'class' => 'ajax']) !!}

        <div class="col-md-7">
            <div class="box  box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มข้อมูล</h2>
                </div>

                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <label for="course_id" class=" required">เลขที่คอร์ส</label>
                        <input class=" form-control" required
                               type="text" value="{{Input::old('course_id')}}"
                               id="course_id"
                               name="course_id" placeholder="ระบุเลขที่คอร์ส ...">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="course_name" class=" required">ชื่อคอร์ส</label>
                        <input class=" form-control" type="text" value="{{Input::old('course_name')}}"
                               id="course_name" name="course_name"
                               placeholder="ระบุชื่อคอร์ส ..." required>
                        <br>
                    </div>
                    <div class="col-md-12">

                        <label for="ct_id" class=" required">ประเภทคอร์ส</label>
                        <select name="ct_id" id="ct_id" class=" form-control">
                            @foreach($ct as $item)
                            <option value="{{$item->ct_id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <br>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label>รายละเอียดเพิ่มเติม</label>
                            <textarea class="form-control" rows="3" placeholder="ระบุรายละเอียด ... "
                                      value="{{Input::old('course_detail')}}"
                                      name="course_detail">{{Input::old('course_detail')}}</textarea>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="course_name" class=" required">ราคา</label>
                        <input class=" form-control" type="number" id="course_name"
                               value="{{Input::old('course_price')}}" name="course_price"
                               placeholder="ระบุราคา ..." required>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="course_qty" class=" required">จำนวนครั้ง</label>
                        <input class=" form-control" type="number" id="course_qty" name="course_qty"
                               value="{{Input::old('course_qty')}}"
                               placeholder="ระบุจำนวนครั้ง ..." required>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="commission" class=" required">Commission</label>
                        <input class=" form-control" type="number" id="commission"
                               value="{{Input::old('commission')}}" name="commission"
                               placeholder="commission ..." required>
                        <br>
                    </div>

                </div>

            </div>


        </div>
        <div class="col-md-5">
            {!! Form::open(['url' => 'course/create', 'class' => 'ajax']) !!}
            <div class="box  box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">เพิ่มตัวยา</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('course')}}"
                           class="btn btn-danger">กลับหน้าคอร์ส</a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <p>*ในกรณีที่คอร์สนั้นไม่ต้องใช้ยา สามารถกดบันทึกได้เลย.</p>

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
                                    <td><a ng-click="deleteById(item.product_id)"> ลบยา</a></td>
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
                                    <label class=" required">   </label>

                                    <a class="btn btn-default" ng-click="addMedicine()">เพิ่มตัวยา</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="box-footer">

                    <input ng-value="jsonData" type="hidden" name="json">
                    <input type="submit" class="btn btn-success btn-block" value="บันทึก">

                </div>

            </div>
        </div>
        </form>

@stop
