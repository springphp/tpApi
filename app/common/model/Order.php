<?php
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;
/*
 * @param 订单类
 *@param  pengqiang 2017-05-20
 */
class Order extends Model{
   use SoftDelete;
    //商品 店铺关联
    public function shop(){
        return $this->hasOne('shop','shop_id','shop_id');
    }
    //关联地址-省
    public function province1(){
        return $this->hasOne('city','city_id','province');
    }
    //关联地址-市
    public function city1(){
        return $this->hasOne('city','city_id','city');
    }
    //关联地址-区
    public function area1(){
        return $this->hasOne('city','city_id','area');
    }
    //关联用户
    public function user(){
        return $this->hasOne('user','user_id','user_id');
    }

    /*
     * 订单列表
     * */
    public function order_list($data){
        $where =[];
        if(isValue($data,'order_id')){
            if(is_array($data['order_id'])){
                $where['order_id']     = ['in',$data['order_id' ]];
            }else{
                $where['order_id']     = $data['order_id' ];
            }
        }
        if(isValue($data,'user_id')){
            $where['user_id']     = $data['user_id' ];
        }
        if(isValue($data,'user_name')){
            $where['user_name']     = $data['user_name' ];
        }
        if(isValue($data,'order_sn')){
            $where['order_sn']    = $data['order_sn' ];
        }
        if(isValue($data,'datestart') && isValue($data,'dateend')){
            $datestart            = strtotime($data['datestart' ]);
            $dateend              = strtotime($data['dateend' ]);
            $where['create_time'] = ['BETWEEN',[$datestart,$dateend]];
        }
        if(isset($data['shop_id'])){
            $where['shop_id']   = $data['shop_id'];
        }
        if(isset($data['goods_id'])){
            if(!empty($data['goods_id'])){
                $where['order_id']   =['in',$data['goods_id']] ;
            }
        }
        if(isValue($data,'status')){
            $where['status']      = $data['status' ];
            if($data['status']==4){
                $order_status=4;
            }
        }
         if(isset($data['recycle'])){//回收站
             $where['recycle']   = $data['recycle'];
         }
        if(isset($data['page'])){//显示页数
            $page                 = $data['page'];
        }else{
            $page                 = 1;
        }
        unset($data['page']);
        unset($data['size']);
        $query  = $data;
        $orders = $this->where($where)->order('update_time desc')->paginate('',false,['page'=>$page,'query' => $query]);
        foreach ($orders as $k => &$v){
            if(isset($order_status)){
                $v['order_status'] =$order_status;
            }
            $v['shop_id']         = $v->shop->shop_name;
            $v['user_id']         = $v->user->account;
            $v['nickname']         = $v->user->nickname;
            if($v->province1->city_name){
                $v['province']        = $v->province1->city_name;
            }else{
                $v['province']        = '-----';
            }
            
            $v['city']            = $v->city1->city_name;
            $v['area']             = $v->area1->city_name;
            $v['statusText']      = $this->status($v['status']);
        }
        return $orders;
    }
    /*
     * 订单id
     * */
    public  function orders_id($data){
        if(isValue($data,'user_id')){
            $where['user_id']     = $data['user_id' ];
        }
        $where['status']          = 2;
        $array_id = $this->where($where)->field('order_id')->order('create_time desc')->select();
        resultToArray($array_id);
        foreach ($array_id as $key => &$val){
           $array_id[$key]        = $val['order_id'];
        }
        return $array_id;
    }
    /*
     * 订单详情
     * */
    public  function oder_info($order_sn){
          if($order_sn){
              $where['order_sn']  = $order_sn;
              $order = $this->where($where)->hasWhere('shop',['shop_id'=>5])->find();

              $order['shop_id']   = $order->shop->shop_name;
              $order['user_id']   = $order->user->account;
              $order['province']  = $order->province1->city_name;
              $order['city']      = $order->city1->city_name;
              $order['area']      = $order->area1->city_name;
              $order['statusText']    = $this->status($order['status']);
              $order['all_price'] = bcadd($order['despatch_money'],$order['deal_price'],2);
              dump($order);
              return  $order->toArray();
          }
    }
    /*
     * 客户修改订单
     * **/
    public function edit_order($arr,$order_id){
        foreach ($arr as $key => &$val){
            $val['order_id']      = $order_id[$val['order_sn']];
        }
        return $this->saveAll($arr);
    }
    /*
     * 用户ID查所有订单ID
     * */
    public  function orders($user){
        if(isset($user['user_id'])){
            $where['user_id'] = $user['user_id'];
        }
        if(isset($user['shop_id'])){
            $where['shop_id'] = $user['shop_id'];
        }
        if(isset($user['recycle'])){
            $where['recycle'] = $user['recycle'];
        }
        $orders = $this->where($where)->field('order_id')->select();
        resultToArray($orders);
        foreach ($orders as $k =>$v){
            $orders[$k]           = $v['order_id'];
        }
        return $orders;
    }
    /*
     * 流水号查订单编号
     * */
    public function order_sn($data){
        if(isValue($data,'serial_sn')){
            $where['serial_sn']   = $data['serial_sn' ];
        }
        $order_sn_arr  = $this->where($where)->field('order_id,order_sn,shop_id')->select();
        resultToArray($order_sn_arr);
        $arr = [];
        foreach ($order_sn_arr as $key =>$val){
            $arr['order_sn'][$val['shop_id']]  = $val['order_sn'];
            $arr['order_id'][$val['order_sn']] = $val['order_id'];
        }
        return  $arr;
    }
    /*
     *不同状态下的订单数量
     * */
    public  function recycle($data){
        if(isValue($data['recycle'])){
            $where['recycle'] = $data['recycle'];
        }
        if(isValue($data['user_id'])){
            $where['user_id'] = $data['user_id'];
        }
        $status = $this ->where($where)->field('status')->select();
        resultToArray($status);
        $status['all']=count($status);$status['money']=0;$status['delivery']=0;$status['evaluation']=0;$status['momentum']=0;$status['reimburse']=0;
        foreach ($status as $key =>&$val){
            if($val['status']==2){
                $status['money'] +=1;//未付款
            }elseif ($val['status']==4){
                $status['momentum']+=1;//待发货
            }elseif ($val['status']==5){
                $status['delivery']+=1;//已发货/待收货
            }elseif ($val['status']==7){
                $status['reimburse']+=1;//申请退款
            }elseif ($val['status']==11){
                $status['evaluation']+=1;//未评价
            }
        }
        return $status;
    }
    /**
     *商铺本月订单数量,购买人数以及总金额
     */
    public function shop_order_info($month,$shop_id){
        $order['money']=0;$order['order_num']=0;$order['t_money_num']=0;$order['user_num']=0;$user=[];
        $shop_order = $this->where(['create_time'=>['>=',$month],'shop_id'=>$shop_id])->select();
        $order['order_num']= count($shop_order);//订单量
        foreach ($shop_order as $k => $v){
            $user[] = $v['user_id'];
            $order['money'] += ($v['deal_price']+$v['despatch_money']);//订单总额
            if($v['status']==9){
                $order['t_money_num'] +=  1;//退款订单数量
            }
        }
        $order['money']= sprintf("%.2f",$order['money']);//订单总额保留2未小数
        $order['user_num']=count(array_unique($user)) ;//不同买家数量
        return $order;
    }



    /**
     *订单状态
     */
    public function status($val){
        $status = [2=>'未付款',3=>'已付款',4=>'待发货',5=>'已发货',6=>'对方已签收',7=>'申请退款',8=>'同意退款',9=>'完成退款',10=>'拒绝退款',11=>'待评价'];
        return $status[$val];
    }


}