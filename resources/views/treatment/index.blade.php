@extends('layout.master')
@section('title','รักษา')
@section('headText','การรักษา')


@section('content')
    <div ng-controller="treatController" id="treat">

        <div class="row">
            @if( Session::get('message') != null )
                <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4>Success!</h4>

                        <p>{{Session::get('message')}}.</p>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="box box-default ">
                    <div class="box-header with-border">
                        <h2 class="box-title"><i class="fa fa-search"></i> ข้อมูลลูกค้า</h2>
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
                            <div class="col-md-2">
                            <span id="div_cus_name">
                                <br>
                                <label for="cus_id" class=" required">รหัสสมาชิก</label>
                                <input class=" form-control" type="text" ng-model="customer.cus_id" disabled>
                                 <label for="cus_name" class=" required">Email</label>
                                <input class=" form-control" type="taginput" ng-model="customer.cus_email" disabled>

                            </span>
                            </div>
                            <div class="col-md-2">
                            <span id="div_cus_name">
                                 <br>
                                 <label for="cus_name" class=" required">ชื่อ - นามสกุล</label>
                                <input class=" form-control" type="text" ng-model="customer.cus_name" disabled>
                                   <label for="cus_name" class=" required">แพ้ยา</label>
                                <input class=" form-control" type="taginput" ng-model="customer.disease" disabled>
                            </span>
                            </div>
                            <div class="col-md-2">
                            <span id="div_cus_name">
                                 <br>
                                <label for="cus_name" class=" required">เบอร์โทรศัพท์</label>
                                <input class=" form-control" type="text" value="@{{ customer.cus_phone }}" disabled>
                                <label for="cus_name" class=" required">โรคประจำตัว</label>
                                <input class=" form-control" type="taginput" ng-model="customer.allergic" disabled>
                            </span>
                            </div>
                            <div class="col-md-1">
                            <span id="div_cus_name">
                                 <br>
                                <label for="cus_name" class=" required">อายุ</label>
                                <input class=" form-control" type="text"
                                       value="@{{getYear() - customer.cus_birthday_year }}" disabled>
                            </span>
                            </div>
                            <div class="col-md-2">
                            <span id="div_cus_name">
                                 <br>
                                <label for="cus_name" class=" required">เบอร์โทรศัพทมือถือ</label>
                                <input class=" form-control" type="text" value="@{{ customer.cus_tel }}" disabled>
                            </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h2 class="box-title">ข้อมูล คอร์ส</h2>
                    </div>

                    <div class="box-body">
                        <div ng-repeat="order in course">
                            <b>รหัสการซื้อ @{{order.quo_id}} / ราคา @{{order.price}} ชำระแล้ว .... บาท สถานะ ....</b>
                            <table class="table table-bordered" ng-table="tableParams" ng-init="">
                                <tr data-ng-repeat=" item in order.course">

                                    <td data-title="'#'" align="middle" style="width: 10px">
                                        @{{$index+1 }}
                                    </td>

                                    <td data-title="'คอร์ส'" style="width: 500px">
                                        <strong>@{{ item.course_id }} : @{{item.course_name}}</strong> <br>
                                        - @{{item.course_detail}}
                                    </td>

                                    <td data-title="'จำนวน'" align="middle" style="width: 100px">
                                        @{{item.course_qty}}
                                    </td>

                                    <td style="width: 100px" data-title="'รักษาแล้ว'" align="middle"
                                        style="width: 100px">
                                        @{{item.pivot.qty}}
                                    </td>

                                    <td data-title="'สถานะ'" style="width: 200px">
                                        <div ng-bind-html="getTreatStatus(item.pivot.treat_status)"
                                             align="middle"></div>
                                    </td>
                                    <td data-title="" align="middle" style="width: 200px">

                                        <div ng-bind-html="getCheck(item.pivot.treat_status,order.quo_id,item.course_id)"
                                             align="middle"></div>

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
                            suggestion: Handlebars.compile('<div>@{{cus_name}}</div>')
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
