@extends('layout.master')
@section('title',trans('course.edit'))

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
                    <h2 class="panel-title">{{trans('course.edit')}}</h2>

                </div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <label for="course_id" class=" required">{{trans('course.course_id')}}</label>
                        <input class=" form-control" required value="{{$course->course_id}}"
                               type="text"
                               id="course_id"
                               name="course_id" placeholder="{{trans('course.course_id')}} ...">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label for="course_name" class=" required">{{trans('course.course_name')}}</label>
                        <input class=" form-control" type="text" id="course_name" name="course_name"
                               placeholder="{{trans('course.course_name')}} ..." value="{{$course->course_name}}"
                               required>
                        <br>
                    </div>
                    <div class="col-md-12">

                        <label for="ct_id" class=" required">{{trans('course.Type')}}</label>
                        {!! Form::select('ct_id',$ct,$course->ct_id,array('class' => 'form-control')) !!}


                        <br>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label>{{trans('course.Item_Information')}}</label>
                                                                 <textarea class="form-control" rows="3"
                                                                           placeholder="{{trans('course.Item_Information')}} ..."
                                                                           name="course_detail">{{$course->course_detail}}</textarea>
                            <br>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="course_price" class=" required">{{trans('course.price')}}</label>
                        <input class=" form-control" type="number" id="course_price" name="course_price"
                               placeholder="{{trans('course.price')}} ..." required value="{{$course->course_price}}">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="course_qty" class=" required">{{trans('course.qty_course')}}</label>
                        <input class=" form-control" type="number" id="course_qty" name="course_qty"
                               placeholder="{{trans('course.qty_course')}} ..." required value="{{$course->course_qty}}">
                        <br>
                    </div>
                    <div class="col-md-12"><br>

                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 10px">#</td>
                                    <td style="width: 80px">{{trans('course.Product_id')}}</td>
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
                                    <label class=" required"> </label>

                                    <a class="btn btn-info" ng-click="addMedicine()">{{trans('course.add_medicine')}}</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="panel-footer">

                    <input ng-value="jsonData" type="hidden" name="json">
                    <input type="submit" class="btn btn-primary btn-block" value="{{trans('course.save')}}">
                </div>

            </div>
            </form>


        </div>
    </div>

@stop