<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 17:32
 */

namespace Common\Model;

use Common\Common\Opadmin;
use Think\Auth;

class NavModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'nav';
    protected $_validate = [
        ['name','require','菜单名称不能为空'],
        ['mac','require','菜单链接不能为空'],
    ];
    /**
     * 删除数据
     * @param	array	$map	where语句数组形式
     * @return	boolean			操作是否成功
     */
    public function deleteData($map){
        $count=$this
            ->where(array('pid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $this->where(array($map))->delete();
        return true;
    }
    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @return array       	结构数据
     */
    public function getTree($type='tree',$order=''){
        //var_dump('Nav');
        $Opadmin=new Opadmin();
        $uid=$Opadmin->getUserid();
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order('order_number is null,'.$order)->select();
        }

        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;','id');
            if($uid == 1){
                return $data;
            }else{
                // 显示有权限的菜单
                $auth=new Auth();
                foreach ($data as $k => $v) {
                    if ($auth->check($v['mca'],$uid)) {
                        foreach ($v['_data'] as $m => $n) {
                            if(!$auth->check($n['mca'],$uid)){
                                unset($data[$k]['_data'][$m]);
                            }
                        }
                    }else{
                        // 删除无权限的菜单
                        unset($data[$k]);
                    }
                }

            }
        }
        //p($data);die;
        return $data;
    }
}