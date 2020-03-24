<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-24
 *Time: 19:48
 */

namespace app\api\controller;


class Logout extends AuthBase
{
    public function index(){
        //删除redis中的token;
        $res = cache(config('redis.token_pre').$this->token,NUll);

        if($res){
            return show(config('status.success'),'退出登陆成功');
        }
        return show(config('status.error'),'退出登陆失败');


    }
}