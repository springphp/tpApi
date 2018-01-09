<?php
namespace extend;
use think\Config;
use think\Request;

/**
* 
*/
class UploadImg
{
	private static $msg,$info,$path,$func;
	public static function upload($path,$func='time',$imgArr = []){
		$imgArr = $imgArr ?: Request::instance()->param();
		self::$path  = $path;
		self::$func  = $func;
		if (!function_exists($func)) {
			self::_setError('参数($func)函数不存在');
		} elseif (array_key_exists('uploadImg', $imgArr) && count($imgArr['uploadImg']) > 0) {
			array_walk($imgArr['uploadImg'], 'self::_upload');
		} else {
			self::_setError('没有上传图片');
		}
		return new self;
	}

	public static function getMsg(){
		return self::_Msg('get');
	}

	//数据处理核心方法
	private static function _upload($imgs,$index){
		$up_path  ="./upload/".self::$path;
		if (!file_exists($up_path)) {
            mkdir($up_path, 0777, true);
        }
		foreach ($imgs as $k => $v) {
	        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)) {//匹配base64编码
	            $type = $result[2];
	        }
        	$func = self::$func;
        	$name = $index.$k.$func().'.'.$type;
			$re = file_put_contents($up_path.'/'.$name, base64_decode(str_replace($result[1], '', $v)));
			if ($re !== false) {
				self::$info[$index][] = $name;
				self::_setSuccess();
			}
		}
		return new self;
	} 

	private static function _setError($msg){
		$reslut = ['code'=>0,'msg'=>$msg,'info'=>[]];
		self::_Msg('set',$reslut);
    }
    private static function _setSuccess($msg = '上传成功'){
		$reslut = ['code'=>1,'msg'=>$msg,'info'=>self::$info];
		self::_Msg('set',$reslut);
    }
	// 上传信息处理核心方法
	private static function _Msg($type,$msg=[]){
		switch ($type) {
			case 'get':
				return self::$msg;
				break;
			case 'set':
				self::$msg = $msg;
				break;
			default:
		        return false;
				break;
		}
	}
}