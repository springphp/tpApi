<?php
namespace app\common\controller;
use extend\Auths;
use think\Cookie;
use think\Session;
use think\Url;
/**
 * Shop模块基础类
 * by chick 2017-06-08
 */
class HomeBase extends Base
{
    protected $allowed = [
        'shop'=>[
            'index.*',
        ],
    ];
    public function __construct(){
        $this->theme = config('web_theme')?:(config('template.view_theme')?:'default');
        //分页设置
        config(['paginate'=>['type'      => 'bootstrap1','list_rows' => 3,'var_page'  => 'page',]]);
        Session::set('pageSize', config('paginate.list_rows'));

        config('template.view_theme',$this->theme);
        config('template.layout_name',$this->theme.'/'.config('template.layout_name'));
        parent::__construct();
    }

    public function _initialize(){
        parent::_initialize();
        $this->is_close();
        $this->set_var();
    }

    protected function is_close(){
        if(config('web_status') == 0){
            $this->error('站点已关闭',0);
        }
    }

    protected function set_var(){
        $this->shop_var['public']       = WEB_PUBLIC;
        $this->shop_var['static']       = WEB_PUBLIC .'/theme/'.MODULE_NAME.'/'.$this->theme.'/static/';
        $this->shop_var['img']          = $this->shop_var['static'].'/img/';
        $this->shop_var['css']          = $this->shop_var['static'].'/css/';
        $this->shop_var['js']           = $this->shop_var['static'].'/js/';
        $this->assign($this->shop_var);
    }

}