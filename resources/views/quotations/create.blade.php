@extends('layout.master')
@section('title','ซื้อคอร์ส')
@section('content')

    <div ng-controller="quotationsController" id="course">
        <div class="row">
            @if( Session::get('message') != null )
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4>Success!</h4>

                        <p>{{Session::get('message')}}.</p>
                    </div>
                </div>
            @endif

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
                                <li>ชื่อลูกค้า | <span class="customer"><strong>@{{customer.fullname}}</strong></span>
                                </li>
                                <li>ชื่อเบอร์โทร | <span class="customer"><strong>@{{ customer.tel }}</strong></span>
                                </li>
                            </ul>
                        </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="div row">
                                    <div class="col-md-5">
                                        <input class="form-control typeahead input-lg courseBtn"
                                               type="search"
                                               id="course"
                                               placeholder="พืมชื่อสินค้า รหัสสินค้า หรือสแกนบาร์โค็ด ">
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
                                    <table class="table table-bordered" ng-table="tableParams" ng-init="">
                                        <tr data-ng-repeat="item in product">
                                            <td>
                                                <button class="btn btn-box-tool" data-widget="remove"
                                                        ng-click="deleteById(item.course_id)"><i class="fa fa-times"></i>
                                                </button>

                                            </td>
                                            <td data-title="'#'">
                                                @{{$index+1}}
                                            </td>

                                            <td data-title="'คอร์ส'">
                                                @{{item.course.course_name}}<br>
                                            <strong>รายละเอียดคอร์ส</strong>
                                               <ul>
                                                   <li ng-repeat="c in item.course.detail">@{{c.course_de_name}}: ราคา <strong>@{{c.course_de_price}}</strong> บาท</li>
                                               </ul>
                                            </td>
                                            <td data-title="'จำนวน'">
                                                <div>
                                                    <input type="number"                                                           style="width: 5em"
                                                           ng-model="item.qty"
                                                           ng-change="update(item)"
                                                           ng-model-options="{debounce: 750}">
                                                    @{{item.course_type}}

                                                </div>

                                            </td>


                                        </tr>

                                    </table>

                                </div>
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
                    url: '/quotations/course_query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/quotations/query?q=%QUERY',
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
                            cus_tel: datum.cus_tel
                        }
                        console.log(customer);
                        angular.element(document.getElementById('course')).scope().customerSelect(customer);

                    })


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
                        course =
                        {
                            id: datum.course_id,
                            course :{
                                course_name: datum.course_name,
                                detail: datum.detail
                            }
                        }
                        console.log(course);
                        angular.element(document.getElementById('course')).scope().pushProduct(course);

                    })

        });
    </script>
@stop
