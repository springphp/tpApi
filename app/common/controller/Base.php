<?php
namespace app\common\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Lang;
use extend\Encrypt;

/**
 * 基础类
 * by chick 2017-05-02
 */
class Base extends Controller
{
	protected $base_url,$var;
    public function __construct(){
        parent::__construct();
    }

    public function _initialize(){
        $this->setLanguage();
        $this->base_setUrl();
        $this->base_setVar();
        Session::init(['prefix' => MODULE_NAME,]);
    }

    /**
     * 设置常用url为常量 
     * 配置 前后台模板+主题的url
     */
    final protected function base_setUrl(){
    	$this->base_url['module_name']     = Request::instance()->module();//当前模块
    	$this->base_url['controller_name'] = Request::instance()->controller();//当前控制器
    	$this->base_url['action_name']     = Request::instance()->action();//当前方法
    	$this->base_url['public_path']     = ROOT_PATH.'/';
    	$this->base_url['static_path']     = ROOT_PATH.'/static/';
    	$this->base_url['web_public']      = Request::instance()->domain().'/';
    	$this->base_url['web_static']      = Request::instance()->domain().'/static/';
    	foreach ($this->base_url as $name => $value) {
    		$name = strtoupper($name);
    		!defined($name) && define($name, $value);
    	}
        $this->base_url['js'] =  WEB_PUBLIC.'theme/'.MODULE_NAME.'/static/js';
        $this->base_url['css'] = WEB_PUBLIC.'theme/'.MODULE_NAME.'/static/css';
        $this->base_url['img'] = WEB_PUBLIC.'theme/'.MODULE_NAME.'/static/img';

        $this->assign($this->base_url);//加载到模版
    }

    final protected function base_setVar(){
    	$this->var['title']        = config('web_name');
    	$this->var['admin_title']  = config('web_admin_name')?:config('web_name').'后台管理';
        $this->var['nowpage']      = input(config('paginate.var_page'))?:1;
        $this->var['upload']       = WEB_PUBLIC .'/public/upload/';
    	$this->assign($this->var);//加载到模版
    }

    final protected function setLanguage(){
        $language      = Lang::range();
        $language_list = config('language_list')?:['zh-cn','en-us'];
        Lang::setAllowLangList($language_list);
        Lang::load(APP_PATH . 'common/lang/'.Request::instance()->module().'/'.$language.'.php');
    }

   /**
     * 检测用户是否登录
     * @return true 已登录  false 未登录
     *
     */
    final protected function is_login(){
        $api    = Api('this');
        $user_id = session('islogin');
        if (!$user_id) {
            return $api->setApi('msg','未登录')->ApiError();
        } else {
            $login_time = session('user.last_login_time');
            $map['admin_id'] = session('user.admin_id');
            $admin = model('admin')->get($map)->toArray();
            if($login_time != $admin['last_login_time']){
                return $api->setApi('msg','帐号在其它浏览器登录！')->ApiError();//1 账号被占用
            }
            if(config('login_timeout') != 0){
                $logintimed =time()-$login_time;
               if( $logintimed > config('login_timeout')){
                    return $api->setApi('msg','登录超时')->ApiError();//2 登录超时
                }
            }
            return $api->setApi('msg','-')->ApiSuccess();
        }
    }

    /**
     * 清除登录信息
     */
    final protected function destroyUser(){
        session('islogin',0);
        session('user',[]);
    }
    /**
     * 修改数据表指定字段
     * @param string    $table    要修改的数据表
     * @param string    $status   要修改成的值
     * @param int|array $id       主键ID
     * @param string    $pk       主键名，默认为表名_id
     * @param string    $field    要修改的字段，默认status
     */
    final protected function setStatus($table,$status,$id,$pk='',$field='status',$where='', $setAjax=false){
        $api    = Api('this',$setAjax);
        $pk     = $pk ?: $table.'_id';
        $field  = $field ?: 'status';
        $ids    = (array)$id;
        if (!$table  || !$ids || !$pk || !$field) {
            !$table      && $msg  = 'table';
            !$ids        && $msg  = 'id';
            !$pk         && $msg  = 'pk';
            !$field      && $msg  = 'field';
            return $api->setApi('msg','param error:'.$msg)->ApiWarning();
        }
        $model = model($table);
        // if ($where) {
        //     $model->where($where);
        // }
        foreach ($ids as $k => $id) {
            if (!(int)$id) continue;
            $where[$pk]    = (int)$id;
            $data[$field] = $status;
            $model->where($where)->update($data);
        }
        // if (false !== $result) {
            return $api->setApi('msg','操作成功')->ApiSuccess();
        // }else{
        //     return $api->setApi('msg','操作失败')->ApiError();
        // }
    }
}
