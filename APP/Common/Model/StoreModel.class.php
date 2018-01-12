<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 16:02
 */

namespace Common\Model;


class StoreModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'store';
    protected $_validate = [
        ['name','require','门店名称不能为空'],
        ['larea','require','大区不能为空'],
        ['sarea','require','小区不能为空'],
    ];
}