<?php
/**
 *Descript:短信发送的接口定义，保证每种发送都是同一结构
 *User: jack wang
 *Date: 2020-03-22
 *Time: 13:33
 */
namespace app\common\lib\sms;

interface SmsBase {
    public static function sendCode(string $phone, int $code);
}