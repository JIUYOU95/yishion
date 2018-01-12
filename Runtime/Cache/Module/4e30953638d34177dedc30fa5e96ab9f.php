<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
<body ng-cloak class="ng-cloak" ng-controller="ctrl" style="
        padding:0 15px;">


<ul class="breadcrumb row navigation">
    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">系统设置</li>
</ul>
<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading">数据设置</header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">网站名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-model="field.webname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">备案号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-model="field.icp">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">日志操作</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" ng-model="field.log_status" ng-value="1"> 开启
                            </label>
                            <label class="radio-inline">
                                <input type="radio" ng-model="field.log_status" ng-value="0"> 关闭
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">管理员电话</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-model="field.tel">
                        </div>
                    </div>
                    <input type="hidden" name="system" value="{{field}}" />
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
    function controller($scope, $http, $filter) {
        $http.get("<?php echo U('get_set');?>").success(function (data) {
            $scope.field=data;
        });
    }
</script>
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