<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 17:04
 */

namespace app\common\model\mysql;


use think\Model;

class Category extends Model
{
    /**
     * 添加分类
     * @param $data
     * @return bool
     */
    public function add($data){
        if(!$data || !is_array($data)){
            return false;
        }
        return $this->save($data);
    }

    public function edit($data){
        if(!$data || !is_array($data)){
            return false;
        }

        return $this->update($data);
    }
    /**
     * 用name 获取分类信息
     * @param $name
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getInfoByName($name){
        if(!$name){
            return false;
        }
        $where = [
            'name' => $name,
        ];
        return $this->where($where)->find();
    }

    /**
     * 从数据库中获取所有正常状态的分类
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys($field = '*'){
        $where = [
            'status' => config('status.mysql.table_normal'),
        ];
        $order = [
            'listorder'=>'desc',
            'id' => 'desc'
        ];
        $categorys = $this->where($where)->order($order)->field($field)->select();
        return $categorys;
    }

    /**
     * 从数据库中获取分类列表
     * @param string $where
     * @param int $num
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getList($where='', $num =10){
        $order = [
            'listorder'=>'desc',
            'id' => 'desc'
        ];

        $result = $this->where('status','<>',config('status.mysql.table_delete'))
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $result;

    }

    /**
     * 获取pid的子目录的个数
     * @param $pids
     * @return mixed
     */
    public function getpidChildCount($pids){

        $where[] = ['pid','in',$pids];
        $where[] = ['status','<>',config('status.mysql.table_delete')];

        $result = $this->where($where)
                       ->field(['pid','count(*) as count'])
                       ->group('pid')
                       ->select();

        return $result;
    }

    /**
     * 通过id更新数据库数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data){
        $data['update_time'] = time();
        return $this->where('id',$id)->save($data);
    }

}