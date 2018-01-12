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


<style type="text/css">
    .table{margin:10px 0;}
</style>
<ul class="breadcrumb row navigation">
    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">权限控制</a></li>
    <li><a href="<?php echo U('group');?>">用户组管理</a></li>
    <li class="active">分配权限</li>
</ul>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo ($group_data['id']); ?>">
            <table class="table table-bordered table-condensed">
                <?php if(is_array($rule_data)): foreach($rule_data as $key=>$v): if(empty($v['_data'])): ?><tr class="b-group">
                            <td width="10%"> <label><?php echo ($v['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($v['id']); ?>" <?php if(in_array($v['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)" ></label></td>
                            <td></td>
                        </tr>
                        <?php else: ?>
                        <tr class="b-group">
                            <td width="10%"> <label><?php echo ($v['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($v['id']); ?>" <?php if(in_array($v['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)"></label></td>
                            <td class="b-child">
                                <?php if(is_array($v['_data'])): foreach($v['_data'] as $key=>$n): ?><table class="table table-striped table-bordered table-condensed">
                                        <tr class="b-group">
                                            <td width="15%"> <label><?php echo ($n['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($n['id']); ?>" <?php if(in_array($n['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> onclick="checkAll(this)"></label></td>
                                            <td>
                                                <?php if(!empty($n['_data'])): if(is_array($n['_data'])): $i = 0; $__LIST__ = $n['_data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><label>&emsp;<?php echo ($c['title']); ?> <input type="checkbox" name="rule_ids[]" value="<?php echo ($c['id']); ?>" <?php if(in_array($c['id'],$group_data['rules'])): ?>checked="checked"<?php endif; ?> ></label><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                            </td>
                                        </tr>
                                    </table><?php endforeach; endif; ?>
                            </td>
                        </tr><?php endif; endforeach; endif; ?>
                <tfoot>
                <tr>
                    <td colspan="2"><input class="btn btn-success" type="submit" value="提交"></td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>

<script>
    function controller($scope, $, _) {
    }
    function checkAll(obj){
        $(obj).parents('.b-group').eq(0).find("input[type='checkbox']").prop('checked', $(obj).prop('checked'));
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