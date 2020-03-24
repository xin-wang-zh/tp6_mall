<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 23:56
 */

namespace app\common\lib;


class Time
{
    public static function userLoginExpireTime($type){
        $type == 1 ? $type = 1 : $type ==2;
        if($type ==1){
            $day = $type *7;
        }
        if($type ==2){
            $day = 30;
        }
        return $day * 24 *3600;
    }
}