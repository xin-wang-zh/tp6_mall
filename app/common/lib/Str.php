<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 23:50
 */

namespace app\common\lib;


class Str
{
    /**
     * 生成一个登陆的token
     * @param $string
     */
    public static function getLoginToken($string){
        $str = md5(uniqid(md5(microtime(true)),true));//生成一个不会重复的字符串
        $token = sha1($str.$string);//加密
        return $token;
    }
}