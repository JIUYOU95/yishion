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
    <li class="active">通讯录</li>
    <a href="<?php echo U('update');?>" class="btn btn-primary rightbut">通讯录更新</a>
</ul>
<div class="row">
    <div class="col-sm-12">
        <table class="table-bordered table-condensed mail">
            <tr>
                <td>搜索</td>
                <td>搜索</td>
            </tr>
            <tr>
                <td class="depa">
                    <ul ng-repeat="v in depa" style="height:680px;overflow-y:auto;">
                        <li ng-click="myVar=!myVar"><i ng-class="{true:'fa fa-minus', false: 'fa fa-plus'}[myVar]"></i>{{v.name}}</li>
                        <ul ng-show="myVar" ng-repeat="vo in v.child">
                            <li ng-click="su_myVar=!su_myVar"><i ng-class="{true:'fa fa-minus', false: 'fa fa-plus'}[su_myVar]"></i>{{vo.name}}</li>
                            <ul ng-show="su_myVar" ng-repeat="vz in vo.child">
                                <li>{{vz.name}}</li>
                            </ul>
                        </ul>
                    </ul>

                </td>
                <td>
                    <!--<table class="table table-bordered  table-hover table-container">-->
                        <!--<thead>-->
                            <!--<tr>-->
                                <!--<td>姓名</td>-->
                                <!--<td>性别</td>-->
                                <!--<td>职位</td>-->
                                <!--<td>手机</td>-->
                                <!--<td>邮箱</td>-->
                                <!--<td>状态</td>-->
                            <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody>-->
                            <!--<tr>-->
                                <!--<td>{{u.name}}</td>-->
                                <!--<td>{{u.gender}}</td>-->
                                <!--<td>{{u.position}}</td>-->
                                <!--<td>{{u.mobile}}</td>-->
                                <!--<td>{{u.email}}</td>-->
                                <!--<td>{{u.status}}</td>-->
                            <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                    <table class="layui-hide" id="table_user" lay-filter="user"></table>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    require(['layui'],function () {
        layui.config({
            dir: '/node_modules/hdjs/component/layui/',
            version: false,
            debug: false,
            base: ''
        });
        layui.use('table', function(){
            var table = layui.table;

            //方法级渲染
            table.render({
                elem: '#table_user',
                url: "<?php echo U('user');?>",
                cols: [[
                    {field:'name', title: '姓名', width:80, sort: true},
                    {field:'gender', title: '性别', width:80},
                    {field:'position', title: '职位', width:80, sort: true},
                    {field:'mobile', title: '手机', width:80},
                    {field:'email', title: '邮箱', width:177},
                    {field:'status', title: '状态', sort: true, width:80}
                ]],
                id: 'testReload',
                page: true,
                height: 680
            });

        });
    });

    function controller($scope,$http, $) {
        $http.get("<?php echo U('depa');?>").success(function (d) {
            $scope.depa=d;
        });
        $scope.myVar = false;
        $scope.su_myVar = false;
        //获取人员表
//        $http.get("<?php echo U('user');?>").success(function (u) {
//            $scope.user=u;
//        });
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