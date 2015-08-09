@extends('layout.master')
@section('title','ข้อมูลลูกค้า')


@section('content')

    <div class="row">


        <div class="col-md-12">
            <div class="panel panel-primary table-responsive no-padding">

                <div class="panel-heading">
                    <h2 class="panel-title">ข้อมูลลูกค้า</h2>
                </div>

                <div class="panel-body ">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>รหัสลูกค้า</td>
                            <td>ชื่อ</td>
                            <td>เบอร์โทร</td>
                            <td>รายละเอียด</td>
                            <td>จัดการรูปภาพ</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                            <tr>
                            <td>{{$customer->cus_id}}</td>
                            <td>{{$customer->cus_name}}</td>
                            <td>{{$customer->cus_tel}}</td>
                            <td><a href="{{url('customer/view')}}?cus_id={{$customer->cus_id}}" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> ข้อมูลลูกค้า</a> </td>
                            <td><a href="{{url('customer/upload')}}?cus_id={{$customer->cus_id}}" class="btn btn-primary"><i class="fa fa-upload"></i> อัพโหลดรูป</a> </td>
                            <td><a href="{{url('customer/edit')}}?cus_id={{$customer->cus_id}}" class="btn btn-success "> แก้ไข</a> </td>
                            <td></td>

                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$('table').DataTable({--}}
                {{--"language": {--}}
                    {{--"url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Thai.json"--}}
                {{--},--}}
               {{--// "ajax": '{{url('data/customer')}}',--}}

            {{--});--}}


        {{--});--}}
    {{--</script>--}}

@stop
