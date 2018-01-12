<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql',     // 数据库类型
    'DB_HOST'   => '104.224.129.95', // 服务器地址
    'DB_NAME'   => 'yishion',          // 数据库名
    'DB_USER'   => 'yishion',      // 用户名
    'DB_PWD'    => 'yishion1625',          // 密码
    'DB_PORT'   => '3306',        // 端口
    'DB_PREFIX' => 'ys_',    // 数据库表前缀

    'URL_MODEL'          => '2', //URL模式
    'DEFAULT_MODULE'     => 'Theme', //默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION'     => 'master', // 默认操作名称
    'DEFAULT_FILTER'     => '', // 默认参数过滤方法 用于I函数...


    'ERROR_PAGE' =>__ROOT__.'/error.html', // 定义公共错误模板

    'TAGLIB_BUILD_IN' => 'Cx,Common\Tag\My',



);