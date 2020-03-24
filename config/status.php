<?php
/**
 *Descript:该文件主要存放业务状态码相关的配置
 *User: jack wang
 *Date: 2020-03-19
 *Time: 13:07
 */

return [
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "user_is_register" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,

    "mysql"=>[
        "user_normal" => 1,
        "user_pending" => -1,
        "user_delete" =>99,
    ]
];