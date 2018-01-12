<?php namespace Common\Common;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 14:15
 */
class Opadmin {
    private $username;//用户名
    private $password;//密码
    private $userid;  //用户id
    private $kUserid = 'userid';
    private $kUsername = 'username';

    /**
     * +----------------------------------------------------------
     * 构造函数，对象初始化
     * +----------------------------------------------------------
     *
     * @param string $username 用户名
     * @param string $password 密码
     *                         +----------------------------------------------------------
     */
    Public function __construct($username = '', $password = '') {
        $this->cfg_prefix = 'yishion_';
        //$this->cfg_prefix='card_';
        //给保存SESSION的成员变量名称加上前缀
        $this->kUserid = $this->cfg_prefix . $this->kUserid;
        $this->kUsername = $this->cfg_prefix . $this->kUsername;
        //用于登陆的时候初始化变量
        $this->username = $username;
        $this->password = $this->joinmd5($password);
        //判断session是否存在，存在就赋值
        if (isset($_SESSION[ $this->kUserid ]) && $_SESSION[ $this->kUserid ] != '')
            $this->userid = $_SESSION[ $this->kUserid ];
        if (isset($_SESSION[ $this->kUsername ]) && $_SESSION[ $this->kUsername ] != '')
            $this->username = $_SESSION[ $this->kUsername ];
    }

    /**
     * 用户登陆
     * @return bool
     */
    public function login() {
        $Admin = D('Admin');
        $where['username'] = $this->username;
        $where['password'] = $this->password;
        $data = $Admin->where($where)->find();
        if ($data) {
            //登陆成功赋值
            $this->userid = $data['id'];
            $this->username = $data['username'];
            $this->SaveSession();
            //更新登陆信息
            $data['loginip'] = get_client_ip();

            if($this->status($data)) {
                if ($this->updateinfo($data))
                    return 1;   //登录成功
                else
                    return 0;   //数据更新失败
            }else{
                return 3;
            }

        } else {
            return 2;   //用户名和密码错误
        }
    }

    /**
     * 检查用户状态
     * @param $data
     *
     * @return bool
     */
    public function status($data){
        if($data['status']=='2'){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 保存session
     */
    private function SaveSession() {
        $_SESSION[ $this->kUserid ] = $this->userid;
        $_SESSION[ $this->kUsername ] = $this->username;
    }

    /**
     * 用户退出
     * @return bool
     */
    public function loginout(){
        $this->userid="";
        $this->username="";
        unset($_SESSION[$this->kUserid]);
        unset($_SESSION[$this->kUsername]);
        return true;
    }

    /**
     * 更新用户信息
     * @param $data
     *
     * @return bool
     */
    public function updateinfo($data) {
        $user = D('Admin');
        $data['logintime'] = time();
        $data['id'] = $this->userid;
        $count =$user->field('logintime,loginip,id')->save($data);
        if ($count)
            return true;
        else
            return false;
    }

    /**
     * md5加密
     * @param $pwd
     *
     * @return string
     */
    public function joinmd5($pwd) {
        return md5($pwd);
    }

    /**
     * 获取userid
     * @return mixed
     */
    public function getUserid(){
        return $this->userid;
    }

    /**
     * 获得username
     * @return mixed
     */
    public function getUsername(){
        return $this->username;
    }
}