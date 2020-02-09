<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include user_header}

<div class="g-view">

    <div class="user_thread">
        {foreach $collection_data as $k=>$v}
        <!--ajax start-->
        {include forum_list_quanzi}
        <!--ajax end-->
        {/foreach}
    </div>
    {if empty($collection_data)}
    <div class="user_thread">
        <div class="no_thread">
            <i class="icon-meiyouguanzhu"></i>
            <p>还没有任何收藏!</p>
        </div>
    </div>
    {/if}
    {if $page_count>1}
    <div class="scroll" id="load-forun" url="{$pageid}"><span>加载中...</span></div>
    <script type="text/javascript">
        $(function() {
            $(window).scroll(function() {
                //$(document).scrollTop() 获取垂直滚动的距离
                //$(document).scrollLeft() 这是获取水平滚动条的距离
                if ($(document).scrollTop() <= 0) {
                    // $('#van').css('margin-top','50px');
                    // /alert("滚动条已经到达顶部为0");
                }
        
                if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                    var page = parseInt($('#load-forun').attr("url")) + 1;
                    var url = "{php HYBBS_URL('my',$data['user'],['thread'=>'"+page+"']);}";
                    var pege_count = "{$page_count}";
                    if (page <= pege_count) {
                        $.get(url, function(s) {
                            s = s.replace(/\\n|\\r/g, "");
                            s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                            $('#user_thread').append(s);
                            $('#load-forun').attr('url', page);
                            // $("img.lazy").lazyload();
                        });
                    } else {
                        $('#load-forun span').text('- 我是有底线的 -');
                    };
                }
            });
        })
    </script>
    {/if}
</div>

{include common/footer} {include common/foot}