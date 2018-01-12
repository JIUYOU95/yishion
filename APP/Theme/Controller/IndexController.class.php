<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 18:38
 */

namespace Theme\Controller;


use Common\Common\Opadmin;
use Common\Controller\AuthController;

class IndexController extends AuthController {
    public function master(){
        $Opadmin=new Opadmin();
        $this->username=$Opadmin->getUsername();
        $this->display();
    }
    public function pwd(){
        $Opadmin=new Opadmin();
        if(IS_POST){
            $pwd=I('pwd');
            $data['password']=$Opadmin->joinmd5($pwd);
            $data=$Opadmin->updateinfo($data);
            if($data){
                $this->success('密码修改成功！',U('./welcome'));
            }else{
                $this->error('密码修改失败！');
            }
        }else {
            $this->display();
        }
    }
    public function Welcome(){
        $sysdata['host']= isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');    //访问网址
        $sysdata['ip']=get_server_ip();                         //服务器IP
        $sysdata['port']=$_SERVER["SERVER_PORT"];               //端口号
        $Agent=$_SERVER['HTTP_USER_AGENT'];
        //以下两条获取服务器时间，中国大陆采用的是东八区的时间,设置时区写成Etc/GMT-8
        date_default_timezone_set("Etc/GMT-8");
        $sysdata['systemtime'] = date("Y-m-d H:i:s",time());    //服务器时间
        $sysdata['sysversion']= PHP_VERSION;                    //PHP版本
        $sysdata['mysqlinfo']=$this-> _mysql_version();         //Mysql版本
        $sysdata['browser']=get_broswer();                      //浏览器
        $sysdata['system']=get_os();                            //操作系统

        $this->assign('sysdata',$sysdata);
        $this->display();
    }
    protected function _model(){
        return new \Think\Model();
    }
    private function _mysql_version(){
        $Model = self::_model();
        $version = $Model->query("select version() as ver");
        return $version[0]['ver'];
    }
}