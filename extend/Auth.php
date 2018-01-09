<?php
namespace extend;
use think\Session;
/**
 * 权限检测类
 * @author wanggang 2017/5/18
 */
class Auth{

    //默认配置
    protected $_config = array(
        'AUTH_ON'           => true,             // 权限检测开关 true开启 false关闭
        'AUTH_GROUP'        => 'Auth_group',     // 用户组数据表名
        'AUTH_RULE'         => 'Auth',           // 权限规则表
        'AUTH_USER'         => 'Admin',          // 用户信息表
        'AUTH_MENU'         => 'Menu',           // 菜单信息表
    );

    public function __construct() {
        $prefix = 'ui_';
        $this->_config['AUTH_GROUP'] = $prefix.$this->_config['AUTH_GROUP'];
        $this->_config['AUTH_RULE']  = $prefix.$this->_config['AUTH_RULE'];
        $this->_config['AUTH_USER']  = $prefix.$this->_config['AUTH_USER'];
        $this->_config['AUTH_MENU']  = $prefix.$this->_config['AUTH_MENU'];
    }
    /**
     * 获取用户组权限列表
     */
    public function getAuthList($type =2){
        $uid         = Session::get('islogin');
        $user        = Session::get('user');
        $user_gorup =$user['group'];
        $authlists =array();
        if (!$this->_config['AUTH_ON']){
            $authlist =db()->table( $this->_config['AUTH_RULE'])->field('menu_id')->select();
            foreach ($authlist as $key => $value) {
              $authlists[] = $value['menu_id'];
            }
        }else{
             if($type ==2){
                if(array_key_exists('Auth',$_SESSION)) return $_SESSION['Auth'];
                $authlist =db()->table( $this->_config['AUTH_RULE'])->where("group_id ='$user_gorup'")->field('menu_id')->select();
                foreach ($authlist as $key => $value) {
                  $authlists[] = $value['menu_id'];
                }
                if($authlist){
                     $_SESSION['Auth']=$authlists;
                }
            }elseif($type ==1 && isset($_SESSION['Auth'])){
                $authlists =$_SESSION['Auth'];
            }
        }
        return $authlists;
    }

    /**
     * 检测权限
     * $name 要检测的操作 MODULE/CONTROLLER/ACTION
     * $type 认证场景  1 实时认证 2登录认证
     * @return true 1有权限 2无权限
     */
    
    public function check($name,$type=1){
        $uid         = Session::get('islogin');
        $user        = Session::get('user');
        $user_gorup =$user['group'];
        if (1 ==$user_gorup)                return true;
        if (!$this->_config['AUTH_ON'])     return true; 
        $authlists   =$this->getAuthList($type);
        if (is_string($name)){
            $name   = explode('/',$name);
        }
        $module     =$name[0];
        $controller =$name[1];
        $action     =$name[2];
        $menu       =array();
        $menu       =db()->table($this->_config['AUTH_MENU'])->where("module ='$module' and controller ='$controller' and action ='$action'")->find();
        if($menu != null){
            $menu_id    =$menu['menu_id'];
        }else{
            $menu_id    = 0;
        }
        if(!in_array($menu_id,$authlists))  return false;
        return true;
    }
}
