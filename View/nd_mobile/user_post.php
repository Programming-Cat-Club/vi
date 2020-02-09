<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head} 
{include user_header}

<div class="g-view">
    {if !empty($post_data)}
    <section id="scrollView" class="yd-scrollview">
        <div class="yd-timeline demo-small-pitch">
            <ul class="yd-timeline-content" id="user_thread">
                <!--ajax start-->
                {foreach $post_data as $v}
                {php $title = S('Thread')->find('title',['tid'=>$v['tid']]);}
                <li class="yd-timeline-item">
                    <!-- <em class="yd-timeline-icon"></em> -->
                    <img src="{#WWW}{$data.avatar.a}" style="{if is_vip($data['uid'])}border:2px solid #FF5722;{/if}width:35px;height:35px;"  class="thread_user_pic">

                    <p style="margin-top: 10px;">{#humandate($v['atime'])}在 <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax style="color: #0d6fbd;font-size: 14px;">{$title}</a> 回复</p>
                    <p style="font-size: 12px;"></p>
                    <p style="margin-top: 10px;padding: 8px 5px;background: #f7f7f7;border-radius: 5px;">{$v.content}</p>
                    <div style="margin-top: 10px;font-size: 14px;text-align: right;">
                        <span style="margin-right: 10px;" onclick="tp('post1','{$v.pid}',this)">
                            <i class="icon-yduihao"></i> <span>{$v.goods}</span>
                        </span>
                        <span>
                            <i class="icon-huifu1"></i> {$v.posts}
                        </span>
                    </div>
                </li>
                {/foreach}
                <!--ajax end-->
            </ul>
        </div>
    </section>
    {else}
    <div class="user_thread">
        <div class="no_thread">
            <i class="icon-meiyouguanzhu"></i>
            <p>还没有任何回复!</p>
        </div>
    </div>
    {/if}
    {if $page_count>1}
    <a href="javascript:;" id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block;" onclick="ajax_list(this)">
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
            var url = "{php HYBBS_URL('my',$data['user'],['post'=>'"+page+"']);}";
            var pege_count = "{$page_count}";
            if (page <= pege_count) {
                    $.get(url, function(s) {
                        s = s.replace(/\\n|\\r/g, "");
                        s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                        $('#user_thread').append(s);
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
</div>

{include common/footer} {include common/foot}