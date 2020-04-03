<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-31
 *Time: 13:42
 */

namespace app\common\lib;


class Status
{
    public static function getStatus(){
        $status = config('status.mysql');
        return array_values($status);
    }
}