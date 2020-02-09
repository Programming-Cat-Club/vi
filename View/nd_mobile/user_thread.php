<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include user_header}
<div class="g-view">
    {if !empty($thread_data)}
    <div  id="list_thread" class="user_thread">
        <!--ajax start-->
        {foreach $thread_data as $k=>$v}
        {include forum_list_quanzi}
        {/foreach}
        <!--ajax end-->
    </div>
    {else}
    <div class="user_thread">
        <div class="no_thread">
            <i class="icon-meiyouguanzhu"></i>
            <p>文章还在写作中...</p>
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
            var url = "{php HYBBS_URL('my',$data['user'],['thread'=>'"+page+"']);}";
            var pege_count = "{$page_count}";
            if (page <= pege_count) {
                    $.get(url, function(s) {
                        s = s.replace(/\\n|\\r/g, "");
                        s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                        $('#list_thread').append(s);
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