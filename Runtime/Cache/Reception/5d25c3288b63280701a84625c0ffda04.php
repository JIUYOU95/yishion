<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>快单投票</title>
    <link rel="stylesheet" href="/Public/css/vote.css">
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
    <div class="row vote">
        <div class="bg-primary text-center head">
            以纯集团营销总部快单问卷系统
        </div>
        <form role="form">
            <div class="container centent">
                <h3 class="text-center"><?php echo ($data["title"]); ?></h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label>办事处</label>
                            <select class="form-control" ng-disabled="true">
                                <option ng-repeat="v in data track by $index" ng-selected="reud.office_id==v.name">{{v.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>名字</label>
                            <input type="text" class="form-control" ng-model="reud.user" ng-disabled="true">
                        </div>
                    </div>
                </div>
                <ul class="item">
                    <li ng-repeat="v in item track by $index">
                        <table class="table table-bordered table-condensed">
                            <tbody>
                            <tr>
                                <td>系列</td>
                                <td>{{v.series}}</td>
                            </tr>
                            <tr>
                                <td>性别</td>
                                <td>{{v.sex}}</td>
                            </tr>
                            <tr>
                                <td>颜色</td>
                                <td>{{v.colour}}</td>
                            </tr>
                            <tr>
                                <td>版型描述</td>
                                <td>{{v.descd}}</td>
                            </tr>
                            <tr>
                                <td>投票号：{{v.vote_id}}</td>
                                <td>
                                    <img ng-src="/Upload/vote/{{v.picture}}">
                                </td>
                            </tr>
                            <tr>
                                <td>投票</td>
                                <td>
                                    <label class="radio-inline">
                                        <input type="radio" ng-value="1" ng-model="reud.sub[v.id]" ng-disabled="true"> 赞成
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-value="2" ng-model="reud.sub[v.id]" ng-disabled="true"> 不赞成
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>改善建议</td>
                                <td>
                                    <textarea class="form-control" rows="3" ng-disabled="true">{{reud.sub['v'+v.id]}}</textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </li>
                </ul>
            </div>
        </form>
        <div class="bg-primary text-center foot">
            YISHION内部问卷调查
        </div>
    </div>
</div>

<script>
    require(['util'],function () {
        require(['angular','jquery'],function (angualr,$) {
            m=angular.module('app', []);
            m.filter('trustHtml',['$sce',function($sce){
                return function(data){
                    return $sce.trustAsHtml(data);
                }
            }])
            m.controller('ctrl', ['$scope','$http','$filter', function ($scope,$http, $filter) {
                //获取办事处列表
                $http.get("<?php echo U('get_office');?>").success(function (data) {
                    $scope.data=data;
                });
                //获取投票列表
                $scope.preid="<?php echo ($data["preid"]); ?>";
                $scope.uid="<?php echo ($data["uid"]); ?>";
                $http.get("<?php echo U('get_item');?>",{params:{'pid':$scope.preid,'uid':$scope.uid}}).success(function (v) {
                    $scope.item=v;
                });
                //获取投票结果
                $scope.id="<?php echo ($ud["id"]); ?>";
                $scope.user="<?php echo ($ud["uid"]); ?>";
                $http.get("<?php echo U('get_result');?>",{params:{'id':$scope.id,'uid':$scope.user}}).success(function (v) {
                    console.log(v);
                    $scope.reud=v;
                });

            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
    })
</script>
</body>
</html>