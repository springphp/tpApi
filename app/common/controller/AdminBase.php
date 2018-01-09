<?php
namespace app\common\controller;
use extend\Auths;
use think\Session;
use think\Url;
use extend\Encrypt;
/**
 * Admin模块基础类
 * by chick 2017-05-03
 */
class AdminBase extends Base{
    protected $allowed = [
        'admin'=>[
            'publics.*',
        ],
    ];
    public function _initialize(){
        parent::_initialize();
        $this->setTitle();
        $this->islogin();
        $this->_checkAuth();
    }
    private function _checkAuth(){
        $force = false;
        if (strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index') $force = true;
        !Auths::checkAuth([],$force) && Api()->setApi('msg',Auths::getMsg())->setApi('url',0)->ApiError();
    }

    protected function setTitle(){
        $m = ['pmenu'=>'后台管理','menu_name'=>'','menu_des'=>''];
        $url = Url::build(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
        $menu = model('menu')->getByUrl($url);
        if ($menu) {
            $p = model('menu')->getByMenuId($menu->pid);
            if ($p) {
                $m['pmenu'] = $p['menu_name'];
            } else {
                $m['pmenu'] = '后台管理';
            }
            $m['menu_name'] = $menu->menu_name;
            $m['menu_des']  = $menu->menu_des;
        }
        $this->assign('menu',$m);
    }
    /*
     * 检测用户是否登录
     **/
    protected function islogin(){
        $module_name     = strtolower(MODULE_NAME);
        $controller_name = strtolower(CONTROLLER_NAME);
        $action_name     = strtolower(ACTION_NAME);
        if (array_key_exists($module_name,$this->allowed)) {
            $auth1 = $controller_name.'.*';
            $auth2 = $controller_name.'.'.$action_name;
            if (in_array($auth1, $this->allowed[$module_name])) {
                return;
            } elseif(in_array($auth2, $this->allowed[$module_name])) {
                return;
            }
        }
        if(1 != $this->is_login()->code && !request()->isAjax()){
            $this->destroyUser();
            $this->redirect('publics/login');
        }
    }
    /**
     * 判断URL链接前是否添加Http,/www.
     */
    public function getUrl($url){
        $p1 = '/^(.*?)www\.(.*)$/';
        $p2 = '/^http(.*)$/';
        $re1 = preg_match($p1,$url);
        if (!$re1){
            $url = $url;
        } else {
            $re2 = preg_match($p2,$url);
            if (!$re2){
                $url = 'http://'.$url;
            }
        }        
        return  $url;
    }
    /*
     * 获取分类名称
     * by weichunfeng 2017/06/20
     * */
    public function getTypeTree(){
        $articleCates = model('articleCate')->field('cate_id,pid,cate_name')->where('status != 0')->order('cate_id asc')->select();
        $articleCates = $this->getTrees($articleCates,0);//获取无限极分类
        return $articleCates;
    }

    //无限极菜单
    public function getTrees($arr,$pid,$step = 0){
        global $tree;
        foreach($arr as $val) {
            if($val['pid'] == $pid) {
                $flag = str_repeat('&nbsp;&nbsp;&nbsp;',$step);
                $val['cate_name'] = $flag.$val['cate_name'];
                $tree[] = $val;
                $this->getTrees($arr , $val['cate_id'] ,$step+1);
            }
        }
        return $tree;
    }

    //获取分类等级
    public function getCateLevel($id){
        $level = 1;
        while ($id > 0){
            $id = model('articleCate')->where("cate_id = {$id}")->value('pid');
            $level++;
        }
        return $level;
    }
}