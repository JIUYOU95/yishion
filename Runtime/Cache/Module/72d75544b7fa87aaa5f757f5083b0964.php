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
    <li><a href="<?php echo U('index');?>">投票列表</a></li>
    <li class="active">投票汇总表</li>
</ul>


<div class="row vote">
    <div class="col-sm-12">
        <h3 class="text-center"><?php echo ($name["title"]); ?></h3>
        <form class="form-inline search" role="form" action="<?php echo U('log');?>" method="post">
            <div class="form-group">
                <label for="name">请输入百分比</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="请输入百分比" value="" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <table class="table table-bordered table-condensed">
            <thead>
            <tr>
                <th width="10%">设计师</th>
                <th>总投票人</th>
                <th>总发起投票款</th>
                <th>其中达到<?php echo ($name["perc"]); ?>%为有效款</th>
                <th><?php echo ($name["perc"]); ?>%以下无效款<?php echo ($name["perc"]); ?>%为</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): foreach($data as $k=>$v): ?><tr>
                    <td><?php echo ($k); ?></td>
                    <td>
                        <?php if(is_array($v["sub"])): foreach($v["sub"] as $key=>$vo): ?><a href="#"><?php echo ($vo["user"]); ?> \</a><?php endforeach; endif; ?>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<script>
    function controller($scope, $http, $filter) {
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