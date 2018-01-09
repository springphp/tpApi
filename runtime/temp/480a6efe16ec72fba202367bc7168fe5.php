<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"D:\phpStudy\WWW\tpApi\public\theme\admin\index\index.html";i:1498444428;s:57:"D:\phpStudy\WWW\tpApi\public\theme\admin\layout\left.html";i:1504174195;}*/ ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit"><title><?php echo $admin_title; ?></title><meta name="keywords" content=""><meta name="description" content=""><!-- 引入公共css/js --><link rel="shortcut icon" href="<?php echo $web_public; ?>favicon.ico"><!-- JQuery --><script src="<?php echo $web_static; ?>js/jquery.min.js"></script><link href="<?php echo $web_static; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"><!-- 字体图标 --><link href="<?php echo $web_static; ?>css/font-awesome.min.css" rel="stylesheet"><!-- 自定义样式 --><link href="<?php echo $css; ?>/animate.css" rel="stylesheet"><link href="<?php echo $css; ?>/style.css" rel="stylesheet"></head><body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden"  onload="checkLoginStatus()"><div id="wrapper"><script type="text/javascript" src="<?php echo $web_static; ?>/plugins/tree/jquery.ztree.core.js"></script><!--左侧导航开始--><nav class="navbar-default navbar-static-side" role="navigation"><div class="nav-close"><i class="fa fa-times-circle"></i></div><div class="sidebar-collapse"><ul class="nav sidebar-nav" id="side-menu"><li class="nav-header"><div class="dropdown profile-element" style="margin-left:-20px;text-align: center;"><span id ="imgs"><?php if($headimg != ''): ?><img alt="image" id="headimg" class="img-circle" src="<?php echo $web_public; ?>upload\<?php echo $headimg; ?>" width="70px" height="70px"/><?php else: ?><img alt="image" id="headimg" class="img-circle" src="<?php echo $web_static; ?>img/default1.jpg" width="70px" height="70px"/><?php endif; ?></span><a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="clear"><span class="block m-t-xs"><strong class="font-bold"><?php echo get_login_user_name(); ?></strong></span><span class="text-muted text-xs block"><?php echo get_login_admin_group(); ?><b class="caret"></b></span></span></a><ul class="dropdown-menu animated fadeInRight m-t-xs"><!--<li><a class="J_menuItem" href="">修改头像</a>--><!--</li>--><li><a  class="J_menuItem" href="<?php echo U('Admins/admin_info'); ?>">个人资料</a></li><!--<li><a class="J_menuItem" href="">信箱</a>--><!--</li>--><li class="divider"></li><li><a href="<?php echo U('Publics/loginOut'); ?>" text="退出登录确认" class="js-del-btn roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 安全退出</a></li></ul></div><div class="logo-element">L</div></li><?php echo $menus; ?></ul></div></nav><!--左侧导航结束--><script type="text/javascript">        	 $(function(){
        		$('#menu2').metisMenu();
                $("[data-url]").each(function(){
                    $(this).one('click', function(event){
                      event.preventDefault();
                      var $this = $(this);
                      var url = $this.attr('data-url');
                      console.log(url);
                      $.ajax({
                         url: url,
                         success: function(result) {
                            $('#menu2').metisMenu('dispose');
                            $this.parent('li').append(result);
                            $('#menu2').metisMenu();
                            $this.click();
                         }
                      });
                    });
                });
        	 })
        </script><!--右侧部分开始--><div id="page-wrapper" class="gray-bg dashbard-1"><div class="row border-bottom visible-xs"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin:10px 5px 5px 20px" href="#"><i class="fa fa-bars"></i></a></div><div class="row content-tabs"><button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button><nav class="page-tabs J_menuTabs"><div class="page-tabs-content"><a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a></div></nav><button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button><div class="btn-group roll-nav roll-right"><button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span></button><ul role="menu" class="dropdown-menu dropdown-menu-right"><li class="J_tabShowActive"><a>定位当前选项卡</a></li><li class="divider"></li><li class="J_tabCloseAll"><a>关闭全部选项卡</a></li><li class="J_tabCloseOther"><a>关闭其他选项卡</a></li></ul></div><a href="<?php echo U('Publics/loginOut'); ?>" text="退出登录确认" class="js-del-btn roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a></div><div class="row J_mainContent" id="content-main"><iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo url('index/main'); ?>" frameborder="0" data-id="index_v1.html" seamless></iframe></div><!--右侧部分结束--></div><link href="<?php echo $web_static; ?>plugins/metisMenu/metisMenu.css"></link><!-- layui --><script src="<?php echo $web_static; ?>/plugins/layui/layer/layer.js"></script><!-- 全局js --><script src="<?php echo $web_static; ?>js/common.js"></script><script src="<?php echo $web_static; ?>plugins/bootstrap/js/bootstrap.min.js"></script><script src="<?php echo $web_static; ?>plugins/slimscroll/jquery.slimscroll.min.js"></script><script src="<?php echo $web_static; ?>plugins/metisMenu/jquery.metisMenu.js"></script><!-- 第三方插件，加载进度条 --><script src="<?php echo $web_static; ?>plugins/pace/pace.min.js"></script><!-- 自定义js --><script src="<?php echo $js; ?>/hplus.js?v=4.1.0"></script><script src="<?php echo $js; ?>/contabs.js"></script><!-- 检测登录状态--><style type="text/css">        .J_mainContent{
            overflow-y: hidden!important;
        }
    </style><script type="text/javascript">        $(document).ready(function(){
            $(document).bind("contextmenu",function(e){
                return false;
            });
        });
        $(document).on('dblclick','.J_menuTab',function(){
            $(this).find('.fa-times-circle').click();
        })
        $(document).on('mousedown','.J_menuTab',function(e){
            if (e.which != 1) {
                $(this).find('.fa-times-circle').click();
            }
        })
        function checkLoginStatus(){
            //获取服务器数据
            $.ajax({
                url: '<?php echo U("Index/isUniqueLogin"); ?>',
                type: 'post',
                data: '',
                dataType: 'json',
                success: function (data) {
                    $(window).focus();
                    if(data.code != 1) {
                        clearInterval(getStatus)
                        layer.open({
                            content:data.msg,
                            btn1:function(){
                                window.location.href = '';
                            }
                        })
                        return false;
                    }
                }
            });
        }

        var setTime = '<?php echo config("beat_time"); ?>'?'<?php echo config("beat_time"); ?>'*1000:10000;
        var getStatus = setInterval("checkLoginStatus()",setTime);
    </script></body></html>