@extends('layout.master')
@section('title','ลงทะเบียน')


@section('content')

    {!! Rapyd::scripts() !!}



    <link href="/packages/zofe/rapyd/assets/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />



    <div class="row">

        <div class="col-md-3">

        </div>

        <div class="col-md-6">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>

                </div>
                {!! $form->header !!}

                {!! $form->message !!}

                @if(!$form->message)

                <div class="box-body">


                    <div class="col-md-12">
                        {!! $form->render('order_id') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('emp_id_order') !!}
                        <br>
                    </div>



                    <div class="col-md-12">
                        {!! $form->render('order_date') !!}
                        <br>
                    </div>


                    <div class="col-md-12">
                        {!! $form->render('order_total') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('order_de_discount') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('order_de_disamount') !!}
                        <br>
                    </div>


                    <div class="col-md-12">
                        {!! $form->render('order_receive_id') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('emp_id_receive') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('order_receive_date') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('order_status') !!}
                        <br>
                    </div>


                    @endif

                    <br />
                    {!! $form->footer !!}
                </div>

            </div>






        </div>

    </div>

@stop
