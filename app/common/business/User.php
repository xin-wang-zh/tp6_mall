<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 18:25
 */

namespace app\common\business;

use app\common\model\mysql\User  as UserModel;
use think\Exception;
use app\common\lib\Str;
use app\common\lib\Time;

class User
{
    protected $userObj = '';
    public function __construct()
    {
        $this->userObj = new UserModel();
    }

    /**
     * 登陆验证
     * @param $data
     * @return array|bool
     * @throws Exception
     */
    public function login($data){
        $redisCode = cache(config('redis.code_pre').$data['phone_number']);
        if(!$redisCode || $redisCode != $data['code']){
            //throw new \think\Exception('验证码错误', '-1009');
        }

        //没有数据,数据写入
        $user = $this->userObj->getUserByPhoneNumber($data['phone_number']);
        if(!$user){
            $username = 'mall_'.$data['phone_number'];
            $userData = [
                'phone_number' => $data['phone_number'],
                'username' => $username,
                'type' => $data['type'],
                'status' => config('status.mysql.user_normal'),
            ];
            try{
                $this->userObj->save($userData);
                $userId = $this->userObj->id;
            }catch (\Exception $e){
                throw new \think\Exception('数据库内部数据异常');
            }
        }else{
            $userId = $user->id;
            $username = $user->username;
            $updateData = [
                'last_login_time' => time(),
                'last_login_ip' => request()->ip(),
                'update_time' => time(),
            ];
            try{
                $this->userObj->updateByPhoneNumber($data['phone_number'],$updateData);
            }catch (Exception $e){
                throw new \think\Exception('数据库内部错误');
            }

        }

        $token = Str::getLoginToken($data['phone_number']);
        $redisData = [
            'id' => $userId,
            'username' => $username,
        ];

        $result = cache(config('redis.token_pre').$token, $redisData,Time::userLoginExpireTime($data['type']));

        return $result ? ['token'=>$token,'username'=>$username]: false;
    }

    /**
     * 通过ID获取正常用户信息
     * @param $id
     * @return array|bool
     */
    public function getNormalUserById($id){
        $user = $this->userObj->getUserById($id);
        if(!$user || $user->status != config('status.mysql.user_normal')){
            return false;
        }
        return $user->toArray();
    }

    /**
     * 通过Id更新用户数据
     * @param $id
     * @param $data
     */
    public function Update($id,$data){
        //检查用户是否存在
        $user = $this->userObj->getUserById($id);
        if(!$user){
            throw new \think\Exception('不存在该用户');
        }
        //检查用户名是否存在
        $userData = $this->userObj->getUserByUsername($data['username']);
        if($userData && $userData['id'] != $id){
            throw new \think\Exception('用户名已存在请重新设置');
        }
        //更新数据
        return $result = $this->userObj->UpdateById($id,$data);

    }
}