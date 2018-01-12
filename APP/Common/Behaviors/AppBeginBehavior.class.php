<?php namespace Common\Behaviors;

use Think\Behavior;

require 'APP/Common/Common/helper.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 11:28
 */
class AppBeginBehavior extends Behavior{
    //行为执行入口
    public function run( &$param ) {
        $this->loadConfig();
    }

    //加载配置项
    protected function loadConfig() {
        $data=D('Config')->find(1);
        $data['system']=json_decode($data['system'],true);
        $data['wechat']=json_decode($data['wechat'],true);
        v('config.system',$data['system']);
        v('wx',$data['wechat']);
    }

}