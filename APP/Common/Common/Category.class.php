<?php namespace Common\Common;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 13:51
 */
class Category {
    private $childid;//栏目的所有子栏目id,id之间是用逗号隔开
    //组合一维数组
    Static Public function unlimitedForLevel($cate,$html='├',$reid=0,$level=0){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$reid){
                $v['level']=$level+1;
                $v['html']=str_repeat($html,$level);
                $arr[]=$v;
                $arr=array_merge($arr,self::unlimitedForLevel($cate,$html,$v['id'],$level+1));
            }
        }
        return $arr;
    }
    //组合多维数组
    Static Public function unlimitedForLayer($cate,$name='child',$reid=0,$pid='pid'){
        $arr=array();
        foreach($cate as $v){
            if($v[$pid]==$reid){
                $v[$name]=self::unlimitedForLayer($cate,$name,$v['id'],$pid);
                $arr[]=$v;
            }
        }
        return $arr;
    }
    //传递一个子分类ID返回所有父级分类
    Static Public function getParents($cate,$id){
        $arr=array();
        foreach($cate as $v){
            if($v['id']==$id){
                $arr[]=$v;
                $arr=array_merge(self::getParents($cate,$v['pid']),$arr);
            }
        }
        return $arr;
    }
    //传递一个父分类ID返回所有子级分类ID
    Static Public function getChildsId($cate,$reid){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$reid){
                $arr[]=$v['id'];
                $arr=array_merge($arr,self::getChildsId($cate,$v['id']));
            }
        }
        return $arr;
    }
    //传递一个父分类ID返回所有子级分类
    Static Public function getChilds($cate,$reid){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$reid){
                $arr[]=$v;
                $arr=array_merge($arr,self::getChilds($cate,$v['id']));
            }
        }
        return $arr;
    }
}