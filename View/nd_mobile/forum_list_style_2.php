<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div style="margin-top:50px;"></div>
{include forum_banner}
<div class="m-grids-3" style="box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
    <a href="#" class="grids-item">
        <div class="grids-txt"><span>今日发帖</span><p>{$hy_count.day_thread}</p></div>
    </a>
    <a href="#" class="grids-item">
        <div class="grids-txt"><span>总发帖</span><p>{$hy_count.thread}</p></div>
    </a>
    <a href="#" class="grids-item">
        <div class="grids-txt"><span>会员数</span><p>{$hy_count.user}</p></div>
    </a>
</div>
<style>
.grids-item:after{
    border-bottom: 1px solid #D9D9D9;
}
</style>
{foreach $forum_group as $v}
<div>
    <div class="forum_nav"><span>{$v.name}</span></div>
    <div class="m-grids-2">
        {foreach $forum as $key => $vv}
        {if $vv['fgid'] == $v['id'] && $vv['fid'] == '-1'}
            <a href="{#HYBBS_URL('forum',$vv['id'])}" data-pjax class="grids-item" style="display: flex;padding: 10px;align-items: center;">
                <img src="{#WWW}upload/forum{$vv.id}.png" onerror="this.src='{#WWW}upload/de.png'" style="width: 50px;height: 50px;margin-right: 6px;border-radius: 100%;">
                <div class="list_title">
                    <h1 style="color:{$vv.color}">{$vv.name}</h1>
                    <div style="color:#5c5c5c">
                        <span>帖子:{$vv.threads}</span>
                    </div>
                </div>
            </a>
        {/if}
        {/foreach}
    </div>
</div>

{/foreach}