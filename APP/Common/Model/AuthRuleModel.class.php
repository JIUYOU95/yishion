<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 11:47
 */

namespace Common\Model;


class AuthRuleModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'auth_rule';
    protected $_validate = [
        ['name','require','权限路径不能为空'],
        ['title','require','权限名称不能为空'],
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
        $result=$this->where($map)->delete();
        return $result;
    }
}