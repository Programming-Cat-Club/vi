<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<?php
$renzheng_inc = get_plugin_inc('nd_renzheng');
?>
<header class="m-navbar navbar-fixed coterie">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">找人</span>
        </div>
    </header>

<style>
    .sh{
        position: relative;
        background:#fff;
        padding: 5px 10px;
    }
    .sh input{
        background: #eee;
        width: 100%;
        border: none;
        line-height: 30px;
        border-radius: 30px;
        padding: 0 15px;
        font-size: 14px;
        height: 31px;
    }
    .shbtn{
        position: absolute;
        background: rgb(3, 169, 244);
        color: #fff;
        top: 5px;
        line-height: 30px;
        border: none;
        padding: 0px 10px;
        border-radius: 0 15px 15px 0;
        right: 10px;
        height: 31px;
    }
</style>
<div class="g-view">
    <div class="sh">
        <form id="form" action="{#HYBBS_URL('Coterie','search')}">
            <input id="sou" type="text" name="user" value="{#X('get.user')}" placeholder="搜人">
            <button class="shbtn" type="submit" style="display: none">搜索</button>
        </form>
    </div>
    <div class="lookfor">
        <ul id="user_thread">
            <!--ajax start-->
            {foreach $data as $v}
            <li>
                <a href="{#HYBBS_URL('my',$v['user'])}" data-pjax>
                <img src="{#WWW}{$v.avatar.b}" alt="">
                </a>
                <div class="content">
                    <a href="{#HYBBS_URL('my',$v['user'])}" data-pjax>
                        <h1>
                            <span class="user_name" style="{if is_vip($v['uid'])}color:{$renzheng_inc.color}{/if}">
                                {$v.user}
                                <?php
                                // 查询验证
                                $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                                ?>
                                {if $is_renzheng}
                                <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                                {/if}
                            </span>
                            <i class="iconfont {if $v['sex'] == 0}icon-xingbie2 sex-no{elseif $v['sex'] == 1}icon-nan sex-nan{else}icon-nv sex-nv{/if}"></i>
                            {if $v['age']}{php echo date('Y')-date('Y',$v['age'])}{/if}
                        </h1>
                    </a>
                    <p>{if $v['city']}{$v.city}{/if} 最后在线：{php echo humandate($v['ztime']);}</p>
                </div>
                <div class="right" class="actionsheet-item"{if IS_LOGIN} onclick="open_lt('{$v.user}','{$v.uid}','{$v.avatar.b}')" data-ydui-actionsheet="{target:'#liaotian',closeElement:'#cancel_liaotian'}"{else} onclick="is_login()"{/if}><i class="iconfont icon-xiaoxi1"></i></div>
            </li>
            {/foreach}
            <!--ajax end-->
            <!-- <li>
                <img src="{#WWW}upload/avatar/21232f297a57a5a743894a0e4a801fc3-b.jpg" alt="">
                <div class="content">
                    <h1>用户名成</h1>
                    <p>简介：撒娇时间</p>
                </div>
                <div class="right"><i class="iconfont icon-xiaoxi1"></i></div>
            </li> -->
        </ul>
    </div>
    {if $page_count>1}
    <div class="scroll" id="load-forun" url="{$pageid}"><span>加载中...</span></div>
    <script type="text/javascript">
        $(function() {
            $(window).scroll(function() {

                if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                    var page = parseInt($('#load-forun').attr("url")) + 1;
                    var url = "{php HYBBS_URL('coterie','search','"+page+"');}";
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
{include common/footer}
{include common/foot}