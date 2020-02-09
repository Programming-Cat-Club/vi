<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include coterie_header}
<div class="g-view">
    {if IS_LOGIN}
        {if $friend}
            <div style="padding: 10px 10px 0;margin-bottom: -10px; display: flex;overflow-y: scroll;">
                <style>
                .user_img{
                    border-radius: 50%;
                    width: 40px;
                    border: 2px solid #fff;
                    margin-right: 10px;
                    -webkit-box-shadow: 0 2px 10px -3px rgba(23, 23, 23, 0.1803921568627451);
                    box-shadow: 0 2px 10px -3px rgba(23, 23, 23, 0.1803921568627451);
                    margin-bottom: 10px;
                }
                </style>
                {foreach $follow as $v}
                <a href="{#HYBBS_URL('my',$v['user'])}" data-pjax>
                    <img src="{#WWW}{$v.avatar.b}" alt="" class="user_img">
                </a>
                {/foreach}
                
            </div>
            {foreach $data as $k => $v}
            {include forum_list_quanzi}
            {/foreach}
            {if empty($data)}
            <div class="no_thread">
                <i class="icon-nuandou"></i>
                <p>朋友还没有动态哦...</p>
            </div>
            {/if}
        {else}
            <div class="no_thread">
                <i class="icon-meiyouguanzhu"></i>
                <p>还没关注别人哦！</p>
            </div>
        {/if}
    {else}
        <div class="no_thread">
            <i class="icon-nuandou"></i>
            <p>请登陆后在访问此页</p>
        </div>
    {/if}
</div>
{include common/footer}
{include common/foot}