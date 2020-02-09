<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head} {include common/header}
<style>
    .yd-timeline {
        background-color: #fff;
        font-size: 13px;
        color: #6e6e6e;
        overflow: hidden;
        position: relative;
        z-index: 1
    }

    .yd-timeline:after {
        content: "";
        position: absolute;
        z-index: 0;
        top: 0;
        left: 0;
        width: 100%;
        border-top: 1px solid #d9d9d9;
        -webkit-transform: scaleY(.5);
        transform: scaleY(.5);
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0
    }

    .yd-timeline-content {
        margin-left: 16px;
        border-left: 1px solid #e4e5e9
    }

    .yd-timeline-custom-item,
    .yd-timeline-item {
        padding: 16px 12px 16px 0;
        margin-left: 16px;
        position: relative
    }

    .yd-timeline-custom-item:not(:last-child):after,
    .yd-timeline-item:not(:last-child):after {
        content: "";
        position: absolute;
        z-index: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        border-bottom: 1px solid #d9d9d9;
        -webkit-transform: scaleY(.5);
        transform: scaleY(.5);
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0
    }

    .yd-timeline-custom-item .yd-timeline-icon,
    .yd-timeline-item .yd-timeline-icon {
        content: "";
        position: absolute;
        z-index: 1;
        left: -16px;
        display: block;
        top: 19px;
        -webkit-transform: translate(-50%);
        transform: translate(-50%)
    }

    .yd-timeline-custom-item:first-child,
    .yd-timeline-item:first-child {
        margin-top: 16px;
        padding-top: 0;
        color: #000
    }

    .yd-timeline-custom-item:first-child>.yd-timeline-icon,
    .yd-timeline-item:first-child>.yd-timeline-icon {
        top: 3px
    }

    .yd-timeline-custom-item:last-child:before,
    .yd-timeline-item:last-child:before {
        content: "";
        width: 1px;
        height: 100%;
        background-color: #fff;
        position: absolute;
        left: -17px;
        top: 19px
    }

    .yd-timeline-item .yd-timeline-icon {
        width: 8px;
        height: 8px;
        border-radius: 99px;
        background-color: #e4e5e9
    }

    .yd-timeline-item:first-child>.yd-timeline-icon {
        background-color: #f23030;
        width: 10px;
        height: 10px
    }

    .yd-timeline-item:first-child:before {
        content: "";
        width: 16px;
        height: 16px;
        position: absolute;
        z-index: 0;
        top: 0;
        left: -24px;
        background-color: #fbbfbf;
        border-radius: 99px
    }

    .yd-timeline-custom-item:first-child>.yd-timeline-icon {
        top: 0
    }
</style>
<div class="g-view">
    <div style="background: #fff;margin-top: 15px;">
        <section id="scrollView" class="yd-scrollview">
            <div class="yd-timeline demo-small-pitch">
                <ul class="yd-timeline-content" id="user_thread">
                    <!--ajax start-->
                    {foreach $log_data as $v}
                    <li class="yd-timeline-item">
                        <em class="yd-timeline-icon"></em>
                        <p>{$v.content}</p>
                        <p style="margin-top: 10px;">积分:{$v.credits} 金币:{$v.gold} 时间:{#date('Y-m-d H:i:s',$v['atime'])}</p>
                    </li>
                    {/foreach}
                    <!--ajax end-->
                </ul>
            </div>
        </section>
    </div>
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
                    var url = "{php HYBBS_URL('my',$data['user'],['log'=>'"+page+"']);}";
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