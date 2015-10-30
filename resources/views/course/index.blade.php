@extends('layout.master')
@section('title','คอร์ส')
@section('headText',trans('course.Course_Management'))
@section('content')

    <div class="row">
        @if( Session::get('message') != null )
            <div class="col-md-12">
                <div class="callout callout-success">
                    <h4>Success!</h4>

                    <p>{{Session::get('message')}}.</p>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="box box-default">

                <div class="box-header with-border">
                    <h2 class="box-title">{{trans('course.Course_Management')}}</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('course/create')}}"
                           class="btn btn-default">{{trans('course.add')}}</a>
                    </div>
                </div>


                <div class="box-body ">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-bordered" id="course_table">
                            <thead>

                            <tr>
                                <td style="width: 90px">{{trans('course.course_id')}}</td>
                                <td>{{trans('course.course_name')}}</td>
                                <td style="width: 100px">{{trans('course.qty_course')}}</td>
                                <td style="width: 120px">{{trans('course.price')}}</td>
                                <td style="width: 120px">{{trans('course.Item_Information')}}</td>

                                <td style="width: 120px">{{trans('course.Action')}}</td>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($course as $item)
                                <tr>
                                    <td>{{$item->course_id}}</td>
                                    <td>
                                        <strong>{{$item->course_name}}</strong>
                                        <br>{{$item->course_detail}}
                                    </td>
                                    <td>{{$item->course_qty}}</td>
                                    <td>{{$item->course_price}}</td>
                                    <td>
                                        <a href="{{url('course/view')}}?course_id={{$item->course_id}}"
                                           class="btn btn-default ">{{trans('course.Item_Information')}}</a>
                                    </td>
                                    <td>
                                        <a href="{{url('course/edit')}}?modify={{$item->course_id}}"
                                           class="btn btn-success">{{trans('course.edit')}}</a>
                                        <a href="{{url('course/delete')}}?course_id={{$item->course_id}}"
                                           class="btn btn-danger"
                                           onclick="return confirm('แน่ใจว่าจะลบ การกระทำนี้ไม่สามารถกู้คืนได้ ?');">ลบ</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#course_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>
@stop
