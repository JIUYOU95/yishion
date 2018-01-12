<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8"/>
    <title>后台管理 | <?php echo v('config.system.webname');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <link rel="stylesheet" href="/Public/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/css/font.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/js/calendar/bootstrap_calendar.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/js/jvectormap/jquery-jvectormap-1.2.2.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/css/app.css" type="text/css"/>
    <!--[if lt IE 9]>
    <script src="/Public/js/ie/html5shiv.js"></script>
    <script src="/Public/js/ie/respond.min.js"></script>
    <script src="/Public/js/ie/excanvas.js"></script>
    <![endif]-->
    <script>
        //配置后台地址
        var app = {
            'base': '/Public/vendor',
        };
    </script>
    <script src="/Public/vendor/require.js"></script>
    <script src="/Public/vendor/config.js"></script>
</head>
<style>
    .ng-cloak {
        display: none;
    }
</style>

<body ng-cloak class="ng-cloak" ng-controller="ctrl" style="overflow-y:hidden;">
<base target="main" />
<section class="vbox">
    <!--头部-->
    <header class="header navbar navbar-inverse navbar-fixed-top-xs">
        <div class="navbar-header aside-md">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                <i class="fa fa-bars"></i>
            </a>
            <a href="#" class="navbar-brand" data-toggle="fullscreen">
                <img src="/Public/images/logo.png"><?php echo v('config.system.webname');?>
            </a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                <i class="fa fa-cog"></i>
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="thumb-sm avatar pull-left">
                      <img src="/Public/images/avatar.jpg">
                    </span>
                    <?php echo ($username); ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <span class="arrow top"></span>
                    <li><a href="<?php echo U('./edit_pwd');?>">修改密码</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo U('./logout');?>" target="_top"><i class="fa fa-power-off"></i> 退出</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!--侧栏-->
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-light lter b-r aside-md hidden-print hidden-xs" id="nav">
                <section class="vbox">
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                            <!-- nav -->
                            <ul id="accordion" class="accordion">
                                <li>
                                    <div class="link"><i class="fa fa-navicon"></i>侧栏</div>
                                </li>
                                <?php if(is_array($nav_data)): foreach($nav_data as $key=>$v): if(empty($v['_data'])): ?><li>
                                            <div class="link"><i class="fa fa-<?php echo ($v['ico']); ?>"></i><?php echo ($v['name']); ?></div>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <div class="link"><i class="fa fa-<?php echo ($v['ico']); ?>"></i><?php echo ($v['name']); ?><i class="fa fa-chevron-down"></i></div>
                                            <ul class="submenu">
                                                <?php if(is_array($v['_data'])): foreach($v['_data'] as $key=>$n): ?><li><a href="<?php echo U($n['mca']);?>" data-id="<?php echo ($n['id']); ?>" class="site-demo-active"><span><?php echo ($n['name']); ?></span></a></li><?php endforeach; endif; ?><!-- data-type="tabAdd" -->
                                            </ul>
                                        </li><?php endif; endforeach; endif; ?>
                            </ul>
                            <!-- / nav -->
                        </div>
                    </section>
                    <!--底部显示-->
                    <footer class="footer lt hidden-xs b-t b-light">
                        <div class="btn-group hidden-nav-xs">
                            <i class="fa fa-user-md"></i><?php echo v('config.system.tel');?>
                        </div>
                    </footer>
                </section>
            </aside>
            <!--正文内容-->
            <section id="content">
                <section class="vbox">
                    <section class="scrollable">
                        <iframe src="<?php echo U('./welcome');?>" id="main" name="main" width="100%" height="100%" frameborder="0" scrolling="yes"></iframe>
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>
</section>

<script>
require(['util','select2'],function () {
        require(['/Public/js/app.js', 'css!/Public/css/app.css']);
        require(['angular','jquery'],function (angualr,$) {
            angular.module('app', []).controller('ctrl', ['$scope', function ($scope) {

            }]);
            angular.bootstrap(document.getElementsByTagName('body'), ['app']);
        });
})
</script>

</body>
</html>