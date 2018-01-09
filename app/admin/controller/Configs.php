<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use app\common\Model\Config;
/**
 * 系统设置
 */
class Configs extends AdminBase
{
    public function defaults(){
        $this->redirect(url('Configs/index'));
    }
    /*
    * 配置列表
    * */
    public function index(){
        $authGroup  = model('Config')->select();
        resultToArray($authGroup);
        $admins     = model('Config')->select_config(input());
        return  view([
            'admins'=>$admins,
        ]);
    }
    /*
    * 添加配置
    * */
    public function add(){
        $type                    = array('text','radio','checkbox','textarea','select','input','file');
        $page                    = input('page');
        if(request()->isAjax()){
            $data                = input();
            $type_val            = $data['type_val'];
            $data['config_mark'] = strtoupper($data['config_mark']) ;
            if($data['type'] =='select'|| $data['type'] =='checkbox' || $data['type'] =='radio'){//控件类型
                if(!empty($data['type_val'][0])){//控件值键值对
                    foreach ($type_val as $k => $v) {
                        $type_value[$k]['value'] = $v;
                    }
                    sort($type_value);
                    $data['type_value'] = serialize($type_value);
                }else{//控件值键值对为空或者不完整
                    Api()->setApi('msg','控件值不能为空!')->setApi('url',0)->ApiError();
                }
            }
            unset($data['page'],$data['type_val']);
            $re = model('Config')->add_config($data);
            if($re >0 ){
                Api()->setApi('url',url('Configs/index',['page'=>input('page')]))->ApiSuccess($re);
            }else{
                Api()->setApi('msg',$re)->setApi('url',0)->ApiError();
            }
        }
        return view(['type'=>$type,'page'=>$page]);
    }
    
    /*
     * 修改配置
     * */
    public function edit(){
        $page                      = input('page');
        $config_mark               = input('config_mark');
        $config_info               = db('Config')->where('config_mark',$config_mark)->find();
        $config_info['type_value'] = unserialize($config_info['type_value']);
        $type                      = array('text','radio','checkbox','textarea','select','input','password','file');
        if (request()->isAjax()){
            $data                  = input();
            $type_val              = $data['type_val'];
            $data['update_time']   = time();
            $data['config_mark']   = strtoupper($data['config_mark']) ;
            if($data['type'] =='select'|| $data['type'] =='checkbox' || $data['type'] =='radio'){
                if(!empty($data['type_val'][0])){
                    foreach ($type_val as $k => $v) {
                        $type_value[$k]['value'] = $v;
                    }
                    sort($type_value);
                    $data['type_value'] = serialize($type_value);
                }else{
                    Api()->setApi('msg','控件值不能为空!')->setApi('url',0)->ApiError();
                }
            }
            unset($data['page'],$data['type_val']);
            $re  = model('Config')->edit_config($data);
            if($re >0){
                Api()->setApi('url',url('Configs/index',['page'=>input('page')]))->ApiSuccess($re);
            }else{
                Api()->setApi('msg',$re)->setApi('url',0)->ApiError();
            }
        }
        return view(
            ['config_info'=>$config_info,'page'=>$page,'type'=>$type]
        );

    }
    /*
     * 删除配置
     * */
    public function del(){
        if(request()->isAjax()){
            $data = input();
            $time = time();
            $re   = $this->setStatus('Config',$time,$data['id'],'id','delete_time');
            if($re){
                Api()->setApi('url',input('location'))->ApiSuccess($re);
            }else{
                Api()->setApi('url',0)->ApiError();
            }
        }
    }
}