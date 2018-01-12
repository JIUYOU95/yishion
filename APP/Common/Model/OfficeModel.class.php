<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/10
 * Time: 17:46
 */

namespace Common\Model;


class OfficeModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'office';
    protected $_validate = [
        ['name','require','办事处名称不能为空'],
    ];
}