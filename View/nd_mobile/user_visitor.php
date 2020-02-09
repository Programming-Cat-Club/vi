<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head} {include user_header}
{include user_menu}

<div class="g-view">
    <!-- 导航 -->
    {include user_nav}
    <div class="user_thread">
            <div class="no_thread">
                    <i class="icon-meiyouguanzhu"></i>
                    <p>功能开发中!</p>
                </div>
    </div>
    <!-- <div class="scroll" id="load-forun" url="{$pageid}"><span>加载中...</span></div> -->
    <script type="text/javascript">
        $(function() {
            $(window).scroll(function() {
    
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
</div>

{include common/footer} {include common/foot}