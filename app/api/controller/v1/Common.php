<?php
namespace app\api\controller\v1;
use think\Model;

/**
 * 接口 基础类
 * @author [iwater] <[email address]>
 * @version [1.0.0.0] [2017/12/27]
 */
class Common extends Model
{
    /**
     * 接口返回值
     * @param  integer $status  [description]
     * @param  string  $message [description]
     * @param  array   $data    [description]
     * @return [type]           [description]
     */
    public function show( $status=1, $message='', $data=array(),$extParams= '' )
    {
        $returnDate = [
        	'status'	=> $status,
        	'message'	=> $message,
        	'data'		=> $data,
        	'time'		=> date('Y-m-d H:i:s'),
        	'ext'		=> $extParams
        ];
        return $returnDate;
    }

    /**
     * 验证签名是否正确
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    final protected function checkParams( $params=array() ){
    	extract($params);
    	//验证加密字符合法性 md5 
    	$apiKey = config('app_api.secrectCode');
    	$adminSetSignString = md5( $opertionType.$apiKey.$request );
    	// dump($adminSetSignString);die;
    	if( $sign != $adminSetSignString ){
    		echo json_encode( $this->show(0,'验证不通过，非法访问') );die;
    	}
    }

    /**
	 * 验证唯一设备登录
	 * @return [type] [description]
	 */
	final protected function uniqueSignin(){
        return $this->show(1,'ok');
	}

	final protected function checkTime(){
		$request_time = input('requestTime','','trim');
		//TONE:如何实现接口请求失效逻辑
		if( !$request_time ) return show(0,'请求时间不能为空');
		if( time() - $request_time > config('app_api.request_time') ){
			return show(0,'请求已失效');
		}
	}
}
