<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>
<style>
    .upload_bg {
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        opacity: 0;
        top: 0;
    }

    .m-navbar {
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }

    .m-bg {
        background-color: #fff !important;
    }

    .forum_thread_header .m-bg .navbar-item,
    .forum_thread_header .m-bg .navbar-item .back-ico:before,
    .forum_thread_header .m-bg .navbar-item .next-ico:before {
        color: #5C5C5C;
    }

    .navbar-title {
        color: #5C5C5C !important;
    }

    * {
        -webkit-overflow-scrolling: touch;
    }
    #header{
        height: 40px;
        background: #fff;
        line-height: 42px;
    }
    #header .tabs .active::after {
        position: absolute;
        bottom: 6px;
        display: flex;
        justify-content: center;
        content: '';
        z-index: 10;
        background: #36baf6;
        width: calc(100% - 47px);
        height: 2px;
    }
    #header .swiper-slide {
        padding:0 20px;
        font-size: 16px;
        width:auto;
        display: flex;
        justify-content: center;
    }
    .navding{
        position: static;
        /* transform: translateY(50px); */
        top: 0px;
        z-index: 10;
        background: #2196F3;
        right: 0;
        left: 0;
    }
</style>
<div class="g-view">
    <header class="forum_thread">
        <div style="background-image:url({if $forum[$fid]['bg_img']}{#WWW}{$forum[$fid]['bg_img']}{else}http://bpic.588ku.com/back_pic/04/43/61/69585352e75974a.jpg{/if});" class="forum_thread_header">
            <div class="m-navbar navbar-fixed" id="navbar">
                <a href="javascript:history.back(-1);" class="navbar-item">
                    <i class="icon-fanhui"></i>
                </a>
                <div class="navbar-center">
                    <span class="navbar-title form-title"></span>
                </div>
                {if NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$fid)}
                <a href="JavaScript:;" class="navbar-item" data-ydui-actionsheet="{target:'#xiugaibeijing',closeElement:'#cancel'}">
                    <i class="icon-yduigengduo"></i>
                </a>
                {else}
                <a href="JavaScript:;" class="navbar-item" data-ydui-actionsheet="{target:'#yd-search',closeElement:'#cancel'}">
                    <i class="icon-sousuo"></i>
                </a>
                {/if}
            </div>
            <div class="forumg">
                <div>
                    <div class="title">
                        <img class="forun_icon" src="{#WWW}upload/forum{$fid}.png?s={#NOW_TIME}" alt="" onerror="this.src='{#WWW}upload/de.png'">
                        <h3>{$title}</h3>
                    </div>
                </div>
                <div>
                    <div class="forun_info">
                        <div>
                            <h3 class="forum_color">{$forum[$fid]['threads']}</h3>
                            <p>主题</p>
                        </div>
                        <div>
                            <h3 class="forum_color">{$forum[$fid]['posts']}</h3>
                            <p>回复</p>
                        </div>
                        <div>
                            <h3 class="forum_color">{php echo S('plugins_myforum')->count(['fid'=>$fid])}</h3>
                            <p>关注</p>
                        </div>
                    </div>
                    <div>
                         <a href="javascript:;" {if !IS_LOGIN}onclick="is_login();"{else}data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{#HYBBS_URL('post')}','post')"{/if} class="btn btn-icon">
                             <div><i class="icon--jia"></i></div>
                         </a>
                         <a href="javascript:;" class="btn btn-icon" data-ydui-actionsheet="{target:'#form_fenx',closeElement:'#cancel'}">
                             <div><i class="icon-fenxiang"></i></div>
                         </a>
                         <a href="javascript:;" class="btn btn-icon" data-ydui-actionsheet="{target:'#gengduo',closeElement:'#cancel'}">
                             <div><i class="icon-yduigengduo"></i></div>
                         </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    {if NOW_GID == C("ADMIN_GROUP")||is_forumg($forum,NOW_UID,$fid)}
    <!-- 背景上传 -->
    <div class="m-actionsheet" id="xiugaibeijing" style="height: 100%;">
        <div class="g-view" style="height: 100%;overflow-y: scroll;">
            <header class="forum_thread">
                <div style="background-image:url({if $forum[$fid]['bg_img']}{#WWW}{$forum[$fid]['bg_img']}{else}http://bpic.588ku.com/back_pic/04/43/61/69585352e75974a.jpg{/if});" class="forum_thread_header">
                    <div class="m-navbar navbar-fixed">
                        <a href="javascript:;" class="navbar-item" id="cancel">
                            <i class="icon-cha"></i>
                        </a>
                        <div class="navbar-center">
                            <span class="navbar-title"></span>
                        </div>
                    </div>
                    <div class="forumg">
                        <div>
                            <div class="title">
                                <img class="forun_icon" src="{#WWW}upload/forum{$fid}.png?s={#NOW_TIME}" alt="" onerror="this.src='{#WWW}upload/de.png'">
                                <h3>{$title}</h3>
                            </div>
                        </div>
                        <div>
                            <div class="forun_info">
                                <div>
                                    <h3 class="forum_color">{$forum[$fid]['threads']}</h3>
                                    <p>主题</p>
                                </div>
                                <div>
                                    <h3 class="forum_color">{$forum[$fid]['posts']}</h3>
                                    <p>回复</p>
                                </div>
                                <div>
                                    <h3 class="forum_color">{php echo S('plugins_myforum')->count(['fid'=>$fid])}</h3>
                                    <p>关注</p>
                                </div>
                            </div>
                            <div>
                                <a href="javascript:;" class="btn btn-icon">
                                    <div><i class="icon--jia"></i></div>
                                </a>
                                <a href="javascript:;" class="btn btn-icon">
                                    <div><i class="icon-zhifeiji"></i></div>
                                </a>
                                <a href="javascript:;" class="btn btn-icon">
                                    <div><i class="icon-yduigengduo"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="m-celltitle" style="margin-top: 15px;">请上传尺寸接近414X190的图片</div>
            <div style="position: relative;margin: 0 10px;">
                <button class="btn-block btn-primary" style="margin-top: 0">点击上传背景图</button>
                <input class="upload_bg" type="file" name="phone" id="bgimg" multiple="multiple" name="photo" accept="image/*" onchange="upload_bg(this,'{$fid}')">
           </div>
            <div style="position: relative;margin: 0 10px;">
                <button class="btn-block btn-hollow" style="">点击上传板块图</button>
                <input class="upload_bg" type="file" name="phone" id="forum_icon" multiple="multiple" name="photo" accept="image/*" onchange="forum_icon(this,'{$fid}')">
           </div>
           <div class="m-cell" style="margin-top: 15px;">
                <div class="cell-item">
                    <div class="cell-right"><input type="text" name="forum_color" value="{$forum[$fid]['color']}" class="cell-input" placeholder="名称颜色,十六进制例如:#990099" autocomplete="off" /></div>
                </div>
                <div class="cell-item">
                    <div class="cell-right"><input type="text" name="forumg" value="{$forum[$fid]['forumg']}" class="cell-input" placeholder="版主id,多个用,分割例如:1,2" autocomplete="off" /></div>
                </div>
                <div class="cell-item">
                    <div class="cell-right">
                        <textarea class="cell-textarea" name="forum_mess" placeholder="板块简约描述,支持html" style="font-size: 15px">{$forum[$fid]['html']}</textarea>
                    </div>
                </div>
                <div class="cell-item">
                    <div class="cell-right">
                        <textarea class="cell-textarea" name="forum_bangui" placeholder="板块版规,支持html" style="font-size: 15px">{$forum[$fid]['bangui']}</textarea>
                    </div>
                </div>
                <div class="cell-item">
                    <div class="cell-right">
                        <button class="btn btn-primary" style="margin-top: 0" onclick="xiuforum(this,{$fid})">确认修改</button>
                    </div>
                </div>
                
            </div>
            <div class="m-celltitle" style="margin-top: 15px;">操作须知：<p>如果当前登录的账号属于该板块的版主，并且版主在此处删除自己id后讲失去版主权限。</p></div>
        </div>
    </div>
    {/if}
    <!-- 子分类 -->
    <div class="forum_thread_zifenlei forum_list" id="zifenlei">
        <div class="list">
            <div class="m-grids-4">
                <?php
                $fdata = S('forum')->select('*', ['fid' => $fid]);
                ?>
                {foreach $fdata as $v}
                <a href="{#HYBBS_URL('forum',$v['id'])}" data-pjax class="grids-item">
                    <div class="grids-txt">
                        <div class="list_img">
                            <img src="{#WWW}upload/forum{$v.id}.png" onerror="this.src='http://hy.cn/upload/de.png'">
                        </div>
                        <div class="list_title">{$v.name}</div>
                    </div>
                </a>
                {/foreach}
                {if empty($fdata)}
                <div class="no_thread">
                    <i class="icon-nuandou"></i>
                    <p>没有子分类...</p>
                </div>
                {/if}
            </div>
        </div>
    </div>
    <!-- 更多 -->
    <div class="m-actionsheet gengduo" id="gengduo" style="height: 100%;">
        <style>
            .next-ico::before{color: #656565;}
        </style>
        <header class="m-navbar navbar-fixed" style="background:#fff">
            <a href="javascript:;" class="navbar-item" id="cancel">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="" style="font-size: 20px;color: #656565 !important;"></span>
            </div>
        </header>
        <div class="g-view" style="height:100%;overflow-y: scroll;text-align: left">
            <div class="bankuai">
                <div><img src="{#WWW}upload/forum{$fid}.png" alt="{$title}" onerror="this.src='{#WWW}upload/de.png'"></div>
                <div style="width:100%;">
                    <h3>{$title}</h3>
                    <p>{if !$forum[$fid]['html']}赶紧写个描述{else}{$forum[$fid]['html']}{/if}</p>
                </div>
                <div class="guanzu">
                    {if S('plugins_myforum')->count(['fid'=>$fid,'uid'=>NOW_UID])}
                    <a href="javascript:;" onclick="follow_forum({$fid},'q',this)">取消</a>
                    {else}
                    <a href="javascript:;" onclick="follow_forum({$fid},'g',this)">关注</a>
                    {/if}
                </div>
            </div>
            <div class="nd_content">
                <div style="position: relative;">
                    <h4>版主</h4>
                </div>
                <div class="forum_list m-grids-4">
                    <?php
                    $banzhu = explode(",", $forum[$fid]['forumg']);
                    $User = M("User");
                    $banzhu = $User->select('*', ['uid' => $banzhu]);
                    ?>
                    {foreach $banzhu as $ban}
                    <a href="{#HYBBS_URL('my',$ban['user'])}" data-pjax="" class="grids-item">
                        <div class="grids-txt">
                            {php $guser = $User->uid_to_user($ban['uid']);$gavatar = $this->avatar($guser);}
                            <img src="{#WWW}{$gavatar.b}" alt="朋友圈列表">
                            <p>{$ban.user}</p>
                        </div>
                    </a>
                    {/foreach}
                    {if !$banzhu} <p style="padding:0 10px;color: #5a5a5a;font-size: 14px">暂无版主</p> {/if}
                </div>
            </div>
            <div class="nd_content">
                <div style="position: relative;">
                    <h4>版规</h4>
                </div>
                <article class="bangui">
                {if $forum[$fid]['bangui']}{$forum[$fid]['bangui']}{else}暂无版规{/if}
                </article>
            </div>
        </div>
    </div>
    <!-- 板块分享 -->
    <div class="fenxiang">
        <div class="m-actionsheet" id="form_fenx" style="background:#f5f5f5">
            <div style="background:  #fff;line-height:  40px;text-align:  left;padding: 0 15px;">分享到:</div>
            <div class="grids-txt datasetconfig form_fenx" data-sites="yixin">
            </div>
        </div>
    </div>
    <script>
        // 分享
        $(function(){
            soshm('.form_fenx', {
                // 分享的链接，默认使用location.href
                url: "{#HYBBS_URL('forum',$fid)}",
                // 分享的标题，默认使用document.title
                title: '{$title}',
                // 分享的摘要，默认使用<meta name="description" content="">content的值
                digest: "{$forum[$fid]['posts']}",
                // 分享的图片，默认获取本页面第一个img元素的src
                pic: '{#WWW}upload/forum{$fid}.png',
                sites: ['weixin','weixintimeline','qq','qzone','yixin','weibo','tqq','renren','douban','tieba']
            })
        })
    </script>
    <style>
        .soshm-item {
            float: left;
            margin: 10px 0px;
            cursor: pointer;
            width: 20%;
        }
    </style>
    <!-- 搜索页 -->
    <div class="m-actionsheet" id="yd-search" style="height: 100%;">
        <style>
            .next-ico::before{color: #656565;}
        </style>
        <header class="m-navbar navbar-fixed" style="background:#fff">
            <a href="javascript:;" class="navbar-item" id="cancel" style="color: #656565;">
                <i class="icon-fanhui"></i>
            </a>
            <div class="navbar-center">
                <span class="" style="font-size: 20px;color: #656565 !important;">搜索</span>
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
                    <a href="{#HYBBS_URL('search')}?key={$v}" data-pjax style="{if $k==0}color: #ff5900;border: 1px solid #ff5900;{elseif $k == 1}color: #03a9f4;border: 1px solid #03a9f4;{elseif $k==2}color: #4cd864;border: 1px solid #4cd864;{/if}">{$v}</a>
                {/foreach}
            </div>
        </div>
    </div>
    <!-- 菜单 -->
    <div class="navding">
    <div id="header">
        <div class="swiper-wrapper tabs">
            {foreach $forum_class as $k => $v}
                <a href="javascript:;" data-fid='{$v.id}' data-pageid="{$pageid}" data-show="{if $k==0}true{else}false{/if}" class="swiper-slide {if $k == 0}active{/if}">{$v.name}</a>
            {/foreach}
        </div>
    </div>
    </div>
    <!-- 列表视图 -->
    <div class="contentding">
        <div id="tabs-container" class="swiper-container">
            <div class="swiper-wrapper">
                {foreach $forum_class as $k=> $cfid}
                {if $k == 0}
                <div class="swiper-slide">
                    <ul class="news-list">
                    {if $top_list || $top_f_data}
                    <div class="m-cell" style="background:#fdfdfd;box-shadow:0 3px 17px -7px rgba(96, 125, 139, 0.31);margin-top: 1px;">
                        {foreach $top_list as $v}
                            <div class="cell-item">
                                <div class="zhiding">
                                    <span class="">置顶</span>
                                    <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax> {$v.title}</a>
                                </div>
                            </div>
                        {/foreach}
                        {foreach $top_f_data as $v}
                            <div class="cell-item">
                                <div class="zhiding">
                                    <span class="">置顶</span>
                                    <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax> {$v.title}</a>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                    {/if}
                    <!-- 列表 -->
                    <div id="forun_list_{$cfid.id}">
                        <!--ajax start-->
                        <?php
                        function is_style($fid)
                        {
                            $inc = array_filter(explode("\r\n", view_form('nd_mobile', 'style')));
                            foreach ($inc as $key => $val) {
                                $incs = explode(',', $val);
                                if ($fid == $incs['0']) {
                                    return $incs['1']; //返回样式id
                                    break;
                                }
                            }
                        }
                        ?>
                        {if is_style($fid,1) == 1}
                        <!-- 经典风格 -->
                            {foreach $data as $k => $v}
                                {include forum_list_jindian}
                            {/foreach}
                        {elseif is_style($fid) == 2}
                        <!-- 圈子风格 -->
                            {foreach $data as $k => $v}
                                {include forum_list_quanzi}
                            {/foreach}
                        {elseif is_style($fid) == 3}
                        <!-- 瀑布流风格 -->
                            {include forum_list_pubuliu}
                        {else}
                            {foreach $data as $k => $v}
                                {include forum_list_jindian}
                            {/foreach}
                        {/if}
                        <!--ajax end-->
                        {if empty($data)}
                        <div class="no_thread">
                            <i class="icon-meiyougengduo"></i>
                            <p>还没有帖子哦...</p>
                        </div>
                        {/if}
    
                    </div>
                    {if $page_count>1}
                        <a href="javascript:;" id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block" onclick="ajax_list(this)">
                            <span id="list-loading1">
                                点击加载更多
                            </span>
                            <span id="list-loading2" style="display:none">
                                <div class="loader loader-1">
                                    <div class="loader-outter"></div>
                                    <div class="loader-inner"></div>
                                </div>
                                加载中...
                            </span>
                        </a>
                        {if is_style($fid) == 3}
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/modernizr.custom.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/masonry.pkgd.min.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/imagesloaded.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/classie.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/AnimOnScroll.js"></script>
                            <script>
                                new AnimOnScroll(document.getElementById('grid'), {
                                    minDuration: 0.4,
                                    maxDuration: 0.7,
                                    viewportFactor: 0.2
                                });
                            </script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $(window).scroll(function () {
                                        if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                                            var page = parseInt($('#load-forun').attr("url")) + 1;
                                            var urlx = "{php HYBBS_URL('forum',$fid,[$type=>'" + page + "']);}";
                                            var pege_count = '{$page_count}';
                                            if (page <= pege_count) {
                                                    $.get(urlx, function (s) {
                                                        s = s.replace(/\\n|\\r/g, "");
                                                        s = s.substring(s.indexOf("<!--ajax-index start-->"), s.indexOf("<!--ajax-index end-->"));
                                                        $('#grid').append(s);
                                                        new AnimOnScroll(document.getElementById('grid'), {
                                                            minDuration: 0.4,
                                                            maxDuration: 0.7,
                                                            viewportFactor: 0.2
                                                        });
                                                        $('#load-forun').attr('url', page).css('display', 'none');
                                                    });
                                            } else {
                                                $('#load-forun span').text('- 我是有底线的 -');
                                            };
                                        }
                                    });
                                });
                            </script>
                        {else}
                            <script>
                                function ajax_list(obj){
                                    $(obj).addClass('btn-disabled');
                                    $('#list-loading1').hide();
                                    $('#list-loading2').show();
                                    var page = parseInt($('#load-forun').attr("url")) + 1;
                                    var url = "{php HYBBS_URL('forum',$fid,[$type=>'"+page+"']);}";
                                    var pege_count = "{$page_count}";
                                    if (page <= pege_count) {
                                            $.get(url, function(s) {
                                                s = s.replace(/\\n|\\r/g, "");
                                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                                $('#forun_list').append(s);
                                                $('#load-forun').attr('url', page);
                                                $(obj).removeClass('btn-disabled');
                                                $('#list-loading2').hide();
                                                $('#list-loading1').show();
                                                $("img.lazyload").lazyload();
                                            });
    
                                    } else {
                                        $('#load-forun span').text('- 我是有底线的 -');
                                    };
                                };
                            </script>
                        {/if}
                    {/if}
                    </ul>
                </div>
                {else}
                <div class="swiper-slide">
                    <ul class="news-list">
                    {if $top_list || $top_f_data}
                    <div class="m-cell" style="background:#fdfdfd;box-shadow:0 3px 17px -7px rgba(96, 125, 139, 0.31);margin-top: 1px;">
                        {foreach $top_list as $v}
                            <div class="cell-item">
                                <div class="zhiding">
                                    <span class="">置顶</span>
                                    <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax> {$v.title}</a>
                                </div>
                            </div>
                        {/foreach}
                        {foreach $top_f_data as $v}
                            <div class="cell-item">
                                <div class="zhiding">
                                    <span class="">置顶</span>
                                    <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax> {$v.title}</a>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                    {/if}
                    <!-- ajax列表 -->
                    <div id="forun_list_{$cfid.id}">
                        
                    </div>
                    {if $page_count>1}
                        <a href="javascript:;" id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block" onclick="ajax_list(this)">
                            <span id="list-loading1">
                                点击加载更多
                            </span>
                            <span id="list-loading2" style="display:none">
                                <div class="loader loader-1">
                                    <div class="loader-outter"></div>
                                    <div class="loader-inner"></div>
                                </div>
                                加载中...
                            </span>
                        </a>
                        {if is_style($fid) == 3}
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/modernizr.custom.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/masonry.pkgd.min.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/imagesloaded.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/classie.js"></script>
                            <script src="{#WWW}View/nd_mobile/src/GridLoadingEffects/js/AnimOnScroll.js"></script>
                            <script>
                                new AnimOnScroll(document.getElementById('grid'), {
                                    minDuration: 0.4,
                                    maxDuration: 0.7,
                                    viewportFactor: 0.2
                                });
                            </script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $(window).scroll(function () {
                                        if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                                            var page = parseInt($('#load-forun').attr("url")) + 1;
                                            var urlx = "{php HYBBS_URL('forum',$fid,[$type=>'" + page + "']);}";
                                            var pege_count = '{$page_count}';
                                            if (page <= pege_count) {
                                                    $.get(urlx, function (s) {
                                                        s = s.replace(/\\n|\\r/g, "");
                                                        s = s.substring(s.indexOf("<!--ajax-index start-->"), s.indexOf("<!--ajax-index end-->"));
                                                        $('#grid').append(s);
                                                        new AnimOnScroll(document.getElementById('grid'), {
                                                            minDuration: 0.4,
                                                            maxDuration: 0.7,
                                                            viewportFactor: 0.2
                                                        });
                                                        $('#load-forun').attr('url', page).css('display', 'none');
                                                    });
                                            } else {
                                                $('#load-forun span').text('- 我是有底线的 -');
                                            };
                                        }
                                    });
                                });
                            </script>
                        {else}
                            <script>
                                function ajax_list(obj){
                                    $(obj).addClass('btn-disabled');
                                    $('#list-loading1').hide();
                                    $('#list-loading2').show();
                                    var page = parseInt($('#load-forun').attr("url")) + 1;
                                    var url = "{php HYBBS_URL('forum',$fid,[$type=>'"+page+"']);}";
                                    var pege_count = "{$page_count}";
                                    if (page <= pege_count) {
                                            $.get(url, function(s) {
                                                s = s.replace(/\\n|\\r/g, "");
                                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                                $('#forun_list').append(s);
                                                $('#load-forun').attr('url', page);
                                                $(obj).removeClass('btn-disabled');
                                                $('#list-loading2').hide();
                                                $('#list-loading1').show();
                                                $("img.lazyload").lazyload();
                                            });
    
                                    } else {
                                        $('#load-forun span').text('- 我是有底线的 -');
                                    };
                                };
                            </script>
                        {/if}
                    {/if}
                    </ul>
                </div>
                {/if}
                {/foreach}
            </div>
        </div>
    </div>
    <!-- <div class="forum_thread_nav" style="box-shadow:0 3px 17px -7px rgba(96, 125, 139, 0.31);">
        <a class="{if !isset($_GET['HY_URL'][2])}active{/if}" href="{php HYBBS_URL('forum',$fid);}" data-pjax>全部</a>
        <a class="{if isset($_GET['HY_URL'][2])}{if $_GET['HY_URL'][2] == 'new'}active{/if}{/if}" href="{php HYBBS_URL('forum',$fid,'new');}" data-pjax>最新</a>
        <a class="{if isset($_GET['HY_URL'][2])}{if $_GET['HY_URL'][2] == 'btime'}active{/if}{/if}" href="{php HYBBS_URL('forum',$fid,'btime');}" data-pjax>回复</a>
        <a class="" href="{php HYBBS_URL('plugins','digest',$fid);}" data-pjax>精华</a>
        <div class="right">
            <a href="javascript:;" data-ydui-actionsheet="{target:'#zifenlei',closeElement:'#cancel'}">
                <i class="icon-leimupinleifenleileibie"></i>
            </a>
        </div>
    </div> -->


