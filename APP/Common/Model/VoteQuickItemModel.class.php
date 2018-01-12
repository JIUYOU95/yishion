<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/11
 * Time: 17:46
 */

namespace Common\Model;


use Think\Model;

class VoteQuickItemModel extends Model\RelationModel {
    protected $_link = array(
        'VoteQuickItem' => array(
            'mapping_type'  => self::HAS_MANY,
            'class_name'    => 'VoteQuickResult',
            'foreign_key'   => 'result_key',
            'mapping_name'  => 'itname',
        ),
    );
    //明细
    public function data($pid,$uid){
        $Model = new Model();
        $data=$Model->query("select i.designer,r.office_id,r.user,i.series,i.colour,i.sex,i.vote_id,i.picture,r.result_value from ys_vote_quick_item AS i RIGHT JOIN ys_vote_quick_result as r ON i.id=r.result_key and i.pid='$pid' and i.uid='$uid' ORDER BY i.vote_id");
        $reArr=array_filter($data,"delValue");
        return $reArr;
    }
    //比例
    public function item_data($pid,$uid){
        $Model = new Model();
        $data=$Model->query("select i.designer,r.office_id,r.user,i.series,i.colour,i.sex,i.vote_id,i.picture,r.result_value from ys_vote_quick_item AS i LEFT JOIN ys_vote_quick_result as r ON i.id=r.result_key and i.pid='$pid' and i.uid='$uid' ORDER BY i.vote_id");
        return $data;
    }



}