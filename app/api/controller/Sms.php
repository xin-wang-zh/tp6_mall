<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 23:08
 */
declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;
use app\api\validate\User;
use app\common\business\Sms as BusiSms;

class Sms extends BaseController
{
    public function code():object {
        $phoneNumber = input('param.phone_number','','trim');
        $data = [
            'phone_number' => $phoneNumber,
        ];
        try{
            validate(User::class)->scene('sendCode')->check($data);
        }catch (\think\Exception\ValidateException  $e){
            return  show(config('status.error'), $e->getError());
        }

        //调用business层方法
        if(BusiSms::sendCode($phoneNumber,4,$type='Ali')){
            return  show(config('status.success'),"短信发送成功");
        }else{
            return  show(config('status.error'),"短信发送失败");
        };


    }
}