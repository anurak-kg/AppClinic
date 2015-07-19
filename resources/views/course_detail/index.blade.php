@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('content')

    <div ng-controller="courseController" id="course">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูลลูกค้า</h2>
                    </div>

                    <div class="box-body">
                        <div class="customerSearchBox" ng-hide="boxSearch"
                                >
                            <input class="form-control typeahead input-lg customer-input "
                                   type="search"
                                   placeholder="พืมชื่อหรือรหัสลูกค้า ">
                        </div>

                        <div class="customer" ng-show="boxSearch">
                            <ul>
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span></li>
                                <li>ชื่อเบอร์โทร | <span class="customer"><strong>@{{ customer.tel }}</strong></span></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title">รายละเอียด</h2>
                    </div>

                    <div class="box-body">

                    </div>

                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="box box-solid box-info">

                    <div class="box-header with-border">
                        <h2 class="box-title">ซื้อคอร์ส</h2>
                    </div>
                    <div class="div row">
                        <div class="col-md-5">
                            <input class="form-control typeahead input-lg courseBtn"
                                   type="search"
                                   id="course"
                                   placeholder="พืมชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค็ด "      >
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-app" href="{{url('product/update')}}">
                                <i class="fa fa-plus-circle"></i> จัดการคอร์ส
                            </a>
                        </div>

                        <div class="col-md-1">
                            <i ng-if="dataLoading" class="fa fa-spinner fa-spin loading"></i>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body table-responsive no-padding">
                            </div>
                        </div>
                    </div>



                </div>

                <div align="right">
                    <button class="btn btn-lg btn-success pull-right"><i class="fa fa-credit-card "> ยืนยัน
                            การชำระเงิน </i>
                    </button>
                </div>
                <!-- /.col -->

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            var courseDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/course_detail/course_query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/course_detail/query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });

            customerDb.initialize();
            $('.customer-input').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'cus_name',
                        source: customerDb.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลลูกค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{cus_name}} @{{cus_lastname}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        customer =
                        {
                            cus_id: datum.cus_id,
                            cus_name: datum.cus_name,
                            cus_lastname: datum.cus_lastname,
                            cus_tel:datum.cus_tel
                        }
                        console.log(customer);
                        angular.element(document.getElementById('course')).scope().customerSelect(customer);

                    })
                    .on('keyup', function (e) {
                        if (e.which == 13) {
                            $(".tt-suggestion:first-child").trigger('click');
                            //$(".typehahead").val('');
                        }
                    });

            courseDb.initialize();
            $('.courseBtn').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'course_name',
                        source: courseDb.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลสินค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{course_id}} – @{{course_name}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        course =
                        {
                            id: datum.course_id,
                            course_name: datum.course_name
                        }
                        console.log(product);
                        angular.element(document.getElementById('course')).scope().pushProduct(course);

                    })
                    .on('keyup', function (e) {
                        if (e.which == 13) {
                            $(".tt-suggestion:first-child").trigger('click');
                            //$(".typehahead").val('');
                        }
                    });
        });
    </script>
@stop
