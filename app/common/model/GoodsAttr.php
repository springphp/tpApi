<?php
namespace app\common\model;
use think\Model;
use traits\model\SoftDelete;
/**
 * 属性模型
 * @author wanggang 2017/5/21
 */
class GoodsAttr extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $readonly = [];//只读字段
	/**
	 * 属性列表查询
	 */
	public function select_attr($data,$where=array()){
		if(isValue($data,'attr_name')){
			$where['attr_name'] =['like','%'.(string)$data['attr_name'].'%'];
		}
		if(isValue($data,'status')){
			$where['status']=['eq',$data['status']];
		}
		if(isValue($data,'value')){
			$where['value'] =['like','%'.(string)$data['value'].'%'];
		}
        $query =$data;
		$list=$this->where($where)->paginate('',false,['query' => $query]);
		resultToArray($list);
		foreach ($list as $key => $value) {
			if($value['value'] != ''){
				$item =unserialize($value['value']);
				if(is_array($item)){
					foreach ($item as $k => $v) {
						$item[$k]=$v['value'];	
					}
					$item =implode(',',$item);
				}
				$list[$key]['value']=$item;
			}		
		}
		return $list;
	}
	/**
     * 新增品牌
     */
    public function add_attr($data){
    	
    	$result = $this->validate('GoodsAttr.add')->save($data);
		if($result === false){
			return $this->getError();
		}else{
			return $result;
		}
    }
    /**
     * 编辑品牌
     */
    public function edit_attr($data){
    	$result = $this->validate('GoodsAttr.edit')->save($data,['attr_id'=>$data['attr_id']]);
		if($result === false){
			return $this->getError();
		}else{
			return $result;
		}
    }
}