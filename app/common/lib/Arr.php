<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-04-01
 *Time: 8:24
 */

namespace app\common\lib;

Class Arr{
    /**
     * 分类树，支持无限极分类
     * @param $data
     */
    public static function getTree($data){
        $items = [];
        foreach ($data as $v){
            $items[$v['category_id']] =$v;
        }

        $tree = [];
        foreach ($items as $id=>$item){
            if(isset($items[$item['pid']])){
                $items[$item['pid']]['list'][] = &$items[$id];
            }else{
                $tree[] = &$items[$id];
            }
        }
        return $tree;
    }

    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5){
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if(!empty($v['list'])){
                $data[$k]['list'] = array_slice($v['list'], 0, $secondCount);
                foreach ($v['list'] as $kk => $vv){
                    if(!empty($vv['list'])){
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                    }
                }
            }
        }

        return $data;
    }
}