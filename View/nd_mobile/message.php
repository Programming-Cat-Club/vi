<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<div class="g-view">
    <!--ajax-edit start-->
    <!--ajax-post start-->
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">提示</span>
        </div>
    </header>
    <div class="user_thread">
        <div class="no_thread">
            {if $bool}
            <i class="icon-wancheng" style="color:#04be02;font-size: 4rem;"></i>
            {else}
            <i class="icon-warn1" style="color:#EF4F4F;font-size: 4rem;"></i>
            {/if}
            <p style="color: {if $bool}#04be02{else}#EF4F4F{/if};font-weight: bold;font-size: 16px;opacity: 0.8;">{$msg}!</p>
            <div style="margin-top:20px;">
                <a href="javascript:history.back(-1);" class="btn" style="background-color: #777;color:#fff">退回去</a>               
                <a href="{#WWW}" data-pjax class="btn" style="margin-left:10px;background:rgba(3, 169, 244, 0.78);color:#fff">去首页</a>
            </div>
        </div>
    </div>
    <!--ajax-edit end-->
    <!--ajax-post end-->
</div>
{include common/foot}
