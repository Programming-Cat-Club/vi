<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include common/header}
<div class="g-view">
    <div class="m-cell plugins" style="margin-top: 15px;">
        {foreach $data as $v}
        <div class="cell-item">
            <div class="cell-left"><a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>{$v.title}</a></div>
            <div class="cell-right"><a href="javascript:;" class="btn btn-danger" onclick="close_jing({$v.tid},this)">取消</a></div>
        </div>
        {/foreach}
        {if empty($data)}
        <div class="no_thread">
                <i class="icon-nuandou"></i>
                <p>没有任何举报内容...</p>
            </div>
        {/if}
    </div>
</div>
{include common/foot}