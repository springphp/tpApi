<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use app\common\Model\Menu;
use extend\Auths;
use think\Session;
class Index extends AdminBase
{
    protected $class = ['nav nav-second-level','nav nav-third-level'];
    protected $menus,$html  = [
        'noleaf_a' => "<a class='J_menuItem' href='%s'><i class='fa fa-fw fa-%s level-%s'></i>",
        'hasleaf_a' => "<a class='' href='%s'><i class='fa fa-fw fa-%s level-%s'></i>",
        'lv_menu' =>"<span class='nav-label'>%s</span>",
        'left_icon' =>"<span class='fa fa-fw arrow'></span>",
    ];
    public function index(){
        $admin_info = Session::get('user');
        $headimg    = $admin_info['headimg'];
        $pash = "./upload/".$headimg;
        if(!file_exists($pash)){//检测图片图片
            $headimg="";
        }
        $this->view->engine->layout(false);
        $this->getMenus();
        return view([
            'menus' =>$this->menus,
            'headimg'=>$headimg,
        ]);
    }
    
    public function main(){

    }

    public function isUniqueLogin(){
        $rs = $this->is_login();
        if (0 == $rs->code) {
            $this->destroyUser();
        }
        $rs->apiEcho();
    }

    /**
     * 获取html菜单，并写入缓存文件
     */
    protected function getMenus(){
        $menu_list = unserialize(session('user.menuList'));
        if(!empty($menu_list)){
            $menu_id = $menu_list['menu_id'];
            $this->getMenuId($menu_id);
            config('menu_id',$menu_id);
            $menus = Menu::all(function($db){
                $db->where(['menu_id'=>['in',config('menu_id')],'status'=>['eq',1]])->order('sort', 'asc');
            });
            resultToArray($menus);
            if ($menus) {
                $option = ['primary_key'=>'menu_id'];
                $menus = getTree($menus,$option)->makeTreeForHtml();
                $menus = getTree($menus,$option)->makeTree();
                $this->setMenu($menus);
            }
        }
    }
    /**
     * 获取已有菜单父级菜单
     */
    protected function getMenuId(&$menu_id){
        $menu_pid = model('menu')->where(['menu_id'=>['in',$menu_id],'status'=>['eq',1],'pid'=>['neq',0]])->column('pid');
        $menu_pid = array_flip(array_flip($menu_pid));
        if ($menu_pid) {
            $this->getMenuId($menu_pid);
        }
        $menu_id = array_merge($menu_id,$menu_pid);
        $menu_id = array_flip(array_flip($menu_id));
        sort($menu_id);
    }

    /**
     * 递归设置菜单格式
     */
    protected function setMenu(&$menus){
        array_walk($menus, 'self::setMenuFormat');
    }
    /**
     * 递归菜单html
     */
    protected function setMenuFormat(&$val){
        if ($val['level']>=2) {//保证最多只显示三级菜单
            $val['leaf'] = true;unset($val['child']);
        }
        extract($this->html);extract($val);
        $menu_icon = $menu_icon ?: 'list';
        if (array_key_exists('leaf', $val) && $leaf===true) {
            $format = "<li>{$noleaf_a}{$lv_menu}</a></li>";
            $this->menus .= sprintf($format,$url,$menu_icon,$level,$menu_name);
        } else {
            $val['leaf'] = false;
            $format = "<li>{$hasleaf_a}{$lv_menu}{$left_icon}</a><ul class='nav {$this->class[$level]}'>";
            $this->menus .= sprintf($format,$url,$menu_icon,$level,$menu_name);
            $this->setMenu($child);
            $this->menus .= "</ul></li>";
        }
    }
}
