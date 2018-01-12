<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 15:31
 */

namespace Common\Model;

class VoteQuickTitleModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'vote_quick_title';
    protected $_validate = [
        ['title','require','投票名称不能为空'],
        ['preid','require','图片批次不能为空'],
        ['title','checkName','投票名称已经存在',0,'callback',1],
    ];

    protected function checkName($typename){
        $Category=M('VoteQuickTitle');
        $where['title']=$typename;
        $count=$Category->where($where)->count();
        if($count>0)
            return false;
        else
            return ture;
    }
}