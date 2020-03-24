<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 9:24
 */

namespace app\api\Validate;


use think\Validate;

class User extends Validate
{
    protected  $rule = [
        'username' => 'require',
        'phone_number' =>'mobile|require',
        'type' => 'require|in:1,2',
        'code' => 'require|number|min:4',
        'sex'  => 'require|in:0,1,2'
    ];

    protected $message = [
        'username' => '用户名不能为空',
        'phone_number.mobile' => '手机号错误',
        'phone_number.require' => '手机号不能为空',
        'type.require' => '类型必须',
        'type.in' =>'类型数值错误',
        'code.require' => '短信验证码必须',
        'code.number' => '短信验证码为数字',
        'code.min' => '短信验证码最小长度为4',
        'sex.require' => '性别必须',
        'sex.in' => '性别数值错误',
    ];

    protected $scene = [
        'sendCode' => ['phone_number'],
        'login' =>['phone_number','type','code'],
        'updateUser' => ['username','sex'],
    ];


}