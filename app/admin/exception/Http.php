<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 10:47
 */

namespace app\admin\exception;

use think\exception\Handle;
use think\Response;
use Throwable;
class Http extends Handle
{
    public $httpStatus = 501;
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        if(method_exists($e, "getStatusCode")){
            $httpStatus = $e->getStatusCode();
        }else{
            $httpStatus = $this->httpStatus;
        }
        // 添加自定义异常处理机制
        return show(config("status.error"),$e->getMessage(),[],$httpStatus);

    }
}