<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 23:02
 */

namespace app\admin\middleware;


class Auth
{
    public function handle($request, \Closure $next)
    {
        $arr = ['Login','Verify','Logout'];

        if(empty(session(config("admin.admin_session"))) &&  !preg_match("/[login|Verify|Logout]/", $request->pathInfo())){

            return redirect(url('/admin/login/index'));
        }

//        if(!empty(session(config("admin.admin_session"))) &&  preg_match("/login/", $request->pathInfo())){
//            return redirect(url('/admin/index/index'));
//        }
        //前置中间件
        $response =  $next($request);
        //后置中间件
//        $arr = ['Login','Verify','Logout'];
//
//        if(empty(session(config("admin.admin_session"))) && !in_array($request->controller(), $arr)){
//            echo "aaa";
//            //return redirect(url('/admin/login/index'));
//        }

//        if( session(config("admin.admin_session")) && $request->controller() == "Login"){
//            echo $request->controller();
//
//            //return redirect(url('/admin/index/index'));
//        }
        return $response;
    }
}