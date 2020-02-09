<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<footer class="m-tabbar tabbar-fixed">
    <a href="{#WWW}" data-pjax class="tabbar-item {if ACTION_NAME == 'Index' || ACTION_NAME == '_pjax=%23pjax'}tabbar-active{/if}">
        <span class="tabbar-icon">
            <i class="icon-jia1"></i>
        </span>
        <span class="tabbar-txt">首页</span>
    </a>
    <a href="{#HYBBS_URL('forum')}" data-pjax class="tabbar-item {if ACTION_NAME == 'Forum' || ACTION_NAME == 'Thread'}tabbar-active{/if}">
        <span class="tabbar-icon">
            <i class="icon-shejiaoxinxi2"></i>
        </span>
        <span class="tabbar-txt">社区</span>
    </a>
    <a href="javascript:;" class="tabbar-item" data-ydui-actionsheet="{target:'#candan',closeElement:'.guanbi_caidan'}">
        <span class="tabbar-icon" style="padding: 10px;color: #fff;height: 40px;width: 45px;border-radius: 3px;background-image: linear-gradient(65deg, rgba(3, 169, 244, 0.75) 20%,rgba(3, 169, 244, 0.8) 80%);box-shadow: 0 5px 19px -7px #03A9F4;">
            <i class="icon-caozuoqipao"></i>
            <span id="mess_d"></span>
        </span>
        <!-- <span class="tabbar-txt">操作</span> -->
    </a>
    <a href="{#HYBBS_URL('Coterie')}" data-pjax class="tabbar-item {if ACTION_NAME == 'Coterie'}tabbar-active{/if}">
        <span class="tabbar-icon">
            <i class="icon-quanzi3"></i>
        </span>
        <span class="tabbar-txt">圈子</span>
    </a>
    <a href="{if IS_LOGIN}{#HYBBS_URL('my',$user['user'],'my')}{else}{#HYBBS_URL('user','login')}{/if}" data-pjax class="tabbar-item {if ACTION_NAME == 'My'}tabbar-active{/if}">
        <span class="tabbar-icon">
            <i class="icon-shouye"></i>
        </span>
        <span class="tabbar-txt">个人中心</span>
    </a>
</footer>
<div class="nd_menu m-actionsheet" id="candan">
    <div class="nd_mend_content">
        <div class="nd_mened_user">
            <img src="{if !IS_LOGIN}{#WWW}View/nd_mobile/img/no_login.png{else}{#WWW}{$user.avatar.b}{/if}" alt="">
            <div class="name">{if IS_LOGIN} 
                <?php
                $renzheng_inc = get_plugin_inc('nd_website_plus');
                ?>
                <span style="{if is_vip($user['uid'])||$user['renzheng'] == 1}color:{$renzheng_inc.color}{/if}"> 
                    {$user.user}
                </span> 
                <i class="iconfont {if $user['sex'] == 0}icon-xingbie2 sex-no{elseif $user['sex'] == 1}icon-nan sex-nan{else}icon-nv sex-nv{/if}"></i> {php echo M("Usergroup")->gid_to_name($user['gid'])} <em><i class="icon-jinbi">{$user.gold}</i></em>{else}<span style="font-size:14px;color: #b1b1b1;">以下操作需要登录后可用</span>{/if} </div>
            <!-- <div class="right"><i class="icon-jinbi">105</i></div> -->
        </div>
        <div class="m-grids-4">
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'collection')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-star-outline"></i>
                    <p>收藏</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'file')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-wj"></i>
                    <p>文件</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'thread')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-wenzhang"></i>
                    <p>帖子</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'post')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-huifu1"></i>
                    <p>回复</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'pay')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-chongzhi"></i>
                    <p>充值</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('plugins','sign')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                    <i class="icon-qiandao3"></i>
                    <p>签到</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('plugins','task')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-renwu"></i>
                    <p>任务</p>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}{#HYBBS_URL('my',$user['user'],'op')}{/if}" data-pjax data-pjax-close class="grids-item">
                <div class="grids-txt">
                        <i class="icon-yduishezhi"></i>
                    <p>设置</p>
                </div>
            </a>
        </div>
        <div class="m-grids-3">
            <a href="javascript:history.back(-1);" class="grids-item guanbi_caidan">
                <div class="grids-txt" style="text-align: left;padding-left: 23%;">
                    <i class="icon-iconfontfanhui"></i>
                </div>
            </a>
            <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}javascript:;{/if}" class="grids-item guanbi_caidan" {if IS_LOGIN}data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{#HYBBS_URL('post')}','post')"{else}data-pjax{/if}>
                <div class="grids-txt">
                        <i class="icon-plus"></i>
                </div>
            </a>
            <a href="{if IS_LOGIN}javascript:;{else}{#HYBBS_URL('user','login')}{/if}" class="grids-item guanbi_caidan" {if IS_LOGIN}data-ydui-actionsheet="{target:'#actionSheet',closeElement:'#cancel'}" onclick="tog_friend_box()"{else}data-pjax{/if}>
                <div class="grids-txt" style="text-align: right;padding-right: 23%;">
                        <i class="icon-xiaoxi3"></i>
                        <span id="message"></span> 
                </div>
            </a>
        </div>
    </div>
</div>


