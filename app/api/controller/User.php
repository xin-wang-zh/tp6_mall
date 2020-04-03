<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-23
 *Time: 10:26
 */

namespace app\api\controller;

use app\common\business\User As UserBusi;
use app\common\lib\Time;

class User extends AuthBase
{
    public function index(){
        $user = (new UserBusi())->getNormalUserById($this->id);
        $result = [
            'id' => $this->id,
            'username' => $user['username'],
            'sex' => $user['sex'],
        ];
        return show(config('status.success'),'ok',$result);
    }

    public function update(){
        $username =  input('username', '', 'trim');
        $sex = input('sex', '', 'trim');

        $data = [
            'username' => $username,
            'sex' => $sex,
        ];
        $validate = (new  \app\api\validate\User())->scene('updateUser');
        if(!$validate->check($data)){
            return show(config('status.error'),$validate->getError());
        }

        $result = (new UserBusi())->Update($this->id, $data);
        if(!$result){
            return show(config('status.error'),'更新失败');
        }
        //更新redis中的用户名

        $redisData = [
            'id' => $this->id,
            'username' => $username,
        ];

        if($result){
           cache(config('redis.token_pre').$this->token, $redisData,Time::userLoginExpireTime(2));
        }
        return show(config('status.success'),'修改成功');
    }


}