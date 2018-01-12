<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 15:59
 */
return array(//'配置项'=>'配置值'

    //模板引擎设置
    'TMPL_FILE_DEPR'  => '_',  //简化结构目录

    //URL设置
    'URL_HTML_SUFFIX' => 'html',  // URL伪静态后缀设置
    'URL_ROUTER_ON'   => true,  // 开启路由
    'URL_ROUTE_RULES' => array(
        'dologin' => 'Login/index', //登录
        'index'   => 'Index/master',  //首页
        'welcome' => 'Index/Welcome',
        'edit_pwd' => 'Index/pwd',
        'logout'  => 'Login/logout',   //退出
    ),
);