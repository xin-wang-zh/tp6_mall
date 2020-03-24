<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 11:33
 */
declare(strict_types =1);
namespace app\common\lib;


class Num
{
    /**
     * 获取4位或6位验证码
     * @param int $len
     * @return int
     */
    public static function getCode(int $len = 4): int{
        $code = rand(0000, 9999);
        if($len ==6){
            $code = rand(000000, 999999);
        }
        return $code;
    }
}