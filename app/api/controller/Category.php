<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-04-01
 *Time: 8:08
 */
namespace app\api\controller;

use app\common\business\Category as CategoryBusi;
use think\facade\Log;


class Category extends ApiBase
{

    public function index(){
        try{
            $categoryObj = new CategoryBusi();
            $categorys = $categoryObj->getNormalAllCategorys();
        }catch (\Exception $e){
            Log::ERROR('api-contro-category-index: '.$e->getMessage());
            return show(config('status.success'),'ok');
        }

        if(!$categorys){
            return show(config('status.success'),'ok');
        }

        $result = \app\common\lib\Arr::getTree($categorys);
        $result = \app\common\lib\Arr::sliceTreeArr($result);
        return show(config('status.success'),'ok',$result);
    }


}