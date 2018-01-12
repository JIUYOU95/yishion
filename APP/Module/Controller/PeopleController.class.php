<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1
 * Time: 18:47
 */

namespace Module\Controller;


use Common\Common\Category;
use Common\Controller\AuthController;

class PeopleController extends AuthController {
    //通讯录更新
    public function update() {
        $user=$this->wx->user->lists(1,1);
        $exl=$user['userlist'];
        //截取规定字段
        $arrNew=array();
        foreach($exl as $k=>$v){
            $arrNew[$k]=array('userid'=>$v['userid'],'name'=>$v['name'],'department'=>$v['department'],'mobile'=>$v['mobile'],'gender'=>$v['gender'],'email'=>$v['email'],'avatar'=>$v['avatar'],'status'=>$v['status']);

        }
//        // 清理空数组
//        $exl=filter_array($exl);

        //用户列表
        $data['user']=json_encode($arrNew,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        $depa = $this->wx->user_department->lists();
        //部门列表
        $data['department']=json_encode($depa['department'],JSON_UNESCAPED_UNICODE);
        $result=M("Mail")->where('id=1')->save($data);

        if($result){
            A('Log')->add_log('通讯录更新');
            $this->success('通讯录更新成功！',U('mail'));
        }else{
            $this->error('通讯录更新失败');
        }

    }

    //通讯录管理
    public function mail() {
        $data = M('Mail')->find(1);
//        $json=$data['user'];
//        $name=json_decode($json,true);
//        $p=json_last_error();
//        echo $json;
//        die;
        $this->display();
    }
    //获取部门
    public function depa(){
        $data = M('Mail')->find(1);
        $depa=json_decode($data['department'],true);
        $data_depa=Category::unlimitedForLayer($depa,'child','0','parentid');
        $vdepa=json_encode($data_depa,JSON_UNESCAPED_UNICODE);
        echo $vdepa;

    }
    //获取人员
    public function user(){
        $data = M('Mail')->find(1);
        $json=$data['user'];//获取user json数据
        $name=json_decode($json,true);
        $result['count']=count($json);
        echo $name;die;

        $result=json_encode($result,JSON_UNESCAPED_UNICODE);
        echo $data['user'];
        json_encode($data['user'],JSON_UNESCAPED_UNICODE);
        echo json_decode($pd,true);
        echo $pd;
        echo json_last_error();
    }

}