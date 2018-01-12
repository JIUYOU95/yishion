<?php namespace Common\Tag;

use Think\Template\TagLib;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 10:38
 */
class My extends TagLib {
    protected $tags=array(
        'bootstrapselect'=>array('','close'=>0),
    );
    public function _bootstrapselect(){
        $link=<<<php
<link rel="stylesheet" href="__ROOT__/node_modules/hdjs/component/bootstrap-select/css/bootstrap-select.min.css" />
<script src="__ROOT__/node_modules/hdjs/js/jquery.min.js"></script>
<script src="__ROOT__/node_modules/hdjs/component/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="__ROOT__/node_modules/hdjs/component/bootstrap-select/js/i18n/defaults-zh_CN.min.js"></script>
php;
        return $link;
    }
}