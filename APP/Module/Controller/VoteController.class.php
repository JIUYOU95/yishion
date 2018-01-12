<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 11:07
 */

namespace Module\Controller;


use Common\Common\Opadmin;
use Common\Controller\AuthController;
use Think\Upload;

class VoteController extends AuthController {
    /****投票列表****/
    public function index(){
        $this->display();
    }
    //首页获取批次
    public function get_item(){
        $img=D('VoteQuickItem');
        $Opadmin=new Opadmin();
        $where['uid']=$Opadmin->getUserid();
        //查询已用的批次

        $data=$img->where($where)->field('pid')->group('pid')->select();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //投票列表处理
    public function handle_vote(){
        $data=I('post.');
        $date= explode('至',$data['date']);
        $data['begin_date']=trim($date[0]);
        $data['end_date']=trim($date[1]);
        $data['send_time']=time();
        $Opadmin=new Opadmin();
        $data['uid']=$Opadmin->getUserid();
        $result=D('VoteQuickTitle')->store($data);
        if($result['status']=='success'){
            A('Log')->add_log('投票'.$result['message'].'-'.I('title'));
            $this->success($result['message'],U('index'));
        }else{
            $this->error($result['message'],U('index'));
        }
    }
    //获取投票列表
    public function get_vote(){
        $title=D('VoteQuickTitle');
        $Opadmin=new Opadmin();
        $where['uid']=$Opadmin->getUserid();
        $data=$title->where($where)->select();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //修改投票
    public function get_title(){
        $where['id']=I('id');
        $data=D('VoteQuickTitle')->where($where)->find();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //删除投票
    public function del_title(){
        $id=I('get.id');
        $result=D('VoteQuickTitle')->delete($id);
        if($result){
            A('Log')->add_log('删除投票-'.I('name'));
            echo '投票删除成功';
        }else{
            echo '投票删除失败';
        }
    }
    //发布投票
    public function play_code(){
        $data=I('get.');
        $result=D('VoteQuickTitle')->save($data);
        if($result){
            $name='./Upload/vote/qrcode/'.I('title').'.png';
            $url='http://yishion.itnetve.top/Reception/Vote/index/id/'.I('id');
            $this->qrcode($name,$url);
            A('Log')->add_log('投票发布成功-'.I('title'));
            $this->success('投票发布成功！',U('index'));
        }else{
            $this->error('投票发布失败！');
        }
    }
    //停止投票
    public function stop_code(){
        $data=I('get.');
        $result=D('VoteQuickTitle')->save($data);
        if($result){
            $file_name='./Upload/vote/qrcode/'.I('title').'.png';
            unlink($file_name);
            A('Log')->add_log('投票停止成功-'.I('title'));
            $this->success('投票停止成功！');
        }else{
            $this->error('投票停止失败！',U('index'));
        }
    }
    //数据清空
    public function empty_vote(){
        $id=I('id');
        D('VoteQuickTitle')->where(array('id'=>$id))->setField('count','0');
        D('VoteQuickResult')->where(array('reid'=>$id))->delete();
        $this->success('数据已清空',U('index'));
    }
    /****图片列表****/
    public function images(){
        $img=D('VoteQuickItem');
        $Opadmin=new Opadmin();
        $where['uid']=$Opadmin->getUserid();
        $this->data=$img->where($where)->field('pid')->group('pid')->select();
        $this->display();
    }
    //获取列表
    public function get_img(){
        $img=D('VoteQuickItem');
        $Opadmin=new Opadmin();
        $where['uid']=$Opadmin->getUserid();
        $where['pid']=I('pid');
        $data=$img->where($where)->select();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //图片文件导入
    public function upload(){
        $files = $_FILES['exl'];
        // exl格式，否则重新上传$files['type']!='application/vnd.ms-excel' ||
        if($files['type']!='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
            $this->error('不是Excel文件，请重新上传');
        }
        // 上传
        $upload = new Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls','xlsx');// 设置附件上传类型
        $upload->rootPath  =     './Upload/'; // 设置附件上传根目录
        $upload->savePath  =     'vote/'; // 设置附件上传（子）目录
        //$upload->subName   =     array('date', 'Ym');
        $upload->subName   =     '';
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }
        $file_name =  $upload->rootPath.$info['exl']['savepath'].$info['exl']['savename'];
        $exl = $this->import_exl($file_name);
        // 去掉第exl表格中第一行
        unset($exl[0]);
        // 清理空数组
        foreach($exl as $k=>$v){
            if(empty($v)){
                unset($exl[$k]);
            }
        };
        $module=M('VoteQuickItem');
        $old = $module->count();
        S('b',$old);
        // 重新排序
        sort($exl);
        $Opadmin=new Opadmin();
        foreach ($exl as $item){
            $pid=D('VoteQuickItem')->where(array('pid'=>$item[0]))->select();
            if($pid){
                $this->error('上传文件批次重复-'.$item[0].'，请重新核对后上传！');
            }
            $data['pid']=$item[0];
            $data['series']=$item[1];
            $data['colour']=$item[2];
            $data['descd']=$item[3];
            $data['sex']=$item[4];
            $data['vote_id']=$item[5];
            $data['designer']=$item[6];
            $data['picture']=$item[7];
            $data['uid']=$Opadmin->getUserid();
            $module->add($data);
        }
        $count = $module->count();
        // 检测表格导入成功后，是否有数据生成
        $n = S('b');
        if($count<$n){
            $this->error('未检测到有效数据');
            S('b',null);
        }else{
            $this->success('文件导入成功！',U('images'));
            // 删除Excel文件
            S('b',null);
            unlink($file_name);
        }
    }
    //图片上传
    public function img_upload(){
        $upload = new Upload();
        $upload->maxSize   =    3145728 ;// 设置附件上传大小
        $upload->exts      =    array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Upload/'; // 设置附件上传根目录
        $upload->savePath  =     'vote/'; // 设置附件上传（子）目录
        $upload->saveName = '';
        $upload->autoSub   =    true;
        $upload->subName   = array('date','Ymd');
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $this->success('图片上传成功！',U('images'));
        }
    }
    //图片删除
    public function alldel(){
        $ids=explode(',',substr(I('id'),1));
        foreach($ids as $key=>$id){
            if(!$this->dellog($id)){
                $this->show(0);
            }
        }
        A('Log')->add_log('图片删除');
        $this->show(1);
    }
    private function dellog($id){
        if(!$id)
            return false;
        $where['id']=$id;
        $data=D('VoteQuickItem')->where($where)->find();
        unlink('./Upload/vote/'.$data['picture']);
        $count=D('VoteQuickItem')->where($where)->delete();
        if($count){
            return true;
        }else{
            return false;
        }

    }

    /****投票人员查看****/
    public function user_see(){
        $id=I('id');
        $this->name=D('VoteQuickTitle')->where(array('id'=>$id))->find();
        $data=D('VoteQuickResult')->where(array('reid'=>$id))->field('office_id,user')->group('user')->select();
//        $res = array();
//        foreach($data as $item) {
//            if(! isset($res[$item['office_id']])) {
//                $res[$item['office_id']] = $item;
//            } else {
//                $res[$item['office_id']]['user'] .= ',' . $item['user'];
//            }
//        }
        $res=array();
        foreach ($data as $key => $info) {
            $res[$info['office_id']]['sub'][] = $info;
        }
        $this->assign('data',$res);
        $this->display();
    }
    //导出excel
    public function user_export(){
        $id=I('id');
        $data=D('VoteQuickResult')->where(array('reid'=>$id))->field('office_id,user')->group('user')->select();
        $title=array('办事处','用户');
        $this->export_exl($data,'vote_user',$title);
    }
    /****投票明细表****/
    public function detailed(){
        $id=I('id');
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        /*获取信息*/
        $name=D('VoteQuickTitle')->where(array('id'=>$id,'uid'=>$uid))->find();
        $preid=$name['preid'];
        $this->assign('name',$name);
        /**/
        $item=D('VoteQuickItem')->data($preid,$uid);
        $this->assign('data',$item);
        $this->display();
    }
    //导出excel
    public function detailed_export(){
        $id=I('id');
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        /*获取信息*/
        $name=D('VoteQuickTitle')->where(array('id'=>$id,'uid'=>$uid))->find();
        $preid=$name['preid'];
        $this->assign('name',$name);
        /**/
        $item=D('VoteQuickItem')->data($preid,$uid);
        //去除数组中的图片字段
        foreach($item as $key=>$val){
            unset($item[$key]['picture']);
            if($val['result_value']==1){
                $item[$key]['result_value']='赞同';
            }elseif($val['result_value']==2){
                $item[$key]['result_value']='不赞同';
            }
        }
        $title=array('设计师','办事处','投票人','系列','颜色','性别','投票号','结果');
        $this->export_exl($item,'vote_detailed',$title);
    }

    /****投票比例表****/
    public function scaling(){
        $id=I('id');
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        /*获取信息*/
        $name=D('VoteQuickTitle')->where(array('id'=>$id,'uid'=>$uid))->find();
        $preid=$name['preid'];
        $count=$name['count'];
        $this->assign('name',$name);
        /**/
        $item=D('VoteQuickItem')->where(array('pid'=>$preid,'uid'=>$uid))->relation(true)->select();
        foreach($item as $key => $val){
            foreach ($val['itname'] as $k=>$v){
                if($v['result_value']==1) {
                    $val['count'] += 1;
                }else{
                    $val['count'] += 0;
                }

            }
            $val['uncount']=$count-$val['count'];
            $val['pro']=sprintf("%.2f",$val['count']/$count*100);
            $item[$key]=$val;
        }
        $this->assign('item',$item);
        $this->display();
    }
    //导出excel
    public function scaling_export(){
        $id=I('id');
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        /*获取信息*/
        $name=D('VoteQuickTitle')->where(array('id'=>$id,'uid'=>$uid))->find();
        $preid=$name['preid'];
        $count=$name['count'];
        $this->assign('name',$name);
        /**/
        $item=D('VoteQuickItem')->where(array('pid'=>$preid,'uid'=>$uid))->field('id,designer,series,colour,sex,vote_id')->relation(true)->select();
        foreach($item as $key => $val){
            $val['allcount']=$count;
            foreach ($val['itname'] as $k=>$v){
                if($v['result_value']==1) {
                    $val['count'] += 1;
                }else{
                    $val['count'] += 0;
                }

            }
            $val['uncount']=$count-$val['count'];
            $val['pro']=sprintf("%.2f",$val['count']/$count*100);

            unset($val['itname']);
            unset($val['id']);
            $item[$key]=$val;
        }
        $title=array('设计师','系列','颜色','性别','投票号','总','赞成','不赞成','比例');
        $this->export_exl($item,'vote_scaling',$title);

    }
    /****投票汇总表****/
    public function pool(){
        $id=I('id');
        /*获取信息*/
        $name=D('VoteQuickTitle')->where(array('id'=>$id))->find();
        $preid=$name['preid'];
        $this->assign('name',$name);
        /**/
        $item=D('VoteQuickItem')->where(array('pid'=>$preid))->select();
        $res=array();
        foreach ($item as $key => $info) {
            $res[$info['designer']]['sub'][] = $info;
        }
        p($res);
        die;
        $res=D('VoteQuickResult')->where(array('reid'=>$id))->group('user')->select();

        die;
        $this->display();
    }
    /****设计师查看****/
    public function designer(){
        $this->display();
    }
    //获取设计师
    public function get_designer(){
        $desh=I('desh');
        $Opadmin=new Opadmin();
        $uname=$Opadmin->getUsername();
        $uid=$Opadmin->getUserid();
        if($uid!=1){
            $data[]['designer']=$uname;
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            $title=D('VoteQuickTitle')->where(array('title'=>$desh))->field('preid')->find();
            $name=D('VoteQuickItem')->where(array('pid'=>$title['preid']))->group('designer')->field('designer')->select();
            echo json_encode($name,JSON_UNESCAPED_UNICODE);
        }
    }
    //获取投票批次
    public function get_pi(){
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        if($uid!=1){
            $where['designer']=$Opadmin->getUsername();
        }
        $data=D('VoteQuickItem')->where($where)->group('uid,pid')->order('id')->select();
        foreach ($data as $key=>$value){
            $where['uid']=$value['uid'];
            $where['preid']=$value['pid'];
            $title=D('VoteQuickTitle')->where($where)->find();
            if($title)
                $ds['title'][]=$title['title'];
        }
        foreach ($ds as $k1=>$v1){
            $res=$v1;
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
    }
    //获取投票信息
    public function get_desit(){
        $get=I('get.');
        $pid=D('VoteQuickTitle')->where(array('title'=>$get['pi']))->find();
        $data=D('VoteQuickItem')->where(array('pid'=>$pid['preid'],'designer'=>$get['des']))->select();
        foreach ($data as $key=>$value){
            $vid='v'.$value['id'];
            //获取赞同数量
            $count=D('VoteQuickResult')->where(array('result_key'=>$value['id'],'result_value'=>1))->count();
            //获取意见
            $opinion=D('VoteQuickResult')->where(array('result_key'=>$vid))->field('result_value')->select();
            foreach ($opinion as $k=>$v){
                $value['opin'].=$v['result_value'].',';
            }
            //组合百分比
            $value['count']=sprintf("%.2f",$count/$pid['count']*100);
            $data[$key]=$value;
        }
        //echo D('VoteQuickItem')->_sql();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

}