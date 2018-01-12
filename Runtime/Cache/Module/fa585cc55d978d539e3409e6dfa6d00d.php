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
    <li><a href="#">投票系统</a></li>
    <li class="active">设计师查看</li>
</ul>
<!--图片管理-->
<div class="row designer">
    <div class="col-sm-12">
        <form role="form">
            <div class="form-group">
                <label>投票批次</label>
                <select class="form-control" ng-model="num" ng-change="myFunc(num)">
                    <option value="">请选择批次</option>
                    <option ng-repeat="v in data track by $index">{{v}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>设计师</label>
                <select class="form-control" ng-model="des">
                    <option value="">请选择设计师</option>
                    <option ng-repeat="v in desi track by $index">{{v.designer}}</option>
                </select>
            </div>
            <button type="button" class="btn btn-default" ng-click="get(num,des)">查询</button>
        </form>
        <ul class="item">
            <li ng-repeat="v in list track by $index">
                <table class="table table-bordered table-condensed">
                    <tbody>
                    <tr>
                        <td>设计师</td>
                        <td>{{v.designer}}</td>
                    </tr>
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
                        <td>投票比例</td>
                        <td>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                     style="width:{{v.count}}%;">
                                    <span>{{v.count}}%</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>改善建议</td>
                        <td>
                            <textarea class="form-control" rows="3" ng-disabled="true">{{v.opin}}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </li>
        </ul>
    </div>
</div>

<script>
    function controller($scope, $http, $filter) {
        //获取投票批次
        $http.get("<?php echo U('get_pi');?>").success(function (data) {
            $scope.data=data;
        });
        //获取设计师
        $scope.myFunc=function (num) {
            $http.get("<?php echo U('get_designer');?>",{params:{desh:num}}).success(function (data) {
                $scope.desi=data;
                //console.log(data);
            });
        }
        //获取数据
        $scope.get=function (n,d) {
            if(n==undefined || d==undefined){
                alert('投票批次和设计师不能为空！');
                return false;
            }else{
                $http.get("<?php echo U('get_desit');?>",{params:{des:d,pi:n}}).success(function (data) {
                    $scope.list=data;
                    console.log(data);
                });
            }
        }
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