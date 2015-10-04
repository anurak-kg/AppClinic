/**
 * Created by Anurak on 26/06/58.
 */

(function () {
    'use strict'
    var app = angular.module('application', ['ngTable', 'ui.bootstrap', 'ngSanitize', 'ui.select']);
    app.directive('onLastRepeat', function () {
        return function (scope, element, attrs) {
            if (scope.$last) setTimeout(function () {
                scope.$emit('onRepeatLast', element, attrs);
            }, 1);
        };
    })
    app.directive('datepicker', function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ctrl) {
                $(element).datepicker({
                    format: 'yyyy-mm-dd',
                    language: 'th',
                    startView: 2,
                    todayBtn: "linked",
                    autoclose: true,
                    todayHighlight: true,
                    onSelect: function (date) {
                        ctrl.$setViewValue(date);
                        ctrl.$render();
                        scope.$apply();
                    }
                });
            }
        };
    });

    app.directive('ngConfirmClick', [
        function () {
            return {
                link: function (scope, element, attr) {
                    var msg = attr.ngConfirmClick || "Are you sure?";
                    var clickAction = attr.confirmedClick;
                    element.bind('click', function (event) {
                        if (window.confirm(msg)) {
                            scope.$eval(clickAction)
                        }
                    });
                }
            };
        }]);
    app.controller('quotationsController', function ($scope, $http, ngTableParams, $modal) {
        $scope.product = [];
        $scope.customer = [];
        $scope.sale = [];
        $scope.quo_id = null;
        $scope.cashInput = 0;
        $scope.CashTotal = 0;
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.vat = 7;
        $scope.vatType = null;
        $scope.controller = '/quotations'
        //$scope.modalInstance = null;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.init = function (vat, quo_id,vatType) {
            $scope.quo_id = quo_id;
            $scope.vat = vat;
            $scope.vatType = vatType;
        }

        $http.get('/quotations/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                console.log(data)
                $scope.dataLoading = false;

            }).
            error(function (data, status, headers, config) {

            });
        $http.get($scope.controller + '/data-customer').
            success(function (data, status, headers, config) {
                console.log(typeof (data.status));
                if (data.status === null) {
                    console.log('Receive Customer null');
                    $scope.boxSearch = false;

                }
                else {
                    $scope.customer = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {

            });

        $scope.customerSelect = function (customer) {
            $scope.customer.cus_name = customer.cus_name;
            $scope.customer.tel = customer.cus_tel;
            $scope.customer.cus_id = customer.cus_id;
            $scope.customer.phone = customer.cus_phone;
            $scope.customer.day = customer.cus_birthday_day;
            $scope.customer.month = customer.cus_birthday_month;
            $scope.customer.year = customer.cus_birthday_year;
            $scope.customer.height = customer.cus_height;
            $scope.customer.weight = customer.cus_weight;
            $scope.customer.email = customer.cus_email;
            $scope.customer.allergic = customer.allergic;
            $scope.customer.disease = customer.disease;
            $scope.dataLoading = true;

            console.log(customer)
            $http.get('/quotations/set-customer?id=' + customer.cus_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)

                });
            $scope.$apply(function () {
                $scope.boxSearch = true;
            });
        }

        $http.get('/quotations/data-sale').
            success(function (data, status, headers, config) {
                if (data.status == 'success') {
                    $scope.sale.id = data.id;
                    $scope.sale.name = data.name;
                    $scope.SaleBoxSearch = true;
                    console.log('update sale success');
                }
            }).
            error(function (data, status, headers, config) {
            });

        $scope.saleSelect = function (sale) {
            $scope.sale.id = sale.id;
            $scope.sale.name = sale.name;
            $scope.dataLoading = true;
            $http.get('/quotations/setsale?id=' + sale.id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)
                });
            $scope.$apply(function () {
                $scope.SaleBoxSearch = true;
            });
        }
        $scope.save = function () {
            if ($scope.product.length == 0) {
                alert("ยังไม่มีการเพิ่มคอร์ส");
            }
            else if ($scope.boxSearch == false) {
                alert("ยังไม่เลือกลูกค้า");
            }
            else if ($scope.SaleBoxSearch == false) {
                alert("ยังไม่เลือกพนักงานขาย");
            }
            else {
                $scope.payment();
            }
        }
        $scope.pushCourse = function (data) {
            //
            //$scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(data);
            $scope.tableParams.reload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.courseSearchBox = ""
        }
        $scope.getAddProduct = function (data) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/add?id=' + data.id + '&type=' + data.type;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.product.push(data);
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();
                });
        }
        $scope.cashAdd = function (cash) {
            $scope.cashInput += cash;
        }
        $scope.getDiscount = function () {
            $scope.discout = 0.0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.discout += parseInt((product.quo_de_price * product.quo_de_discount / 100)) + parseInt(product.quo_de_disamount);
            }
            return $scope.discout;
        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.total += parseInt(product.quo_de_price) * parseInt(product.product_qty)

            }
            return $scope.total;
        }
        $scope.getCommission = function (){
            $scope.commission = 0;
            for (var i=0; i < $scope.product.length; i++){
                var product = $scope.product[i];
                $scope.commission += parseInt(product.commission)
            }
            return $scope.commission;
        }
        $scope.getFinalTotal = function () {
            if($scope.vatType == 'false'){
                return $scope.getTotal()-$scope.getDiscount();
            }else if($scope.vatType == 'true'){
                return ($scope.getTotal()-$scope.getDiscount()) + $scope.getVat();
            }
        }
        $scope.setVat = function (vat) {
            $scope.vat = vat;
        }
        $scope.getVat = function () {
            return ($scope.getTotal()-$scope.getDiscount()) * $scope.vat / 100;
        }
        $scope.update = function (type, course_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + course_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }
        $scope.updatesale = function (type, quo_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/updatesale?id=' + quo_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }
        $scope.deleteById = function (id) {
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.quo_de_id !== id;
                });
            $scope.dataLoading = true;
            $http.get('/quotations/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.open = function () {

            $scope.modalInstance = $modal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'payment.html',
                controller: 'quotationsController',
                scope: $scope

            });

            $scope.modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
            });
        };
        $scope.cancel = function () {
            $scope.modalInstance.dismiss();
        };
        $scope.payment = function () {
            window.location.href = '/quotations/save';
        }
        $scope.paymentAndPrint = function (id) {
            window.open(
                '/bill/bill?quo_id=' + id,
                '_blank' // <- This is what makes it open in a new window.
            );
            window.location.href = '/quotations/save';
        }
        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].course_id;
                // console.log("id ="+ id +"len="+len);
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }

    });
    app.controller('treatController', function ($scope, $http, ngTableParams, $sce) {
        $scope.customer = [];
        $scope.course = [];
        $scope.customerSelect = function (customer) {
            $scope.$apply(function () {
                $scope.customer = customer;
                $scope.customer.cus_name = customer.cus_name;
            });
            $scope.getCourseData();
            console.log($scope.customer);
        }
        $scope.getYear = function () {
            var d = new Date();
            var n = d.getFullYear() + 543;
            return n;
        }
        $scope.getAge = function (year) {
            var age = null;
            if (typeof year === "undefined") {
                age = ""
            }
            else {
                age = $scope.getYear() - year;
            }
            return age;
        }
        $scope.getCourseData = function () {
            $http.get('/treatment/course_data?id=' + $scope.customer.cus_id).
                success(function (data, status, headers, config) {
                    $scope.course = data;
                    console.log($scope.course);
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
        }
        $scope.getTreatStatus = function (status) {
            var text;
            if (status == 0) {
                text = "<span class=\"label label-danger\">ไม่เริ่ม</span>";
            }
            if (status == 1) {
                text = "<span class=\"label label-info\">อยุ่ในการรักษา</span>";
            }
            if (status == 5) {
                text = "<span class=\"label label-success\">เสร็จแล้ว</span>";
            }
            return $sce.trustAsHtml(text);
        }
        $scope.getCheck = function (status, quo_id, course_id) {
            var text;
            var url = "/treatment/add?course_id=" + course_id + "&quo_id=" + quo_id
            if (status == 5) {
                text = "<span class=\"label label-success\">เสร็จแล้ว</span>";
            }
            else {
                text = "<a class=\"btn btn-success\" href=" + url + ">เข้ารับการรักษา</a>";
            }
            return $sce.trustAsHtml(text);
        }
    });
    app.controller('orderController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.vendor = [];
        $scope.order_detail = [];
        $scope.quo_id = null;
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.VendorBoxSearch = false;
        $scope.vat = null;
        $scope.vat_rate = 7;
        $scope.controller = '/order'
        $scope.warehouse = [];
        $scope.warehouse.id = 0;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                console.log($scope.product);
                $scope.dataLoading = false;

                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });
        $http.get($scope.controller + '/datavendor').
            success(function (data, status, headers, config) {
                if (data.status == -1) {
                    console.log('Receive vendor null');
                    $scope.boxSearch = false;
                }
                else {
                    $scope.vendor = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {
            });
        $scope.init = function(vat,vat_rate,order_id){
            $scope.vat = vat;
            $scope.vat_rate = vat_rate;
            $scope.order_id = order_id;
            if($scope.vat  =='true'){
                $scope.vat_enable = true;
            }else{
                $scope.vat_enable = false;

            }
        }
        $scope.vatChange = function(){
            $scope.dataLoading = true;
            //alert($scope.vat_enable);
            $http.get($scope.controller + '/vat-change?vat='+$scope.vat_enable).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;

                });
        }
        $scope.warehouseChange = function(){
            $http.get($scope.controller + '/warehouse?id=' + $scope.warehouse.id ).
                success(function (data, status, headers, config) {
                        console.log('Warehouse Changed');
                }).
                error(function (data, status, headers, config) {
                });
        }

        $scope.vendorSelect = function (vendor) {
            $scope.vendor = vendor;
            $scope.dataLoading = true;
            console.log(vendor)
            $http.get($scope.controller + '/setvendor?id=' + vendor.ven_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.boxSearch = true;

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)
                });
            $scope.$apply(function () {
                $scope.VendorBoxSearch = true;
            });
        }
        $scope.setTax = function(){

        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
            $scope.vendorSearchBox = ""
            $scope.empSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            $http.get($scope.controller + '/addproduct?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get('/order/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.total += parseInt(product.order_de_price * product.order_de_qty)

            }
            return $scope.total;
        }
        $scope.getFinalTotal = function () {
            if($scope.vat_enable == false){
                return $scope.getTotal();
            }else if($scope.vat_enable == true){
                return ($scope.getTotal() + $scope.getVat());
            }
        }

        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat_rate / 100;
        }

        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }

        $scope.save = function (id) {
            if ($scope.product.length == 0) {
                alert("ยังไม่มีการเลือกสินค้า");
            }
            else if ($scope.VendorBoxSearch == false) {
                alert("ยังไม่เลือกร้านค้า");
            }
            else {
                window.open(
                    '/bill/order?order_id=' + id,
                    '_blank' // <- This is what makes it open in a new window.
                );
                window.location.href = '/order/save';
            }
        }

    });
    app.controller('requestController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.vendor = [];
        $scope.order_detail = [];
        $scope.quo_id = null;
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.VendorBoxSearch = false;
        $scope.vat = null;
        $scope.vat_rate = 7;
        $scope.controller = '/request'
        $scope.warehouse = [];
        $scope.warehouse.id = 0;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                console.log($scope.product);
                $scope.dataLoading = false;

                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });
        $http.get($scope.controller + '/datavendor').
            success(function (data, status, headers, config) {
                if (data.status == -1) {
                    console.log('Receive vendor null');
                    $scope.boxSearch = false;
                }
                else {
                    $scope.vendor = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {
            });
        $scope.init = function(vat,vat_rate,order_id){
            $scope.vat = vat;
            $scope.vat_rate = vat_rate;
            $scope.order_id = order_id;
            if($scope.vat  =='true'){
                $scope.vat_enable = true;
            }else{
                $scope.vat_enable = false;

            }
        }
        $scope.vatChange = function(){
            $scope.dataLoading = true;
            //alert($scope.vat_enable);
            $http.get($scope.controller + '/vat-change?vat='+$scope.vat_enable).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;

                });
        }
        $scope.warehouseChange = function(){
            $http.get($scope.controller + '/warehouse?id=' + $scope.warehouse.id ).
                success(function (data, status, headers, config) {
                    console.log('Warehouse Changed');
                }).
                error(function (data, status, headers, config) {
                });
        }

        $scope.vendorSelect = function (vendor) {
            $scope.vendor = vendor;
            $scope.dataLoading = true;
            console.log(vendor)
            $http.get($scope.controller + '/setvendor?id=' + vendor.ven_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.boxSearch = true;

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)
                });
            $scope.$apply(function () {
                $scope.VendorBoxSearch = true;
            });
        }
        $scope.setTax = function(){

        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
            $scope.vendorSearchBox = ""
            $scope.empSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            $http.get($scope.controller + '/addproduct?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get('/order/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.total += parseInt(product.order_de_price * product.order_de_qty)

            }
            return $scope.total;
        }
        $scope.getFinalTotal = function () {
            if($scope.vat_enable == false){
                return $scope.getTotal();
            }else if($scope.vat_enable == true){
                return ($scope.getTotal() + $scope.getVat());
            }
        }

        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat_rate / 100;
        }

        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }

        $scope.save = function (id) {
            if ($scope.product.length == 0) {
                alert("ยังไม่มีการเลือกสินค้า");
            }
            else {
               // window.open(
                //    '/bill/request?order_id=' + id,
                //    '_blank' // <- This is what makes it open in a new window.
                //);
                window.location.href = '/request/save';
            }
        }

    });
    app.controller('courseController', function ($scope, $http) {
        $scope.course_medicine = [];
        $scope.medicine = {};
        $scope.qtyValue = 0;
        $scope.count = 0;
        $scope.jsonData = undefined;
        $scope.addMedicine = function (id) {
            var course =
            {
                id: $scope.count,
                product_id: $scope.medicine.selected.product_id,
                product_name: $scope.medicine.selected.product_name,
                qty: $scope.qtyValue
            }
            $scope.course_medicine.push(course);
            $scope.count++;
            $scope.jsonData = JSON.stringify($scope.course_medicine);
            console.log($scope.course_medicine);
        }
        $scope.form = {
            course_name: ''
        }
        $scope.submit = function () {
            alert($scope.form);
        }
        $scope.showText = function (text1, text2) {
            return text1 + ' ' + text2;
        }
        $scope.scopeMessage = "default text";
        var changeCount = 0;

        $http.get("/data/product").
            success(function (data, status, headers, config) {
                $scope.product = data;
            }).
            error(function (data, status, headers, config) {
                console.log('error' + headers)
            });


        $scope.deleteById = function (id) {
            console.log($scope.course_medicine);
            $scope.course_medicine = $scope.course_medicine
                .filter(function (el) {
                    return el.product_id !== id;
                });

        }
    });
    app.controller('courseEditController', function ($scope, $http) {
        $scope.course_medicine = [];
        $scope.medicine = {};
        $scope.qtyValue = 0;
        $scope.count = 0;
        $scope.jsonData = undefined;
        $scope.init = function (course_id) {
            $scope.course_id = course_id;
            var url = "/course/medicine-data?course_id=" + $scope.course_id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.course_medicine = data;
                    console.log($scope.course_medicine);

                }).
                error(function (data, status, headers, config) {
                    console.log('error' + headers)
                });
        }
        $scope.addMedicine = function (id) {
            if ($scope.qtyValue == 0) {
                alert("กรุณาใส่จำนวนยาก่อนค่ะ")
            } else {
                var course =
                {
                    id: $scope.count,
                    product_id: $scope.medicine.selected.product_id,
                    product_name: $scope.medicine.selected.product_name,
                    qty: $scope.qtyValue
                }
                $scope.course_medicine.push(course);
                $scope.course_medicine = $scope.pushDuplicateCheck();
                $scope.count++;

                var url = "/course/medicine-add?course_id=" + $scope.course_id +
                    "&product_id=" + $scope.medicine.selected.product_id + "&qty=" + $scope.qtyValue;
                console.log(url);
                $http.get(url).
                    success(function (data, status, headers, config) {
                    }).
                    error(function (data, status, headers, config) {
                        console.log('error' + headers)
                    });
            }
        }
        $scope.form = {
            course_name: ''
        }
        $scope.submit = function () {
            alert($scope.form);
        }
        $scope.showText = function (text1, text2) {
            return text1 + ' ' + text2;
        }
        $scope.scopeMessage = "default text";
        var changeCount = 0;


        $http.get("/data/product").
            success(function (data, status, headers, config) {
                $scope.product = data;
            }).
            error(function (data, status, headers, config) {
                console.log('error' + headers)
            });

        $scope.pushDuplicateCheck = function () {
            var arr = $scope.course_medicine;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                console.log(idsSeen[id]);
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
        $scope.deleteById = function (id) {
            $scope.course_medicine = $scope.course_medicine
                .filter(function (el) {
                    return el.product_id !== id;
                });
            console.log(id);
            var url = "/course/medicine-remove?course_id=" + $scope.course_id + "&product_id=" + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    console.log($scope.course_medicine);
                }).
                error(function (data, status, headers, config) {
                    console.log('error' + headers)
                });


        }
    });
    app.controller('salesController', function ($scope, $http, ngTableParams,$modal) {
        $scope.product = [];
        $scope.customer = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.cashInput = 0;
        $scope.CashTotal = 0;
        $scope.SaleBoxSearch = false;
        $scope.vat = 7;
        $scope.vatType = null;        $scope.controller = '/sales'
        $scope.paymentType = "cash"
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                console.log($scope.product);
                $scope.dataLoading = false;

                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });

        $http.get($scope.controller + '/datacustomer').
            success(function (data, status, headers, config) {
                if (data.status == 'success') {
                    $scope.customer.fullname = data.cus_name;
                    $scope.customer.tel = data.tel;
                    $scope.customer.cus_id = data.cus_id;
                    $scope.boxSearch = true;
                    console.log('update customer success');
                }
            }).
            error(function (data, status, headers, config) {

            });
        $scope.init = function(vat_type,vat){
            $scope.vatType = vat_type;
            $scope.setVat(vat);

        }
        $scope.customerSelect = function (customer) {
            $scope.customer.fullname = customer.cus_name;
            $scope.customer.tel = customer.cus_tel;
            $scope.customer.cus_id = customer.cus_id;
            $scope.dataLoading = true;
            console.log(customer)
            $http.get($scope.controller + '/setcustomer?id=' + customer.cus_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)

                });
            $scope.$apply(function () {
                $scope.boxSearch = true;
            });
        }
        $scope.pushProduct = function (product) {
            $scope.clearSearch();

            $scope.product.push(product);
            //$scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }
        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/addproduct?id=' + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.save = function () {
            if ($scope.product.length == 0) {
                alert("ยังไม่มีการเพิ่มสินค้า");
            }
            else {
                $scope.open();
            }
        }
        $scope.deleteById = function (id) {
            console.log($scope.product);
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get($scope.controller + '/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                //console.log(product);
                $scope.total += parseInt(product.sales_de_price * product.sales_de_qty);
            }

            return $scope.total;
        }
        $scope.getDiscount = function () {
            $scope.discout = 0.0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.discout += ((product.sales_de_price * product.sales_de_discount / 100) + parseInt(product.sales_de_disamount))*product.sales_de_qty;
            }
            return $scope.discout;
        }
        $scope.getFinalPrice = function () {
            if($scope.vatType == 'false'){
                $scope.finalPrice = $scope.getTotal()-$scope.getDiscount();
            }else if($scope.vatType == 'true'){
                $scope.finalPrice = ($scope.getTotal() - $scope.getDiscount()) + $scope.getVat();
            }
            console.log($scope.finalPrice);
            return $scope.finalPrice;
        }
        $scope.setVat = function (vat) {
            $scope.vat = vat;
        }
        $scope.stringToInt =function(string){
            return parseInt(string)
        }
        $scope.getVat = function () {
            return ($scope.getTotal()-$scope.getDiscount()) * $scope.vat / 100;
        }
        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
        $scope.cashAdd = function (cash) {
            $scope.cashInput += cash;
        }
        $scope.open = function (size) {

            $scope.modalInstance = $modal.open({
                animation: $scope.animationsEnabled,
                templateUrl: 'payment.html',
                controller: 'salesController',
                size: size,
                scope: $scope

            });

            $scope.modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
            });
        };

        $scope.cancel = function () {
            $scope.modalInstance.dismiss();
        };

        $scope.payment = function () {
            window.location.href = '/quotations/save';
        }
        $scope.paymentAndPrint = function (id) {
            /*window.open(
                '/bill/billproduct?sales_id=' + id,
                '_blank' // <- This is what makes it open in a new window.
            );*/
            window.location.href = 'payment/sale-pay?sale_id='+id+'&type='+$scope.paymentType;
        }
    });
    app.controller('receiveController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.receive = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/receive'
        $scope.warehouse = [];
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.warehouseChange = function(id){
            console.log(id);

            /*$http.get($scope.controller + '/warehouse?id=' + $scope.warehouse.id ).
                success(function (data, status, headers, config) {
                    console.log('Warehouse Changed');
                }).
                error(function (data, status, headers, config) {
                });*/
        }
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];
        $scope.open = function ($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                $scope.dataLoading = false;
                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });

        $http.get($scope.controller + '/datacustomer').
            success(function (data, status, headers, config) {
                if (data.status == -1) {
                    console.log('Receive vendor null');
                    $scope.boxSearch = false;

                }
                else {
                    $scope.vendor = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {

            });

        $scope.customerSelect = function (customer) {
            $scope.vendor = customer;
            $scope.dataLoading = true;
            $http.get($scope.controller + '/setcustomer?id=' + customer.ven_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)

                });
            $scope.$apply(function () {
                $scope.boxSearch = true;
            });
        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/addproduct?id=' + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            console.log($scope.product);
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get($scope.controller + '/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getDiscount = function () {
            $scope.discout = 0.0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.discout += parseInt((product.receive_de_price *  product.receive_de_discount  / 100)) + parseInt(product.receive_de_disamount);
            }
            return $scope.discout;
        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.total += parseInt(product.receive_de_price)
            }
            return $scope.total;
        }
        $scope.getFinalTotal = function () {
            /*if($scope.vatType == 'false'){
                return $scope.getTotal()-$scope.getDiscount();
            }else if($scope.vatType == 'true'){
                return ($scope.getTotal()-$scope.getDiscount()) + $scope.getVat();
            }*/
            return $scope.getTotal()-$scope.getDiscount();

        }

        $scope.getOrderData = function (id) {
            window.location.href = '/receive/orderdata?id=' + id;

        }
        $scope.init = function (vat_mode,vat) {
            $scope.vat_mode = vat_mode;
            $scope.vat = vat;
        }
        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat / 100;
        }
        $scope.save = function(e)
        {
            if ($scope.product.length == 0) {
                alert("ยังไม่เพิ่มข้อมูลสินค้า");
                e.preventDefault();
            }

        }
        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
    });
    app.controller('receiveRequestController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.receive = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/receive-request'
        $scope.warehouse = [];
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.warehouseChange = function(id){
            console.log(id);

            /*$http.get($scope.controller + '/warehouse?id=' + $scope.warehouse.id ).
             success(function (data, status, headers, config) {
             console.log('Warehouse Changed');
             }).
             error(function (data, status, headers, config) {
             });*/
        }
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];
        $scope.open = function ($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                $scope.dataLoading = false;
                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });

        $http.get($scope.controller + '/datacustomer').
            success(function (data, status, headers, config) {
                if (data.status == -1) {
                    console.log('Receive vendor null');
                    $scope.boxSearch = false;

                }
                else {
                    $scope.vendor = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {

            });

        $scope.customerSelect = function (customer) {
            $scope.vendor = customer;
            $scope.dataLoading = true;
            $http.get($scope.controller + '/setcustomer?id=' + customer.ven_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)

                });
            $scope.$apply(function () {
                $scope.boxSearch = true;
            });
        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/addproduct?id=' + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            console.log($scope.product);
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get($scope.controller + '/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getDiscount = function () {
            $scope.discout = 0.0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.discout += parseInt((product.receive_de_price *  product.receive_de_discount  / 100)) + parseInt(product.receive_de_disamount);
            }
            return $scope.discout;
        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                $scope.total += parseInt(product.receive_de_price)
            }
            return $scope.total;
        }
        $scope.getFinalTotal = function () {
            /*if($scope.vatType == 'false'){
             return $scope.getTotal()-$scope.getDiscount();
             }else if($scope.vatType == 'true'){
             return ($scope.getTotal()-$scope.getDiscount()) + $scope.getVat();
             }*/
            return $scope.getTotal()-$scope.getDiscount();

        }

        $scope.getOrderData = function (id) {
            window.location.href = $scope.controller+'/orderdata?id=' + id;

        }
        $scope.init = function (vat_mode,vat) {
            $scope.vat_mode = vat_mode;
            $scope.vat = vat;
        }
        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat / 100;
        }
        $scope.save = function(e)
        {
            if ($scope.product.length == 0) {
                alert("ยังไม่เพิ่มข้อมูลสินค้า");
                e.preventDefault();
            }

        }
        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].product_id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
    });
    app.controller('returnController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.return = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/return'

        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];
        $scope.open = function ($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                $scope.dataLoading = false;
                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });

        $http.get($scope.controller + '/datacustomer').
            success(function (data, status, headers, config) {
                if (data.status == -1) {
                    console.log('return vendor null');
                    $scope.boxSearch = false;

                }
                else {
                    $scope.vendor = data;
                    $scope.boxSearch = true;
                }
            }).
            error(function (data, status, headers, config) {

            });

        $scope.customerSelect = function (customer) {
            $scope.vendor = customer;
            $scope.dataLoading = true;
            $http.get($scope.controller + '/setcustomer?id=' + customer.ven_id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    console.log('error' + headers)

                });
            $scope.$apply(function () {
                $scope.boxSearch = true;
            });
        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/addproduct?id=' + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            console.log($scope.product);
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get($scope.controller + '/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                var receive = $scope.return[i];
                //console.log(product);
                $scope.total += parseInt((product.return_de_qty * product.return_de_price) -
                    ((product.return_de_price * product.return_de_qty) * product.return_de_discount / 100)
                    - product.return_de_disamount);
            }
            return $scope.total;
        }
        $scope.getReceiveData = function (id) {
            window.location.href = '/return/receivedata?id=' + id;

        }
        $scope.setVat = function (vat) {
            $scope.vat = vat;
        }
        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat / 100;
        }
        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
    });
    app.controller('returntostockController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.return = [];
        $scope.return_detail = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.controller = '/returntostock'
        $scope.warehouse = [];
        $scope.warehouse.id = 0;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];
        $http.get($scope.controller + '/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
                $scope.dataLoading = false;
                $scope.tableParams.reload();
            }).error(function (data, status, headers, config) {
                $scope.dataLoading = false;

            });

        $scope.warehouseChange = function(){
            $http.get($scope.controller + '/warehouse?id=' + $scope.warehouse.id ).
                success(function (data, status, headers, config) {
                    console.log('Warehouse Changed');
                }).
                error(function (data, status, headers, config) {
                });
        }

        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.product.product_id);
            console.log($scope.product);
            // $scope.clearAndReload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.productSearchBox = ""
        }
        $scope.update = function (type, product_id, value) {
            $scope.dataLoading = true;

            var url = $scope.controller + '/update?id=' + product_id + '&type=' + type + '&value=' + value;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            var url = $scope.controller + '/addproduct?id=' + id;
            console.log(url);
            $http.get(url).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                    $scope.tableParams.reload();

                });
        }
        $scope.deleteById = function (id) {
            console.log($scope.product);
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.product_id !== id;
                });
            $scope.dataLoading = true;
            $http.get($scope.controller + '/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

        }
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                var receive = $scope.return[i];
                //console.log(product);
                $scope.total += parseInt((product.return_de_qty * product.return_de_price) -
                    ((product.return_de_price * product.return_de_qty) * product.return_de_discount / 100)
                    - product.return_de_disamount);
            }
            return $scope.total;
        }

        $scope.pushDuplicateCheck = function () {
            var arr = $scope.product;
            var results = [];
            var idsSeen = {}, idSeenValue = {};
            for (var i = 0, len = arr.length, id; i < len; ++i) {
                id = arr[i].id;
                if (idsSeen[id] !== idSeenValue) {
                    results.push(arr[i]);
                    idsSeen[id] = idSeenValue;
                }
            }
            return results;
        }
        $scope.save = function (id) {
            if ($scope.product.length == 0) {
                alert("ยังไม่มีการเลือกสินค้า");
            }
            else {
                // window.open(
                //    '/bill/request?order_id=' + id,
                //    '_blank' // <- This is what makes it open in a new window.
                //);
                window.location.href = '/returntostock/save';
            }
        }
    });
    app.controller('treatmentAddController', function ($scope,$http,ngTableParams) {
        $scope.treat_has_medicine = [];
        $scope.medicine = {};
        $scope.qtyValue = 0;
        $scope.jsonData = undefined;
        $scope.course_medicine =[];
        $scope.product_out_stock_can_treat = null;
        $scope.payment_remain = null;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })

        $scope.init = function( courseId,product_out_stock_can_treat,payment_remain){
            $scope.product_out_stock_can_treat=product_out_stock_can_treat;
            $scope.payment_remain = parseInt(payment_remain);
            //console.log($scope.payment_remain + payment_remain);

            $http.get('/treatment/medicine-remain?courseId='+courseId).
                success(function (data, status, headers, config) {
                    $scope.course_medicine = data;
                }).error(function (data, status, headers, config) {
                });
        }

        $http.get('/treatment/product-list').
            success(function (data, status, headers, config) {
                $scope.product = data;
            }).error(function (data, status, headers, config) {
            });
        $scope.addMedicine = function(){
            $scope.course_medicine.push($scope.medicine.selected);
        }
        $scope.deleteById = function (id) {
           // console.log($scope.product);
            $scope.course_medicine = $scope.course_medicine
                .filter(function (el) {
                    return el.p_id !== id;
                });
            $scope.tableParams.reload();

        }
        $scope.outOfStock = function(){
            var arrayLength = $scope.course_medicine.length;
            var remain = null;
            for (var i = 0; i < arrayLength; i++) {

                if($scope.course_medicine[i].remain == null || $scope.course_medicine[i].remain <=0  ){
                    return true;
                }
                else if($scope.course_medicine[i].remain < $scope.course_medicine[i].qty){
                    return true;
                }
            }

        }
        $scope.save = function (e) {
            console.log(e);
            console.log($scope.bt1);

            if (typeof $scope.dr === 'undefined' && typeof $scope.bt1 === 'undefined' && typeof $scope.bt2 === 'undefined') {
                alert("ยังไม่มีการเลือกพนักงานที่เกี่ยวข้อง");
                e.preventDefault();
            }

        }

    });
    app.controller('paymentController', function ($scope,$modal) {
        $scope.payment = [];
        $scope.box = [];
        $scope.vat_rate = null;
        $scope.vat = 7;
        $scope.quo_id = null;
        $scope.vat_amount = 0;
        $scope.data = [];

        var that = this;

        this.isOpen = false;

        this.openCalendar = function(e) {
            e.preventDefault();
            e.stopPropagation();

            that.isOpen = true;
        };

        $scope.paymentMethod = function () {
            $scope.payment.buttonPay = true;
                 console.log($scope.payment.boxMethod);
            if ($scope.payment.boxMethod == "PAID_IN_FULL") {
                $scope.payment.boxPaidFull = true;

                $scope.payment.received_amount = 0;
                if($scope.vat == 'true') {
                    $scope.vat_amount = $scope.course.price * $scope.vat_rate / 100;
                }
                $scope.payment.minPrice = $scope.course.price + $scope.vat_amount ;

            }
            if ($scope.payment.boxMethod == "PAYABLE") {
            }
            if ($scope.payment.boxMethod == "PAY_BY_COURSE") {
                $scope.payment.boxPaidFull = true;

                if($scope.vat == 'true'){
                    $scope.vat_amount = ($scope.course.price / $scope.course.qty) * $scope.vat_rate /100
                }
                $scope.payment.minPrice = ($scope.course.price / $scope.course.qty ) + $scope.vat_amount ;
            }

        }
        $scope.init = function (value, vat,vat_rate, quo_id, courseId, qty, pay_by_course,quo_de_id) {
            $scope.payment = [];
            $scope.box = [];
            $scope.course = [];
            $scope.course.qty = qty;
            $scope.course.price = value;
            $scope.box.Show = false;
            $scope.payment.boxPaidMethod = true;
            $scope.quo_id = quo_id;
            $scope.payment.creditCardBox = false;
            console.log(value);
            $scope.vat = vat;
            $scope.quo_de_id = quo_de_id;
            $scope.vat_rate = vat_rate;
            $scope.pay_by_course = pay_by_course;
            // Vat นอก
            // $scope.payment[index].paymentTotal = (value * (100 + $scope.vat))/100;
            //Vat ใน
            $scope.payment.paymentTotal = value;
            $scope.payment.course_id = courseId;



        }
        $scope.changeType = function () {
            console.log($scope.payment.type);
            if ($scope.payment.type == "credit_card") {
                $scope.payment.creditCardBox = true;
            } else {
                $scope.payment.creditCardBox = false;
            }
            if ($scope.payment.type == "transfer") {
                $scope.payment.boxTransfer = true;
            } else {
                $scope.payment.boxTransfer = false;
            }
        }
        $scope.receiveChange = function () {
            if ($scope.payment.receivedAmount >= 0) {
                $scope.payment.withdawn = $scope.payment.minPrice - $scope.payment.receivedAmount;
                if ($scope.payment.receivedAmount >= $scope.payment.minPrice) {
                    $scope.payment.buttonPay = false;
                } else {
                    $scope.payment.buttonPay = true;

                }
            }
        };
        $scope.saveFullPaidPayment = function() {
            /*window.open(
                '/bill/bill?quo_de_id=' + $scope.quo_de_id,
                '_blank' // <- This is what makes it open in a new window.
            );*/
        }
        $scope.open = function (sales_id) {
        $scope.modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: '/payment/detail/?id='+sales_id,
            controller: 'paymentController',
            scope: $scope

        });
        $scope.modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
        });
        };
        $scope.cancel = function () {
            $scope.modalInstance.dismiss();
        };

    });
    app.controller('paymentIndexController', function ($scope) {


    });
    app.controller('printBillController', function ($scope) {
        $scope.print = function(){
            setTimeout(function () {
                location.reload()
            }, 300);        }

    });
    app.controller('newPaymentController', function ($scope) {
        $scope.product = [];
        $scope.payment = [];
        $scope.payment.receivedAmount = 0;
        $scope.payment.type = 'cash';
        $scope.init = function(id,paymentType,remain,type,netPrice,qty){
            var data= [];
            data['id'] = id;
            data['type'] = type;
            data['remain'] = remain;
            data['netPrice'] = netPrice;
            data['paymentPrice'] = remain;
            data['selected'] = true;
            data['paymentType'] = paymentType;
            if(type == "course" ){
                data['minPayment'] = netPrice / qty;
            }

            $scope.product.push(data);

        }
        $scope.changePayType = function (index) {
            console.log($scope.product[index].paymentType );
            if ($scope.product[index].paymentType == "payByQty") {
                $scope.product[index].paymentPrice = $scope.product[index].minPayment;
            }

        }
        $scope.changeType = function () {
            console.log($scope.payment.type);
            if ($scope.payment.type == "credit_card") {
                $scope.payment.creditCardBox = true;
            } else {
                $scope.payment.creditCardBox = false;
            }
            if ($scope.payment.type == "transfer") {
                $scope.payment.boxTransfer = true;
            } else {
                $scope.payment.boxTransfer = false;
            }
        }
        $scope.getTotalLength = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                if(product.selected == true){
                    $scope.total++;
                }
            }
            return $scope.total;
        }

        $scope.getWithdrawn = function () {
            return $scope.payment.receivedAmount - $scope.getTotal();
        };
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                if(product.selected == true){
                    $scope.total += parseInt(product.paymentPrice);
                }
            }
            return $scope.total;
        }



    });

})

();
