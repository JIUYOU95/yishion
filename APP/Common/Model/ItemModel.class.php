<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 16:02
 */

namespace Common\Model;


class ItemModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'item';
    protected $_validate = [
        ['name','require','项目名称不能为空'],
    ];
    /**
     * 删除数据
     * @param	array	$map	where语句数组形式
     * @return	boolean			操作是否成功
     */
    public function deleteData($map){
        $count=$this
            ->where(array('reid'=>$map['id']))
            ->count();
        if($count!=0){
            return false;
        }
        $result=$this->where($map)->delete();
        return $result;
    }
}