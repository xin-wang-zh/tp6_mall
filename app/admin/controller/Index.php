<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 16:06
 */

namespace app\admin\controller;



use think\facade\View;

class Index extends AdminBase
{
    public function Index(){

        return View::fetch();
    }

    public function welcome(){
        return View::fetch();
    }
}