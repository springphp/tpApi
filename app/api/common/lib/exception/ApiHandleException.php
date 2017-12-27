<?php
namespace app\api\common\lib\exception;

use think\exception\Handle;

/**
* 异常报错
*/
class ApiHandleException extends Handle
{
	public $httpCode = 500;
	/**
     * Render an exception into an HTTP response.
     * @param  \Exception $e
     * @return Response
     */
    public function render(\Exception $e)
    {
        $data = [
        	'status'	=> 0,
        	'message'	=> $e->getMessage(),
        	'data'		=> []
        ];
        if( strpos( $e->getMessage(),'not exists:') ){
            $data['message'] = '请求错误，非法访问！';//一般接口地址错误
        }
        
        if( config('app_debug') == true ) {
        	return parent::render($e);
        }
        if ($e instanceof ApiException) {
        	$this->httpCode = $e->httpCode;
        }
        return json($data,$this->httpCode);
    }
}