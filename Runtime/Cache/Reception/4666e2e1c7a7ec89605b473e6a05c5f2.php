<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>信息提示</title>
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
    <div class="msg">
        <?php if($vid == 4): ?><i class="fa fa-check-circle"></i>
        <?php else: ?>
            <i class="fa fa-info-circle"></i><?php endif; ?>
        <span>
            <?php if($vid == 1): ?>投票不存在
            <?php elseif($vid == 2): ?>
                投票未发布
            <?php elseif($vid == 3): ?>
                投票时间已结束
            <?php elseif($vid == 4): ?>
                投票成功
            <?php elseif($vid == 5): ?>
                投票失败
            <?php elseif($vid == 6): ?>
                此用户未投票<?php endif; ?>
        </span>
        <?php if($vid == 4): ?><a href="<?php echo U('user',array('id'=>$s['id'],'uid'=>$s['uid']));?>" class="btn btn-success">查看投票</a><?php endif; ?>

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

            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
    })
</script>
</body>
</html>