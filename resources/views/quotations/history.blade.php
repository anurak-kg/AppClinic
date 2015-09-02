@extends('layout.master')
@section('title','ประวัติการขายคอร์ส')
@section('headText','ประวัติการขายคอร์ส')

@section('content')


    <div class="box box-default">

        <div class="box-header with-border" align="middle">
            <h2 class="box-title">ประวัติการขายคอร์ส</h2>
        </div>

        <div class="box-body ">
            <div class="col-xs-12 table-responsive">
                <table class="table table-bordered" id="course_table">
                    <thead>

                    <tr>
                        <td style="width: 200px">เลขที่ขายคอร์ส</td>
                        <td>คอร์ส</td>
                        <td style="width: 120px">ราคา</td>
                        <td style="width: 120px">ส่วนลดเปอร์เซ็น</td>
                        <td style="width: 120px">ส่วนลดจำนวนเงิน</td>
                        <td style="width: 120px">ราคาทั้งสิ้น</td>
                        <td style="width: 120px">Action</td>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($quotations as $item)
                        <tr>
                            <td>{{$item->quo_id}}</td>
                            <td>
                                {{$item->course_name}}
                            </td>
                            <td>{{$item->course_price}}</td>
                            <td>{{$item->quo_de_discount }}</td>
                            <td>{{$item->quo_de_disamount }}</td>
                            <td>{{$item->net_price }}</td>
                            <td>
                                <a href="{{url('bill/bill')}}?quo_id={{$item->quo_id}}"
                                   class="btn btn-default ">Print</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop