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
    <li class="active">门店管理</li>
</ul>
<!--门店管理-->
<div class="row">
    <div class="col-sm-12">
        <!--搜索界面-->
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline" action="<?php echo U('store');?>" method="post">
                    <div class="form-group">
                        <select class="form-control js-example-theme-single" name="topL" ng-model="topL" ng-change="selectChange(topL);">
                            <option value="">请选择办事处</option>
                            <?php if(is_array($larea)): foreach($larea as $key=>$v): ?><option value="<?php echo ($v); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control js-example-theme-single" name="topS" ng-model="topS">
                            <option value="">请选择区域</option>
                            <option ng-repeat="sv in sub track by $index">{{sv}}</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="门店名称" name="name">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索</button>
                    <button type="button" class="btn btn-success" ng-click="add()"><i class="fa fa-plus"></i> 新增</button>
                    <button type="button" class="btn btn-info" ng-click="down()"><i class="fa fa-cloud-download"></i> Excel模板</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-cloud-upload"></i> Excel上传</button>
                </form>

            </div>
        </div>
        <!--end搜索界面-->
        <!--门店列表-->
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>店铺名称</th>
                    <th>店铺编号</th>
                    <th>办事处</th>
                    <th>区域</th>
                    <th>具体地址</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($data["data"])): foreach($data["data"] as $key=>$v): ?><tr>
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["shopnum"]); ?></td>
                    <td><?php echo ($v["larea"]); ?></td>
                    <td><?php echo ($v["sarea"]); ?></td>
                    <td><?php echo ($v["address"]); ?></td>
                    <td>
                        <?php if($v['status'] == 1): ?>营业中
                            <?php else: ?>
                            已关闭<?php endif; ?>
                    </td>
                    <td>
                        <a href="#" ng-click="edit_store(<?php echo ($v['id']); ?>)">编辑</a> |
                        <a href="<?php echo U('del_store',array('id'=>$v['id']));?>">删除</a>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="page">
            <?php echo ($data["page"]); ?>
        </div>
    </div>
</div>
<!--新增门店-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">门店操作</h4>
            </div>
            <form class="form-horizontal" action="<?php echo U('add_store');?>" method="post">
            <div class="modal-body">
                <input type="hidden" name="id" value="{{edit_data.id}}" ng-if="edit_data.id" />
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="门店名称" autocomplete="off" required value="{{edit_data.name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">大区</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="larea" placeholder="大区" autocomplete="off" required value="{{edit_data.larea}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">小区</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sarea" placeholder="小区" autocomplete="off" required value="{{edit_data.sarea}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">具体地址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" placeholder="具体地址" autocomplete="off" value="{{edit_data.address}}">
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
<!--上传文件-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">文件上传</h4>
            </div>
            <form role="form" action="<?php echo U('upload');?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="file"  id="file" name="exl">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary">上传</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
function controller($scope, $http, $filter) {

    $scope.topL='';
    $scope.topS='';
    //触发新增
    $scope.add = function(){
        $scope.edit_data="";
        $('#myModal').modal('show');
    }
    //触发修改
    $scope.edit_store=function (id) {
        $scope.edit_id=id;
        $http.get("<?php echo U('edit_store');?>",{params:{'id':id}}).success(function (data) {
            $scope.edit_data=data;
        });
        $('#myModal').modal('show');
    }
    $scope.down=function () {
        window.open("/Public/store_down.xlsx");
    }

    //二级联动菜单
    $scope.selectChange=function (topL) {
        $scope.topS='';
        $scope.sub='';
        $http.get("<?php echo U('get_sarea');?>",{params:{'topL':topL}}).success(function (response) {
            response=='null'?$scope.sub='':$scope.sub=response;
        },function error() {
            $scope.sub='';
        });
    }

    //下拉美化
    $(".js-example-theme-single").select2({
        theme: "classic",
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