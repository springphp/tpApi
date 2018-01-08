<?php
namespace app\api\common\controller;
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
     * @param  integer $status    [状态码 0：异常，1：正常]
     * @param  string  $message   [提示信息]
     * @param  array   $data      [返回参数]
     * @param  string  $extParams [额外返回参数]
     * @return [type]             [description]
     */
    public function show( $status=1, $message='', $data=array(), $extParams= array() )
    {
        $returnDate = [
        	'status'	=> $status,
        	'message'	=> $message,
        	'data'		=> $data,
        	'time'		=> date('Y-m-d H:i:s'),
        	'ext'		=> $extParams
        ];

       /* if( empty($returnDate['data'])) unset($returnDate['data']);
        if( empty($returnDate['ext']))  unset($returnDate['ext']);*/

        return $returnDate;
    }

    /**
     * 验证签名是否正确
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    final protected function checkParams(){
    	$params = [
			'opertionType'	=> input('opertionType','','trim'),
			'sign'			=> input('sign','','trim'),
			'request'		=> input('request','','trim')
		];
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
        echo json_encode( $this->show(0,'注意：您的账号异地登录！') );die;
	}

    /**
     * 验证接口访问超时
     * @return [type] [description]
     */
	final protected function checkTime(){
		$request_time = input('requestTime','','trim');
		//TONE:如何实现接口请求失效逻辑
		if( !$request_time ) return show(0,'请求时间不能为空');
		if( time() - $request_time > config('app_api.request_time') ){
            echo json_encode( $this->show(0,'请求已失效') );die;
		}
	}

    /**
     * 验证版本号
     * @return [type] [description]
     */
    final protected function checkVersion(){
        if( input('version','v1','trim') != config('app_api.app_version') ){
            $message = '当前版本为：'.config('app_api.app_version').'，请确认访问版本';
            echo json_encode( $this->show(0, $message) );die;
        }
    }
}
