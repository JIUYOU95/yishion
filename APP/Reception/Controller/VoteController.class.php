<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/10
 * Time: 16:35
 */

namespace Reception\Controller;


use Common\Controller\BaseController;

class VoteController extends BaseController {
    /****投票****/
    public function index(){
        $id=I('id');
        $data=D('VoteQuickTitle')->find($id);
        $time=strtotime(date('Y-m-d',time()));
        if(empty($data)){
            $this->redirect('msg',array('vid' =>1));
        }else{
            //判断投票是否在时间范围之内
            if($time>strtotime($data['begin_date']) && $time<strtotime($data['end_date'])){
                //判断投票是否发布
                if($data['publish']=='0'){
                    $this->redirect('msg',array('vid' =>2));
                }else{
                    $this->assign('data',$data);
                    $this->display();
                }
            }else{
                $this->redirect('msg',array('vid' =>3));
            }
        }
    }
    //获取办事处信息
    public function get_office(){
        $data=D('Office')->order('sort')->select();
        echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
    //获取项目信息
    public function get_item(){
        $pid=I('pid');
        $uid=I('uid');
        $item=D('VoteQuickItem')->where(array('pid'=>$pid,'uid'=>$uid))->select();
        echo json_encode($item,JSON_UNESCAPED_UNICODE);
    }
    //结果插入
    public function result(){
        $result=array_filter(I('post.')); //清除空数据
        $key=array_keys($result);	    //获取键值
        $value=array_values($result);	//获取值
        $key=array_slice($key,3);	    //去掉前三个元素
        $value=array_slice($value,3);	    //去掉前三个元素
        $data['reid']=$result['reid'];
        $data['office_id']=$result['office_id'];
        $data['user']=$result['user'];
        for($i=0;$i<count($key);$i++){
            $data['result_key']=$key[$i];
            $data['result_value']=$value[$i];
            $c=D('VoteQuickResult')->add($data);
        }
        if($c){
            //回写人数加一
            D('VoteQuickTitle')->where(array('id'=>I('reid')))->setInc('count');
            $this->redirect('msg',array('vid' =>4,'id'=>I('reid'),'uid'=>I('user')));
        }else{
            $this->redirect('msg',array('vid' =>5));
        }
    }
    /****查看****/
    public function user(){
        $uid=I('uid');
        $id=I('id');
        $udata=D('VoteQuickResult')->where(array('user'=>$uid,'reid'=>$id))->select();
        //判断是否存在
        if(!$udata){
            $this->redirect('msg',array('vid' =>6));
        }
        $ud=array('uid'=>$uid,'id'=>$id);
        /*赋值*/
        $this->assign('ud',$ud);

        $data=D('VoteQuickTitle')->find($id);
        $time=strtotime(date('Y-m-d',time()));
        if(empty($data)){
            $this->redirect('msg',array('vid' =>1));
        }else{
            //判断投票是否在时间范围之内
            if($time>strtotime($data['begin_date']) && $time<strtotime($data['end_date'])){
                //判断投票是否发布
                if($data['publish']=='0'){
                    $this->redirect('msg',array('vid' =>2));
                }else{
                    $this->assign('data',$data);
                    $this->display();
                }
            }else{
                $this->redirect('msg',array('vid' =>3));
            }
        }
    }
    //获取结果
    public function get_result(){
        $uid=I('uid');
        $id=I('id');
        $udata=D('VoteQuickResult')->where(array('user'=>$uid,'reid'=>$id))->select();
        //去除id和reid
        foreach ($udata as $k=>$v){
            unset($v['id']);
            unset($v['reid']);
            $udata[$k]=$v;
        }

        $res=array();
        foreach ($udata as $key => $info) {
            $res['0']['user']=$info['user'];
            $res['0']['office_id']=$info['office_id'];
            unset($info['office_id']);
            unset($info['user']);
            $res['0']['sub'][] = $info;

        }

        $res['0']['sub']=array_column($res['0']['sub'],'result_value','result_key');

        foreach ($res as $k1=>$v1){
            $res=$v1;
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }

    /****信息提示****/
    public function msg(){
        $vid=I('vid');
        $this->s=I('get.');
        if(empty($vid)){
            redirect('http://www.baidu.com',1, '大兄弟，走错路了');
        }else{
            $this->assign('vid',$vid);
            $this->display();
        }

    }

}