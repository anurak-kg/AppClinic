@extends('layout.master')
@section('title','ลงทะเบียน')


@section('content')

    {!! Rapyd::scripts() !!}




    <div class="row">

        <div class="col-md-2">

        </div>

        <div class="col-md-8">
            <div class="box box-solid box-default">

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title">ข้อมูลลูกค้า</h2>

                </div>

                {!! $form->header !!}

                {!! $form->message !!}

                @if(!$form->message)

                <div class="box-body">


                        <div class="col-md-6">
                            {!! $form->render('cus_name') !!}
                        </div>

                        <div class="col-md-6">
                            {!! $form->render('cus_lastname') !!}
                        <br>
                        </div>



                        <div class="col-md-12">
                            {!! $form->render('cus_code') !!}
                            <br>
                        </div>


                        <div class="col-md-4">
                            {!! $form->render('cus_birthday_day') !!}
                            <br>
                        </div>

                        <div class="col-md-4">
                            {!! $form->render('cus_birthday_month') !!}
                            <br>
                        </div>

                        <div class="col-md-4">
                            {!! $form->render('cus_birthday_year') !!}
                            <br>
                        </div>


                        <div class="col-md-12">
                            {!! $form->render('cus_sex') !!}
                            <br>
                        </div>

                        <div class="col-md-12">
                            {!! $form->render('cus_blood') !!}
                            <br>
                        </div>

                        <div class="col-md-6">
                            {!! $form->render('cus_height') !!}
                            <br>
                        </div>

                        <div class="col-md-6">
                            {!! $form->render('cus_weight') !!}
                            <br>
                        </div>

                        <div class="col-md-6">
                            {!! $form->render('allergic') !!}
                            <br>
                            <br>
                        </div>

                        <div class="col-md-6">
                            {!! $form->render('disease') !!}
                            <br>
                            <br>
                        </div>

                        <div class="col-md-12">
                            {!! $form->render('cus_tel') !!}
                            <br>
                        </div>

                        <div class="col-md-12">
                            {!! $form->render('cus_phone') !!}
                            <br>
                        </div>

                        <div class="col-md-12">
                            {!! $form->render('cus_email') !!}
                            <br>
                        </div>

                </div>

            </div>




            <div class="box box-solid box-default" >

                <div class="box-header with-border" align="middle">
                    <h2 class="box-title" >ที่อยู่</h2>
                </div>

                <div class="box-body">

                    <div class="col-md-12">
                        {!! $form->render('cus_province') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_district') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_subdis') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_hno') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_moo') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_soi') !!}
                        <br>
                    </div>

                    <div class="col-md-6">
                        {!! $form->render('cus_road') !!}
                        <br>
                    </div>

                    <div class="col-md-12">
                        {!! $form->render('cus_postal') !!}
                        <br>
                    </div>


                </div>



            </div>

            <div class="box box-solid box-default">

                <div class="box-body">
                @endif
                {!! $form->footer !!}
                </div>

            </div>


        </div>

    </div>

@stop
