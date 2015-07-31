@extends('layout.master')
@section('title','ข้อมูลสมาชิก')
@section('headText','Customer')
@section('headDes','ลูกค้า')

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>

                        <h2 class="box-title"> รายการข้อมูลลูกค้า </h2>
                    </div>
                    <div class="box-body">
                        <table id="customer" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>รหัสลูกค้า</th>
                                <th>ชื่อลูกค้า</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>รายละเอียด</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#customer').dataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Thai.json"
                },
                processing: true,
               // serverSide: true,
                "searching": true,
                "ajax": '{{url('data/customer')}}',

            } );

        });
    </script>
@stop
