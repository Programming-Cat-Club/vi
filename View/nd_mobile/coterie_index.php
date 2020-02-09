<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include coterie_header}
<div class="g-view">
    {include index_banner}
    <!-- 菜单 -->
    <script src="//at.alicdn.com/t/font_617807_0alwjn63mwnm.js"></script>
    <style type="text/css">
        .icon {
            width: 1em; height: 1em;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
        }
    </style>
    <div id="forun_list" style="margin-top:25px">
        <!--ajax start-->
        {foreach $data as $k=>$v}
        {include forum_list_quanzi}
        {/foreach}
        <!--ajax end-->
    </div>
    {if $page_count>1}
    <a href="javascript:;" id="load-forun" class="scroll load-index" url="{$pageid}" style="display: block" onclick="ajax_list(this)">
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
    <script>
        function ajax_list(obj){
            $(obj).addClass('btn-disabled');
            $('#list-loading1').hide();
            $('#list-loading2').show();
            var page = parseInt($('#load-forun').attr("url")) + 1;
            var url = "{php HYBBS_URL('coterie');}?pageid="+page;
            var pege_count = "{$page_count}";
            if (page <= pege_count) {
                    $.get(url, function(s) {
                        s = s.replace(/\\n|\\r/g, "");
                        s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                        $('#forun_list').append(s);
                        $('#load-forun').attr('url', page);
                        $(obj).removeClass('btn-disabled');
                        $('#list-loading2').hide();
                        $('#list-loading1').show();
                        $("img.lazyload").lazyload();
                    });

            } else {
                $('#load-forun span').text('- 我是有底线的 -');
            };
        };

    </script>
    {/if}
</div>
{include common/footer}
{include common/foot}