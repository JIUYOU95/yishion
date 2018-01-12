<?php namespace Common\Model;

use Think\Model;
use Think\Page;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 11:48
 */
class BaseModel extends Model {
    //数据的保存
    public function store($data) {
        if ($this->create($data)) {
            $acton = isset($data[ $this->pk ]) ? "save" : "add";
            $msg = isset($data[ $this->pk ]) ? "更新" : "新增";
            $res = $this->$acton($data);
            return ['status' => 'success', 'data' => $res, 'message' => $msg.'成功'];
        }

        return ['status' => 'failed', 'message' => $this->getError() ?: '未知错误'];
    }
    /**
     * 添加数据
     * @param  array $data  添加的数据
     * @return int          新增的数据id
     */
    public function addData($data){
        // 去除键值首尾的空格
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $id=$this->add($data);

        return $id;
    }
    /**
     * 修改数据
     * @param   array   $map    where语句数组形式
     * @param   array   $data   数据
     * @return  boolean         操作是否成功
     */
    public function editData($map,$data){
        // 去除键值首位空格
        foreach ($data as $k => $v) {
            $data[$k]=trim($v);
        }
        $result=$this->where($map)->save($data);
        return $result;
    }
    /**
     * 删除数据
     * @param   array   $map    where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map){
        if (empty($map)) {
            die('where为空的危险操作');
        }
        $result=$this->where($map)->delete();
        return $result;
    }
    /**
     * 数据排序
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($data,$id='id',$order='order_number'){
        foreach ($data as $k => $v) {
            $v=empty($v) ? null : $v;
            $this->where(array($id=>$k))->save(array($order=>$v));
        }
        return true;
    }
    /**
     * 获取全部数据
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTreeData($type='tree',$order='',$name='name',$child='id',$parent='pid'){
        //var_dump('Base');
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,$name,$child,$parent);
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;',$child);
        }
        return $data;
    }

    /**
     * 获取分页数据
     * @param        $map   条件
     * @param string $order 排序自动
     * @param int    $limit 数量
     * @param string $field 需要字段
     *
     * @return array
     */
    public function getPage($map,$order='',$limit=10,$field=''){
        $count=$this
            ->where($map)
            ->count();
        //$page=new_page($count,$limit);
        $page=new Page($count,$limit);
        $page->setConfig('prev','«');
        $page->setConfig('next','»');
        $page->setConfig('header','条');
        // 获取分页数据
        if (empty($field)) {
            $list=$this
                ->where($map)
                ->order($order)
                ->limit($page->firstRow.','.$page->listRows)
                ->select();
        }else{
            $list=$this
                ->field($field)
                ->where($map)
                ->order($order)
                ->limit($page->firstRow.','.$page->listRows)
                ->select();
        }
        $data=array(
            'data'=>$list,
            'page'=>$page->show()
        );
        return $data;
    }
}