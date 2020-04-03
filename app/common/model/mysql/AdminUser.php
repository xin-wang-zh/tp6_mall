<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 17:04
 */

namespace app\common\model\mysql;


use think\Model;

class AdminUser extends Model
{
    public function getAdminUserByusername($username){
        if(!$username){
            return false;
        }
        $where = [
            "username" => trim($username),
        ];
        $result =$this->where($where)->find();

        return  $result;
    }

    /**
     * updateById
     * 根据用户ID更新用户表
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data){
        $id = intval($id);
        if(!$id || empty($data) || !is_array($data)){
            return false;
        }
        $where = [
            "id" => $id,
        ];
        $this->where($where)->save($data);
    }


}