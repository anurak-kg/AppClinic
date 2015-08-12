@extends('layout.master')
@section('title','ข้อมูลลูกค้า')


@section('content')


    <div class="panel panel-primary">

        <div class="panel-heading">
            <h2 class="panel-title">ข้อมูลลูกค้า</h2>
        </div>

        <div class="panel-body ">

            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" id="customer_table">
                    <thead>
                    <tr>
                        <td>รหัสลูกค้า</td>
                        <td>ชื่อ</td>
                        <td>เบอร์โทร</td>
                        <td align="middle">รายละเอียด</td>
                        <td align="middle">จัดการรูปภาพ</td>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->cus_id}}</td>
                            <td>{{$customer->cus_name}}</td>
                            <td>{{$customer->cus_tel}}</td>
                            <td align="middle">
                                <a href="{{url('customer/view')}}?cus_id={{$customer->cus_id}}" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    ข้อมูลลูกค้า</a>
                            </td>
                            <td align="middle"><a href="{{url('customer/upload')}}?cus_id={{$customer->cus_id}}"
                                   class="btn btn-primary"><i class="fa fa-upload"></i> อัพโหลดรูป</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#customer_table').DataTable({
                "language": {
                    "url": "/Thai.json"
                },
            });
        });
    </script>

@stop
