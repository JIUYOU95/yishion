<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 14:06
 */

namespace Reception\Controller;


class InspectController extends OAuthController {

    public function tasknew(){

        $this->display();
    }
    //获取店铺
    public function get_shopin(){
        $shop=D('Store');
        $where['shopnum']=I('number');
        $data=$shop->where($where)->find();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}