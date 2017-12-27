<?php
namespace app\api\controller\v1;
use app\api\controller\v1\Common;
use think\Request;

/**
* 用户类接口
*/
class User extends Common
{
	/**
	 * 用户登录
	 * @return [type] [description]
	 */
	public function signin(){
		$username = input('request.username','','trim');
		$password = input('request.password','','trim');
		dump($username);dump(input());die;
		$userInfo = db('member')->where('mobile',$username)->find();
		if( $userInfo ) {
			if( md5( $password ) == $userInfo['password'] ) {
				//保存session 
				session('islogin',$userInfo['user_id']);
				unset($userInfo['password']);
				session('app_users',$userInfo);

				return $this->show('1','恭喜您，登录成功！',$userInfo);
			}
		}
		return $this->show('1','很遗憾，登录失败！');
	}

	/**
	 * 用户注册
	 * @return [type] [description]
	 */
	public function signup(){
		$username = input('username','','trim');
		$password = input('password','','trim');
		$data = [
			'mobile'	=> $username,
			'password'	=> md5( $password )
		];
		if( empty($username) || empty($password) ){
			return $this->show(0,'用户名或密码皆不能为空');
		}
		$res = model('member')->add( $data );
		if( $res ) {
			return $this->show(1,'恭喜您，注册成功！');
		}
		return $this->show(0,'很遗憾，注册失败！');
	}

	public function test(){
		return $this->show('1','this is a test');
	}
}
