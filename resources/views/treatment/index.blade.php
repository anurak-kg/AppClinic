@extends('layout.master')
@section('title','รักษา')
@section('headText','การรักษา')


@section('content')
    <div ng-controller="treatController" id="treat">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูลลูกค้า</h2>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-5">
                                <input class="form-control typeahead input-lg customer-input "
                                       type="search"
                                       placeholder="ระบุ ชื่อลูกค้า หรือ รหัสลูกค้า"
                                        >
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">ชื่อ - นามสกุล@{{tesf}}</label>
                                <input class=" form-control" type="text" ng-model="customer.fullname">
                            </span>
                            </div>
                            <div class="col-md-3">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">แพ้ยา</label>
                                <input class=" form-control" type="text">
                            </span>
                            </div>
                            <div class="col-md-3">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">โรคประจำตัว</label>
                                <input class=" form-control" type="text">
                            </span>
                            </div>
                            <div class="col-md-1">
                            <span id="div_cus_name">
                                <label for="cus_name" class=" required">อายุ</label>
                                <input class=" form-control" type="text">
                            </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูล คอร์ส</h2>
                    </div>

                    <div class="box-body">
                           <div ng-repeat="order in course">
                           รหัสการซื้อ @{{order.quo_id}} ราคา @{{order.price}} ชำระแล้ว ....  บาท   สถาน ....
                            <table class="table table-bordered" ng-table="tableParams" ng-init="">
                                <tr data-ng-repeat=" item in order.course">

                                    <td data-title="'#'">
                                        @{{$index+1 }}
                                    </td>

                                    <td data-title="'คอร์ส'">
                                        <strong>@{{ item.course_id }} : @{{item.course_name}}</strong> <br>  - @{{item.course_detail}}
                                    </td>

                                    <td data-title="'จำนวน'">
                                        2
                                    </td>

                                    <td data-title="'จำนวนครั้งที่รักษาแล้ว'">
                                        @{{item.pivot.qty}}
                                    </td>

                                    <td data-title="'สถานะ'" >
                                        <div ng-bind-html="getTreatStatus(item.pivot.treat_status)"></div>

                                    </td>
                                    <td data-title="'Action'">
                                        <a class="btn btn-success" ng-href="add?course_id=@{{item.pivot.course_id}}&quo_id=@{{item.pivot.quo_id}}" target="_blank">เข้ารับการรักษา</a>
                                    </td>
                                </tr>

                            </table>
                        </div>


                    </div>

                </div>

            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/data/customer_search?q=%QUERY',
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
                        customer = datum

                        //console.log(customer);
                        angular.element(document.getElementById('treat')).scope().customerSelect(customer);

                    })
        });
    </script>
@stop
