@extends('layout.master')
@section('title','ลงทะเบียน')


@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="box box-solid box-success">

                <div class="box-header with-border">
                    <h2 class="box-title">ลงทะเบียน</h2>
                </div>

                <div class="box-body">
                    {!! $form->header !!}

                    {!! $form->message !!} <br/>

                    @if(!$form->message)
                    <div class="row">
                        <div class="col-md-4">
                            {!! $form->render('cus_name') !!}
                            <div class="col-md-3">

                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! $form->render('cus_lastname') !!}

                            </button>
                        </div>
                        {!! Rapyd::scripts() !!}

                    </div>
                    @endif
                    {!! $form->footer !!}
                </div>

            </div>


        </div>

    </div>

@stop
