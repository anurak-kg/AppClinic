@extends('layout.master')
@section('title','คอร์ส')
@section('headText','Course Management')
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
                    <h2 class="box-title">จัดการคอร์ส</h2>

                    <div class="box-tools pull-right">
                        <a href="{{url('course/create')}}?modify={{$item->course_id}}"
                           class="btn btn-success">เพิ่มคอร์สใหม่</a>
                    </div>
                </div>


                <div class="panel-body ">
                    <table class="table table-bordered">
                        <thead>

                        <tr>
                            <td style="width: 45px">รหัสคอร์ส</td>
                            <td>ชื่อคอร์ส</td>
                            <td style="width: 100px">จำนวนครั้ง</td>
                            <td style="width: 120px">ราคา</td>
                            <td style="width: 120px">รายละเอียด</td>

                            <td style="width: 120px">Action</td>
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
                                       class="btn btn-default ">รายละเอียดคอร์ส</a>
                                </td>
                                <td>
                                    <a href="{{url('course/edit')}}?modify={{$item->course_id}}"
                                       class="btn btn-success">แก้ไข</a>
                                    <a href="{{url('course/delete')}}?course_id={{$item->course_id}}"
                                       class="btn btn-danger"
                                       onclick="return confirm('แน่ใจว่าจะลบ การกระทำนี้ไม่สารถกู้คืนได้ ?');">ลบ</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            console.log('foor');
            $('table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Thai.json"
                },
            });
        });
    </script>
@stop
