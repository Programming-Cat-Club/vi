<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{$title}{$conf.title2}</title>
    <meta name="keywords" content="{$conf.keywords}">
    <meta name="description" content="{$conf.description}">
    <meta name="author" content="哄着自己玩">
    <!--使用webkit内核-->
    <meta name="renderer" content="webkit">
    <meta name="renderer" content="ie-stand">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="alternate icon" type="image/png" href="{#WWW}favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="{#WWW}favicon.ico">
    <!-- 引入样式 -->
    <link rel="stylesheet" href="{#WWW}View/nd_mobile/css/ydui.css?var={#ND_MOBILE_V}">
    <link href="https://cdn.bootcss.com/Swiper/4.4.2/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{#WWW}View/nd_mobile/css/style.css?var={#ND_MOBILE_V}">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_617807_pnvsjr9bdcb.css">
    <!-- 引入rem自适应类库 -->
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>
    <script type="text/javascript">
        var www = "{#WWW}{#RE}";
        var WWW = "{#WWW}";
        var exp = "{#EXP}";
        var action_name = "{#ACTION_NAME}";
        var method_name = "{#METHOD_NAME}";
        var rewrite = "{#C('REWRITE')}" ? '' : '?';
        {if IS_LOGIN}
        window.hy_user = "{#NOW_USER}";
        window.hy_avatar = "{$user.avatar.a}";
        $(function(){tog_friend_box();})
        {else}
        window.hy_user = '';
        window.hy_avatar = '';
        {/if}
        <!--{hook t_m_h_1}-->

    </script>
    {hook t_m_h_jiaoben}
    <script type="text/javascript" src="{#WWW}hyui/hy.js?var={#ND_MOBILE_V}"></script>
    <script type="text/javascript" src="{#WWW}public/js/app.js?var={#ND_MOBILE_V}"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <!-- jq -->

    <!-- 编辑器 -->
    <link href="https://cdn.bootcss.com/simditor/2.3.21/styles/simditor.min.css" rel="stylesheet">
    <script type="text/javascript" src="{#WWW}View/nd_mobile/src/simditor/module.js?var={#ND_MOBILE_V}"></script>
    <script type="text/javascript" src="{#WWW}View/nd_mobile/src/simditor/hotkeys.js?var={#ND_MOBILE_V}"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/simditor/2.3.21/lib/simditor.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/4.4.2/js/swiper.min.js"></script>
    <!-- pulltorefresh -->
    <!-- <script src="https://cdn.bootcss.com/pulltorefreshjs/0.1.14/pulltorefresh.min.js"></script> -->
    <!-- 分享 -->
    <script type="text/javascript" src="{#WWW}View/nd_mobile/js/soshm.min.js?var={#ND_MOBILE_V}"></script>
</head>

<body>
<?php
//字符截取方法substr_cut(截取的字符串,字数)
function substr_cut($v, $length)
{
    if (mb_strlen($v) > $length) {
        echo mb_substr($v, 0, $length, "utf-8") . '...';
    } else {
        echo mb_substr($v, 0, $length, "utf-8");
    }
}
function is_vip($uid){
    $Uvip = S('uvip');
    $res = $Uvip->count(['uid'=>$uid]);
    if($res){
        return true;
    }else{
        return false;
    }
}
?>
<div class="loading-page" style="display: none;">
    <div class="reds">
        <div class="loader2"></div>
    </div>
</div>
{if IS_LOGIN}
    {include common/message}
    {include common/ajax_post}
{/if}
<div id="pjax">