<?php
/**
 *Descript:  登陆参数验证
 *User: jack wang
 *Date: 2020-03-20
 *Time: 9:14
 */
namespace app\admin\Validate;

use think\Validate;

class AdminUser extends Validate{

    protected  $rule = [
        "username" => 'require',
        "password" => 'require',
        "captcha"  => 'require|checkCaptcha',
        ];

    protected $message = [
        "username" => "用户名不为空",
        'password' => "密码不为空",
        'captcha' => '验证码不为空',
    ];



    protected function checkCaptcha($value, $rule, $data=[]){
        if(!captcha_check($value)){
            return  "您的验证码输入错误";
        }
        return true;
    }
}