</div>
<script>
    var navSwiper = new Swiper('#header', {
        freeMode: true,
        slidesPerView: 'auto',
        freeModeSticky: true,
    });

    var tabsSwiper = new Swiper('#tabs-container', {
        speed: 500,
        on: {
            slideChangeTransitionStart: function() {
                $(".tabs .active").removeClass('active');
                $(".tabs a").eq(this.activeIndex).addClass('active');
                var fid = $(".tabs a").eq(this.activeIndex).attr('data-fid');
                var show = $(".tabs a").eq(this.activeIndex).attr('data-show')
                if(show != 'true'){                    
                    $(".tabs a").eq(this.activeIndex).attr('data-show','true');
                    $.ajax({
                        type: "get",
                        url: "{#HYBBS_URL('plugins','forum')}",
                        data: {fid:fid},
                        dataType: "json",
                        success: function (e) {
                            loopjindian(e);
                        }
                    });
                }
            }
        }
    })

    $(".tabs a").on('click', function(e) {
        e.preventDefault()
        $(".tabs .active").removeClass('active')
        $(this).addClass('active')
        tabsSwiper.slideTo($(this).index())
        // console.log('打开了'+$(this).index())
    })
    $(function() {
        $(window).scroll(function() {
            if ($(document).scrollTop() >= 140) {
                $('#navbar').addClass('m-bg');
                $('.form-title').text('{$title;}');
                $('.navding').css({
                    position: 'fixed',
                    top: '50px'
                })
                $('.contentding').css('margin-top','40px');
                $('.contentding .swiper-slide').css({
                    'overflow-y': 'scroll',
                    'height':" calc(100vh - 140px)"
                })

            }else{
                $('#navbar').removeClass('m-bg');
                $('.form-title').text('');
                $('.contentding').css('margin-top','0px');

                $('.navding').css({
                    position: 'static',
                    top: '0'
                })
                $('.contentding .swiper-slide').attr('style','')
            }
            
        });
        $('.contentding .swiper-slide').scroll(function(){
            console.log($(this).scrollTop())
            if($('.contentding .swiper-slide').scrollTop() < 0){
                $('body').attr('style','')
                $('.contentding').css('margin-top','40px');
                $('.contentding .swiper-slide').attr('style','')
            }
        })

    });
</script>
{include common/footer} 
{include common/foot}