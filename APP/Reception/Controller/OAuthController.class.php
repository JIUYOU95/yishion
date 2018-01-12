<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 14:05
 */

namespace Reception\Controller;

use EntWeChat\Foundation\Application;
use Org\WeChat\Qywx;
use Think\Controller;

class OAuthController extends Controller {
    protected $wx;
    protected function _initialize(){
        $config = [
            "corpid"   => v('wx.corpid'),
            "secret"    => v('wx.mail.0.mailsecret'),
            "shopin"    => [
                "agent_id" => v('wx.sub.0.app_agentid'),
                "secret"   => v('wx.sub.0.app_secret'),
            ],
        ];
        $this->wx = new Qywx($config);

//        if(empty($_GET['code'])) {
//            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//            $info = $this->wx->getJumpOAuthUrl($url);
//            redirect($info,0);
//        }else{
//            $user=$this->wx->getUserId($_GET['code']);
//            echo $user;
//        }
    }
}