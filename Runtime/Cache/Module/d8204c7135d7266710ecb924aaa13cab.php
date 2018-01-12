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
    <li class="active">管理员列表</li>
    <span class="btn btn-primary rightbut" onclick="add()">新增管理员</span>
</ul>
<!--管理员列表-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>用户名</th>
                <th>用户组</th>
                <th>状态</th>
                <th>注册时间</th>
                <th>登录IP</th>
                <th>登录时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($access)): foreach($access as $key=>$v): ?><tr>
                    <td>
                        <span <?php if($v['password'] == md5('')): ?>class="text-danger"<?php endif; ?> ><?php echo ($v['username']); ?></span>
                    </td>
                    <td>
                        <?php if($v['id'] == 1): ?>超级管理员
                            <?php else: ?>
                            <?php echo ($v['title']); endif; ?>
                    </td>
                    <td>
                        <?php if($v['status'] == 1): ?>允许登录
                        <?php elseif($v['status'] == 2): ?>
                            禁止登录<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v['regtime'] != 0): echo (date('Y-m-d',$v['regtime'])); endif; ?>
                    </td>
                    <td><?php echo ($v['loginip']); ?></td>
                    <td>
                        <?php if($v['logintime'] != 0): echo (date('Y-m-d',$v['logintime'])); endif; ?>
                    </td>
                    <td class="user_list_edit">

                            <?php if(($v['status'] == 1) AND ($v['id'] != 1)): ?><a href="<?php echo U('lockHandle',array('id'=>$v['id'],'username'=>$v['username'],'lock'=>2));?>"><i class="fa fa-unlock" title="锁定"></i></a> |
                                <?php elseif(($v['status'] == 2) AND ($v['id'] != 1)): ?>
                                <a href="<?php echo U('lockHandle',array('id'=>$v['id'],'username'=>$v['username'],'lock'=>1));?>"><i class="fa fa-lock" title="解锁"></i></a> |<?php endif; ?>

                           <a href="<?php echo U('edit_admin',array('id'=>$v['id']));?>"><i class="fa fa-edit" title="修改"></i></a>
                        <?php if($v['id'] != 1): ?>| <a href="<?php echo U('delete_admin',array('id'=>$v['id'],'username'=>$v['username']));?>"><i class="fa fa-trash-o" title="删除"></i></a><?php endif; ?>
                            | <a href="<?php echo U('empty_password',array('id'=>$v['id'],'username'=>$v['username']));?>"><i class="fa fa-recycle" title="清空密码"></i></a>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!--新增管理员-->
<div class="modal fade" id="myModal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增管理员</h4>
            </div>
            <form class="form-horizontal" role="form" action="<?php echo U('add_admin');?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">管理组</label>
                        <div class="col-sm-10">
                            <?php if(is_array($group)): foreach($group as $key=>$v): ?><label class="checkbox-inline">
                                <input type="checkbox" name="group_ids[]" value="<?php echo ($v['id']); ?>" id="<?php echo ($v['id']); ?>"><label for="<?php echo ($v['id']); ?>"><?php echo ($v['title']); ?></label>
                                </label><?php endforeach; endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" autocomplete="off" placeholder="登录账号，填写后不可修改" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" autocomplete="off" placeholder="请输入初始密码" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机号</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入手机号" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" autocomplete="off" placeholder="请输入邮箱" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" id="status1" checked=""><label for="status1">允许登录</label>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="2" id="status0" ><label for="status0">禁止登录</label>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function controller($scope, $, _) {
    }
    function add(){
        $('#myModal-add').modal('show');
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