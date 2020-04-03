<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-22
 *Time: 18:25
 */

namespace app\common\business;

use app\common\model\mysql\Category  as CategoryModel;
use http\Exception;
use think\facade\Log;

class Category
{
    protected $model = '';
    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    /**
     * 添加分类业务
     * @param $data
     * @return mixed
     */
    public function add($data){

        $data['status']  = config('status.mysql.table_normal');
        $name = $data['name'];
        //根据name 去数据库检查name是否存在

        $nameResult = $this->model->getInfoByName($name);
        if($nameResult){
            throw new \think\Exception('改分类名已存在,请换分类名');
        }

        try{
            $this->model->add($data);
        }catch (\Exception $e){
            throw new \think\Exception('服务器内部错误');
        }

        return $this->model->id;
    }

    /**
     * 修改分类业务
     * @param $data
     * @return mixed
     */
    public function edit($data){

        $data['status']  = config('status.mysql.table_normal');
        $name = $data['name'];
        //根据name 去数据库检查name是否存在

        $nameResult = $this->model->getInfoByName($name);
        if($nameResult){
            throw new \think\Exception('改分类名已存在,请换分类名');
        }

        try{
            $result = $this->model->edit($data);
        }catch (\Exception $e){
            throw new \think\Exception('服务器内部错误');
        }

        return $result ;
    }

    /**
     * 获取所有状态正常的分类
     * @return array
     */
    public function getNormalCategorys(){
        $field = "id, name, pid";
        $categorys = $this->model->getNormalCategorys($field);
        if(!$categorys){
            return [];
        }
        $categorys = $categorys->toArray();
        return $categorys;
    }

    public function getNormalAllCategorys(){
        $field = "id as category_id, name, pid";
        $categorys = $this->model->getNormalCategorys($field);
        if(!$categorys){
            return [];
        }
        $categorys = $categorys->toArray();
        return $categorys;
    }


    /**
     * 获取分类列表
     * @param $where
     * @param $num
     * @return array
     */
    public function getList($where, $num){

        $list = $this->model->getList($where, $num);

        if(!$list){
            return [];
        }

        $result = $list->toArray();

        $result['render'] = $list->render();

        //获取子目录个数

        $pids = array_column($result['data'],'id');

        if($pids){

            try{
                $pidChildCount = $this->model->getpidChildCount($pids);
            }catch (\Exception $e){

                Log::ERROR('busi-categroy-getList: '.$e->getMessage());
                throw new \think\Exception($e->getMessage());
            }


            $pidChildCount = $pidChildCount->toArray(); //如果没有的话会返回空数组

            $idCount = [];

            foreach($pidChildCount as $value){
                $idCount[$value['pid']] = $value['count'];
            }
        }

        if($result['data']){
            foreach ($result['data'] as $k => $value){
                $result['data'][$k]['childCount'] = $idCount[$value['id']] ?? 0;
            }
        }

        return $result;
    }

    /**
     * 通过id获取信息
     * @param $id
     * @return bool
     */
    public function getById($id){
        $result =$this->model->find($id);
        if($result){
            return $result;
        }
        return false;
    }
    /**
     * 获取分类列表
     * @param $id
     * @param $sort
     */
    public function orderlist($id, $sort){
        $info = $this->getById($id);
        if(!$info){
            throw new \think\Exception('不存在该条记录');
        }
        $data = [
            'listorder'=>$sort
        ];
        try{
            $result = $this->model->updateById($id,$data);
        }catch (\Exception $e){
            //记录日志
            Log::ERROR('busi-Category-orderlist-exception: '.$e->getMessage());
            return false;
        }
        return $result;
    }

    /**
     * 更改分类记录状态
     * @param $id
     * @param $status
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function status($id, $status){
        $res = $this->getById($id);
        if(!$res){
            throw new \think\Exception('不存在该记录');
        }
        if($res['status'] ==$status){
            throw new \think\Exception('状态修改前和修改后一样，没有意义哦');
        }
        $data = [
            'status' => $status,
        ];
        try{
            $res = $this->model->updateById($id,$data);
        }catch (\Exception $e){
            Log::ERROR('busi-Category-status-exception: '.$e->getMessage());
            return false;
        }
        return $res;
    }

}