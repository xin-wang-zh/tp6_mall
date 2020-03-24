<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 15:40
 */

namespace app\admin\controller;

use app\BaseController;
use think\captcha\facade\captcha;

class Verify extends BaseController
{

    public function index(){
        return captcha::create('abc');
    }
}