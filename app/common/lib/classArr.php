<?php
/**
 *Descript:工厂模式的基础类库
 *User: jack wang
 *Date: 2020-03-22
 *Time: 15:12
 */

namespace app\common\lib;


class classArr
{
    public static function SmsClassStat(){
        return [
            'Ali' => "app\common\lib\sms\AliSms",
            'Baidu' => "app\common\lib\sms\BaiDuSms",
            'Jd' => "app\common\lib\sms\JdSms",
        ];
    }

    public static function uploadClassStat(){
        return [
            'file' => 'xxx',
            'image' => 'xxx',
        ];
    }

    public static function initClass($type, $classes,$param =[], $needInstance = false){
        //如果工厂模式调用的是静态方法，那么只要返回类库 如AliSms
        //如果不是静态模式，我们需要返回实例化 对象
        if(!array_key_exists($type, $classes)){
            return false;
        }
        $className = $classes[$type];
        // new ReflectionClass('A') => 建立反射类('A');
        // ->newInstanceArg($arg) => 相当于建立实例化A对象
        return $needInstance == true ? (new ReflectionClass($className))->newInstanceArg($param) :  $className;
    }
}