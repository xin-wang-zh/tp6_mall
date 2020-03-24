<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 11:39
 */

namespace app\admin\controller;

use app\admin\controller\AdminBase;
use http\Url;
use think\facade\View;



class Login extends AdminBase
{
    //1.判断是否登陆
    public function initialize()
    {
//        if($this->isLogin()){
//            return $this->redirect(url('index/index'));
//           // return redirect(Url('/admin/index/index'));
//        }
    }

    //2.用中间件判断是否登陆

    public function index(){

        return View::fetch('login');
    }

    public function md5(){
       halt( session(config("admin.admin_session")) );


        echo md5("admin_jack_abc");
    }
    public function check(){
        if(!$this->request->isPost()){
            return show(config("status.error"),"请求方式出错");
        }

        $username = $this->request->param("username", "", "trim");
        $password = $this->request->param("password", "", "trim");
        $captcha = $this->request->request("captcha","","trim");

        $validate = new \app\admin\validate\AdminUser();
        $data =[
            'username' =>$username,
            'password' => $password,
            'captcha'  => $captcha,
        ];
        if(!$validate->check($data)){
            return show(config("status.error"),$validate->getError());
        }


        //if(!$username || !$password || !$captcha){
            //return show(config("status.error"),"参数不能为空");
        //}

//        if(!captcha_check($captcha)){
//            return show(config("status.error"),"验证码错误".$captcha);
//        }

        try{
            $result = \app\admin\business\AdminUser::login($data);
        }catch (\ Exception $e){
            return show(config("status.error"),$e->getMessage());
        }

        if($result){
            return show(config("status.success"),"登陆成功");
        }else{
            return show(config("status.error"),"登陆失败");
        }
    }
}