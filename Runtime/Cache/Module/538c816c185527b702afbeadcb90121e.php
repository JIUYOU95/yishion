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
    <li><a href="#">权限控制</a></li>
    <li><a href="<?php echo U('admin');?>">管理员列表</a></li>
    <li class="active">管理员修改</li>

</ul>

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading">管理员修改</header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="" method="post">
                    <input type="hidden" name="id" value="<?php echo ($user_data['id']); ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">管理组</label>
                        <div class="col-sm-10">
                            <?php if($user_data['id'] == 1): ?>超级管理员
                            <?php else: ?>
                            <?php if(is_array($data)): foreach($data as $key=>$v): ?><label class="checkbox-inline">
                                <input type="checkbox" name="group_ids[]" value="<?php echo ($v['id']); ?>" id="<?php echo ($v['id']); ?>"  <?php if(in_array(($v['id']), is_array($group_data)?$group_data:explode(',',$group_data))): ?>checked="checked"<?php endif; ?>><label for="<?php echo ($v['id']); ?>"><?php echo ($v['title']); ?></label>
                                </label><?php endforeach; endif; endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" autocomplete="off" value="<?php echo ($user_data['username']); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" autocomplete="off" placeholder="如不修改改密码,留空即可" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机号</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入手机号" class="form-control" value="<?php echo ($user_data['phone']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" autocomplete="off" placeholder="请输入邮箱" class="form-control" value="<?php echo ($user_data['email']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" id="status1" <?php if(($user_data['status']) == "1"): ?>checked<?php endif; ?> ><label for="status1">允许登录</label>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="2" id="status0" <?php if(($user_data['status']) == "2"): ?>checked<?php endif; ?> ><label for="status0">禁止登录</label>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
<script>
    function controller($scope, $, _) {

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