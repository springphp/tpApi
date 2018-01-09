<?php
namespace app\api\common\lib\exception;

use think\Exception;

/**
* 
*/
class ApiException extends Exception
{
	public $message = '';
	public $status = 0;
	public $httpCode= 500;

	/**
	 * 异常类
	 * @param string  $message  [description]
	 * @param integer $httpCode [description]
	 * @param integer $code     [description]
	 */
	public function __construct($message = '',$httpCode = 0, $status = 0){
		$this->message  = $message;
		$this->httpCode = $httpCode;
		$this->status 	= $status;
	}
	
}