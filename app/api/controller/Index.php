<?php 
namespace app\api\controller;

use app\api\common\controller\Common;
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
	public function index()
	{
		// $this->checkParams();//验证访问参数

		// $this->checkVersion();//验证版本号
		
		$opertionType = input('opertionType','','trim');
		switch ($opertionType) {
			case 'api.signin':
				return D('User','controller')->signin();
				break;
			case 'api.signup':
				return D('User','controller')->signup();
				break;
			default:
				return D('User','controller')->test();
				break;
		}
	}
}
?>