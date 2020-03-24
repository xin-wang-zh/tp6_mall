<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-19
 *Time: 17:04
 */

namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 通过手机号码获取用户信息
     * @param $phoneNumber
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhoneNumber($phoneNumber){
        if(!$phoneNumber){
            return false;
        }
        $where = [
            "phone_number" => trim($phoneNumber),
        ];
        $result =$this->where($where)->find();

        return  $result;
    }

    /**
     * updateByPhoneNumber
     * 根据用户手机号码更新用户表
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateByPhoneNumber($phoneNumber, $data){
        $phoneNumber = trim($phoneNumber);
        if(!$phoneNumber || empty($data) || !is_array($data)){
            return false;
        }
        $where = [
            "phone_number" => $phoneNumber,
        ];
        $this->where($where)->save($data);
    }

    /**
     * 通过ID获取用户数据
     * @param $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($id){
        $id = intval($id);
        if(!$id){
            return false;
        }
        return $this->find($id);
    }

    /**
     * 通过用户名获取用户信息
     * @param $phoneNumber
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByUsername($username){
        if(!$username){
            return false;
        }
        $where = [
            "username" => trim($username),
        ];
        return  $result =$this->where($where)->find();
    }
    /**
     * 通过ID更改数据
     */
    public function UpdateById($id,$data){
        $id = intval($id);
        if(!$id || empty($data) || !is_array($data)){
            return false;
        }
        $where = [
            "id" => $id,
        ];
        return   $this->where($where)->save($data);
    }


}