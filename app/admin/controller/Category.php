<?php
/**
 *Descript:分类管理
 *User: jack wang
 *Date: 2020-03-25
 *Time: 9:07
 */

namespace app\admin\controller;

use think\facade\View;
use app\common\business\Category as CategoryBusi;
use think\facade\Log;

class Category extends AdminBase
{
    public function index(){
        $pid = $this->request->param('pid','','trim');
        $pid = intval($pid);
        $where = [
            'pid' =>$pid,
        ];
        try{
            $categorys = (new CategoryBusi())->getList($where,5);
        }catch (\Exception $e){
            Log::ERROR('contro-category-index:'.$e->getMessage());
            $categorys = [];
        }

        return View::fetch('',[
            "categorys" =>$categorys,
            "pid" => $pid,
        ]);
    }

    /**
     * 添加分类页面展示
     * @return string
     * @throws \Exception
     */
    public function add(){
        try{
            $categorys = (new CategoryBusi())->getNormalCategorys();
        }catch (\Exception $e){
            Log::ERROR('contro-category-add:'.$e->getMessage());
            $categorys =  [];
        }

        return View::fetch('',["categorys" =>json_encode($categorys)]);
    }

    /**
     * 修改分类页面展示
     * @return \think\response\Json
     */
    public function edit(){
        if(!$this->request->isGet()){
            return show(config('status.error'),"请求方式出错");
        }
        $id = $this->request->param('id', '', 'trim');

        $id = intval($id);

        try{
            $rowInfo = (new CategoryBusi())->getById($id);
        }catch (\Exception $e){
            Log::ERROR('contro-category-edit:'.$e->getMessage());
            $rowInfo = [];
        }

        try{
            $categorys = (new CategoryBusi())->getNormalCategorys();
        }catch (\Exception $e){
            Log::ERROR('contro-category-add:'.$e->getMessage());
            $categorys =  [];
        }
        $rowInfo = $rowInfo->toArray();

        return View::fetch('',[
            'rowInfo' => $rowInfo,
            'categorys' =>json_encode($categorys),
        ]);
    }

    public function editsave(){
        if(!$this->request->isPost()){
            return show(config('status.error'),"请求方式出错");
        }
        //接受检查参数
        $pid = input('parent','','trim');
        $name = input('name', '', 'trim');
        $id = input('id', '', 'trim');
        $data = [
            'pid' => $pid,
            'name' => $name,
            'id' =>$id,
        ];
        $validate = new \app\admin\validate\Category();
        if(!$validate->scene('categoryEdit')->check($data)){
            return show(config('status.error'), $validate->getError());
        };

        $data['operate_user'] = $this->adminUser->operate_user;
        try{
            $result = (new CategoryBusi())->edit($data);
        }catch (\Exception $e){
            return   show(config('status.error'), $e->getMessage());
        }
        if($result){
            return   show(config('status.success'),'ok');
        }
        return   show(config('status.error'),'修改失败');
    }

    /**
     * 添加分类逻辑
     * @return \think\response\Json
     */
    public function save(){
        if(!$this->request->isPost()){
            return show(config('status.error'),"请求方式出错");
        }
        //接受检查参数
        $pid = input('parent','','trim');
        $name = input('name', '', 'trim');
        $data = [
            'pid' => $pid,
            'name' => $name,
        ];
        $validate = new \app\admin\validate\Category();
        if(!$validate->scene('categoryAdd')->check($data)){
            return show(config('status.error'), $validate->getError());
        };

        $data['operate_user'] = $this->adminUser->operate_user;
        try{
            $result = (new CategoryBusi())->add($data);
        }catch (\Exception $e){
            return   show(config('status.error'), $e->getMessage());
        }
        if($result){
            return   show(config('status.success'),'ok');
        }
        return   show(config('status.error'),'新增失败');
    }

    public function listorder(){
        if(!$this->request->isGet()){
            return show(config('status.error'),"请求方式出错");
        }

        $id = $this->request->param('id', '', 'trim');
        $sort = $this->request->param('sort', '', 'trim');
        $data = [
            'id' => $id,
            'sort' =>$sort,
        ];
        $validate = new \app\admin\validate\Category();
        if(!$validate->scene('categorySort')->check($data)){
            return show(config('status.error'), $validate->getError());
        };

        try{
            $result = (new CategoryBusi())->orderlist($id, $sort);
        }catch (\Exception $e){
            Log::error('Category-orderlist-exception'.$e->getMessage());
            return   show(config('status.error'), $e->getMessage());
        }

        if($result){
            return show(config('status.success'),'OK');
        }
        return show(config('status.error'), '更新失败');
    }

    /**
     * 更改分类状态
     * @return \think\response\Json
     */
    public function status(){
        if(!$this->request->isGet()){
            return show(config('status.error'),"请求方式出错");
        }

        $id = $this->request->param('id', '', 'trim');
        $status = $this->request->param('status', '', '');
        $validate = new \app\admin\validate\Category();
        $data = [
            'id' =>$id,
            'status' => $status,
        ];

        if(!$validate->scene('categoryStatus')->check($data)){
            return show(config('status.error'),$validate->getError());
        };

        try{
           $result = (new CategoryBusi())->status($id,$status);
        }catch (\Exception $e){
            Log::error('Category-status-exception'.$e->getMessage());
            return   show(config('status.error'), $e->getMessage());
        }

        if($result){
            return show(config('status.success'), '状态更新成功');
        }
        return show(config('status.error'),'状态更新失败');

    }

}