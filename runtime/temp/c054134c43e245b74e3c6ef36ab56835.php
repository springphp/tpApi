<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:57:"D:\phpStudy\WWW\tpApi\public\theme\admin\menus\index.html";i:1504165292;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\layout.html";i:1498444427;s:59:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\static.html";i:1499741413;s:55:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\js.html";i:1504165296;}*/ ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><meta name="renderer" content="webkit"><title><?php echo $admin_title; ?></title><meta name="keywords" content=""><meta name="description" content=""><!-- 引入公共css/js --><!-- 字体图标 --><link rel="shortcut icon" href="<?php echo $web_public; ?>favicon.ico"><link href="<?php echo $web_static; ?>/css/font-awesome.min.css" rel="stylesheet"><!-- JQuery --><script src="<?php echo $web_static; ?>/js/jquery.min.js"></script><script src="<?php echo $web_static; ?>/plugins/metisMenu/jquery.metisMenu.js"></script><!-- bootstrap --><link href="<?php echo $web_static; ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/bootstrap/js/bootstrap.min.js"></script><!-- 自定义样式 --><link href="<?php echo $css; ?>/animate.css" rel="stylesheet"><link href="<?php echo $css; ?>/style.css" rel="stylesheet"><!-- checkbox 和radio 美化 --><link href="<?php echo $web_static; ?>/css/input.css" rel="stylesheet"><!-- <link href="<?php echo $web_static; ?>/css/checkbox.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/js/checkbox.js"></script> --><!-- select 美化 --><link href="<?php echo $web_static; ?>/css/select.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/jquery/scrollbar.css" rel="stylesheet"><script src="<?php echo $web_static; ?>/plugins/jquery/scrollbar.js"></script><script src="<?php echo $web_static; ?>/js/select.js"></script><link href="<?php echo $web_static; ?>/css/common.css" rel="stylesheet"><link href="<?php echo $web_static; ?>/plugins/editor/wangEditor.min.css" rel="stylesheet"><style>        .layout-return-btn{
            position: relative;
            top: -8px;
            left: -6px;
            margin: 0!important;
        }
        body{
            height: 1vh;
        }
    </style></head><body class="gray-bg  animated fadeIn"><div class="wrapper wrapper-content ibox float-e-margins" ><div class="ibox-title visible-lg"><!-- <h5> --><ul class="breadcrumb inline pull-left" ><li><?php echo $menu['pmenu']; ?></li><li><?php echo $menu['menu_name']; ?></li></ul><!-- </h5> --><a class="pull-right btn btn-default btn-xs" title="刷新当前" href=""><i class="fa fa-refresh"></i></a></div><div class="ibox-content"><div class="table-responsive"><div class="btn-group pull-left hidden-xs"><a href="<?php echo url('add'); ?>" class="btn btn-outline btn-default js-window-load"js-title="新增菜单" js-unique="true"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;新增
        </a><a href="<?php echo url('menus/del'); ?>" class="btn btn-outline btn-default del-all" text="删除后将无法恢复，请谨慎操作"><i class="fa fa-trash" aria-hidden="true" ></i>&nbsp;删除
        </a></div><div class="pull-right col-sm-3 search"></div><table id="menuTree"  class="table table-hover table-bordered table-condensed" style="width:100%"><thead><tr ><th class="hidden-xs" width="1"><input type="checkbox" class="i-checks i-check-all my-all-check" name="input[]"></th><th width="200" js-order='menu_name' class="js-order">名称</th><th class="hidden-xs" width="50">排序</th><th class="hidden-xs" width="70">状态&nbsp;<i class="fa fa-hand-pointer-o"></i></th><th class="hidden-xs">URL</th><th width="200">操作</th></tr></thead><tbody><?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo $vo['menu_id']; ?>"<?php if($vo['pid'] != 0): ?>pId="<?php echo $vo['pid']; ?>"<?php endif; ?>><td class="hidden-xs"><input type="checkbox" class="i-checks" name="input[]" value="<?php echo $vo['menu_id']; ?>"></td><td controller="true"><i title="<?php echo $vo['menu_icon']; ?>" class="fa fa-fw fa-lg fa-<?php echo $vo['menu_icon']; ?>"></i>&nbsp;<?php echo $vo['menu_name']; ?></td><td class="hidden-xs"><?php echo $vo['sort']; ?></td><td class="hidden-xs"><?php if($vo['status'] == 0): ?><a href="<?php echo U('changeStatus',['menu_id'=>$vo['menu_id'],'status'=>1]); ?>" js-color="#eea236" class="btn btn-danger btn-outline btn-xs js-del-btn" text="菜单将会在导航中显示" js-btn="<i class='fa fa-check fa-fw'></i>显示"><i class="fa fa-times fa-fw"></i><span class="hidden-xs">隐藏</span></a><?php elseif($vo['status'] == 1): ?><a href="<?php echo U('changeStatus',['menu_id'=>$vo['menu_id'],'status'=>0]); ?>" js-color="#eea236" class="btn btn-default btn-outline btn-xs js-del-btn" text="菜单将不会显示在导航中" js-btn="<i class='fa fa-times fa-fw'></i>隐藏"><i class="fa fa-check fa-fw"></i><span class="hidden-xs">显示</span></a><?php endif; ?></td><td class="hidden-xs" controller="true"><?php echo $vo['url']; ?></td><td><span class="btn-group"><?php if($vo['level'] < 2): ?><a href="<?php echo U('menus/add',['pid'=>$vo['menu_id']]); ?>" class="btn btn-outline btn-default btn-xs js-window-load" js-title="新增子菜单" js-unique="true"><i class="fa fa-plus fa-fw"></i><span class="hidden-xs">新增子项</span></a><?php else: ?><a href="javascript:;" class="btn btn-outline btn-default btn-xs disabled"><i class="fa fa-plus fa-fw"></i><span class="hidden-xs">新增子项</span></a><?php endif; ?><a href="<?php echo U('menus/edit',['menu_id'=>$vo['menu_id']]); ?>" class="btn btn-outline btn-default btn-xs js-window-load" js-title="编辑：<?php echo $vo['menu_name']; ?>" js-unique="true"><i class="fa fa-edit fa-fw"></i><span class="hidden-xs">编辑</span></a><a href="<?php echo U('menus/del',['id'=>$vo['menu_id']]); ?>" class="btn btn-outline btn-danger btn-xs js-del-btn" text="删除：<?php echo $vo['menu_name']; ?>，将同时删除子菜单！"><i class="fa fa-trash-o fa-fw"></i><span class="hidden-xs">删除</span></a></span></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></tbody></table><div class="cleanfix"><div class="pull-left"></div></div></div><link id="tree_table_default" href="<?php echo $web_static; ?>/plugins/treetable/default/jquery.treeTable.css" rel="stylesheet" type="text/css" /><script src="<?php echo $web_static; ?>/plugins/treetable/jquery.treeTable.js" type="text/javascript"></script><script type="text/javascript">$(function(){
    var option = {
        theme:'default',
        column:1,
        expandLevel : 1,
        beforeExpand : function($treeTable, id) {},//展开过后动作
        onSelect : function($treeTable, id) {}//选中时操作
    };
    $('#menuTree').treeTable(option);
});
</script></div></div></body><!-- 全局js --><script src="<?php echo $web_static; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script><!-- 第三方插件，加载进度条 --><script src="<?php echo $web_static; ?>/plugins/pace/pace.min.js"></script><!-- layui --><script src="<?php echo $web_static; ?>/plugins/layui/layer/layer.js"></script><script src="<?php echo $web_static; ?>/plugins/layui/laydate/laydate.js"></script><!-- 自定义js --><script src="<?php echo $web_static; ?>/js/layer.com.js"></script><script src="<?php echo $web_static; ?>/js/common.js"></script><script src="<?php echo $web_static; ?>/js/vue.js"></script><script src="<?php echo $js; ?>/hplus.js?v=4.1.0"></script><script src="<?php echo $js; ?>/contabs.js"></script></html><style type="text/css">    .panel-heading{
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