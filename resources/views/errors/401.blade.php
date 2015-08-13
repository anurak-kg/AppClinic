@extends('layout.master')
@section('title','Error 403')
@section('content')

    <div class="row">

        <div class="error-page">
            <h2 class="headline text-red">401</h2>
            <div class="error-content"><br>
                <h3><i class="fa fa-warning text-red"></i> อุปป์! คุณไม่มีสิทธ์เข้าใช้งาน.</h3>
                <p>
                   ขออภัย คุณไม่มีสิทธิ์ในการเข้าใช้งานหน้านี้.
                   โปรดติดต่อฝ่ายไอที หรือ ผู้พัฒนาโปรแกรม เพื่อสอบถามข้อมูลเพิ่มเติม.
                </p>

            </div>
        </div><!-- /.error-page -->

    </div>
@stop
