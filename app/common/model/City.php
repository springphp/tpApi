<?php
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;
class City extends Model{
    /*@param 省市区联查
     *@param  int  $province   省id
     *@param  int  $city       市id
     *@param  int  $city       区id
     *@return arr  $areasArr   返回值
     * @param   pengqiang  2017-05-20
     * */
    public function get_city($areas=""){
        foreach ($areas as $key => $val){
            if($val){
              $where['city_id'] = $val;
              $area = $this->where($where)->find();
              $list = $area->toArray();
              $areasArr[$key]= $list['city_name'];
            }
        }
        return  $areasArr;
    }

/*
 * 省市联动
 * */
    public function getareas($data){
        if ($data){
            $where['pid'] = $data['pid'];
        }
        return  $this->where($where)->order('city_id','asort')->select();
    }


}