<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 10:05
 */

namespace app\admin\business;

use app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminUser
{
    public static function login($data){
        try{
            $AdminUserObj = new AdminUserModel();
           $AdminUser = self::getAdminUserByusername($data['username']);
            //判断用户是否存在
            if(empty($AdminUser)){
                throw new Exception("该用户不存在");
                //return show(config("status.error"), "该用户不存在");
            }
            //判断密码是否正确
            if($AdminUser->password != md5($data['password']."_jack_abc")){
                throw new Exception("密码错误");
                //return show(config("status.error"), "密码错误");
           }
            //更新数据库数据
            $updateData =[
                "last_login_time" =>time(),
                "last_login_ip" => request()->ip(),
                "update_time" =>time(),
            ];
            $res = $AdminUserObj->updateById($AdminUser->id,$updateData);
            if($res){
                throw new Exception("登陆失败");
                //return show(config("status.error"), "登陆失败");
            }

        }catch (\Exception $e){
            // todo 记录日记 $e->getMessage();
            throw new Exception($e->getMessage());
            //return show(config("status.error"), "登陆失败，内部错误");
        }
        //保存session信息
        session(config("admin.admin_session"), $AdminUser);
        return true;
    }

    public static function getAdminUserByusername($username){
        $AdminUserObj = new AdminUserModel();
        $AdminUser = $AdminUserObj->getAdminUserByusername($username);
        //判断用户是否存在
        if(empty($AdminUser) || $AdminUser->status != config("status.mysql.user_normal")){
            return false;
        }
        return $AdminUser;
    }
}