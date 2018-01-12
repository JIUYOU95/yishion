<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 16:02
 */

namespace Common\Model;


class ProjectModel extends BaseModel {
    protected $pk='id';
    protected $tableName = 'project';
    protected $_validate = [
        ['name','require','方案不能为空'],
    ];
}