<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 18:29
 */

namespace Theme\Controller;

use Common\Common\Opadmin;
use Common\Controller\BaseController;

class LoginController extends BaseController {
    public function index() {
        session(null);
        $this->display();
    }

    //登录验证
    public function sign(){
        if(!IS_POST) E('页面不存在');
        //验证用户和密码
        $Opadmin=(new Opadmin(I('username'),I('password')))->login();
        if($Opadmin==1){    //登录成功
            $this->success('登录成功',U('./index'));
        }else if($Opadmin==0){  //数据更新失败
            $this->error('登录失败，请重新输入！',U('./dologin'));
        }else if($Opadmin==2){  //用户名或密码错误
            $this->error('用户名或密码错误！',U('./dologin'));
        }else if($Opadmin==3){
            $this->error('用户名已被锁定，请联系管理员解锁！',U('./dologin'));
        }
    }
    //退出
    public function logout() {
        $Opadmin = new Opadmin();
        if ($Opadmin->loginout()) {
            $this->redirect('./dologin');
        }
    }
}