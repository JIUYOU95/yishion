<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 13:59
 */

namespace Common\Model;


class ConfigModel extends BaseModel {
    protected $pk = 'id';
    protected $tableName = 'config';
    protected $_validate = [
        ['system','require','系统配置不能为空'],
        ['wechat','require','公众号配置不能为空']
    ];

    //保存数据
    public function store( $data ) {
        $data['id']=1;
        return parent::store($data);
    }
}