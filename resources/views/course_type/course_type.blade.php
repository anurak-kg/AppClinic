@extends('layout.master')
@section('title',trans('course.course_category'))
@section('headText',trans('course.course_category'))
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">
                <div class="panel-heading">
                    <h2 class="panel-title">{{trans('course.course_category')}}</h2>
                </div>
                <div class="panel-body">
                    {!! $form !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading ">
                    <h2 class="panel-title">{{trans('course.course_category')}}</h2>
                </div>

                <div class="panel-body ">
                    {!! $grid !!}
                </div>
            </div>
        </div>
    </div>
@stop
