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
    <li><a href="#">巡店系统</a></li>
    <li class="active">评分配置</li>
</ul>
<!--评分配置-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                选择评分方案
                <a href="#" class="pull-right" ng-click="add()"><i class="fa fa-plus"></i> 新增</a>
            </div>
            <div class="panel-body">
                <div class="row score">
                    <div class="col-sm-6" ng-repeat="v in data">
                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="media-object" src="/Public/images/type.png" alt="媒体对象">
                            </a>
                            <div class="media-body">
                                <a href="<?php echo U('plugin');?>?id={{v.id}}" ng-bind="v.name"></a>
                                <div class="oper">
                                    <a href="#" ng-click="edit(v.name,v.id)"><i class="fa fa-pencil-square-o"></i> 编辑名称</a>
                                    <a href="#" ng-click="del(v.id,v)"><i class="fa fa-trash"></i> 删除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--修改名称-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">修改名称</h4>
            </div>
            <form class="form-horizontal" action="" method="post">
                <div class="modal-body">
                    <input type="hidden"  value="{{field.id}}" name="id" ng-if="field.id">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{field.name}}"  placeholder="门店名称" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    require(['underscore']);
    function controller($scope, $http, $filter) {
        $http.get("<?php echo U('get_project');?>").success(function (response) {
            $scope.data=response;
        });
        //新增
        $scope.add = function () {
            $('#myModal').modal('show');
        }
        //修改
        $scope.edit = function (data,id) {
            $scope.field={id:id,name:data};
            $('#myModal').modal('show');
        }
        //删除
        $scope.del=function (id,v) {
            $http.get("<?php echo U('del_project');?>",{params:{'id':id}}).success(function (data) {
                alert(data);
                $scope.data = _.without($scope.data, v);
            });
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