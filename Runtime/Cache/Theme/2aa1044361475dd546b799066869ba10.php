<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
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
<body ng-cloak class="ng-cloak" ng-controller="ctrl" style="padding:0 15px;">

<ul class="breadcrumb row navigation">
    <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Welcome</li>
</ul>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr><th colspan="4">服务器信息</th></tr>
            </thead>
            <tbody>
            <tr>
                <td>操作系统</td>
                <td><?php echo ($sysdata['system']); ?></td>
                <td>服务器时间</td>
                <td><?php echo ($sysdata['systemtime']); ?></td>
            </tr>
            <tr>
                <td>服务器IP地址</td>
                <td><?php echo ($sysdata['ip']); ?></td>
                <td>服务器端口</td>
                <td><?php echo ($sysdata['port']); ?></td>
            </tr>
            </tbody>
            <thead>
            <tr><th colspan="4">开发信息</th></tr>
            </thead>
            <tbody>
            <tr>
                <td>框架版本号</td>
                <td><?php echo (THINK_VERSION); ?></td>
                <td>浏览器</td>
                <td><?php echo ($sysdata['browser']); ?></td>
            </tr>
            <tr>
                <td>PHP版本号</td>
                <td><?php echo ($sysdata['sysversion']); ?></td>
                <td>Mysql版本号</td>
                <td><?php echo ($sysdata['mysqlinfo']); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
        require(['css!/Public/css/app.css']);
        require(['util','angular','jquery'],function (angualr,$) {
            angular.module('app', []).controller('ctrl', ['$scope', function ($scope) {

            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
</script>
</body>
</html>