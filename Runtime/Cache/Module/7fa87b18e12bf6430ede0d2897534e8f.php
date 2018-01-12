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
    <li class="active">比例查看</li>
    <a href="<?php echo U('scaling_export',array('id'=>$name['id']));?>" class="btn btn-primary rightbut">导出Excel</a>
</ul>
<div class="row">
    <div class="col-sm-12">
        <h3 class="text-center"><?php echo ($name["title"]); ?></h3>
        <table class="table table-bordered table-condensed vote_img">
            <thead>
            <tr>
                <th>设计师</th>
                <th>系列</th>
                <th>颜色</th>
                <th>性别</th>
                <th>投票号</th>
                <th>图片</th>
                <th>总</th>
                <th>赞成</th>
                <th>不赞成</th>
                <th>投票比例</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($item)): foreach($item as $key=>$v): ?><tr>
                    <td><?php echo ($v["designer"]); ?></td>
                    <td><?php echo ($v["series"]); ?></td>
                    <td><?php echo ($v["colour"]); ?></td>
                    <td><?php echo ($v["sex"]); ?></td>
                    <td><?php echo ($v["vote_id"]); ?></td>
                    <td class="img"><img src="/Upload/vote/<?php echo ($v["picture"]); ?>"></td>
                    <td><?php echo ($name["count"]); ?></td>
                    <td><?php echo ($v["count"]); ?></td>
                    <td><?php echo ($v["uncount"]); ?></td>
                    <td>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                 style="width:<?php echo ($v["pro"]); ?>%;">
                                <span><?php echo ($v["pro"]); ?>%</span>
                            </div>
                        </div>
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