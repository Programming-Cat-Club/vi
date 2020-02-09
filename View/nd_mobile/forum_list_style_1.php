<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{foreach $forum_group as $v}
    <div class="forum_nav"><span>{$v.name}</span></div>
    <div class="forum_list">
        <div class="m-grids-4">
            {foreach $forum as $key => $vv}
            {if $vv['fgid'] == $v['id']}
            <a href="{#HYBBS_URL('forum',$vv['id'])}" data-pjax class="grids-item">
                <div class="grids-txt">
                    <div class="list_img"><img src="{#WWW}upload/forum{$key}.png" onerror="this.src='{#WWW}upload/de.png'"></div>
                    <div class="list_title">{$vv.name}</div>
                </div>
            </a>
            {/if}
            {/foreach}
        </div>
    </div>
{/foreach}