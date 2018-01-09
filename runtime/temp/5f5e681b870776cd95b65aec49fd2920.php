<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\refresh\index.html";i:1498444429;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\layout.html";i:1498444427;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\static.html";i:1499741413;s:55:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\js.html";i:1504165296;}*/ ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><meta name="renderer" content="webkit"><title><?php echo $admin_title; ?></title><meta name="keywords" content=""><meta name="description" content=""><!-- 引入公共css/js --><!-- 字体图标 --><link rel="shortcut icon" href="<?php echo $web_public; ?>favicon.ico"><link href="<?php echo $web_static; ?>/css/font-awesome.min.css" rel="stylesheet"><!-- JQuery --><script src="<?php echo $web_static; ?>/js/jquery.min.js"></script><script src="<?php echo $web_static; ?>/plugins/metisMenu/jquery.metisMenu.js"></script><!-- bootstrap --><link href="<?php echo $web_static; ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/bootstrap/js/bootstrap.min.js"></script><!-- 自定义样式 --><link href="<?php echo $css; ?>/animate.css" rel="stylesheet"><link href="<?php echo $css; ?>/style.css" rel="stylesheet"><!-- checkbox 和radio 美化 --><link href="<?php echo $web_static; ?>/css/input.css" rel="stylesheet"><!-- <link href="<?php echo $web_static; ?>/css/checkbox.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/js/checkbox.js"></script> --><!-- select 美化 --><link href="<?php echo $web_static; ?>/css/select.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/jquery/scrollbar.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/jquery/scrollbar.js"></script><script src="<?php echo $web_static; ?>/js/select.js"></script><link href="<?php echo $web_static; ?>/css/common.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/editor/wangEditor.min.css" rel="stylesheet"><style>        .layout-return-btn{
            position: relative;
            top: -8px;
            left: -6px;
            margin: 0!important;
        }
        body{
            height: 1vh;
        }
    </style></head><body class="gray-bg  animated fadeIn"><div class="wrapper wrapper-content ibox float-e-margins" ><div class="ibox-title visible-lg"><!-- <h5> --><ul class="breadcrumb inline pull-left" ><li><?php echo $menu['pmenu']; ?></li><li><?php echo $menu['menu_name']; ?></li></ul><!-- </h5> --><a class="pull-right btn btn-default btn-xs" title="刷新当前" href=""><i class="fa fa-refresh"></i></a></div><div class="ibox-content"><div class="timeline-item"><div class="row"><div class="col-xs-2 date"><i class="fa fa-file-text"></i><span><?php echo $dir_info['all']['count']; ?>个文件</span><br><small class="text-navy"><?php echo $dir_info['all']['size']; ?></small></div><div class="col-xs-6 content"><p class="m-b-xs"><strong>所有缓存</strong></p><p>更新服务器所有缓存，不包括包括资源缓存</p><a href="<?php echo url('refresh/index',['type'=>'all']); ?>" class="btn btn-danger btn-w-m js-del-btn pull-right btn-outline" text="更新服务器所有缓存"><i class="fa fa-recycle fa-fw"></i>&nbsp;更新
            </a></div></div></div><div class="timeline-item"><div class="row"><div class="col-xs-2 date"><i class="fa fa-file-text"></i><span><?php echo $dir_info['static']['count']; ?>个文件</span><br><small class="text-navy"><?php echo $dir_info['static']['size']; ?></small></div><div class="col-xs-6 content"><p class="m-b-xs"><strong>资源缓存</strong></p><p>更新JS、CSS缓存文件，页面显示不正常请清理</p><a href="<?php echo url('refresh/index',['type'=>'static']); ?>" class="btn btn-danger btn-w-m js-del-btn pull-right btn-outline" text="更新JS、CSS缓存文件"><i class="fa fa-recycle fa-fw"></i>&nbsp;更新
            </a></div></div></div><div class="timeline-item"><div class="row"><div class="col-xs-2 date"><i class="fa fa-file-text"></i><span><?php echo $dir_info['html']['count']; ?>个文件</span><br><small class="text-navy"><?php echo $dir_info['html']['size']; ?></small></div><div class="col-xs-6 content"><p class="m-b-xs"><strong>页面缓存</strong></p><p>更新HTML页面缓存文件，页面显示不正常请清理</p><a href="<?php echo url('refresh/index',['type'=>'html']); ?>" class="btn btn-danger btn-w-m js-del-btn pull-right btn-outline" text="更新页面HTML缓存文件"><i class="fa fa-recycle fa-fw"></i>&nbsp;更新
            </a></div></div></div><div class="timeline-item"><div class="row"><div class="col-xs-2 date"><i class="fa fa-file-text"></i><span><?php echo $dir_info['log']['count']; ?>个文件</span><br><small class="text-navy"><?php echo $dir_info['log']['size']; ?></small></div><div class="col-xs-6 content"><p class="m-b-xs"><strong>系统日志</strong></p><p>系统运行产生的日志文件，不等于操作日志</p><a href="<?php echo url('refresh/index',['type'=>'log']); ?>" class="btn btn-danger btn-w-m js-del-btn pull-right btn-outline" text="更新缓存文件"><i class="fa fa-recycle fa-fw"></i>&nbsp;更新
            </a></div></div></div><div class="timeline-item"><div class="row"><div class="col-xs-2 date"><i class="fa fa-file-text"></i><span><?php echo $dir_info['cache']['count']; ?>个文件</span><br><small class="text-navy"><?php echo $dir_info['cache']['size']; ?></small></div><div class="col-xs-6 content"><p class="m-b-xs"><strong>系统缓存</strong></p><p>网站运行的其他缓存文件</p><a href="<?php echo url('refresh/index',['type'=>'cache']); ?>" class="btn btn-danger btn-w-m js-del-btn pull-right btn-outline" text="更新缓存文件"><i class="fa fa-recycle fa-fw"></i>&nbsp;更新
            </a></div></div></div></div></div></body><!-- 全局js --><script src="<?php echo $web_static; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script><!-- 第三方插件，加载进度条 --><script src="<?php echo $web_static; ?>/plugins/pace/pace.min.js"></script><!-- layui --><script src="<?php echo $web_static; ?>/plugins/layui/layer/layer.js"></script><script src="<?php echo $web_static; ?>/plugins/layui/laydate/laydate.js"></script><!-- 自定义js --><script src="<?php echo $web_static; ?>/js/layer.com.js"></script><script src="<?php echo $web_static; ?>/js/common.js"></script><script src="<?php echo $web_static; ?>/js/vue.js"></script><script src="<?php echo $js; ?>/hplus.js?v=4.1.0"></script><script src="<?php echo $js; ?>/contabs.js"></script></html><style type="text/css">    .panel-heading{
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