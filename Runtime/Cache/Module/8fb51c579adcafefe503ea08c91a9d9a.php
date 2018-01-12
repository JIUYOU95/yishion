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
    <li><a href="<?php echo U('./Theme/welcome');?>"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">权限控制</a></li>
    <li class="active">权限列表</li>
    <span class="btn btn-primary rightbut" ng-click="add()">新增权限</span>
</ul>
<!--权限列表-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>权限名</th>
                <th>权限</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="v in data">
                <td ng-bind-html="v._name | trustHtml"></td>
                <td>{{v.name}}</td>
                <td>
                    <a href="#" ng-click="add_sub(v.id)">添加子权限</a> |
                    <a href="#" ng-click="edit(v.id,v.name,v.title)">修改</a> |
                    <a href="#" ng-click="del(v,v.id,v.title)">删除</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!--权限新增修改-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel" ng-bind="ed.id?'修改权限':'新增权限'"> </h4>
            </div>
            <form class="form-horizontal" action="<?php echo U('handle_rule');?>" method="post">
                <input type="hidden" name="id" value="{{ed.id}}" ng-if="ed.id">
                <input type="hidden" name="pid" value="{{pid}}" ng-if="pid">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">权限名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" placeholder="请输入权限名" autocomplete="off" value="{{ed.title}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">权限</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="模块/控制器/方法 例如 Admin/Rule/index" autocomplete="off" value="{{ed.name}}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">提交更改</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    require(['underscore']);
    function controller($scope, $http, $filter) {
        //获取权限列表
        $http.get("<?php echo U('get_rule');?>").success(function (data) {
            $scope.data=data;
        });
        //新增父级权限
        $scope.add=function () {
            $scope.pid='0';
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //新增子权限
        $scope.add_sub=function (pid) {
            $scope.pid=pid;
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //权限修改
        $scope.edit=function (id,name,title) {
            $scope.ed={id:id,name:name,title:title};
            $('#myModal').modal('show');
        }
        //删除菜单
        $scope.del=function (v,id,title) {
            if(confirm('确定删除！')){
                $http.get("<?php echo U('delete_rule');?>",{params:{'id':id,'title':title}}).success(function (data) {
                    alert(data);
                    $scope.data = _.without($scope.data, v);
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