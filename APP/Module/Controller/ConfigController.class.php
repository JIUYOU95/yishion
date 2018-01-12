<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 13:37
 */

namespace Module\Controller;

use Common\Controller\AuthController;

class ConfigController extends AuthController {
    /****菜单****/
    public function nav(){
        $data=D('Nav')->getTree('tree','order_number,id');
        $this->display();
    }
    //菜单获取
    public function get_nav(){
        $data=D('Nav')->getTree('tree','order_number,id');
        $data=array_merge($data);
        echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
    //菜单新增修改处理
    public function handle_nav(){
        $result=D('Nav')->store(I('post.'));
        if($result['status']=='success'){
            A('Log')->add_log('菜单'.$result['message'].'-'.I('name'));
            $this->success($result['message'],U('nav'));
        }else{
            $this->error($result['message'],U('nav'));
        }
    }
    //删除菜单
    public function delete_nav(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
        );
        $result=D('Nav')->deleteData($map);
        if($result){
            A('Log')->add_log('删除菜单-'.I('name'));
            echo '菜单删除成功';
        }else{
            echo '请先删除子菜单';
        }
    }
    //菜单排序
    public function nav_order(){
        $data=I('post.');
        $result=D('Nav')->orderData($data);
        if ($result) {
            A('Log')->add_log('菜单排序');
            $this->success('排序成功',U('nav'));
        }else{
            $this->error('排序失败');
        }
    }

    /****系统设置****/
    public function set() {
        $model = D('Config');
        if(IS_POST){
            $result=$model->store(I('post.'));
            if($result['status']=='success'){
                A('Log')->add_log('系统设置'.$result['message']);
                $this->success($result['message'],U('set'));
            }else{
                $this->error($result['message'],U('set'));
            }
        }else{
            $this->display();
        }

    }
    //获取系统设置
    public function get_set(){
        $field=D('Config')->field('system')->find(1);
        echo $field['system'];
    }

    /****微信配置****/
    public function wset(){
        $model = D('Config');
        if(IS_POST){
            $this->store($model,I('post.'));
        }
        $field=$model->find(1);
        $this->assign('field',$field);
        $this->display();
    }
    //获取系统设置
    public function get_wset(){
        $field=D('Config')->field('wechat')->find(1);
        echo $field['wechat'];
    }

    /****日志列表****/
    public function log(){
        $Log=D('Log');
        if(I('name')){
            $where['uid']=I('name');
            $this->name=I('name');
        }
        $this->loglist=$Log->getPage($where,'id desc','14');
        $this->display();
    }
    /*
	 * 日志删除
	 */
    public function alldel(){
        $ids=explode(',',substr(I('id'),1));
        foreach($ids as $key=>$id){
            if(!$this->dellog($id)){
                $this->show(0);
            }
        }
        A('Log')->add_log('日志删除');
        $this->show(1);
    }
    private function dellog($id){
        if(!$id)
            return false;
        $where['id']=$id;
        $count=D('Log')->where($where)->delete();
        if($count){
            return true;
        }else{
            return false;
        }

    }

    /****办事处管理****/
    public function office(){
        $this->display();
    }
    //获取办事处信息
    public function get_office(){
        $data=D('Office')->order('sort')->select();
        echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
    //办事处新增修改处理
    public function handle_office(){
        $result=D('Office')->store(I('post.'));
        if($result['status']=='success'){
            A('Log')->add_log('办事处'.$result['message'].'-'.I('name'));
            $this->success($result['message'],U('office'));
        }else{
            $this->error($result['message'],U('office'));
        }
    }
    //删除菜单
    public function delete_office(){
        $id=I('get.id');
        $result=D('Office')->delete($id);
        if($result){
            A('Log')->add_log('删除办事处-'.I('name'));
            echo '办事处删除成功';
        }else{
            echo '办事处删除子菜单';
        }
    }
    //菜单排序
    public function office_order(){
        $data=I('post.');
        $result=D('Office')->orderData($data,'id','sort');
        if ($result) {
            A('Log')->add_log('办事处排序');
            $this->success('排序成功',U('office'));
        }else{
            $this->error('排序失败');
        }
    }

}