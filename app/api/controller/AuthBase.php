<?php
/**
 *Descript:需要登录权限的基础控制器
 *User: jack wang
 *Date: 2020-03-23
 *Time: 10:23
 */

namespace app\api\controller;



class AuthBase extends ApiBase
{
    protected $token = '';
    protected $username = '';
    protected $id = '';
    public function initialize(){
        parent::initialize();

        $this->token = $this->request->header('access-token');
        if(!$this->token || !$this->isLogin()){
           return $this->show(config('status.not_login'),'没有登陆');
        }
    }

    /**
     * 检查用户是否登陆
     * @return bool
     */
    public function isLogin(){
        $userInfo  = cache(config('redis.token_pre').$this->token);
        if(!$userInfo){
            return false;
        }
        if(!empty($userInfo['id']) || empty($userInfo['username'])){
            $this->username = $userInfo['username'];
            $this->id = $userInfo['id'];
            return true;
        }
        return false;
    }
}