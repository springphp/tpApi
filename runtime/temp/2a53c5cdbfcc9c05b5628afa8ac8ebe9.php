<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\publics\login.html";i:1515470185;}*/ ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title><?php echo $admin_title; ?> - 登录</title><link rel="shortcut icon" href="<?php echo $web_public; ?>favicon.ico"><link href="<?php echo $web_static; ?>/css/font-awesome.min.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/js/jquery.min.js"></script><!-- bootstrap --><link href="<?php echo $web_static; ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/bootstrap/js/bootstrap.min.js"></script><link href="<?php echo $css; ?>/animate.css" rel="stylesheet"><link href="<?php echo $css; ?>/style.css" rel="stylesheet"><script>
        if(window.top !== window.self){ window.top.location = window.location;}
    </script></head><body class="gray-bg"><div class="middle-box text-center loginscreen  animated fadeInDown"><div><div><h1 class="logo-name"><img src="<?php echo getImg(config($logo='web_logo')); ?>"></h1></div><!-- <h3><?php echo $admin_title; ?> - 登录</h3> --><form class="m-t js-ajax-form" name="form" action="<?php echo U('login'); ?>" method="post" ><div class="form-group"><input type="text" name="username" class="form-control" placeholder="用户名/手机号码/电子邮箱" required=""></div><div class="form-group"><input type="password" name="password" class="form-control" placeholder="密码" required=""></div><button type="submit" class="btn btn-primary block full-width m-b js-submit-btn">登 录</button><!-- <p class="text-muted text-center"><a href="login.html#"><small>忘记密码了？</small></a></p> --></form></div></div></body><style type="text/css">
    .logo-name img{
        width: 100px;
        height: 100px;
        margin-bottom: -45px
    }
</style><script src="<?php echo $web_static; ?>/plugins/layui/layer/layer.js"></script><script src="<?php echo $web_static; ?>/js/layer.com.js"></script><script src="<?php echo $web_static; ?>/js/common.js"></script></html>
