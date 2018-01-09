<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"D:\phpStudy\WWW\tpApi\public\theme\admin\admins\admin_info.html";i:1498444428;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\layout.html";i:1498444427;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\static.html";i:1499741413;s:55:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\js.html";i:1504165296;}*/ ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><meta name="renderer" content="webkit"><title><?php echo $admin_title; ?></title><meta name="keywords" content=""><meta name="description" content=""><!-- 引入公共css/js --><!-- 字体图标 --><link rel="shortcut icon" href="<?php echo $web_public; ?>favicon.ico"><link href="<?php echo $web_static; ?>/css/font-awesome.min.css" rel="stylesheet"><!-- JQuery --><script src="<?php echo $web_static; ?>/js/jquery.min.js"></script><script src="<?php echo $web_static; ?>/plugins/metisMenu/jquery.metisMenu.js"></script><!-- bootstrap --><link href="<?php echo $web_static; ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/bootstrap/js/bootstrap.min.js"></script><!-- 自定义样式 --><link href="<?php echo $css; ?>/animate.css" rel="stylesheet"><link href="<?php echo $css; ?>/style.css" rel="stylesheet"><!-- checkbox 和radio 美化 --><link href="<?php echo $web_static; ?>/css/input.css" rel="stylesheet"><!-- <link href="<?php echo $web_static; ?>/css/checkbox.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/js/checkbox.js"></script> --><!-- select 美化 --><link href="<?php echo $web_static; ?>/css/select.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/jquery/scrollbar.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/jquery/scrollbar.js"></script><script src="<?php echo $web_static; ?>/js/select.js"></script><link href="<?php echo $web_static; ?>/css/common.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/editor/wangEditor.min.css" rel="stylesheet"><style>        .layout-return-btn{
            position: relative;
            top: -8px;
            left: -6px;
            margin: 0!important;
        }
        body{
            height: 1vh;
        }
    </style></head><body class="gray-bg  animated fadeIn"><div class="wrapper wrapper-content ibox float-e-margins" ><div class="ibox-title visible-lg"><!-- <h5> --><ul class="breadcrumb inline pull-left" ><li><?php echo $menu['pmenu']; ?></li><li><?php echo $menu['menu_name']; ?></li></ul><!-- </h5> --><a class="pull-right btn btn-default btn-xs" title="刷新当前" href=""><i class="fa fa-refresh"></i></a></div><div class="ibox-content"><link href="<?php echo $web_static; ?>plugins/cropper/cropper/cropper.min.css" rel="stylesheet"><link href="<?php echo $web_static; ?>plugins/cropper/sitelogo/sitelogo.css" rel="stylesheet"><script src="<?php echo $web_static; ?>plugins/cropper/cropper/cropper.min.js"></script><script src="<?php echo $web_static; ?>plugins/cropper/sitelogo/sitelogo.js"></script><!--修改个人资料开始--><form class="form-horizontal js-ajax-form clearfix" action="<?php echo U('Admins/admin_info'); ?>" method='post'><input type="hidden" name="admin_id" id="admin_id" value="<?php echo $info['admin_id']; ?>"><div class="form-group"><label for="account" class="col-sm-2 control-label">帐号</label><div class="col-sm-4"><p class="form-control-static"><?php echo $info['account']; ?></p></div></div><div class="form-group"><label for="phone" class="col-sm-2 control-label">头像</label><div id="crop-avatar" class="col-sm-4" ><div class="avatar-view " >修改头像
                <?php if($info['headimg'] != ''): ?><img src="<?php echo $web_public; ?>upload\<?php echo $info['headimg']; ?>" alt="Logo"  class="form-control"/><?php else: ?><img src="<?php echo $web_static; ?>img/default.jpg" alt="Logo"  class="form-control" /><?php endif; ?></div></div></div><div class="form-group"><label for="phone" class="col-sm-2 control-label">密码</label><div class="col-sm-4"><a type="button" title="修改密码"  class="btn btn-default btn-w-m js-window-load" href="<?php echo url('admins/admin_password'); ?>" >修改密码</a></div></div><div class="form-group"><label for="nickname" class="col-sm-2 control-label">昵称</label><div class="col-sm-4"><input type="text" name="nickname" class="form-control" id="nickname" placeholder="昵称" value="<?php echo $info['nickname']; ?>"></div></div><div class="form-group"><label for="phone" class="col-sm-2 control-label">手机</label><div class="col-sm-4"><input type="tel" name="phone" class="form-control" id="phone" placeholder="手机" value="<?php echo $info['phone']; ?>"></div></div><div class="form-group"><label for="email" class="col-sm-2 control-label">邮箱</label><div class="col-sm-4"><input type="email" name="email" class="form-control" id="email" placeholder="邮箱" value="<?php echo $info['email']; ?>"><input type="hidden" name="url" class="form-control" id="url"  value="<?php echo U('Admins/admin_info'); ?>"></div></div><div class="form-group"><label for="inputPassword3" class="col-sm-2 control-label"></label><div class="col-sm-4"><button type="submit" class="btn btn-info js-submit-btn mr_3px">确认</button><button type="reset" class="btn btn-info">重置</button></div></div></form><!--修改个人资料结束--><!--上传头像开始--><div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form class="avatar-form" action="<?php echo U('Admins/admin_headimg'); ?>" enctype="multipart/form-data" method="post"><div class="modal-header"><button class="close" data-dismiss="modal" type="button">&times;</button><h4 class="modal-title" id="avatar-modal-label">Change Logo Picture</h4></div><div class="modal-body"><div class="avatar-body"><div class="avatar-upload"><input class="avatar-src" name="avatar_src" type="hidden"><input class="avatar-data" name="avatar_data" type="hidden"><label for="avatarInput">图片上传</label><input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div><div class="row"><div class="col-md-9"><div class="avatar-wrapper"></div></div><div class="col-md-3"><div class="avatar-preview preview-lg"></div><div class="avatar-preview preview-md"></div><div class="avatar-preview preview-sm"></div></div></div><div class="row avatar-btns"><div class="col-md-9"><div class="btn-group"><button class="btn" data-method="rotate" data-option="-30" type="button" title="Rotate -30 degrees"><i class="fa fa-undo"></i> 向左旋转</button></div><div class="btn-group"><button class="btn" data-method="rotate" data-option="30" type="button" title="Rotate 30 degrees"><i class="fa fa-repeat"></i> 向右旋转</button></div></div><div class="col-md-3"><button class="btn btn-success btn-block avatar-save " type="submit"><i class="fa fa-save"></i> 保存修改</button></div></div></div></div></form></div></div></div><div class="loading" aria-label="Loading" role="img" tabindex="-1"></div><!--上传头像结束--></div></div></body><!-- 全局js --><script src="<?php echo $web_static; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script><!-- 第三方插件，加载进度条 --><script src="<?php echo $web_static; ?>/plugins/pace/pace.min.js"></script><!-- layui --><script src="<?php echo $web_static; ?>/plugins/layui/layer/layer.js"></script><script src="<?php echo $web_static; ?>/plugins/layui/laydate/laydate.js"></script><!-- 自定义js --><script src="<?php echo $web_static; ?>/js/layer.com.js"></script><script src="<?php echo $web_static; ?>/js/common.js"></script><script src="<?php echo $web_static; ?>/js/vue.js"></script><script src="<?php echo $js; ?>/hplus.js?v=4.1.0"></script><script src="<?php echo $js; ?>/contabs.js"></script></html><style type="text/css">    .panel-heading{
        display: none;
    }
    .panel-footer{
        background-color: #fff;
        border: none
    }
    .panel-body.form-inline .form-group{
        margin-right: 10px!important;
        margin-bottom: 10px!important;

    }
    .panel-body.form-inline .form-group .form-control{
        width: 200px;
    }
    .panel-body.form-inline .form-group.group1 .form-control,
    .panel-body.form-inline .form-group.group2 .form-control
    {
        width: 205px;
    }
    .panel-body.form-inline{
        padding-bottom: 0;
    }
    .panel-body.form-inline .form-group.pull-right {
        margin: 0!important;
    }
    .panel-body.form-inline .form-group.group1{
        margin-right: 0px!important;
    }
</style><script type="text/javascript">    // 页面初始化
    $(function(){
        $('a').click(function(){
            $(this).blur();
        })
        $('.city-picker-span').css('width', '');
    })

</script>