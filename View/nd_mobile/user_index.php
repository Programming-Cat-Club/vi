<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<div class="user">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">{$title}</span>
        </div>
        {if IS_LOGIN}
            {if NOW_UID == $data['uid']}
            <a href="{#HYBBS_URL('my',$data['user'],'op')}" data-pjax class="navbar-item">
                <i class="icon-yduigengduo"></i>
            </a>
            {else}
            <a href="#" class="navbar-item" data-ydui-actionsheet="{target:'#actionsheet',closeElement:'#cancel'}">
                <i class="icon-yduigengduo"></i>
            </a>
            {/if}
        {/if}
    </header>
</div>
{if NOW_UID != $data['uid']}
<div class="m-actionsheet user-gengduo" id="actionsheet" >
    <a href="javascript:;" class="actionsheet-item" onclick="friend({$data.uid},this)">{if M("Friend")->get_state(NOW_UID,$data['uid'])}取消关注{else}加关注{/if}</a>
    <a href="javascript:;" class="actionsheet-item" onclick="open_lt('{$data.user}','{$data.uid}','{#WWW}{$data.avatar.a}')" data-ydui-actionsheet="{target:'#liaotian',closeElement:'#cancel_liaotian'}">聊天</a>
    <a href="javascript:;" class="actionsheet-action" id="cancel">取消</a>
</div>
{/if}
<style>
    .user-gengduo a{
        justify-content: center;
    }
    .user > .m-navbar{
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }
    .m-bg {
        background:#fff !important;
    }
    .m-bg .navbar-item,
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before,
    .m-bg .navbar-center .navbar-title{
        color: #5C5C5C;
    }
    .navbar-item,
    .navbar-item .back-ico:before, 
    .navbar-item .next-ico:before,
    .navbar-center .navbar-title{
        color: #fff;
    }
    .user > .m-navbar:after {
        border-bottom: none;
    }
    .user > .navbar-item>i,
    .user > .navbar-item,
    .user > .navbar-center .navbar-title,
    .user > .navbar-item,
    .user > .navbar-center .navbar-title,
    .user > .navbar-item .icon-fanhui::before,
    .user > .navbar-item .next-ico::before {
        color: #fff;
    }
    
</style>
<script>
    $(function() {
        $(window).scroll(function() {
            //$(document).scrollTop() 获取垂直滚动的距离
            //$(document).scrollLeft() 这是获取水平滚动条的距离
            if ($(document).scrollTop() >= 200) {
                $('header').addClass('m-bg');
            }else{
                $('header').removeClass('m-bg');
                $('.icon-fanhui::before').css('color','');
            }
        });
    });
</script>
{include user_menu}

