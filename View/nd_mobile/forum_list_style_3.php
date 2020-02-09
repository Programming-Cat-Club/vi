<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="m-scrolltab" id="J_ScrollTab">
    <div class="scrolltab-nav">
    {if IS_LOGIN}
    <a href="javascript:;" class="scrolltab-item {if IS_LOGIN}crt{/if}" onclick="get_form('my',this)">
        <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
        <div class="scrolltab-title">我的关注</div>
    </a>
    {/if}
    {foreach $forum_group as $k => $v}
        <a href="javascript:;" class="scrolltab-item {if !IS_LOGIN}{if $k == 0 }crt{/if}{/if}" onclick="get_form({$v.id},this)">
            <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
            <div class="scrolltab-title">{$v.name}</div>
        </a>
    {/foreach}
    </div>
    <div class="scrolltab-content">
        <div class="form_list">
            {if IS_LOGIN}
                <div class="scrolltab-content-item">
                    <ul class="style_list3">
                    <?php 
                        $myforum = S('plugins_myforum')->select([
                            "[>]forum" => array("fid" => "id"),
                        ],[
                            'forum.id',
                            'forum.name',
                            'forum.html'
                        ],[
                            'plugins_myforum.uid'=>NOW_UID,
                            'ORDER'=>['plugins_myforum.atime'=>'DESC']
                        ]);
                    ?>
                    {foreach $myforum as $key => $vv}
                        <li class="form_info">
                            <div>
                                <img src="{#WWW}upload/forum{$vv.id}.png" onerror="this.src='{#WWW}upload/de.png'">
                            </div>
                            <div class="form_right">
                                <a href="{#HYBBS_URL('forum',$vv['id'])}" data-pjax>
                                    <div class="form_name">{$vv.name}</div>
                                    <div class="form_html">{if $vv['html']}{$vv.html}{else}赶紧写个描述{/if}</div>
                                </a>
                            </div>
                            <div class="form_guanzhu">
                                <a href="javascript:;" onclick="follow_forum('{$vv.id}','q',this,true)">取消</a>
                            </div>
                        </li>
                    {/foreach}
                    
                    </ul>
                </div>
                <div class="no_thread" id="no_follow" style="display:{if $myforum}none{else}block{/if}">
                    <div class="">
                        <i class="icon-nuandou"></i>
                    </div>
                    <p>还没有关注的板块哦</p>
                </div>
            {else}
                {foreach $forum_group as $k => $v}
                    {if $k == 0}
                    <div class="scrolltab-content-item">
                        <ul class="style_list3">
                        {foreach $forum as $key => $vv}
                            {if $vv['fgid'] == $v['id']}
                            <li class="form_info">
                                <div>
                                    <img src="{#WWW}upload/forum{$vv.id}.png" onerror="this.src='{#WWW}upload/de.png'">
                                </div>
                                <div class="form_right">
                                    <a href="{#HYBBS_URL('forum',$vv['id'])}" data-pjax>
                                        <div class="form_name">{$vv.name}</div>
                                        <div class="form_html">{if $vv['html']}{$vv.html}{else}赶紧写个描述{/if}</div>
                                    </a>
                                </div>
                                <div class="form_guanzhu">
                                    <a href="javascript:;" onclick="follow_forum('{$v.id}','g',this)">关注</a>
                                </div>
                            </li>
                            {/if}
                        {/foreach}
                        </ul>
                    </div>
                    {/if}
                {/foreach}
            {/if}
        </div>
        <div class="no_thread" style="display:none">
            <div class="loading">
                <i class="icon-loading"></i>
            </div>
            <p>加载中...</p>
        </div>
        <div class="no_thread" id="form_msg" style="display:none;"></div>
    </div>
</div>
