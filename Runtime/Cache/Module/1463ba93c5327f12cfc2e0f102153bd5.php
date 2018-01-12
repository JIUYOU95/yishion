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
    <li class="active">系统日志</li>
</ul>
<!--日志查询-->
<form class="form-inline search" role="form" action="<?php echo U('log');?>" method="post">
    <div class="form-group">
        <label for="name">查看指定用户的日志</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="请输入用户名" value="<?php echo ($name); ?>" autocomplete="off">
    </div>
    <button type="submit" class="btn btn-default">提交</button>
</form>
<!--显示日志-->
<table class="table table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th><input type="checkbox" ng-model="all"></th>
            <th>操作人</th>
            <th>行为</th>
            <th>时间</th>
            <th>IP</th>
        </tr>
    </thead>
    <tbody>
    <?php if(is_array($loglist["data"])): foreach($loglist["data"] as $key=>$v): ?><tr>
            <td><input type="checkbox" value="<?php echo ($v['id']); ?>" ng-checked="all" name='id'/></td>
            <td><?php echo ($v["uid"]); ?></td>
            <td><?php echo ($v["logtext"]); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$v["time"])); ?></td>
            <td><?php echo ($v["ip"]); ?></td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>
<input type="button" value='删除' class="btn btn-default" ng-click="del()">
<div class="page">
    <?php echo ($loglist["page"]); ?>
</div>
<script>
    function controller($scope, $http, $filter) {
        $scope.del=function () {
            var text="";
            $("input[name=id]").each(function(){
                if ($(this).prop("checked")) {
                    text += ","+$(this).val();
                }
            });
            $http.get("<?php echo U('alldel');?>",{params:{'id':text}}).success(function(data){
                if(data){
                    alert('日志删除成功');
                    window.location='/Module/Config/log';
                }else{
                    alert('日志删除失败');
                }
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