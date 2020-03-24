<?php
// 应用公共文件
/**
 * 通用化API数据格式
 * @param $status
 * @param $message
 * @param array $data
 * @param int $httpStatus
 * @return \think\response\Json
 */
function show($status, $message,$data=[],$httpStatus=200){
    $result =[
        "status" => $status,
        "message" => $message,
        "data" =>$data,
    ];

    return json($result,$httpStatus);
}
