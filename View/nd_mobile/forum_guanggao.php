<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{php $gg = array_filter(explode(",",view_form('nd_mobile','guanggao_forum')))}
{if view_form('nd_mobile','guanggao_forum_no')}
<div class="tuijianz">
    <a href="{$gg.0}">
        <span>广告</span>
        <img src="{$gg.2}" alt="{$gg.1}">
    </a>
</div>
{/if}