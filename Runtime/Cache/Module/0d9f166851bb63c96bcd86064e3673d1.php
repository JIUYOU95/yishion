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
    <li class="active">投票列表</li>
    <span class="btn btn-primary rightbut" ng-click="add()">创建投票</span>
</ul>
<div class="row vote">
    <div class="col-sm-12">
        <div class="panel panel-default" ng-repeat="v in data">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span>{{v.title}}[ID:{{v.id}}]</span>
                    <span class="pull-right">{{v.send_time*1000|date:'yyyy-MM-dd'}}</span>
                    <span class="pull-right">投票人数：{{v.count}}人</span>

                </h3>
            </div>
            <div class="panel-body">
                <div class="btn-group">
                    <button type="button" class="btn btn-default">设计问卷</button>
                    <button type="button" class="btn btn-default dropdown-toggle"
                            data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">切换下拉菜单</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" ng-click="edit_title(v.id)">修改投票</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-default">问卷分析</button>
                    <button type="button" class="btn btn-default dropdown-toggle"
                            data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">切换下拉菜单</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('user_see');?>?id={{v.id}}">投票(人员)查看</a></li>
                        <li><a href="<?php echo U('detailed');?>?id={{v.id}}">投票(明细)查看</a></li>
                        <li><a href="<?php echo U('scaling');?>?id={{v.id}}">投票(比例)查看</a></li>
                        <li><a href="<?php echo U('pool');?>?id={{v.id}}">汇总表</a></li>
                        <li class="divider"></li>
                        <li><a href="#" ng-click="qrcode(v.id,v.publish,v.title)">二维码与链接</a></li>
                    </ul>
                </div>
                <a href="<?php echo U('empty_vote');?>?id={{v.id}}" class="btn btn-default">清空数据</a>
                <span class="btn btn-danger pull-right" ng-click="del_title(v,v.id,1,v.title)"><i class="fa fa-times"></i> 删除</span>
                <span class=" pull-right" ng-if="v.publish==0"><a href="<?php echo U('play_code');?>?id={{v.id}}&publish=1&title={{v.title}}" class="btn btn-primary"><i class="fa fa-play"> 发布</i></a></span>
                <span class=" pull-right" ng-if="v.publish==1"><a href="<?php echo U('stop_code');?>?id={{v.id}}&publish=0&title={{v.title}}" class="btn btn-primary"><i class="fa fa-pause"> 停止</i></a></span>
            </div>
        </div>
    </div>
</div>
<!--新增修改投票-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title" id="myModalLabel" ng-bind="ed.id?'修改投票':'新增投票'"> </h4>
            </div>
            <form class="form-horizontal" action="<?php echo U('handle_vote');?>" method="post">
                <input type="hidden" name="id" value="{{ed.id}}" ng-if="ed.id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">投票题目</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title" placeholder="投票题目" autocomplete="off" required value="{{ed.title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片选择</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="preid" ng-model="ed.preid">
                                <option value="">请选择图片批次</option>
                                <option ng-repeat="sv in item track by $index">{{sv.pid}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">有效期</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="date" placeholder="时间范围" autocomplete="off" ng-model="date">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">提交更改</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--二维码生成-->
<div class="modal fade" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                <h4 class="modal-title">二维码生成</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">投票题目</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-disabled="true" ng-model="code.name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">链接</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" ng-model="code.link">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 text-center">
                            <img ng-src="{{code.url}}">
                        </div>
                        <div class="col-sm-6">
                            微信通过扫描二维码填写！
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    require(['util'],function (util) {
        //日期区间
        util.daterangepicker({
            element: 'input[name="date"]',
            options: {},
            callback: function (start, end, label) {
                var str = start.format('YYYY-MM-DD') + ' 至 ' + end.format('YYYY-MM-DD');
                console.log(str);
            }
        });

    });
    require(['underscore']);
    function controller($scope, $http, $filter) {
        //新增投票
        $scope.add=function () {
            $scope.ed="";
            $('#myModal').modal('show');
        }
        //修改投票
        $scope.edit_title=function (id) {
            $http.get("<?php echo U('get_title');?>",{params:{'id':id}}).success(function (data) {
                $scope.ed=data;
                $scope.date=$scope.ed.begin_date + ' 至 ' + $scope.ed.end_date;
                console.log(data);
            });

            $('#myModal').modal('show');
        }
        //删除投票
        $scope.del_title=function (v,id,name) {
            if(confirm('确定删除！')){
                $http.get("<?php echo U('del_title');?>",{params:{'id':id,'name':name}}).success(function (data) {
                    alert(data);
                    $scope.data = _.without($scope.data, v);
                });
            }
        }
        //二维码查看
        $scope.qrcode=function (id,pid,name) {
            if(pid==0){
                alert('请先发布投票！');
            }else{
                $scope.code={id:id,name:name,url:'../../Upload/vote/qrcode/'+name+'.png',link:'http://yishion.itnetve.top/Reception/Vote/index/id/'+id}
                $('#qrcode').modal('show');
            }
        }
        //获取列表
        $http.get("<?php echo U('get_vote');?>").success(function (data) {
            $scope.data=data;
        });
        $http.get("<?php echo U('get_item');?>").success(function (v) {
            $scope.item=v;
        });

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