<div class="g-view">
    <!-- 菜单 -->
    <style type="text/css">

        .user_manun{
            position: relative;
            background: #fff;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            padding-top: 10px;
        }
        .user_manun .left{
            position: absolute;
            top: -30px;
            left: 15px;
        }
        .user_manun .right{
            margin-left: 106px;
        }
        .user_manun img{
            width: 80px;
            border-radius: 5px;
        }
        .user_manun h1{
            font-size: 18px;
            color: #444
        }
        .user_menu i{
            color:#fff;
        }
        .user_menu .grids-item{padding:10px;}
        .m-grids-5:before,
        .m-grids-5 .grids-item:not(:nth-child(5n)):before{
            border:none;
        }
        .user_tongji {
            top: 175px;
            background: #fff;
            padding: 5px 20px;
            width: 100%;
            box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
        }
    .user_tongji li {
        text-align: center;
        list-style: none;
        width: 33.333333%;
        float: left;
        position: relative;
        z-index: 0;
        padding: 10px 0;
        font-size: 18px;
        color:#4CAF50;
        font-weight: bold;
    }
    .user_tongji li span{
        font-size: 12px;
        color: #444;
        font-weight:200
    }
    .user_tongji_bg::after{
        content: '';
        display: block;
        clear: both;
    }
    </style>
    <div class="user_menu">
        <div class="user_manun">
            <div class="left">
                <img src="{#WWW}{$data.avatar.a}" alt="">
            </div>
            <div class="right">
                <h1>
                    <?php
                    $renzheng_inc = get_plugin_inc('nd_website_plus');
                    ?>
                        <?php
                        // 查询验证
                        $is_renzheng = S('user')->find('renzheng',['uid'=>$data['uid']]);
                        ?>
                    <span class="user_name" style="{if is_vip($data['uid'])||$is_renzheng}color:{$renzheng_inc.color};{/if}text-transform: capitalize">
                        {$data.user}
                        {if $is_renzheng}
                        <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                        {/if}
                    </span>
                    <?php 
                        $usertagid = S('user')->find('tagid',['uid'=>$data['uid']]);
                        $usertag = S('user_tag')->find('*',['tag_id'=>array_filter(explode(",",$usertagid))]);
                    ?>
                    <span style="{if $usertag['color']}color:{$usertag.color}{/if}">
                        {$usertag.name}
                    </span>
                </h1>
                <div style="margin-left: -3px;margin-bottom: 5px;margin-top: 5px;">
                    <?php
                        $inc = get_plugin_inc('nd_website_plus');
                        $lv = array_filter(explode("\r\n",$inc['user_lv']));
                        $lv_limit = count($lv);
                        $credits = S('User')->find('credits',['uid'=>$data['uid']]);
                    ?>
                    <span class="lv no" style="background: #3cbbf4;">ID:{$data.uid}</span>
                    <!-- 性别 -->
                    {php $sex = S('user')->find('sex',['uid'=>$data['uid']])}
                    {if $sex == 0}
                    <!-- 没设置 -->
                    <span class="lv no">
                        <i class="iconfont icon-xingbie">{php $age =  date('Y')-date('Y',$data['age'])}{if $age!=0}{$age}{/if}</i>
                    </span>
                    {elseif $sex == 1}
                    <!-- 男 -->
                    <span class="lv nan">
                        <i class="iconfont icon-nan1">{php $age =  date('Y')-date('Y',$data['age'])}{if $age!=0}{$age}{/if}</i>
                    </span>
                    {else}
                    <!-- 女 -->
                    <span class="lv nv">
                        <i class="iconfont icon-nv1">{php $age =  date('Y')-date('Y',$data['age'])}{if $age!=0}{$age}{/if}</i>
                    </span>
                    {/if}

                    <!-- 等级 -->
                    {foreach $lv as $key => $lv}
                    {php $user_lv = explode("|",$lv);}
                        {if $credits < $user_lv['0']}
                        <span class="lv" style="color: {$user_lv.1};background: {$user_lv.2};box-shadow: 0 1px 10px -2px {$user_lv.2};">Lv.{$key+1}</span>
                        {php break;}
                        {/if}
                        {if $key+1 == $lv_limit && $credits > $user_lv['0']}
                        <span class="lv max">Lv.Max</span>
                        {php break;}
                        {/if}
                    {/foreach}
                    <!-- 用户组 -->
                    <?php
                        $gid =  S('User')->find('gid',['uid'=>$data['uid']]);
                        $gname = M("Usergroup")->gid_to_name($gid);
                        $style = array_filter(explode("\r\n",$inc['style']));
                    ?>
                    {foreach $style as $style}
                    {php $sty = explode("|",$style);}
                    {if $sty['0'] == $gid}
                    <span class="lv group" style="color:{$sty.1};background:{$sty.2};box-shadow: 0 1px 10px -2px {$sty.2};">{$gname}</span>
                    {/if}
                    {/foreach}
                </div>
                <div>
                    <span style="font-size: 14px;">{$data.ps}</span>
                </div>
            </div>
        </div>
        <div class="user_tongji">
            <div class="user_tongji_bg">
                <li>
                        <a href="javascript:;">{$data.follow} <span>关注</span></a>
                </li>
                <li>
                        <a href="javascript:;">{$data.fans} <span>粉丝</span></a>
                </li>
                <li>
                        <a href="javascript:;" >{$data.gold} <span>金币</span></a>
                </li>
            </div>
        </div>
    </div>
    <!-- 基本信息 -->
    <div class="user_zil">
        <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$data['user'],'thread')}" data-pjax>{if $data['uid'] == NOW_UID}我{else}他{/if}的帖子</a></div>
                <div class="cell-right cell-arrow"><a href="{#HYBBS_URL('my',$data['user'],'thread')}" data-pjax>{$data.threads}</a></div>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$data['user'],'thread')}" data-pjax>{if $data['uid'] == NOW_UID}我{else}他{/if}的帖子</a></div>
                <div class="cell-right cell-arrow"><a href="{#HYBBS_URL('my',$data['user'],'thread')}" data-pjax>{$data.threads}</a></div>
            </div>
            <div class="cell-item">
                <?php
                    $collection = S('plugins_collection')->count(['uid'=>$data['uid']]);
                ?>
                <div class="cell-left"><a href="{#HYBBS_URL('my',$data['user'],'collection')}" data-pjax>{if $data['uid'] == NOW_UID}我{else}他{/if}的收藏</a></div>
                <div class="cell-right cell-arrow"><a href="{#HYBBS_URL('my',$data['user'],'collection')}" data-pjax>{$collection}</a></div>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$data['user'],'post')}" data-pjax>{if $data['uid'] == NOW_UID}我{else}他{/if}的回帖</a></div>
                <div class="cell-right cell-arrow"><a href="{#HYBBS_URL('my',$data['user'],'post')}" data-pjax>{$data.posts}</a></div>
            </div>
        </div>
    </div>
    <div class="nd_crde" style="text-align:center"><h4>个人资料</h4></div>
    <div class="user_zil">
        <div style="margin: 10px;padding: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);font-size:14px;background:#fff;color:#626161">
            <div>签名<span style="margin-left:5px;color:#333">{if $data['ps']}{$data.ps}{else}这家伙很懒什么也没留下{/if}</span></div>
            <div>城市<span style="margin-left:5px;color:#333">{if $data['city']}{$data.city}{else}未知{/if}</span></div>
            <div>年龄<span style="margin-left:5px;color:#333">{php $age =  date('Y')-date('Y',$data['age'])}{if $age!=0}{$age}{/if}</span></div>
            <div>标签<span style="margin-left:5px;color:#333">
            <?php
                $xuanze = S('user_tag')->select('*',[
                    'tag_id'    => array_filter(explode(",",$data['tagid'])),
                    'ORDER'     => ['tag_id'=>array_filter(explode(",",$data['tagid']))]
                ]);
                ?>
                {foreach $xuanze as $k=>$v}
                <em class="shanchu" style="color:{$v.color}">{$v.name}</em>
                {/foreach}
            </span></div>
        </div>
    </div>
    <!-- 回复 -->
    {if $post_data}
        <div class="nd_crde" style="text-align:center"><h4>最近回复</h4></div>
        <section id="scrollView" class="yd-scrollview">
            <div class="yd-timeline demo-small-pitch" style="margin: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                <ul class="yd-timeline-content">
                    {foreach $post_data as $v}
                    {php $title = S('Thread')->find('title',['tid'=>$v['tid']]);}
                    <li class="yd-timeline-item">
                        <!-- <em class="yd-timeline-icon"></em> -->
                        <img src="{#WWW}{$data.avatar.a}" style="{if is_vip($data['uid'])}border:2px solid #FF5722;{/if}width:35px;height:35px;"  class="thread_user_pic">
                        <p style="margin-top: 10px;">{#humandate($v['atime'])}在 <a href="{#HYBBS_URL('thread',$v['tid'])}" style="color: #0d6fbd;font-size: 14px;">{$title}</a> 回复</p>
                        <p style="font-size: 12px;"></p>
                        <p style="margin-top: 10px;padding: 8px 5px;background: #f7f7f7;border-radius: 5px;">{$v.content}</p>
                        <div style="margin-top: 10px;font-size: 14px;text-align: right;">
                            <span style="margin-right: 10px;" onclick="tp('post1','{$v.pid}',this)">
                                <i class="icon-yduihao"></i> <span>{$v.goods}</span>
                            </span>
                            <span>
                                <i class="icon-huifu1"></i> {$v.posts}
                            </span>
                        </div>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </section>
    {/if}
    {if $post_data == '' && $post_data ==''}
        <div class="no_thread">
            <i class="icon-meiyougengduo"></i>
            <p>TA还没有动态哦...</p>
        </div>
    {/if}
</div>

{include common/footer} {include common/foot}