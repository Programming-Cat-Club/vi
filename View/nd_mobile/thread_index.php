<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include thread_header}

{hook t_m_thread_index_1}
<div class="g-view container" style="height: auto;">
    <div class="lding"></div>
    <div class="thread_header">
        <h1>{$thread_data.title}</h1>
        <p>
            <a href="{#HYBBS_URL('forum',$thread_data['fid'])}" data-pjax>{$forum[$thread_data['fid']]['name']} {php echo humandate($thread_data['atime'])}</a>
            <span>评论{$thread_data.posts} 浏览{$thread_data.views}</span>
        </p>
    </div>
    {hook thread_user_top}
    <div class="thread_user">
        <a href="{#HYBBS_URL('my',$thread_data['user'])}" style="position: relative;" data-pjax>
            {if is_vip($thread_data['uid'])}<i style="position: absolute;left: -4px;font-size: 30px;top: -8px;color: #FF5722;transform: rotate(278deg);" class="iconfont icon-huangguan2"></i>{/if}
            <img style="{if is_vip($thread_data['uid'])}border:2px solid #FF5722;{/if}width:45px;height:45px;" src="{#WWW}{$thread_data.avatar.b}" alt="{$thread_data.user}">
        </a>
        <div class="user">
            <div>
                <div class="jcenter">
                    <?php
                        $inc = get_plugin_inc('nd_website_plus');
                        $lv = array_filter(explode("\r\n",$inc['user_lv']));
                        $lv_limit = count($lv);
                        $credits = S('User')->find('credits',['uid'=>$thread_data['uid']]);
                        $renzheng_inc = get_plugin_inc('nd_website_plus');
                    ?>
                    <?php
                        // 查询验证
                        $is_renzheng = S('user')->find('renzheng',['uid'=>$thread_data['uid']]);
                    ?>
                    <span class="user_name" style="{if is_vip($thread_data['uid']) || $is_renzheng}color:{$renzheng_inc.color}{/if}">
                        {$thread_data.user}
                        {if $is_renzheng}
                        <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                        {/if}
                    </span>
                    <?php 
                        $usertagid = S('user')->find('tagid',['uid'=>$thread_data['uid']]);
                        $usertag = S('user_tag')->find('*',['tag_id'=>array_filter(explode(",",$usertagid))]);
                    ?>
                    <span style="{if $usertag['color']}color:{$usertag.color}{/if}">
                        {$usertag.name}
                    </span>
                </div>
                <p style="margin-left:-3px;">
                <span class="lv no" style="background: #3cbbf4;">ID:{$thread_data.uid}</span>
                <!-- 性别 -->
                {php $sex = S('user')->find('sex',['uid'=>$thread_data['uid']])}
                    {if $sex == 0}
                    <!-- 没设置 -->
                    <span class="lv no">
                        <i class="iconfont icon-xingbie">{php $user_data = M('User')->read($thread_data['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
                    </span>
                    {elseif $sex == 1}
                    <!-- 男 -->
                    <span class="lv nan">
                        <i class="iconfont icon-nan1">{php $user_data = M('User')->read($thread_data['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
                    </span>
                    {else}
                    <!-- 女 -->
                    <span class="lv nv">
                        <i class="iconfont icon-nv1">{php $user_data = M('User')->read($thread_data['uid']);; $age =  date('Y')-date('Y',$user_data['age'])}{if $age!=0}{$age}{/if}</i>
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
                        $gid =  S('User')->find('gid',['uid'=>$thread_data['uid']]);
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
            {if NOW_UID != $thread_data['uid']}
            <a href="javascript:;" onclick="friend({$thread_data['uid']},this)" class="btn_gz jcenter">{if M("Friend")->get_state(NOW_UID,$thread_data['uid'])}取消关注{else}+关注{/if}</a>
            {/if}
        </div>
    </div>
    {hook thread_user_bottom}
    <article class="thread_content">
        {if $thread_data['state']}
        <div class="lock">
            帖子已锁定
            {if $thread_data['uid'] == NOW_UID || NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$thread_data['fid'])}
            <a href="javascript:;" onclick="set_state({$thread_data.tid},{$thread_data.state})" style="color:#41c1fb">解锁</a>
            {/if}
        </div>
        {/if}
        {hook thread_article_top}
        {if $thread_data['jing'] == 1}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/001.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 2}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/002.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 3}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/003.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 4}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/004.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 5}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/006.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 6}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/007.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 7}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/009.gif" alt="">
        {/if}
        {if $thread_data['jing'] == 8}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/banzhurenzhen.png" alt="">
        {/if}
        {if $thread_data['jing'] == 9}
            <img class="tuzhang" src="{#WWW}View/nd_mobile/img/stamp/008.gif" alt="">
        {/if}
        <!--{hook t_m_thread_content_top}-->
        {if $thread_data['show'] && $thread_data['gold_show']}
        {$post_data.content}
        {else}
        {if $thread_data['gold_show']}
        <blockquote class="shenhe">
        内容需要回复可见
        </blockquote>
        {else}
        <blockquote class="shenhe">
        {$_LANG['内容需要付费']} <a href="javascript:void(0);" style="color:#03a9f4" onclick="buy_thread({$thread_data['tid']},{$thread_data['gold']})">({$_LANG['点击购买']})</a> {$_LANG['售价']}：{$thread_data['gold']} {$_LANG['金币']}
        </blockquote>
        {/if}
        {/if}
        {if $thread_data['files']}
        <!--{hook t_m_thread_index_7}-->
        <div class="hy-box hy-bo-t" style="border: 1px solid #f5f5f5;margin-top: 10px;">
            <h2 class="hy-bo-b" style="padding: 0 10px;background: #f5f5f5;line-height: 35px;">{$_LANG['附件列表']}</h2>
            <!--{hook t_m_thread_index_8}-->
            {foreach $filelist as $v}
            <!--{hook t_m_thread_index_9}-->
            <div style="padding:10px;font-size:18px;border-top: 1px #f5f5f5 solid">
                {if $v['show']}
                    <p>
                        <a href="javascript:void(0);" onclick="hy_downfile({$v.fileid})">{$v.name}</a>
                    </p>
                {else}
                    <p>
                        <a href="javascript:void(0);"  style="color: #c31d1d;">{$_LANG['附件隐藏提示']}</a>
                    </p>
                {/if}
                <i style="color: grey;font-size: 14px;">{$_LANG['文件大小']}:{php echo round($v['size']/1024/1024,2);}M ({$_LANG['下载次数']}：{$v.downs})</i>
                {if $v['gold']}
                <span style="color: brown;font-size: 14px"> &nbsp;&nbsp;{$_LANG['售价']}:{$v.gold}</span>
                {/if}
              </div>
             <!--{hook t_m_thread_index_10}-->
             {/foreach}
             <!--{hook t_m_thread_index_11}-->
        </div>
        {/if}

        <!--{hook t_m_thread_content_bottom}-->
        <div class="text-center thread_content_foot">

            <a href="javascript:;"  class="btn btn-primary border-radius" onclick="tp('thread1','{$thread_data.tid}',this)"><div><i class="iconfont icon-dianzan"></i></div><p>{$thread_data.goods}</p></a>
            <a href="javascript:;"  class="btn btn-warning border-radius" onclick="tp('thread2','{$thread_data.tid}',this)"><div><i class="iconfont icon-zan11"></i></div><p>{$thread_data.nos}</p></a>
            <a href="javascript:;"  class="btn btn-danger border-radius" style="background:#4cd864" onclick="collection('{$thread_data.tid}',this)"><div><i class="iconfont icon-shoucang"></i></div><p>{php echo S('plugins_collection')->count(['tid'=>$thread_data['tid']]);}</p></a>
            <a href="javascript:;"  class="btn btn-fenxiang border-radius" id="shareBtn"  data-ydui-actionsheet="{target:'#fenxiang',closeElement:'#cancel'}"><div><i class="iconfont icon-fenxiang"></i></div><p>{php $share = S('plugins_share')->find('share',['tid'=>$thread_data['tid']]);}{if $share}{$share}{else}0{/if}</p></a>

        </div>
    </article>
    <div class="thread_footer">
        <div class="thread_forum" style="background: #fff;margin-top: 10px;">
            <div>
                <img src="{#WWW}upload/forum{$thread_data['fid']}.png" onerror="this.src='{#WWW}upload/de.png'">
            </div>
            <div class="title">
                <a href="{#HYBBS_URL('forum',$thread_data['fid'])}" data-pjax>
                    <h2>{$forum[$thread_data['fid']]['name']}</h2>
                    <p>
                        主题:{$forum[$thread_data['fid']]['threads']} 帖子:{$forum[$thread_data['fid']]['posts']}
                    </p>
                </a>
            </div>
            <div class="guanzu">
                {if S('plugins_myforum')->count(['fid'=>$thread_data['fid'],'uid'=>NOW_UID])}
                <a href="javascript:;" onclick="follow_forum({$thread_data.fid},'q',this)">取消</a>
                {else}
                <a href="javascript:;" onclick="follow_forum({$thread_data.fid},'g',this)">关注</a>
                {/if}
            </div>
        </div>
        
        </div>
        <!-- 楼主帖子 -->
        {include thread_user}
        {hook m_nd_mobile_thread_bottom}
        <!-- 广告 -->
        {include thread_guanggao}
    <div class="post_nav" id="thread_post">
        <div class="post_info">
            共有{$thread_data.posts}条评论
            <div class="post_sort">
                    <span class="{if X('get.order') == 'desc'}active{/if}"><a href="{php HYBBS_URL('thread',$thread_data['tid'])}?order=desc#thread_post">最新</a></span>
                    <span class="{if X('get.order') != 'desc'}active{/if}"><a href="{php HYBBS_URL('thread',$thread_data['tid'])}#thread_post">最早</a></span>
            </div>
        </div>
    </div>
    <div id="post_list">
        <!--ajax start-->
        {foreach $PostList as $k => $v}
        <div class="thread_post">
            <div class="post_header">
                <div class="thread_user">
                    <a href="{#HYBBS_URL('my',$v['user'])}" style="position: relative;" data-pjax>
                        {if is_vip($v['uid'])}<i style="position: absolute;left: -3px;font-size: 22px;top: -6px;color: #FF5722;transform: rotate(277deg);" class="iconfont icon-huangguan2"></i>{/if}
                        <img style="{if is_vip($v['uid'])}border:2px solid #FF5722;{/if}width:35px;height:35px;" src="{#WWW}{$v.avatar.b}" alt="{$v.user}">
                    </a>
                    <div class="user">
                        <div>
                            <div class="jcenter">
                            <?php
                                $inc = get_plugin_inc('nd_website_plus');
                                $lv = array_filter(explode("\r\n",$inc['user_lv']));
                                $lv_limit = count($lv);
                                $credits = S('User')->find('credits',['uid'=>$v['uid']]);
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
                            <p>
                                    <span class="lv no" style="background: #3cbbf4;">ID:{$v.uid}</span>
                                    <!-- 性别 -->
                                    {php $sex = S('user')->find('sex',['uid'=>$v['uid']])}
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
                                    </div>
                                {if $v['lou'] == 1}
                                沙发 |
                                {elseif  $v['lou'] == 2}
                                板凳 |
                                {elseif  $v['lou'] == 3}
                                地毯 |
                                {else}
                                {$v.lou}楼 |
                                {/if}
                                {php echo humandate($v['atime'])}
                                {if IS_LOGIN }
                                {if $v['uid'] == NOW_UID || NOW_GID == C("ADMIN_GROUP")}
                                    <!-- 帖子作者 或者 管理员 -->
                                    
                                    <a style="color: #00bcd4;" href="javascript:;" data-ydui-actionsheet="{target:'#ajax_edit_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{php HYBBS_URL('post','edit',['id'=>$v['pid']]); }','edit')">{$_LANG['编辑']}</a>
                                {/if}
                                {if $v['uid'] == NOW_UID || NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$thread_data['fid'])}
                                    <!-- 作者 与 管理员 判断 -->
                                    <a style="color: #c31d1d" href="javascript:void(0);" onclick="del_thread({$v.pid},'post')" >{$_LANG['删除帖子']}</a>
                                {/if}
                                
                            {/if}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post_conent">
    
            <!--{hook t_m_post_content_top}-->
                {$v.content}
            <!--{hook t_m_post_content_bottom}-->
            <?php            
                $post_post_data = S('post_post')->select('*',[
                    'pid'=>$v['pid'],
                    'ORDER'=>['atime'=>'DESC'],
                    'LIMIT'=>3
                ]);
                $User = M('User');

            ?> 
            {if $post_post_data}
                <div class="thread_post_post_list" style="">
                    {foreach $post_post_data as $val}
                    <li>
                        <a href="{#HYBBS_URL('my',$User->uid_to_user($val['uid']))}" data-pjax>{php echo $User->uid_to_user($val['uid'])}</a>:
                        {#substr_cut(trim(strip_tags($val['content'])),20)}
                    </li>
                    {/foreach}
                    {if $v['posts'] >= 3}
                    <li><a href="{#HYBBS_URL('thread','post',$v['pid'])}" data-pjax>查看全部 {$v.posts} 条回复</a>
                    {/if}
                </div>
            {/if}
            </div>
            <div class="post_footer">
                <span onclick="tp('post1','{$v.pid}',this)"><i class="icon-yduihao"></i> <p style="display: inherit;">{if $v['goods']}{$v.goods}{/if}</p></span>
                <span onclick="tp('post2','{$v.pid}',this)"><i class="icon-yduihuai"></i> <p style="display: inherit;">{if $v['nos']}{$v.nos}{/if}</p></span>
                <span><a href="{#HYBBS_URL('thread','post',$v['pid'])}" data-pjax><i class="icon-huaban"></i> {if $v['posts']}{$v.posts}{/if}</a></span>
            </div>
        </div>
        {/foreach}
        <!--ajax end-->
    </div>
    {if empty($PostList)}
    <div class="user_thread">
        <div class="no_thread" style="margin-top: 0">
            <i class="icon-meiyouguanzhu"></i>
            <p>还没有任何评论!</p>
        </div>
    </div>
    {/if}
    {if $page_count>1}
    <a href="javascript:;" id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block;margin-bottom: -28px;" onclick="ajax_list(this)">
        <span id="list-loading1">
            点击加载更多
        </span>
        <span id="list-loading2" style="display:none">
            <div class="loader loader-1">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>
            </div>
            加载中...
        </span>
    </a>
    <script type="text/javascript">
        function ajax_list(obj){
            $(obj).addClass('btn-disabled');
            $('#list-loading1').hide();
            $('#list-loading2').show();
            var page = parseInt($('#load-forun').attr("url")) + 1;
            {if X('get.order') == 'desc'}
            var url = "{php HYBBS_URL('thread',$thread_data['tid'],'"+page+"');}?order=desc";
            {else}
            var url = "{php HYBBS_URL('thread',$thread_data['tid'],'"+page+"');}";
            {/if}
            var pege_count = "{$page_count}";
            if (page <= pege_count) {
                    $.get(url, function(s) {
                        s = s.replace(/\\n|\\r/g, "");
                        s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                        $('#post_list').append(s);
                        $('#load-forun').attr('url', page);
                        $(obj).removeClass('btn-disabled');
                        $('#list-loading2').hide();
                        $('#list-loading1').show();
                        // $("img.lazy").lazyload();
                    });

            } else {
                $('#load-forun span').text('- 我是有底线的 -');
            };
        };
    </script>
    {/if}
    <!-- 分享 -->
    <div class="fenxiang ">
        <div class="m-actionsheet" id="fenxiang" style="background:#f5f5f5">
            <div style="background:  #fff;line-height:  40px;text-align:  left;padding: 0 15px;" data-shear-id="{$thread_data.tid}">分享到:</div>
            <div class="grids-txt datasetconfig" data-sites="yixin">
            </div>
        </div>
    </div>
    <script>
        // 分享
        $(function(){
            soshm('.datasetconfig', {
            sites: ['weixin','weixintimeline','qq','qzone','yixin','weibo','tqq','renren','douban','tieba']
            })
        })

    </script>
    <style>
    .soshm-item {
        float: left;
        margin: 10px 0px;
        cursor: pointer;
        width: 20%;
    }
    .g-view:after{
        height: 60px;
    }
    </style>

</div>
{hook t_post_editer_top}
{include thread_footer}
{include common/foot}