<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 23:15
 */
declare(strict_types=1);
namespace app\common\business;

use app\common\lib\sms\AliSms;
use app\common\lib\Num;
use think\facade\Log;
use app\common\lib\classArr;
class Sms
{
    public static function sendCode(string $phone,int $len, string $type='Ali'):bool {
        //生成4位数验证码
        $code = Num::getCode($len);

        $type = ucfirst($type);

        //工厂模式
//        $class =  "app\common\lib\sms\\".$type."Sms";
//        $sms = $class::sendCode($phone , $code);

        //1.再对接一个短信平台  2.短信到的流量控制  20%=>阿里云 80%=>百度云
        $classStat = classArr::SmsClassStat();

        $classObj = classArr::initClass($type,$classStat);

        $sms = $classObj::sendCode($phone,$code);
        if($sms){
            cache(config('redis.code_pre').$phone, $code,config('redis.code_expire'));
        }
        return  $sms;
    }
}