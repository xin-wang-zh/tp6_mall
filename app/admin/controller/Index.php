<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 16:06
 */

namespace app\admin\controller;


use app\admin\controller\AdminBase;
use think\facade\View;

class Index extends AdminBase
{
    public function Index(){
        echo $ab;
        throw new \think\Exception\HttpException(404,'找不到该页面');
        return View::fetch();
    }

    public function welcome(){
        return View::fetch();
    }
}