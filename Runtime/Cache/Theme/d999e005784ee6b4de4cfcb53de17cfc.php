<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>后台登录</title>
    <link rel="stylesheet" href="/Public/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/Public/css/login.css" type="text/css"/>
    <script>
        //配置后台地址
        var hdjs = {
            'base': '/node_modules/hdjs',
            'ueditor': '',
            'uploader': '/admin/Component/uploader',
            'filesLists': '/admin/Component/filesLists',
            'removeImage': '删除图片后台地址'
        };
    </script>
    <!--<script src="/node_modules/hdjs/app/util.js"></script>-->
    <script src="/node_modules/hdjs/require.js"></script>
    <script src="/node_modules/hdjs/config.js"></script>
</head>
<body>
<div class="site-demo-upload">
    <img id="lay_demo_upload" src="/Public/images/Kitty.jpg">
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="<?php echo U('sign');?>" method="post">
            <div class="form-group">
                <label for="username" class="sr-only">User</label>
                <input type="text" name="username" class="form-control" id="username" autocomplete="off" placeholder="用户名">
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="密码">
            </div>
            <button type="submit" class="btn btn-primary center-block">登录</button>
        </form>
        <div class="error"><a href="#">忘记密码？</a></div>
    </div>
    <div class="address">
        <p>Copyright © 2017 by Yishion OA</p>
    </div>
</div>

</body>
</html>