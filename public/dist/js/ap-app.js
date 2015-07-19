(function () {
    'use strict'
    var app = angular.module('application', ['ngTable']);
    app.controller('quotationsController', function ($scope, $http, ngTableParams) {
        $scope.product = [];
        $scope.customer = [];

        $scope.dataLoading = false;
        $scope.boxSearch = false;
        $scope.tableParams = new ngTableParams({}, {
            data: $scope.product
        })
        $scope.getTotal = function () {
            var total = 0;
            for (var i = 0; i < $scope.product.length; i++) {
                var product = $scope.product[i];
                total += ((product.ProductSellPrice - product.discount_price) * product.qty);
            }
            return total;
        }

        $http.get('/quotations/data').
            success(function (data, status, headers, config) {
                $scope.product = data;
            }).
            error(function (data, status, headers, config) {
            });

        $scope.customerSelect = function (customer) {
            $scope.customer.fullname = customer.cus_name + ' ' + customer.cus_lastname;
            $scope.customer.tel = customer.cus_tel;

            console.info($scope.customer);
            $scope.$apply(function() {
                $scope.boxSearch = true;
            });
        }
        $scope.pushProduct = function (product) {
            $scope.product.push(product);
            $scope.product = $scope.pushDuplicateCheck();
            $scope.getAddProduct(product.id);
            $scope.tableParams.reload();
            $scope.clearSearch();
        }
        $scope.clearSearch = function () {
            $scope.searchBarcode = ""
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

        $scope.update = function (item) {
            $scope.dataLoading = true;
            console.log(item);

            $http.get('/course_detail/update?id=' + item.id + '&qty=' + item.qty + "&discount_price=" + item.discount_price).
                success(function (data, status, headers, config) {
                    //console.log(data)
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
        }
        $scope.deleteById = function (id) {
            $scope.product = $scope.product
                .filter(function (el) {
                    return el.id !== id;
                });
            $scope.dataLoading = true;
            $http.get('/pos/delete?id=' + id).
                success(function (data, status, headers, config) {
                    $scope.dataLoading = false;
                }).
                error(function (data, status, headers, config) {
                    console.log(status)
                    $scope.dataLoading = false;
                });
            $scope.tableParams.reload();

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
