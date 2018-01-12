<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 10:40
 */

namespace Module\Controller;


use Common\Common\Opadmin;
use Common\Controller\BaseController;

class LogController extends BaseController {
    public function add_log($content){
        $Opadmin=new Opadmin();
        if(v('config.system.log_status')=='0')
            return true;
        $data['uid']=$Opadmin->getUsername();
        $data['time']=time();
        $data['ip']=get_client_ip();
        $data['logtext']=$content;
        $result=D('Log')->add($data);
        if($result)
            return true;
        else
            return false;
    }
}