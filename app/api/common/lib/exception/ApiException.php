<?php
namespace app\api\common\lib\exception;

use think\Exception;

/**
* 
*/
class ApiException extends Exception
{
	public $message = '';
	public $httpCode= 500;
	public $code = 0;

	/**
	 * 异常类
	 * @param string  $message  [description]
	 * @param integer $httpCode [description]
	 * @param integer $code     [description]
	 */
	public function __construct($message = '',$httpCode = 0, $code = 0){
		$this->message  = $message;
		$this->httpCode = $httpCode;
		$this->code 	= $code;
	}
	
}