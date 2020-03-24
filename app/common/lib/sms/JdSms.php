<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 13:30
 */
declare(strict_types=1);
namespace app\common\lib\sms;



class JdSms implements SmsBase
{
    public static function sendCode(string $phone, int $code):bool{
        return true;
    }
}