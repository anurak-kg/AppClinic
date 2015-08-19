@extends('layout.master')
@section('title','จัดการรูปถ่าย')
@section('headDes',$customer->cus_name)
@section('headText','Customer Photo')
@section('content')
    <script src="/dist/js/dropzone.js"></script>
    <link href="/dist/js/dropzone.css" rel="stylesheet" type="text/css"/>


        <div class="box box-success">
            <div class="box-header with-border">
                <h2 class="box-title">จัดการรูปถ่าย :: {{$customer->cus_id}} - {{$customer->cus_name}}</h2>

                <div class="box-tools pull-right">
                    <a href="{{url('/customer/view?cus_id='.$customer->cus_id.'')}}" class="btn btn-info">ดูข้อมูลลูกค้า</a>

                    <a href="{{url('/customer')}}" class="btn btn-success">กลับไปที่ข้อมูลลูกค้า</a>
                </div>
            </div>
            <div class="box-body">

                    <p><strong>ขั้นตอนการอัพโหลดรูป. </strong> คุณสามารถลากรูปภาพของลูกค้าจาก Folder ในคอมพิวเตอร์ เข้ามาในกล่องสีแดงด้านล่าง
                        หรือ คลิกที่กล่องเพื่อเลือกไฟล์ โดยสามารถคลิกลาก หรือ กด ctrl เพื่อเลือกภาพพร้อมกันหลายภาพ</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h2 class="box-title">Before : ก่อน [ สูงสุด 5 รูปภาพ ]</h2>
                            </div>
                            <div class="box-body">
                                <div class="dropzone" id="beforeZone"></div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h2 class="box-title">After : หลัง  [ สูงสุด 5 รูปภาพ ]</h2>
                            </div>
                            <div class="box-body">
                                <div class="dropzone" id="afterZone"></div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>



    <script type="text/javascript">
        var baseUrl = "{{ url('customer/upload') }}";
        var jsonBeforeDataUrl = "{{ url('customer/photo-data') }}?cus_id={{ $customer->cus_id }}&type=before";
        var jsonAfterDataUrl = "{{ url('customer/photo-data') }}?cus_id={{ $customer->cus_id }}&type=after";
        var deleteUrl = "{{ url('customer/photo-delete') }}";
        console.log(jsonBeforeDataUrl);
        console.log(jsonAfterDataUrl);

        Dropzone.autoDiscover = false;

        var myDropzoneBefore = new Dropzone("div#beforeZone", {
            url: baseUrl,
            acceptedFiles:'image/*',
            uploadMultiple: true,
            addRemoveLinks: true,
            dictRemoveFile: "ลบรูป",
            maxFilesize: 4,//MB
            dictRemoveFileConfirmation: 'แน่ใจว่าต้องการลบรูป ?',
            dictDefaultMessage: "คลิก หรือลากไฟล์มาไว้ในช่องสีเหลี่ยมเพื่ออัพโหลดภาพ",
            maxFiles: {{getConfig('customer_photo_limit')}},
            params: {
                customer_id: {{ $customer->cus_id }},
                type: 'before'
            },
            init: function () {
                thisDropzone = this;
                $.getJSON(jsonBeforeDataUrl, function (data) {
                    $.each(data, function (index, val) {
                        var mockFile = {name: val.name, size: val.size};
                        myDropzoneBefore.emit("addedfile", mockFile);
                        myDropzoneBefore.emit("thumbnail", mockFile, "/uploads/customer/" + val.name);
                        myDropzoneBefore.emit("complete", mockFile);
                    });
                });
            }
        }).on("removedfile", function (file) {
                    $.ajax({
                        url: deleteUrl,
                        type: "POST",
                        data: {'filename': file.name}
                    });
                });

        var myDropzoneAfter = new Dropzone("div#afterZone", {
            url: baseUrl,
            acceptedFiles:'image/*',
            uploadMultiple: true,
            addRemoveLinks: true,
            dictRemoveFile: "ลบรูป",
            maxFilesize: 4,//MB
            dictRemoveFileConfirmation: 'แน่ใจว่าต้องการลบรูป ?',
            dictDefaultMessage: "คลิก หรือลากไฟล์มาไว้ในช่องสีเหลี่ยมเพื่ออัพโหลดภาพ",
            maxFiles: {{getConfig('customer_photo_limit')}},
            params: {
                customer_id: {{ $customer->cus_id }},
                type: 'after'
            },
            init: function () {
                $.getJSON(jsonAfterDataUrl, function (data) {
                    $.each(data, function (index, val) {
                        var mockFile = {name: val.name, size: val.size};
                        myDropzoneAfter.emit("addedfile", mockFile);
                        myDropzoneAfter.emit("thumbnail", mockFile, "/uploads/customer/" + val.name);
                        myDropzoneAfter.emit("complete", mockFile);
                    });
                });
            }
        }).on("removedfile", function (file) {
                    $.ajax({
                        url: deleteUrl,
                        type: "POST",
                        data: {'filename': file.name}
                    });
                });

    </script>
@stop