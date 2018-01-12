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
    <li class="active">图片管理</li>
</ul>
<!--图片管理-->
<div class="row">
    <div class="col-sm-12">
        <!--搜索界面-->
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline" action="" method="post">
                    <div class="form-group">
                        <select class="form-control js-example-theme-single" ng-model="pid" ng-change="selectChange(pid);">
                            <option value="">请选择图片批次</option>
                            <?php if(is_array($data)): foreach($data as $key=>$v): ?><option value="<?php echo ($v["pid"]); ?>"><?php echo ($v["pid"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>

                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_all"><i class="fa fa-cloud-upload"></i> 图片导入</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-cloud-upload"></i> Excel上传</button>
                    <button type="button" class="btn btn-info" ng-click="down()"><i class="fa fa-cloud-download"></i> Excel模板下载</button>

                </form>

            </div>
        </div>
        <!--end搜索界面-->
        <!--图片列表-->
        <table class="table table-bordered table-condensed vote_img">
            <thead>
            <tr>
                <th><input type="checkbox" ng-model="all"></th>
                <th>批次</th>
                <th>系列</th>
                <th>颜色</th>
                <th>性别</th>
                <th>投票号</th>
                <th>设计师</th>
                <th>图片</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="v in data">
                <td><input type="checkbox" value="{{v.id}}" ng-checked="all" name='id'/></td>
                <td>{{v.pid}}</td>
                <td>{{v.series}}</td>
                <td>{{v.colour}}</td>
                <td>{{v.sex}}</td>
                <td>{{v.vote_id}}</td>
                <td>{{v.designer}}</td>
                <td class="img">
                    <img class="img-zoomable" ng-src="/Upload/vote/{{v.picture}}">
                </td>
            </tr>
            </tbody>
        </table>
        <input type="button" value='删除' class="btn btn-default" ng-click="del()">
    </div>
</div>

<!--上传文件-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">文件上传</h4>
            </div>
            <form role="form" action="<?php echo U('upload');?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="file"  id="file" name="exl">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">上传</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--批量导入图片-->
<div class="modal fade bs-example-modal-lg" id="add_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">批量导入图片</h4>
            </div>
            <form class="form-inline" role="form" action="<?php echo U('img_upload');?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="sr-only">图片</label>
                        <input type='file' name='picture[]' accept="image/*" id="add_img_all" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">导入</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    //图片上传
    require(['fileinput'],function () {
        $("#add_img_all").fileinput({
            allowedFileExtensions : ['jpg', 'png','gif'],//接收的文件后缀
            showUpload: false, //是否显示上传按钮
            showCaption: false,//是否显示标题
            dropZoneEnabled: false, //是否显示拖拽区域
        });
    });
    //图片放大

    function controller($scope, $http, $filter) {
        //excel模板文件下载
        $scope.down=function () {
            window.open("/Public/vote_quick.xlsx");
        }
        //下拉获取列表
        $scope.selectChange=function (pid) {
            $http.get("<?php echo U('get_img');?>",{params:{'pid':pid}}).success(function (response) {
                $scope.data=response;
            },function error() {
                console.log('错误');
            });
        }
        //删除
        $scope.del=function () {
            var text="";
            $("input[name=id]").each(function(){
                if ($(this).prop("checked")) {
                    text += ","+$(this).val();
                }
            });
            $http.get("<?php echo U('alldel');?>",{params:{'id':text}}).success(function(data){
                if(data){
                    alert('图片删除成功');
                    window.location='/Module/Vote/images';
                }else{
                    alert('图片删除失败');
                }
            });
        }
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