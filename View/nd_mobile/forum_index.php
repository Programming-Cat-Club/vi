<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include forum_header}
<div class="g-view">
    {if empty($forum)}
    <div class="forum_nav"><span>未分组</span></div>
    {/if}
    <?php 
    $forum_group = M('Forum_group')->read_all_cache();
    ?>
    <!--{hook t_m_forum_index_1}-->
    <div class="forum_list">
        <div class="m-grids-4">
            {foreach $forum as $key => $v}
                <?php $has = false; ?>
                {foreach $forum_group as $vv}
                    
                    {if $v['fgid'] == $vv['id']}
                        <?php $has = true;break; ?>
                    {/if}
                    
                {/foreach}
                {if !$has}
                <?php $has_none = false; ?>
                <a href="{#HYBBS_URL('forum',$v['id'])}" data-pjax class="grids-item">
                    <div class="grids-txt">
                        <div class="list_img"><img src="{#WWW}upload/forum{$key}.png" onerror="this.src='{#WWW}upload/de.png'"></div>
                        <div class="list_title">{$v.name}</div>
                    </div>
                </a>
                {/if}
            {/foreach}
        </div>
    </div>
    <!--{hook t_m_forum_index_2}-->
    <!-- view_form('nd_mobile','forun_index_style') == '1' -->
    {if view_form('nd_mobile','forun_index_style') == '1'}
        {include forum_list_style_1}
    {elseif view_form('nd_mobile','forun_index_style') == '2'}
        {include forum_list_style_2}
    {elseif view_form('nd_mobile','forun_index_style') == '3'}
        {include forum_list_style_3}
    {/if}
    <!--{hook t_m_forum_index_5}-->
</div>
{include common/footer}
{include common/foot}