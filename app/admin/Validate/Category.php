<?php
/**
 *Descript:  登陆参数验证
 *User: jack wang
 *Date: 2020-03-20
 *Time: 9:14
 */
namespace app\admin\Validate;

use think\Validate;
use app\common\lib\Status;

class Category extends Validate{


    protected  $rule = [
        "name" => 'require',
        "pid" => 'require|number',
        'sort' => 'require|number',
        'status' => 'require|checkStatus',
        ];

    protected $message = [
        "username" => "分类名不为空",
        'pid.require' => "父级ID不为空",
        'parent.number' => "父级ID只能是数字",
        'status.require'=> "状态值必须",
    ];

    protected $scene = [
        'categoryAdd' => ['name','pid'],
        'categorySort' => ['id','sort'],
        'categoryStatus' => ['id','status'],
        'categoryEdit' =>['id','name','pid'],
    ];

    protected function checkStatus($value, $rule, $data=[]){
        $status = Status::getStatus();
        if(!in_array($value,$status)){
            return '状态值错误';
        }
        return true;
    }

}