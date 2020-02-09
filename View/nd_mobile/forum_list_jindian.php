<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

<div class="nd_list_1">
        <div class="list_header">
            {php $sex = S('user')->find('sex',['uid'=>$v['uid']])}
            <a href="{#HYBBS_URL('my',$v['user'])}" style="position: relative;" data-pjax>
                {if is_vip($v['uid'])}<i style="position: absolute;left: -4px;font-size: 30px;top: -8px;color: #FF5722;transform: rotate(278deg);" class="iconfont icon-huangguan2"></i>{/if}
                <img style="{if is_vip($v['uid'])}border:2px solid #FF5722;{/if}width:45px;height:45px;" src="{#WWW}{$v.avatar.b}" alt="{$v.user}">
            </a>
                <div class="title">
                    <div>
                        <div class="jcenter">
                            <a href="{#HYBBS_URL('my',$v['user'])}" data-pjax> 
                                <?php
                                    $renzheng_inc = get_plugin_inc('nd_website_plus');
                                ?>
                                <?php
                                // 查询验证
                                $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                                ?>
                                <span class="user_name" style="{if is_vip($v['uid']) || $is_renzheng}color:{$renzheng_inc.color}{/if}">
                                    {$v.user}
                                    {if $is_renzheng}
                                    <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                                    {/if}
                                </span>
                                <?php 
                                    $usertagid = S('user')->find('tagid',['uid'=>$v['uid']]);
                                    $usertag = S('user_tag')->find('*',['tag_id'=>array_filter(explode(",",$usertagid))]);
                                ?>
                                <span style="{if $usertag['color']}color:{$usertag.color}{/if}">
                                    {$usertag.name}
                                </span>
                            </a>
                        </div>                        
                        <p style="margin-left:-3px;">
                            <?php
                                $inc = get_plugin_inc('nd_website_plus');
                                $lv = array_filter(explode("\r\n",$inc['user_lv']));
                                $lv_limit = count($lv);
                                $credits = S('User')->find('credits',['uid'=>$v['uid']]);
                            ?>
                            <span class="lv no" style="background: #3cbbf4;">ID:{$v.uid}</span>
                            <!-- 性别 -->
                            {if $sex == 0}
                            <!-- 没设置 -->
                            <span class="lv no">
                                <i class="iconfont icon-xingbie">{php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
                            </span>
                            {elseif $sex == 1}
                            <!-- 男 -->
                            <span class="lv nan">
                                <i class="iconfont icon-nan1">{php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
                            </span>
                            {else}
                            <!-- 女 -->
                            <span class="lv nv">
                                <i class="iconfont icon-nv1">{php $user_data = M('User')->read($v['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
                            </span>
                            {/if}
                            <!-- 等级 -->
                            {foreach $lv as $key => $lv}
                            {php $user_lv = explode("|",$lv);}
                                {if $credits < $user_lv['0']}
                                <span class="lv" style="color: {$user_lv.1};background: {$user_lv.2};border-radius: 4px;font-size: 12px;padding: 2px 4px;box-shadow: 0 1px 10px -2px {$user_lv.2};">Lv.{$key+1}</span>
                                {php break;}
                                {/if}
                                {if $key+1 == $lv_limit && $credits > $user_lv['0']}
                                <span class="lv max">Lv.Max</span>
                                {php break;}
                                {/if}
                            {/foreach}
                            <!-- 用户组 -->
                            <?php
                                $gid =  S('User')->find('gid',['uid'=>$v['uid']]);
                                $gname = M("Usergroup")->gid_to_name($gid);
                                
                                $style = array_filter(explode("\r\n",$inc['style']));
                            ?>
                            {foreach $style as $style}
                            {php $sty = explode("|",$style);}
                            {if $sty['0'] == $gid}
                            <span class="lv group" style="color:{$sty.1};background:{$sty.2};box-shadow: 0 1px 10px -2px {$sty.2};">{$gname}</span>
                            {/if}
                            {/foreach}    
                        {php //echo humandate($v['atime']);}</p>
                    </div>
                    {if NOW_UID != $v['uid']}
                    <a href="javascript:;" onclick="friend(1,this)" class="btn_gz jcenter">{if M("Friend")->get_state(NOW_UID,$v['uid'])}取消关注{else}<i class="icon-plus"></i>关注{/if}</a>
                    {/if}
                </div>
            </div>
            <div class="list_content" style="position: relative;">
                {hook nd_m_list_jd_1}
                {if $v['jing'] == 1}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/001.gif" alt="">
                {/if}
                {if $v['jing'] == 2}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/002.gif" alt="">
                {/if}
                {if $v['jing'] == 3}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/003.gif" alt="">
                {/if}
                {if $v['jing'] == 4}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/004.gif" alt="">
                {/if}
                {if $v['jing'] == 5}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/006.gif" alt="">
                {/if}
                {if $v['jing'] == 6}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/007.gif" alt="">
                {/if}
                {if $v['jing'] == 7}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/009.gif" alt="">
                {/if}
                {if $v['jing'] == 8}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/banzhurenzhen.png" alt="">
                {/if}
                {if $v['jing'] == 9}
                    <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/008.gif" alt="">
                {/if}
                <div class="content_img_list">
                    {if !empty($v['img'])}
                        {php $img = array_filter(explode(',',$v['img']));}
                        
                        <div class="thread_content" style="box-shadow: none;">
                        {hook nd_forumlist_thread_img_title_top}
                        <a class="forum_name" href="{#HYBBS_URL('forum',$v['fid'])}" data-pjax style="color:{$forum[$v['fid']]['color']};"><span>#{$forum[$v['fid']]['name']}#</span></a> 
                        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                            <span>{$v.title}</span>
                        </a>
                        {hook nd_thread_list_20}
                        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                            <div class="summary">{$v.summary}</div>
                        </a>
                        </div>
                        <div class="m-grids-3">
                            {foreach $img as $keys=>$vals}
                            <div href="#" class="grids-item">
                                <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                                    <img class="lazyload" src="{#WWW}View/nd_mobile/img/load_q.svg" data-original="{$vals}" alt="{$v.title}-{$keys+1}" >
                                </a>
                            </div>
                            {if $keys == 5}
                            {php break;}
                            {/if}
                            {/foreach}
                        </div>
                    {else}
                    <div class="m-grids-1">
                        <div class="thread_content" style="box-shadow: none;">
                        {hook nd_forumlist_thread_title_top}
                        <a class="forum_name" href="{#HYBBS_URL('forum',$v['fid'])}" data-pjax style="color:{$forum[$v['fid']]['color']};"><span>#{$forum[$v['fid']]['name']}#</span></a> 
                        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                            <span>{$v.title}</span>
                        </a>
                        {hook nd_thread_list_20}
                        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                            <div class="summary">{$v.summary}</div>
                        </a>
                        </div>
                    </div>
                    {/if}
                </div>
            </div>
    <div class="list_footer">
        <div class="m-grids-3">
            <a href="{#HYBBS_URL('thread',$v['tid'])}#thread_post" data-pjax class="grids-item">
                <div class="grids-txt">
                    <span>
                        <i class="icon-huifu1"></i> {$v.posts}回复</span>
                </div>
            </a>
            <a href="javascript:;" class="grids-item">
                <div class="grids-txt">
                    <span>
                        <i class="iconfont icon-yduizuji"></i> {if $v['views']}{$v.views}{/if}人踩过</span>
                </div>
            </a>
            <a href="javascript:;" class="grids-item">
                <div class="grids-txt">
                    <span class="zan" onclick="tp('thread1',{$v['tid']},this)">
                        <i class="icon-zansel"></i> <p>{if $v['goods']}{$v.goods}{/if}</p><span>喜欢</span></span>
                </div>
            </a>
        </div>
    </div>
</div>
{if $k == rand(1,10)}
    {include forum_guanggao}
{/if}