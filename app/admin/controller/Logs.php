<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use app\common\Model\Log;
/**
 * 操作日志控制器
 * @author  wangang 
 * @version 2017/5/18
 */
class Logs extends AdminBase{
	/**
	 * 操作日志列表
	 */
	public function index(){
		$data=input(); 
    	$list = model('log')->select_log($data);
    	return view([
        'list'=>$list,
        ]);
	}

	/**
	 * 清空数据
	 */
	public function delAll(){
		$re =model('log')->delAll();
		if($re){
			Api()->setApi('url',url('Logs/index'))->ApiSuccess($re);
		}else{
			Api()->ApiError();
		}
	}

}