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
    <li class="active">微信配置</li>
</ul>
<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading">数据设置</header>
            <form class="form-horizontal" role="form" action="" method="post">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">corpid</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-model="field.corpid">
                        </div>
                    </div>
                    <div class="panel panel-default" ng-repeat="vo in field.mail">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">通讯录Secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="vo.mailsecret">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--应用配置-->
                    <div class="panel panel-default" ng-repeat="v in field.sub">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">应用agentid</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="v.app_agentid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">应用Secret</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="v.app_secret">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">应用描述</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" ng-model="v.app_content">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end应用配置-->
                    <input type="hidden" name="wechat" value="{{field}}" />
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">保存</button>
                            <!--<button type="button" class="btn btn-default" ng-click="addSubButton(v)">新增应用</button>-->
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    function controller($scope, $http, $filter) {
        $http.get("<?php echo U('get_wset');?>").success(function (data) {
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