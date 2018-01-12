<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/1
 * Time: 15:39
 */

namespace Module\Controller;


use Common\Common\Category;
use Common\Common\Opadmin;
use Common\Controller\AuthController;
use Think\Upload;

class ShopinController extends AuthController {
    //巡店记录
    public function lists(){
        $this->display();
    }
    //门店管理
    public function store(){
        $model = D('Store');
        if (IS_POST){
            $topL=I('topL');//获取大区
            $topS=I('topS');//获取小区
            $name=I('name');//店铺名称
            if($topL){
                $data['larea']=$topL;
            }
            if($topS){
                $data['sarea']=$topS;
            }
            if($name){
                $data['name']=array('like',array('%'.$name.'%'));
            }
        }
        $data=$model->getPage($data,'id','15');
        $this->assign('data',$data);
        $this->larea=$model->distinct(true)->getField('larea',true);
        $this->display();

    }

    //新增门店
    public function add_store(){
        if(!IS_POST) E('页面不存在');
        $model = D('Store');
        $result=$model->store(I('post.'));
        if ($result){
            $this->success('操作成功',U('store'));
        }else{
            $this->error('操作失败');
        }
    }
    //修改门店
    public function edit_store(){
        $model = D('Store');
        $id=I('id');
        $data=$model->find($id);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //删除门店
    public function del_store(){
        $id=I('id');
        $model = D('Store')->delete($id);
        if($model){
            $this->success('门店删除成功',U('store'));
        }else{
            $this->error('门店删除失败');
        }

    }
    //获取小区
    public function get_sarea(){
        $sarea=I('topL');
        $model = D('Store');
        $data=$model->distinct(true)->where(array('larea'=>$sarea))->getField('sarea',true);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    //门店列表
    public function get_store(){
        $input = file_get_contents("php://input",true);
        $currentPage=json_decode($input)->currentPage;
        $itemsPerPage=json_decode($input)->itemsPerPage;
        $topL=json_decode($input)->topL;//获取大区
        $topS=json_decode($input)->topS;//获取小区
        $name=json_decode($input)->name;//店铺名称
        if($topL){
            $data['larea']=$topL;
        }
        if($topS){
            $data['sarea']=$topS;
        }
        if($name){
            $data['name']=array('like',array('%'.$name.'%'));
        }
        $currentPage=($currentPage-1)*$itemsPerPage;//计算开始条目
        $model = D('Store');
        $count=$model->where($data)->count();// 查询满足要求的总记录数
        $data=$model->where($data)->limit($currentPage,$itemsPerPage)->select();//数据
        //echo $model->_sql();
        $result['items']=$data; //组合分页数据
        $result['total']=$count['tp_count'];
        $model_data=json_encode($result,JSON_UNESCAPED_UNICODE);
        echo $model_data;
    }
    //门店导入
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
        $upload->savePath  =     'excel/'; // 设置附件上传（子）目录
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
        $module=M('Store');
        $old = $module->count();
        S('a',$old);
        // 重新排序
        sort($exl);
        foreach ($exl as $item){
            $data['name']=$item[0];
            $data['shopnum']=$item[1];
            $data['larea']=$item[2];
            $data['sarea']=$item[3];
            $data['address']=$item[4];
            $module->add($data);
        }
        $count = $module->count();
        // 检测表格导入成功后，是否有数据生成
        $n = S('a');
        if($count<$n){
            $this->error('未检测到有效数据');
            S('a',null);
        }else{
            $this->success('文件导入成功！',U('store'));
            // 删除Excel文件
            S('a',null);
            unlink($file_name);
        }
    }

    //评分配置
    public function score(){
        $project=D('Project');
        $Opadmin=new Opadmin();
        if(IS_POST){
            $data=I('post.');
            $data['uid']=$Opadmin->getUserid();
            $result=$project->store($data);
            if($result){
                A('Log')->add_log('操作评分方案-'.I('name'));
                $this->success('操作评分方案成功',U('score'));
            }else{
                $this->error('操作评分方案失败');
            }
        }else{
            $this->display();
        }

    }
    //获取方案
    public function get_project(){
        $project=M('Project');
        $Opadmin=new Opadmin();
        $data['uid']=$Opadmin->getUserid();
        $data=$project->where($data)->select();
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        echo $data;
    }
    //删除方案
    public function del_project(){
        $id=I('id');
        $project=D('Project');
        $result=$project->delete($id);
        if($result){
            A('Log')->add_log('操作评分方案-'.I('name'));
            echo '方案删除成功';
        }else{
            echo '方案删除失败';
        }
    }
    //评分方案
    public function plugin(){
        $item=D('Item');
        if(IS_POST){
            $result=$item->store(I('post.'));
            if($result){
                A('Log')->add_log('项目操作-'.I('name'));
                $this->success('项目操作成功',U('plugin',array('id'=>I('pid'))));
            }else{
                $this->error('项目操作失败');
            }
        }else {
            $pid = I('id');
            $this->assign('pid', $pid);
            $this->display();
        }

    }
    //获取评分方案
    public function get_item(){
        $item=D('Item');
        $pid = I('id');
        //$data=$item->where(array('pid'=>$pid))->getTreeData('tree','sort','name','id','reid');
        $data=$item->where(array('pid'=>$pid))->select();
        $data=Category::unlimitedForLayer($data,'child','0','reid');
        $data=array_merge($data);
        echo json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
    //项目排序
    public function item_order(){
        $data=I('post.');
        $result=D('Item')->orderData($data,'id','sort');
        if ($result) {
            A('Log')->add_log('菜单排序');
            $this->success('排序成功');
        }else{
            $this->error('排序失败');
        }
    }
    //删除项目
    public function delete_item() {
        $id = I('get.id');
        $map = array('id' => $id);
        $result = D('Item')->deleteData($map);
        if ($result) {
            A('Log')->add_log('删除项目-' . I('name'));
            echo "删除项目成功";
        } else {
            echo "请先删除子项目";
        }
    }
}