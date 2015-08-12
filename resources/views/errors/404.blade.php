@extends('layout.master')
@section('title','Error 404')
@section('content')

    <div class="row">

        <div class="error-page">
            <h2 class="headline text-red">404</h2>
            <div class="error-content"><br>
                <h3><i class="fa fa-warning text-red"></i> อุปป์! ไม่พบไฟล์.</h3>
                <p>
                   ขออภัย ไม่พบไฟล์ที่คุณกำลังเรียกใช้งานในตอนนี้.
                   โปรดติดต่อฝ่ายไอที หรือ ผู้พัฒนาโปรแกรม เพื่อสอบถามข้อมูลเพิ่มเติม.
                </p>

            </div>
        </div><!-- /.error-page -->

    </div>
@stop
