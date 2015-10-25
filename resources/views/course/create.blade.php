@extends('layout.master')
@section('title','ข้อมูลคอร์ส')
@section('headText','Course Management')
@section('headDes',trans('course.add'))
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
                    <h2 class="box-title">{{trans('course.add')}}</h2>
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
                        <label for="course_id" class=" required">{{trans('course.course_id')}}</label>
                        <input class=" form-control" required
                               type="text" value="{{Input::old('course_id')}}"
                               id="course_id"
                               name="course_id" placeholder="{{trans('course.course_id')}} ...">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="course_name" class=" required">{{trans('course.course_name')}}</label>
                        <input class=" form-control" type="text" value="{{Input::old('course_name')}}"
                               id="course_name" name="course_name"
                               placeholder="{{trans('course.course_name')}} ..." required>
                        <br>
                    </div>
                    <div class="col-md-12">

                        <label for="ct_id" class=" required">{{trans('course.Type')}}</label>
                        <select name="ct_id" id="ct_id" class=" form-control">
                            @foreach($ct as $item)
                            <option value="{{$item->ct_id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <br>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label>{{trans('course.Item_Information')}}</label>
                            <textarea class="form-control" rows="3" placeholder="{{trans('course.Item_Information')}} ... "
                                      value="{{Input::old('course_detail')}}"
                                      name="course_detail">{{Input::old('course_detail')}}</textarea>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="course_name" class=" required">{{trans('course.price')}}</label>
                        <input class=" form-control" type="number" id="course_name"
                               value="{{Input::old('course_price')}}" name="course_price"
                               placeholder="{{trans('course.price')}} ..." required>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="course_qty" class=" required">{{trans('course.qty_course')}}</label>
                        <input class=" form-control" type="number" id="course_qty" name="course_qty"
                               value="{{Input::old('course_qty')}}"
                               placeholder="{{trans('course.qty_course')}} ..." required>
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
                    <h2 class="box-title">{{trans('course.add_medicine')}}</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('course')}}"
                           class="btn btn-danger">{{trans('course.back')}}</a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="col-md-12">
                        <p>{{trans('course.detail')}}</p>

                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td style="width: 80px">{{trans('course.medicine_id')}}</td>
                                    <td>{{trans('course.medicine')}}</td>
                                    <td style="width: 90px">{{trans('course.qty')}}</td>
                                    <td style="width: 20px"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr data-ng-repeat="item in course_medicine">
                                    <td>@{{ $index+1 }}</td>
                                    <td>@{{ item.product_id }}</td>
                                    <td>@{{ item.product_name }}</td>
                                    <td>@{{ item.qty }}</td>
                                    <td><a ng-click="deleteById(item.product_id)"> {{trans('course.delete')}}</a></td>
                                </tr>
                                </tbody>

                            </table>
                            <div class="col-md-7">
                                <label class=" required">{{trans('course.medicine')}}</label>

                                <ui-select style="width: 100%;"
                                           sortable="true"
                                           theme="select2"
                                           ng-model="medicine.selected"
                                           title="Choose a person">
                                    <ui-select-match
                                            placeholder="...">@{{$select.selected.product_name}}</ui-select-match>
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
                                    <label for="course_name" class="">{{trans('course.qty')}}</label>
                                    <input class=" form-control" ng-model="qtyValue" type="text" id="" required>
                                </div>
                            </div>
                            <div class="col-md-1">

                                <div class="form-group">
                                    <label class=" required">   </label>

                                    <a class="btn btn-default" ng-click="addMedicine()">{{trans('course.add_medicine')}}</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="box-footer">

                    <input ng-value="jsonData" type="hidden" name="json">
                    <input type="submit" class="btn btn-success btn-block" value="{{trans('course.save')}}">

                </div>

            </div>
        </div>
        </div>
        </form>

@stop
