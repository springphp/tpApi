<?php
namespace app\api\controller\v1;
use app\api\controller\v1\Common;
use think\Request;

/**
* 接口访问入口文件
* @author [iwater] <[email address]>
* @version [1.0.0.0] [description]
*/
class Index extends Common
{

	/**
	 * api 入口访问方法
	 * @return [type] [description]
	 */
	public function index(){
		$params = [
			'opertionType'	=> input('opertionType','','trim'),
			'sign'			=> input('sign','','trim'),
			'request'		=> input('request','','trim')
		];
		extract($params);

		$this->checkParams( $params );//验证访问参数

		switch ($opertionType) {
			case 'api.signin':
				return D('v1.User','controller')->signin($request);
				break;
			case 'api.signup':
				return D('v1.User','controller')->signup($request);
				break;
			default:
				return D('v1.User','controller')->test();
				break;
		}
	}


}
