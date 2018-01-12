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
    <li class="active">办事处管理</li>
    <span class="btn btn-primary rightbut" ng-click="add()">新增办事处</span>
</ul>
<!--办事处显示列表-->
<div class="row">
    <div class="col-sm-12">
        <form action="<?php echo U('office_order');?>" method="post">
        <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th width="8%">排序</th>
                <th>办事处名称</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>

            <tr ng-repeat="v in data">
                <td style="padding:0;">
                    <input class="form-control order" type="text" name="{{v.id}}" value="{{v.sort}}" autocomplete="off">
                </td>
                <td>{{v.name}}</td>
                <td>
                    <a href="#" ng-click="edit(v.id,v.name,v.sort)">修改</a> |
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
                <h4 class="modal-title" id="myModalLabel" ng-bind="ed.id?'修改办事处':'新增办事处'"> </h4>
            </div>
            <form class="form-horizontal" action="<?php echo U('handle_office');?>" method="post">
                <input type="hidden" name="id" value="{{ed.id}}" ng-if="ed.id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">办事处</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="请输入办事处名称" autocomplete="off" required value="{{ed.name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sort" placeholder="排序" autocomplete="off" value="{{ed.sort}}" required >
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
        $http.get("<?php echo U('get_office');?>").success(function (data) {
            $scope.data=data;
        });
        //新增办事处
        $scope.add=function () {
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //菜单修改
        $scope.edit=function (id,name,sort) {
            $scope.ed={id:id,name:name,sort:sort};
            $('#myModal').modal('show');
        }

        //删除办事处
        $scope.del=function (v,id,name) {
            if(confirm('确定删除！')){
                $http.get("<?php echo U('delete_office');?>",{params:{'id':id,'name':name}}).success(function (data) {
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