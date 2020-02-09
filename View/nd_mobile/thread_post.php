<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head} {include thread_header}
<div class="g-view">
    <div>
        <div class="thread_user">
            <a href="{#HYBBS_URL('my',$post_data['user'])}" data-pjax>
                <img src="{#WWW}{$post_data.avatar.b}">
            </a>
            <div class="user">
                <div>
                    <h2>{$post_data.user}
                        <i class="iconfont icon-nan sex-nan"></i>
                    </h2>
                    <p>{php echo humandate($post_data['atime']);}</p>
                </div>
            </div>
        </div>
        <article class="thread_content" style="padding: 10px;">
            {$post_data.content}
            <div class="text-center thread_content_foot" style="margin-top: 10px;">
                <a href="javascript:;" class="btn btn-primary border-radius" onclick="tp('post1','{$post_data.pid}',this)">
                    <div>
                        <i class="iconfont icon-dianzan"></i>
                    </div>
                    <p>{$post_data.goods}</p>
                </a>
                <a href="javascript:;" class="btn btn-warning border-radius" onclick="tp('post2','{$post_data.pid}',this)">
                    <div>
                        <i class="iconfont icon-zan11"></i>
                    </div>
                    <p>{$post_data.nos}</p>
                </a>
                <a href="javascript:;" class="btn btn-fenxiang border-radius" id="shareBtn" data-ydui-actionsheet="{target:'#fenxiang',closeElement:'#cancel'}">
                    <div>
                        <i class="iconfont icon-fenxiang"></i>
                    </div>
                    <p>&nbsp;</p>
                </a>

            </div>
        </article>
        <div class="post_nav" id="thread_post">
            <div class="post_info">
                共有{$post_data.posts}条评论
                <div class="post_sort">
                    <span class="{if X('get.order')!='desc'}active{/if}">
                        <a href="{php HYBBS_URL('thread','post',$post_data['pid'])}#thread_post" data-pjax>最早</a>
                    </span>
                    <span class="{if X('get.order')=='desc'}active{/if}">
                        <a href="{php HYBBS_URL('thread','post',$post_data['pid'])}?order=desc#thread_post" data-pjax>最新</a>
                    </span>
                </div>
            </div>
        </div>
        <div id="post_list">
            <!--ajax start-->

            {foreach $post_post_data as $k => $v}
            <div class="thread_post">
                <div class="post_header">
                    <div class="thread_user">
                        <a href="{php HYBBS_URL('my',$v['user']);}" data-pjax>
                            <img src="{#WWW}{$v.avatar.b}">
                        </a>
                        <div class="user">
                            <div>
                                <h2>{$v.user}</h2>
                                <p>
                                    {$v.atime_str}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post_conent">
                    {$v.content}
                </div>
                <div class="post_footer">

                </div>
            </div>
            {/foreach}
            <!--ajax end-->
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
                        {if X('get.order') == 'desc'}
                        var url = "{php HYBBS_URL('thread','post',[$post_data['pid']=>'"+page+"'] );}?order=desc";
                        {else}
                        var url = "{php HYBBS_URL('thread','post',[$post_data['pid']=>'"+page+"'] );}";
                        {/if}
                        var pege_count = "{$page_count}";
                        if (page <= pege_count) {
                            $.get(url, function(s) {
                                s = s.replace(/\\n|\\r/g, "");
                                s = s.substring(s.indexOf("<!--ajax start-->"), s.indexOf("<!--ajax end-->"));
                                $('#post_list').append(s);
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
    <!-- 分享 -->
    <div class="fenxiang ">
        <div class="m-actionsheet" id="fenxiang" style="background:#f5f5f5">
                <div style="background:  #fff;line-height:  40px;text-align:  left;padding: 0 15px;">分享到:</div>
                <div class="grids-txt datasetconfig" data-sites="yixin">
                </div>
        </div>
    </div>
    <script>
        $(function(){
            // 分享
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
    </style>
</div>
{include thread_post_footer} {include common/foot}