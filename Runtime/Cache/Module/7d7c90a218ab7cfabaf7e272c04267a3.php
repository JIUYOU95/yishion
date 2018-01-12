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
    <li><a href="#">系统设置</a></li>
    <li class="active">菜单管理</li>
    <span class="btn btn-primary rightbut" ng-click="add()">新增菜单</span>
</ul>
<!--菜单显示列表-->
<div class="row">
    <div class="col-sm-12">
        <form action="<?php echo U('nav_order');?>" method="post">
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th width="8%">排序</th>
                    <th>菜单名</th>
                    <th>连接</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                <tr ng-repeat="v in data">
                    <td style="padding:0;"><input class="form-control order" type="text" name="{{v.id}}" value="{{v.order_number}}" autocomplete="off"></td>
                    <td ng-bind-html="v._name | trustHtml"></td>
                    <td>{{v.mca}}</td>
                    <td>
                        <a href="#" ng-click="add_sub(v.id)">添加子菜单</a> |
                        <a href="#" ng-click="edit(v.id,v.name,v.mca,v.ico)">修改</a> |
                        <a href="#" ng-click="del(v,v.id,v.name)">删除</a>
                    </td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"><input class="btn btn-success" type="submit" value="排序"></td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>

<!--新增,修改菜单-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel" ng-bind="ed.id?'修改菜单':'新增菜单'"> </h4>
            </div>
            <form class="form-horizontal" action="<?php echo U('handle_nav');?>" method="post">
                <input type="hidden" name="id" value="{{ed.id}}" ng-if="ed.id">
                <input type="hidden" name="pid" value="{{pid}}" ng-if="pid">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">菜单名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="请输入菜单名" autocomplete="off" required value="{{ed.name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">链接</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="mca" placeholder="模块/控制器/方法 例如 Admin/Nav/index" autocomplete="off" value="{{ed.mca}}" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ico" class="col-sm-2 control-label">图标</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ico" name="ico" placeholder="font-awesome图标 输入fa fa- 后边的即可" autocomplete="off" value="{{ed.ico}}">
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
        //获取菜单列表
        $http.get("<?php echo U('get_nav');?>").success(function (data) {
            $scope.data=data;
        });
        //新增父级菜单
        $scope.add=function () {
            $scope.pid='0';
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //新增子菜单
        $scope.add_sub=function (pid) {
            $scope.pid=pid;
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //菜单修改
        $scope.edit=function (id,name,mca,ico) {
            $scope.ed={id:id,name:name,mca:mca,ico:ico};
            $('#myModal').modal('show');
        }
        //删除菜单
        $scope.del=function (v,id,name) {
            if(confirm('确定删除！')){
                $http.get("<?php echo U('delete_nav');?>",{params:{'id':id,'name':name}}).success(function (data) {
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