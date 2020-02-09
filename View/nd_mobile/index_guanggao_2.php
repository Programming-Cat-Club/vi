<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{php $gg = array_filter(explode(",",view_form('nd_mobile','guanggao_index_2')))}
<div class="tuijianz" style="margin-left: 10px;margin-right: 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
    <a href="{$gg.0}">
        <span>广告</span>
        <img src="{$gg.2}" alt="{$gg.1}">
    </a>
</div>