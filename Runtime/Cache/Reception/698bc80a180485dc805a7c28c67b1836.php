<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>巡店</title>
    <link rel="stylesheet" href="/Public/css/reception.css">
    <script>
        //配置后台地址
        var app = {
            'base': '/Public/vendor',
        };
    </script>
    <script src="/Public/vendor/require.js"></script>
    <script src="/Public/vendor/config.js"></script>
    <style>
        .ng-cloak {
            display: none;
        }
    </style>
</head>
<body ng-cloak class="ng-cloak" ng-controller="ctrl">
<div class="container">
<ol class="breadcrumb row navigation">
    <li class="active">门店选择</li>
</ol>

<form role="form">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="请输入店铺编号" autocomplete="off" ng-model="num" style="text-transform:uppercase;" ng-change="myFunc(num)">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" ng-model="data.larea" ng-if="data.id" ng-disabled="data.id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" ng-model="data.sarea" ng-if="data.id" ng-disabled="data.id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" ng-model="data.name" ng-if="data.id" ng-disabled="data.id">
    </div>
    <div class="form-group">
        <select class="form-control" name="topL" ng-model="topL" ng-change="selectChange(topL);">
            <option value="">请选择评分配置</option>
            <?php if(is_array($larea)): foreach($larea as $key=>$v): ?><option value="<?php echo ($v); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary center-block">开始评估</button>
</form>
<p class="text-center text-muted">输入店铺编号自动带出店铺信息，该评估将保存至巡店计划</p>

<script>
    function controller($scope, $http, $filter) {
        $scope.num="";
        $scope.myFunc=function (num) {
            $http.get("<?php echo U('get_shopin');?>",{params:{number:num}}).success(function (data) {
                $scope.data=data;
                console.log(data);
            });
        }
    }
</script>
</div>
<script>
    require(['util','select2'],function () {
        require(['/Public/js/app.js', 'css!/Public/css/app.css']);
        require(['angular','jquery'],function (angualr,$) {
            m=angular.module('app', []);
            m.filter('trustHtml',['$sce',function($sce){
                return function(data){
                    return $sce.trustAsHtml(data);
                }
            }])
            m.controller('ctrl', ['$scope','$http','$filter', function ($scope,$http, $filter) {
                if (angular.isFunction(controller)) {
                    controller($scope,$http,$filter);
                }
            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
    })
</script>
</body>
</html>