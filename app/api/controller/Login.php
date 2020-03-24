<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 17:54
 */
declare(strict_types=1);
namespace app\api\controller;


use app\BaseController;
use app\common\business\User;

class Login extends BaseController
{
    public function index():object{
        if(!$this->request->isPost()){
            return show(config('status.error'),'请求方式错误');
        }
        $phoneNumber = $this->request->param('phone_number','','trim');
        $code = input('code', '', 'trim');
        $type = input('type', '', 'trim');

        $data = [
            'phone_number' =>$phoneNumber,
            'code' =>$code,
            'type' => $type,
        ];
        $validate = new \app\api\validate\User();

        if(!$validate->scene('login')->check($data)){
            return show(config('status.error'),$validate->getError());
        };

        //调用business中User
        $UserObj = new User;
        $res = $UserObj->Login($data);

        return show(config('status.success'),'登陆成功',$res);
    }
}