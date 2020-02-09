<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{php $nd_inc = get_plugin_inc('nd_website_plus');}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">{$title}</span>
    </div>
</header>
<style>
    .m-navbar{
        background: #444;
    }
    .m-navbar .navbar-item,
    .m-navbar .navbar-title
    {
        color: #fff
    }
    .vip-header{height: 200px;}
    .vip-header .vip{
        position: relative;
    }
    .vip-header .vip .vip-card{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 165px;
        border-radius: 14px;
        margin: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        background: linear-gradient(75deg, #ffd358 10%,#ffd60e 57%,#ffd84b 88%);
        overflow: hidden;
    }
    .vip-header .vip .vip-card .user{
        display: flex;
        /* justify-content: center; */
        align-items: center;
        padding: 15px;
    }
    .vip-header .vip .vip-card .user>div{
        margin-left: 12px;
    }
    .vip-header .vip .vip-card .user img{
        width: 50px;
        height: 50px;
        border-radius: 100%;
    }
    .vip-header .vip .vip-card .user>div h1{
        font-size: 18px;
        color: #fff;
    }
    .vip-header .vip .vip-card .user>div p{
        color: #fff;
    }
    .vip-header .vip .vip-card .huangguan i{
        font-size: 80px;
        position: absolute;
        bottom: -17px;
        left: -11px;
        color: rgba(255, 255, 255, 0.3);
    }
    .vip-header .vip .vip-card .vip-icon i{
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 60px;
        color: rgba(247, 185, 0, 0.6);
    }
    .vip-header .vip .vip-card .vip-btn a{
        position: absolute;
        bottom: 15px;
        right: 15px;
        border-radius: 15px;
        background: linear-gradient(75deg, #FFB300 10%,#FF9800 57%);
        color: #fff;
        padding: 6px 15px;
        border: 0;
    }
    .vip-header .vip .cir{
        height: 120px;
        border-radius: 0 0 100px 100px;
        background: linear-gradient(16deg, rgba(68, 68, 68, 0.85) 0%,#444 55%);
        margin: 0 -50px;
    }
    .vip-content{
        padding: 0 15px 15px;
    }
    .vip-content .title{
        font-size: 16px;
    }
    .vip-content .content{
        background: #fff;
        box-shadow: 0 1px 10px -5px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 15px;
        margin-top: 10px;
    }
    .vip-content .content .imit{
        margin-bottom: -10px
    }
    .vip-content .content .imit:after{
        content: '';
        clear: both;
        display: block;
    }
    .vip-content .content .imit li{
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        width: 50%;
        float: left;
    }
    .vip-content .content .imit .imit-icon{
        background: linear-gradient(110deg, #ffd358 10%,#ffb74c 57%,#ffa520 88%);
        color: #fff;
        width: 40px;
        height: 40px;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 10px;
    }
    .vip-content .content .imit .imit-title p{
        color: #757575
    }
    .vip-on{
        position: fixed;
        bottom: 15px;
        left: 0;
        right: 0;
        background: linear-gradient(110deg, #ffd358 10%,#ffb74c 57%,#ffa520 88%);
        color: #fff;
        border-radius: 20px;
        padding: 8px 0;
        margin: 0 20px;
        font-weight: 700;
        font-size: 16px;
    }
</style>
<div class="g-view">
    <div class="vip-header">
        <div class="vip">
            <div style="overflow: hidden;"><div class="cir"></div></div>
            
            <div class="vip-card">
                <div class="user">
                    <img src="{#WWW}{$data.avatar.b}" alt="">
                    <div>
                        <h1>{$data.user}</h1>
                        <p>
                        {if !empty($vip_data)}
                            {if $vip_data['atime'] < NOW_TIME}
                                已过期: {$vip_data['str_atime']}
                            {else}
                                到期时间: {#date('Y-m-d',$vip_data['atime'])}
                            {/if}
                        {else}
                            未开通
                        {/if}
                        </p>
                    </div>
                </div>
                <div class="huangguan">
                    <i class="iconfont icon-huangguan3"></i>
                </div>
                <div class="vip-icon">
                    <i class="iconfont icon-VIP1"></i>
                </div>
                <div class="vip-btn">
                    <a  href="{#HYBBS_URL('my',$data['user'],'vip-pay')}" data-pjax>{if $vip_data}立即续费{else}立即开通{/if}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="vip-content">
        <h5 class="title">会员特权</h5>
        <div class="content">
            <ul class="imit">
                {$nd_inc['vip_tequan']}
            </ul>
        </div>
    </div>
</div>
<a href="{#HYBBS_URL('my',$data['user'],'vip-pay')}" data-pjax class="tabbar-item vip-on">{if $vip_data}立即续费{else}立即开通{/if}</a>
{include common/foot}