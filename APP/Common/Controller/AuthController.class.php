<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 16:32
 */

namespace Common\Controller;

use Common\Common\Opadmin;
use EntWeChat\Foundation\Application;
use Think\Auth;

class AuthController extends BaseController {
    protected $wx;
    //权限验证
    protected function _initialize(){
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        if($uid){
            //如果是超级管理员的话，就不用验证权限了，给予所有权限
            if($uid == 1){
                return true;
            }
            //下面进行权限判断
            $auth = new Auth();
            if (!$auth->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$uid)) {
                $this->error('权限不足！');exit;
            }
        }else{
            //$this->error('无权限登录！','http://yishion.itnetve.top/Theme/dologin');
            $this->redirect('http://yishion.itnetve.top/Theme/dologin');
        }
    }

    //分配菜单
    public function __construct() {
        parent::__construct();
        $this->assignModuelMenu();
        $config = [
            "corp_id"   => v('wx.corpid'),
            "secret"    => v('wx.mail.0.mailsecret'),
            "shopin"    => [
                "agent_id" => v('wx.sub.0.app_agentid'),
                "secret"   => v('wx.sub.0.app_secret'),
            ],
        ];
        $this->wx = new Application($config);
    }
}