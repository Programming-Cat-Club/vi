<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<style>
    .upload_bg{
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        opacity: 0;
        top: 0;
    }
    .m-navbar{
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }
    .m-bg {
        background-color:#fff!important;
    }
    .m-bg .navbar-item, .navbar-center .navbar-title, 
    .m-bg .navbar-item .icon-fanhui::before, 
    .m-bg .navbar-item .next-ico::before,
    .m-bg .navbar-center .navbar-title{
        color: #5c5c5c;
    }
    .navbar-item, .navbar-center .navbar-title, .navbar-item .icon-fanhui::before, .navbar-item .next-ico::before{
        color: #fff;
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
                    <span class="navbar-title"></span>
                </div>
                {if NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$fid)}
                <a href="JavaScript:;" class="navbar-item" data-ydui-actionsheet="{target:'#xiugaibeijing',closeElement:'#cancel'}">
                    <i class="icon-yduigengduo"></i>
                </a>
                {else}
                <a href="{#HYBBS_URL('Search')}" data-pjax class="navbar-item">
                    <i class="icon-yduisousuo"></i>
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

    <div class="forum_thread_nav">
        <a class="{if !isset($_GET['HY_URL'][2])}active{/if}" href="{php HYBBS_URL('forum',$fid);}" data-pjax>全部</a>
        <a class="{if isset($_GET['HY_URL'][2])}{if $_GET['HY_URL'][2] == 'new'}active{/if}{/if}" href="{php HYBBS_URL('forum',$fid,'new');}" data-pjax>最新</a>
        <a class="{if isset($_GET['HY_URL'][2])}{if $_GET['HY_URL'][2] == 'btime'}active{/if}{/if}" href="{php HYBBS_URL('forum',$fid,'btime');}" data-pjax>回复</a>
        <a class="{if METHOD_NAME == 'Digest'}active{/if}" href="{php HYBBS_URL('plugins','digest',$fid);}" data-pjax>精华</a>
        <!-- <a class="{if isset($_GET['HY_URL'][2])}{if $_GET['HY_URL'][2] == 'btime'}active{/if}{/if}" href="{php HYBBS_URL('plugins',$fid,'zhuanti');}">专题</a> -->
        <div class="right">
            <a href="javascript:;" data-ydui-actionsheet="{target:'#zifenlei',closeElement:'#cancel'}">
                <i class="icon-leimupinleifenleileibie"></i>
            </a>
        </div>
    </div>
        <!-- 子分类 -->
    <div class="forum_thread_zifenlei forum_list" id="zifenlei">
        <div class="list">
            <div class="m-grids-4">
                <?php
                    $fdata = S('forum')->select('*',['fid'=>$fid]);
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
        <header class="m-navbar navbar-fixed" style="background:#03A9F4">
            <a href="javascript:;" class="navbar-item" id="cancel">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="" style="font-size: 20px;color: #656565 !important;"></span>
            </div>
        </header>
        <div class="g-view" style="height:100%;text-align: left">
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
                        $banzhu = explode(",",$forum[$fid]['forumg']);
                        $User = M("User");
                        $banzhu = $User->select('*',['uid'=>$banzhu]);
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
    <!-- 列表 -->
    <div id="forun_list">
        <!--ajax start-->
        {foreach $data as  $k=>$v}
            {include forum_list_jindian}
        {/foreach}
        <!--ajax end-->
    </div>
    {if empty($data)}
    <div class="m-cell" style="margin-top: 15px;">
        <div class="no_thread">
                <i class="icon-nuandou"></i>
                <p>没有任何精华内容...</p>
            </div>
        </div>
    {/if}
    {if $page_count>1}
    <div id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block"><span>加载中...</span></div>
    <script>
            $(function() {
                $(window).scroll(function() {
                    if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                        var page = parseInt($('#load-forun').attr("url")) + 1;
                        var url = "{php HYBBS_URL('plugins','digest',$fid,'"+exp+page+"');}";
    
                        var pege_count = "{$page_count}";
                        if (page <= pege_count) {
                            $.get(url, function(s) {
                                s = s.replace(/\\n|\\r/g, "");
                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                $('#forun_list').append(s);
                                $('#load-forun').attr('url', page);
                                $("img.lazyload").lazyload();
                            });
                        } else {
                            $('#load-forun span').text('- 我是有底线的 -');
                        };
                    }
                });
            });
    </script>
    {/if}
</div>
<script>
    $(function() {
        $(window).scroll(function() {
            if ($(document).scrollTop() >= 200) {
                $('#navbar').addClass('m-bg');
                $('.navbar-title').text('{$forum[$fid]["name"]}');
                
            }else{
                $('#navbar').removeClass('m-bg');
                $('.navbar-title').text('');
            }
        });
    });
</script>
{include common/footer}
{include common/foot}