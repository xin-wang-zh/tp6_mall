<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 22:22
 */

namespace app\admin\controller;


class Logout extends AdminBase
{
    public function index(){
        session(config("admin.admin_session"), null);
        return redirect(url('login/index'));
    }
}