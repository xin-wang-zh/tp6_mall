<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 23:09
 */
use think\facade\route;

route::rule('smscode', 'sms/code', 'POST');
route::resource('user','User');