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
    <li class="active">明细查看</li>
    <a href="<?php echo U('detailed_export',array('id'=>$name['id']));?>" class="btn btn-primary rightbut">导出Excel</a>
</ul>
<div class="row">
    <div class="col-sm-12">
        <h3 class="text-center"><?php echo ($name["title"]); ?></h3>
        <table class="table table-bordered table-condensed vote_img">
            <thead>
            <tr>
                <th>设计师</th>
                <th>办事处</th>
                <th>投票人</th>
                <th>系列</th>
                <th>颜色</th>
                <th>性别</th>
                <th>投票号</th>
                <th>图片</th>
                <th>结果</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
                    <td><?php echo ($v["designer"]); ?></td>
                    <td><?php echo ($v["office_id"]); ?></td>
                    <td><?php echo ($v["user"]); ?></td>
                    <td><?php echo ($v["series"]); ?></td>
                    <td><?php echo ($v["colour"]); ?></td>
                    <td><?php echo ($v["sex"]); ?></td>
                    <td><?php echo ($v["vote_id"]); ?></td>
                    <td class="img"><img src="/Upload/vote/<?php echo ($v["picture"]); ?>"></td>
                    <td>
                        <?php if($v["result_value"] == 1): ?>赞同
                        <?php elseif($v["result_value"] == 2): ?>
                            不赞同<?php endif; ?>

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