<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use extend\Encrypt;
/**
 *
 * @author
 */
class Publics extends AdminBase
{
    public function __construct(){
        parent::__construct();
        $this->view->engine->layout(false);
    }
    /**
     * 管理员登录
     */
    public function login()
    {
        //如果已登录，就跳转转至主页
        if(session('islogin')){
            $this->redirect('index/index');
        }
        if (request() -> isAjax()){
            $username = input('username');
            $password = input('password');
            // 验证用户名，密码不能为空
            if(!$username){
                Api()->setApi('msg',"请输入用户名")->setApi('url',0)->ApiError();
            }elseif (!$password){
                Api()->setApi('msg',"请输入密码")->setApi('url',0)->ApiError();
            }
            //获取查询条件用户名的类型
            $type = $this->checkUserNameType();
            $map = array();
            $time = time();
            $map[$type] = $username;
            //获取用户数据
            $admin = model('admin')->get($map);
            if (is_object($admin)){
               $admin = $admin->toArray();
            } else {
               Api()->setApi('msg',"用户名不存在")->setApi('url',0)->ApiError();
            }
            // 验证用户组状态
            $status = model('AuthGroup')->where('group_id',$admin['group'])->value('status');
            if($status == 0){
                Api()->setApi('msg',"用户组被禁用！")->setApi('url',0)->ApiError();
            }
            if(is_array($admin) && $admin['status']){
                //验证用户密码
                $authcode =  Encrypt::authcode($admin['password'],'DECODE'); //解密
                if($password === $authcode){
                    //更新数据
                    $this->updateDate($admin);
                    model('log')->add_log($username);//写入登录日志
                    //设置登录超时时间
                    $timeout = config('LOGIN_TIMEOUT');//获取超时时间
                    session('islogin', $admin['admin_id'],null,$timeout);
                    unset($admin['password']);
                    $admin['last_login_time'] = $time;//保存最新的更新时间
                    session('user',$admin,null,$timeout);
                    //登录成功，跳转页面
                    Api()->setApi('msg',"登录成功！")->setApi('url',url('Index/index'))->ApiSuccess();
                }else {
                    Api()->setApi('msg',"密码错误")->setApi('url',0)->ApiError();
                }
            }else {
                Api()->setApi('msg',"用户被禁用")->setApi('url',0)->ApiError();
            }
        }
        return view();
    }

    /**
     * 检测用户名类型
     * @param  string   $type  用户名类别
     * @return integer  $type  用户名类别
     */
    public function checkUserNameType()
    {
        $username = input('username');
        $bool_email = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        $bool_phone = "/^1[34578]\d{9}$/";
        if(preg_match($bool_phone,$username)){
            $type = 'phone';
        }elseif (preg_match($bool_email,$username)){
            $type = 'email';
        }else{
            $type = 'account';
        }
        return $type;
    }

    //登录成功更新数据
    public function updateDate($admin)
    {
        //更新用户登录信息
        $loginStatus = $this->isMobile();//判断是否是 mobile 登录 or pc 登录
        $data = array(
            'admin_id'              => $admin['admin_id'],
            'last_login_time'       => time(),
            'last_login_ip'         => get_client_ip(),
            'login_status'          => $loginStatus
        );
        model('admin')->save($data,['admin_id',$admin['admin_id']]);
    }

    //判断登录设备
    public function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
            return 2;
        }else{
            return 1;
        }
    }

    //退出登录修改登录状态为0
    public function eidtLoginStatus()
    {
        $admin_id = session('islogin');
        $data = array(
            'admin_id'               => $admin_id,
            'login_status'           => 0
        );
        model('admin')->save($data,['admin_id',$admin_id]);
    }

    //退出登录
    public function loginOut()
    {
        $this->eidtLoginStatus();//格式化登录状态
        $this->destroyUser();
        Api()->setApi('msg',"退出登录")->ApiSuccess();
    }

}