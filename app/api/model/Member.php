<?php
namespace app\api\model;

use think\Model;

/**
* 用户类 model
*/
class Member extends Model
{
	
	public function getUser(){

	}

	public function add( $data ){
		$result = $this->save( $data );
		if( $result === false ){
			return $this->getMessage();
		}else{
			return $result;
		}
	}

	public function edit(){
		$result = $this->save( $data, ['user_id'=>$data['user_id']]);
		if( $result === false ){
			return $this->getMessage();
		}else{
			return $result;
		}
	}
}
