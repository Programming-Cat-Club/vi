<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<style>
    .index .navbar-item,
    .index .navbar-center .navbar-title,
    .index .navbar-item .icon-fanhui:before, .navbar-item .next-ico:before{
        color: #fff;
    }
</style>
    <header class="m-navbar navbar-fixed index" style="background:rgba(0, 0, 0, 0.0);padding: 10px 5px;">
        <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#yd-popup',closeElement:'#cancel'}">
            <i class="icon-fenlei4"></i>
        </a>
        <div class="navbar-center">
            <a href="javascript:;" class="navbar-title" style="background: rgba(255, 255, 255, 0.3);padding: 6px;line-height: 26px;height: 35px;border-radius: 4px;font-size: 18px;" data-ydui-actionsheet="{target:'#yd-search',closeElement:'#cancel'}">搜索</a>
        </div>
        <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}javascript:;{/if}" {if IS_LOGIN}data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{#HYBBS_URL('post')}','post')"{else}data-pjax{/if} class="navbar-item search">
            <i class="icon--jia"></i>
        </a>
    </header>
    <header class="m-navbar navbar-fixed index-navbar" style="display:none">
        <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#yd-popup',closeElement:'#cancel'}">
            <i class="icon-fenlei4"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">{#BBSCONF('logo')}</span>
        </div>
        <a href="javascript:;" class="navbar-item search" data-ydui-actionsheet="{target:'#yd-search',closeElement:'#cancel'}">
            <i class="icon-sousuo"></i>
        </a>
    </header>
    <div class="g-view">
        <div class="lding"></div>
        <div class="m-actionsheet yd-popup-left" style="width: 60%;height: 100%;background: #fff;overflow-y: scroll;" id="yd-popup">
            <!--侧栏-->
            <div class="yd-popup-content">
                    {if IS_LOGIN}
                        {php $user_img = S('user_style')->find('*',['uid'=>$user['uid']]);}
                    {/if}
                    {php $inc = get_plugin_inc('nd_user_img');}
                <div class="sidbg" style="background-image:url({if IS_LOGIN}{if $user_img}{$user_img['img']}?r={#time()}{else}{$inc.user_d_img}{/if}{else}{$inc.user_d_img}{/if});">
                    {if IS_LOGIN}
                    <a class="zhuti" href="{#HYBBS_URL('my',$user['user'],'user_style')}" data-pjax><i class="icon-zhuti"></i></a>
                    {/if}
                    <div class="userinfo" style="">
                        <h3>{if IS_LOGIN}{$user.user}{else}游客{/if}</h3>
                        <p>{if IS_LOGIN}{if $user['user']}{$user.ps}{else}欢迎访问{#BBSCONF('title')}!{/if}{else}欢迎访问{#BBSCONF('title')}!{/if}</p>
                    </div>
                </div>
                <div class="sidbr" style="margin-top: 15px;">
                    <li><a data-pjax href="{#HYBBS_URL('forum')}"><i class="iconfont icon-shejiaoxinxi2" style="color: #00BCD4;"></i> 社区论坛</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('Coterie')}"><i class="iconfont icon-quanzi3" style="color: #8BC34A;"></i> 我的圈子</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','sign')}"><i class="iconfont icon-qiandao" style="color: #673AB7;"></i> 每日签到</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','task')}"><i class="iconfont icon-qiandao1" style="color: #4CAF50;"></i> 每日任务</a></li>
                    <li><a data-pjax href="{if IS_LOGIN}{#HYBBS_URL('my',$user['user'])}{else}{#HYBBS_URL('user','login')}{/if}"><i class="iconfont icon-shouye" style="color: #E91E63;"></i> 个人中心</a></li>
                    {hook nd_m_sidebar_1}
                    {if NOW_GID == C("ADMIN_GROUP")}
                    <li style="border-top: 1px solid #ddd;"><a data-pjax href="{#HYBBS_URL('plugins','tuijian')}"><i class="iconfont icon-tj"></i> 推荐管理</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','jing')}"><i class="iconfont icon-tuijian1"></i> 精华管理</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','jubao')}"><i class="iconfont icon-jubao"></i> 举报管理</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','aut')}"><i class="iconfont icon-renzhengguanli"></i> 认证管理</a></li>
                    <li><a data-pjax href="{#HYBBS_URL('plugins','vip')}"><i class="iconfont icon-vip1"></i> VIP 管理</a></li>
                    {hook nd_m_sidebar_2}
                    <li><a href="{#HYBBS_URL('admin')}"><i class="iconfont icon-Administratorconfig"></i> 后台管理</a></li>
                    {/if}
                    {if IS_LOGIN}
                    <li style="border-top: 1px solid #ddd;"><a href="{#HYBBS_URL('user','out')}" style="color:red"><i class="iconfont icon-qiehuanzuhu"></i> 退出登录</a></li>
                    {/if}
                </div>
            </div>
            <!---->
        </div>
        <div class="m-actionsheet" id="yd-search" style="height: 100%;">
            <header class="m-navbar navbar-fixed">
                <a href="javascript:;" class="navbar-item" id="cancel">
                    <i class="icon-fanhui"></i>
                </a>
                <div class="navbar-center">
                    <span class="navbar-title">搜索</span>
                </div>
            </header>
            <div class="g-view" style="height:100%">
                <div class="sh">
                    <form id="form" action="{#HYBBS_URL('search')}">
                        <input id="sou" type="text" name="key" placeholder="输入关键词">
                        <button class="shbtn" type="submit" style="display: none">搜索</button>
                    </form>
                </div>
                <div class="resou" style="margin-top:10px;text-align: left;">
                    <div>热门搜索</div>
                    {php $inc = get_plugin_inc('nd_website_plus');$sou = array_filter(explode(",",$inc['sou_key']))}
                    {foreach $sou as $k => $v}
                        <a data-pjax href="{#HYBBS_URL('search')}?key={$v}" style="{if $k==0}color: #ff5900;border: 1px solid #ff5900;{elseif $k == 1}color: #03a9f4;border: 1px solid #03a9f4;{elseif $k==2}color: #4cd864;border: 1px solid #4cd864;{/if}">{$v}</a>
                    {/foreach}
                </div>
            </div>
        </div>
        <!-- banner -->
        {include index_banner}
        <div class="index_menu m-grids-3">
            <a data-pjax href="{#HYBBS_URL('plugins','sign')}" class="grids-item">
                <div class="grids-txt">
                    <div  class="sign">
                        <h1><i class="icon-qiandao4"></i></h1>
                        <span>签到有奖</span>
                    </div>
                </div>
            </a>
            <a data-pjax href="{#HYBBS_URL('plugins','task')}" class="grids-item">
                <div class="grids-txt">
                    <div class="task">
                        <h1><i class="icon-renwu"></i></h1>
                        <span>每日任务</span>
                    </div>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}javascript:;{/if}" {if IS_LOGIN}data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{#HYBBS_URL('post')}','post')"{else}data-pjax{/if} class="grids-item">
                <div class="grids-txt">
                    <div class="posts">
                        <h1><i class="icon-shequfatie"></i></h1>
                        <span>发布话题</span>
                    </div>
                </div>
            </a>
        </div>
        <!-- 功能推荐 -->
        {if view_form('nd_mobile','bankuai_no') == 1}
        {include index_gongneng}
        {/if}
        {if view_form('nd_mobile','zidingyi_html_no') == 1}
        {php echo view_form('nd_mobile','zidingyi_html')}
        {/if}

        <!-- 社区新帖 -->
        {if view_form('nd_mobile','xintie_no') == 1}
        {include tuijian_xintie}
        {/if}
        <!-- 推荐阅读 -->
        {if view_form('nd_mobile','tuijian_thread_no') == 1}
        {include tuijian_yuedu}
        {/if}
        <!-- 专题推荐 -->
        {if view_form('nd_mobile','huodong_thread_no') == 1}
        {include tuijian_zhuanti}
        {/if}
        {hook nd_mobile_index_2}
        <!-- 精彩贴图 -->
        {if view_form('nd_mobile','tupian_no') == 1}
        {include tuijian_meitu}
        {/if}
        <!-- 广告位 1 -->
        {if view_form('nd_mobile','guanggao_index_1_no') == 1}
        {include index_guanggao_1}
        {/if}
        <!-- 自定义板块推荐 -->
        {if view_form('nd_mobile','zidingyibankuai_no') == 1}
        {include tuijian_bankuai}
        {/if}
        <!-- 推荐关注 -->
        {if view_form('nd_mobile','guanzhu_no') == 1}
        {include tuijian_guanzhu}
        {/if}
        <!-- 广告位 2 -->
        {if view_form('nd_mobile','guanggao_index_2_no') == 1}
        {include index_guanggao_2}
        {/if}
        {hook nd_mobile_index_1}
        <!-- 精华文章 -->
        {if view_form('nd_mobile','jinghua_no') == 1}
        {include tuijian_jinghua}
        {/if}
        <!-- 新帖热帖 无限下拉 -->
        <style>
        .index_xin {text-align:center;margin-bottom: 15px;}
        .index_xin a{font-size: 16px;margin: 5px;font-weight: bold;padding-bottom: 5px;color:#444}
        .jiazai {text-align: center;margin: 20px;}
        .jiazai a{background: #37bbf7;padding:8px 12px;color: #fff;border-radius: 33px;box-shadow: 0 4px 20px -4px rgba(0, 188, 212, 0.54);}
        </style>
        <div class="index_xin">
            <a href="javascript:;">热门推荐</a>
        </div>
        <div id="index-list">
            <!--ajax start-->
        {foreach $thread_list as $v}
        {include forum_list_jindian}
        {/foreach}
            <!--ajax end-->
        </div>
        <div class="jiazai"><a href="javascript:;" data-page="{$pageid}" onclick="ajax_list(this)">加载更多</a></div>
        <script>
                function ajax_list(obj){
                    $(obj).text('加载中...');
                    var page = parseInt($(obj).attr("data-page")) + 1;
                    var url = "{php echo HYBBS_URL('new','"+page+"');}";
                    
                    var pege_count = "{$page_count}";
                    if (page <= pege_count) {
                            $.get(url, function(s) {
                                s = s.replace(/\\n|\\r/g, "");
                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                $('#index-list').append(s);
                                $('#load-forun').attr('url', page);
                                $(obj).removeClass('btn-disabled');
                                $("img.lazyload").lazyload();
                                $(obj).attr('data-page',page).text('加载更多')
                            });

                    } else {
                        $('#load-forun span').text('- 我是有底线的 -');
                    };
                };
        </script>
        {if view_form('nd_mobile','links_no') == 1}
        <!-- 友情链接 -->
        <div class="nd_crde">
            <div style="position: relative;">
                <h4>友情链接
                    <a href="{php echo view_form('nd_mobile','links_shenqing')}"><span style="float:right;color:#03a9f4">申请</span></a>
                </h4>
            </div>
            <article class="m-list list-theme1 links" style="padding:0">
                <div class="m-grids-4" style="margin: 10px 12px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                {php $links = array_filter(explode("\r\n",view_form('nd_mobile','links')))}
                {foreach $links as $v}
                    {php $youlian = explode(",",$v)}
                    <a href="{$youlian.0}" class="grids-item">
                        <div class="grids-txt"><span>{$youlian.1}</span></div>
                    </a>
                {/foreach}
                </div>
                <style>
                .links .m-grids-4 .grids-item:after{
                    border-bottom: 1px solid #D9D9D9;
                }
                </style>
            </article>
        </div>
        {/if}
        <div class="index_footer">
            <?php echo view_form('nd_mobile','index_footer');?>
        </div>
    </div>
{include common/footer}
{include common/foot}