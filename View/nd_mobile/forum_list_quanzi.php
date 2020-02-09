<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<?php
$renzheng_inc = get_plugin_inc('nd_website_plus');
?>
<div class="nd_list_1">
    <div class="list_header" data-pjax>
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
                        // 查询验证
                        $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                        ?>
                    <span class="user_name" style="{if is_vip($v['uid'])||$is_renzheng}color:{$renzheng_inc.color}{/if}">
                        {$v.user}
                        {if $is_renzheng}
                        <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                        {/if}
                    </span>
                </a>
                <?php
                    $inc = get_plugin_inc('nd_website_plus');
                    $lv = array_filter(explode("\r\n",$inc['user_lv']));
                    $lv_limit = count($lv);
                    $credits = S('User')->find('credits',['uid'=>$v['uid']]);
                ?>
                
                </div>
                <p style="margin-left:-3px;">
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
                    <span class="lv" style="color: {$user_lv.1};background: {$user_lv.2};box-shadow: 0 1px 10px -2px {$user_lv.2};">Lv.{$key+1}</span>
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
                </p>
            </div>
            {if NOW_UID != $v['uid']}
                <a href="javascript:;" onclick="friend({$v['uid']},this)" class="btn_gz jcenter">{if M("Friend")->get_state(NOW_UID,$v['uid'])}取消关注{else}<i class="icon-plus"></i>关注{/if}</a>
            {/if}
        </div>
    </div>
    <div class="list_content" style="position: relative;">
        {hook nd_m_qz_list_1}
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
                {if count($img)}
                <div class="thread_content">
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
                         <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax><img src="{$vals}" alt="{$v.title}-{$keys+1}"></a>
                    </div>
                    {if $keys == 5}
                    {php break;}
                    {/if}
                    {/foreach}
                </div>
                {/if}
            {else}
            <div class="m-grids-1">
                <div class="thread_content">
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
        <div class="right">
            <span onclick="forum_vote(this,'{$v.tid}','{if IS_LOGIN}{$user.user}{/if}')">
                <i class="icon-yduihao"></i>
            </span>
            <span onclick="forum_post_edit({$v.tid})">
                <i class="icon-mn_xiaoxi2"></i>
            </span>
        </div>
        <?php
            // 获取点赞列表
            $vote = S('vote_thread')->select('*',['tid'=>$v['tid'],'LIMIT'=>20]);
            // 获取回帖列表
            $post = S('post')->select('*',['tid'=>$v['tid'],'ORDER'=>['atime'=>'DESC'],'LIMIT'=>5]);
            // 实例化用户模型
            $User = M('User');
        ?>
        
        <div class="goods" style="{if $v['goods']==0}display:none;{/if}">
            <i class="icon-yduihao"></i> <span id="vote_{$v.tid}">{$v.goods}</span>
            <span id="vote_user_{$v.tid}">{foreach $vote as $key => $val}<a href="{#HYBBS_URL('my',$User->uid_to_user($val['uid']))}" data-pjax>{php echo $User->uid_to_user($val['uid'])}</a>{if $key+1 < $v['goods']},{/if}{/foreach}</span>
        </div>
        
        <div class="post">
            <div style="position: relative;">
                <input id="input_{$v.tid}" type="text" name="post" placeholder="参与评论" style="margin-top: 10px;border-radius: 5px;font-size: 12px;line-height: 36px;">
                <button class="btn btn-primary" style="position: absolute;top: 10px;right: 0; background-color: #03a9f4;line-height: 37px;opacity: 0.8;" onclick="{if IS_LOGIN}forum_post(this,{$v.tid},'{$user.user}'){else}is_login(){/if}">评论</button>
            </div>
            <ul class="post_list" id="post_list_{$v.tid}">
                {foreach $post as $key => $val}
                {if $key == $v['posts']}{php break;}{/if}
                <li>
                    <a href="{#HYBBS_URL('my',$User->uid_to_user($val['uid']))}" data-pjax>
                        <span style="{if is_vip($val['uid'])}color:{$renzheng_inc.color}{/if}">{php echo $User->uid_to_user($val['uid'])}</span>
                        <?php
                        // 查询验证
                        $is_renzheng = S('user')->find('renzheng',['uid'=>$val['uid']]);
                        ?>
                        {if $is_renzheng}
                        <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                        {/if}
                    </a>: {#substr_cut(trim(strip_tags($val['content'])),40)}
                </li>
                {/foreach}
                {if $v['posts']}
                <li>
                    <a href="{#HYBBS_URL('thread',$v['tid'])}#thread_post" data-pjax>查看全部 <span id="posts_{$v.tid}">{$v.posts}</span> 条评论</a>
                </li>
                {/if}
            </ul>
        </div>
    </div>
</div>
{if $k == rand(1,10)}
    {include forum_guanggao}
{/if}
