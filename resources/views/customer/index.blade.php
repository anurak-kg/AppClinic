@extends('layout.master')
@section('title','ข้อมูลลูกค้า')
@section('headText','Customers')
@section('headDes','จัดการข้อมูลลูกค้า')

@section('content')
    @if( Session::get('message') != null )
        <div class="col-md-12">
            <div class="callout callout-success">
                <h4>Success!</h4>

                <p>{{Session::get('message')}}.</p>
            </div>
        </div>
    @endif

    <div class="box box-danger">

        <div class="box-header with-border">
            <h2 class="box-title">ข้อมูลลูกค้า</h2>
            <div class="box-tools pull-right">
                <a href="{{url('customer/create')}}"
                   class="btn btn-danger">เพิ่มข้อมูลลูกค้า</a>
            </div>
        </div>

        <div class="box-body ">

            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" id="customer_table">
                    <thead>
                    <tr>
                        <td style="width: 80px">รหัสลูกค้า</td>
                        <td>ชื่อ</td>
                        <td>เบอร์โทร</td>
                        <td>อายุ</td>
                        <td align="middle" style="width: 120px">รายละเอียดการชำระเงิน</td>
                        <td align="middle" style="width: 110px">รายละเอียด</td>
                        <td align="middle" style="width: 110px">จัดการรูปภาพ</td>
                        <td align="middle"  style="width: 110px">Action</td>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->cus_id}}</td>
                            <td>{{$customer->cus_name}}</td>
                            <td>{{$customer->cus_tel}}</td>
                            <td>{{(date('Y')+543) - $customer->cus_birthday_year }} ปี</td>
                            <td align="middle">
                                <a href="{{url('payment')}}?cus_id={{$customer->cus_id}}" class="btn btn-default">
                                    <i class="fa fa-balance-scale"></i>ข้อมูลการจ่ายเงิน </a></td>
                            <td align="middle">
                                <a href="{{url('customer/view')}}?cus_id={{$customer->cus_id}}" class="btn btn-default">
                                    <i class="fa fa-book"></i>
                                    ข้อมูลลูกค้า</a>
                            </td>
                            <td align="middle"><a href="{{url('customer/upload')}}?cus_id={{$customer->cus_id}}"
                                                  class="btn btn-default"><i class="fa fa-upload"></i> อัพโหลดรูป</a>
                            </td>
                            <td>
                                <a href="{{url('customer/edit')}}?modify={{$customer->cus_id}}"
                                   class="btn btn-success">แก้ไข</a>
                                <a href="{{url('customer/delete')}}?cus_id={{$customer->cus_id}}"
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
