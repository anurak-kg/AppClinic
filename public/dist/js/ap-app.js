(function () {
    'use strict'
    var app = angular.module('application', ['ngTable', 'ui.bootstrap', 'ngSanitize', 'ui.select'])
        .directive('onLastRepeat', function () {
            return function (scope, element, attrs) {
                if (scope.$last) setTimeout(function () {
                    scope.$emit('onRepeatLast', element, attrs);
                }, 1);
            };
        })
        .directive('datepicker', function () {
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
    app.controller('quotationsController', function ($scope, $http, ngTableParams, $modal) {
        $scope.product = [];
        $scope.customer = [];
        $scope.sale = [];
        $scope.quo_id = null;
        $scope.cashInput = 0;
        $scope.CashTotal = 0;
        $scope.dataLoading = false;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        //$scope.modalInstance = null;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.init = function (vat, quo_id) {
            $scope.quo_id = quo_id;
            $scope.Vat = vat;
        }
        $scope.getTotal = function () {
            var total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                total += parseInt(product.course.course_price);
            }

            return total;
        }

        $http.get('/quotations/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
            }).
            error(function (data, status, headers, config) {

            });

        $http.get('/quotations/data_customer').
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

        $scope.customerSelect = function (customer) {
            $scope.customer.fullname = customer.cus_name;
            $scope.customer.tel = customer.cus_tel;
            $scope.customer.cus_id = customer.cus_id;
            $scope.dataLoading = true;
            console.log(customer)
            $http.get('/quotations/set_customer?id=' + customer.cus_id).
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

        $http.get('/quotations/data_sale').
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
            $http.get('/quotations/set_sale?id=' + sale.id).
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
                $scope.open();
            }
        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.id);
            $scope.tableParams.reload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.courseSearchBox = ""
        }

        $scope.getAddProduct = function (id) {
            $scope.dataLoading = true;
            $http.get('/quotations/add?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                });
        }
        $scope.cashAdd = function (cash) {
            $scope.cashInput += cash;
        }
        $scope.update = function (item) {
            $scope.dataLoading = true;
            console.log(item);

            $http.get('/quotations/update?id=' + item.id + '&qty=' + item.qty + "&discount_price=" + item.discount_price).
                success(function (data, status, headers, config) {
                    //console.log(data)
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
        }
        $scope.getVat = function () {
            //console.log($scope.Vat );
            return $scope.getTotal() * $scope.Vat / 100;

        }

        $scope.deleteById = function (id) {
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.course_id !== id;
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
                id = arr[i].id;
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
        $scope.quo_id = null;
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.VendorBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/order'

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
        $scope.setVat = function (vat) {
            $scope.vat = vat;
        }
        $scope.getVat = function () {
            return $scope.getTotal() * $scope.vat / 100;
        }
        $scope.getTotal = function () {
            var total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                //console.log(product);
                total += parseInt(product.order_de_price * product.order_de_qty);
            }

            return total;
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

    });
    app.controller('SalesController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.customer = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/sales'

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
            $scope.product = $scope.pushDuplicateCheck();
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
                $scope.total += parseInt((product.sales_de_price * product.sales_de_qty) - ((product.sales_de_price * product.sales_de_qty) * product.sales_de_discount / 100) - product.sales_de_disamount);
            }

            return $scope.total;
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
    app.controller('receiveController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.receive = [];
        $scope.dataLoading = true;
        $scope.boxSearch = false;
        $scope.SaleBoxSearch = false;
        $scope.Vat = 7;
        $scope.controller = '/receive'

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
        $scope.getTotal = function () {
            $scope.total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                var receive = $scope.receive[i];
                //console.log(product);
                $scope.total += parseInt((product.receive_de_qty * product.receive_de_price) -
                    ((product.receive_de_price * product.receive_de_qty) * product.receive_de_discount / 100)
                    - product.receive_de_disamount);

            }
            $scope.setVat = function (vat) {
                $scope.vat = vat;
            }
            $scope.getVat = function () {
                return $scope.getTotal() * $scope.vat / 100;
            }
            return $scope.total;
        }
        $scope.getOrderData = function (id) {
            window.location.href = '/receive/orderdata?id=' + id;

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

})();
/**
 * Created by Anurak on 26/06/58.
 */
