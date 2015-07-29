<!DOCTYPE html>
<html ng-app="application">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="/js/app.js"></script>
    <script src="/dist/js/ap-app.js"></script>
    <link href="/css/all.css" rel="stylesheet" type="text/css"/>


</head>
<body>
<div class="row" ng-controller="courseController">
    <div class="form-group">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <label class="col-sm-3 control-label">Default</label>
        <div class="col-sm-6">
    <ui-select sortable="true" theme="select2" ng-model="course_medicine.selected" style="width: 345px;" title="Choose a person">
        <ui-select-match placeholder="เลือกหรือค้นหายาจากรายการ...">@{{$select.selected.product_name}}</ui-select-match>
        <ui-select-choices repeat="item in product | filter: $select.search">
            <p ng-bind-html="item.product_name | highlight: $select.search"></p>
        </ui-select-choices>
    </ui-select>

        </div>
    </div>

</div>
</body>
</html>