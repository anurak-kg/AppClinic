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

                    <div class="box-body table-responsive no-padding">
                        {!! $grid !!}
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

            var mySearch = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'data.php',
                remote: {
                    url: 'sale/query?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            mySearch.initialize();

            var customerDb = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'data.php',
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


            $('.course').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        displayKey: 'ProductName',
                        source: mySearch.ttAdapter(),
                        templates: {
                            empty: [
                                '<div class="empty-message">',
                                'ไม่พบข้อมูลสินค้า',
                                '</div>'
                            ].join('\n'),
                            suggestion: Handlebars.compile('<div>@{{ProductBarcodeId}} – @{{ProductName}}</div>')
                        }
                    })
                    .on('typeahead:selected', function ($e, datum) {
                        //console.log(datum);
                        product =
                        {
                            id: datum.id,
                            ProductBarcodeId: datum.ProductBarcodeId,
                            ProductName: datum.ProductName,
                            qty: 1,
                            UnitName: datum.UnitName,
                            ProductSellPrice: datum.ProductSellPrice,
                            tax: '7',
                            discount_price: 0,
                            ProductBandName: datum.ProductBandName,
                            cost_price: datum.ProductSellPrice
                        }
                        console.log(product);
                        angular.element(document.getElementById('pos')).scope().pushProduct(product);

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
