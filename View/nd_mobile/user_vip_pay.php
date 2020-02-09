<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{php $nd_inc = get_plugin_inc('nd_website_plus');}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">{$title}</span>
    </div>
    <a href="javascript:;" class="navbar-item" style="font-size: 16px;" onclick="kefu()">
        客服
    </a>
</header>
<style>
    .m-navbar{
        background: #444;
    }
    .m-navbar .navbar-item,
    .m-navbar .navbar-title
    {
        color: #fff
    }
    .user{
        background: #444;
        display: flex;
        align-items: center;
        padding: 0 15px 10px;
    }
    .user img{
        width: 50px;
        height: 50px;
        border-radius: 100%;
        margin-right: 10px;
    }
    .user .title{
        color: #fff;
        width: 100%
    }
    .user .title h1{
        font-size: 16px;
    }
    .user .btn{
        width: 115px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.11);
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .vip-pay{
        padding: 15px;
    }
    .vip-pay .nav{
        font-weight: bold;
        font-size: 16px;
    }
    .vip-pay ul{
        margin: 10px -5px 0;
    }
    .vip-pay ul:after{
        content: '';
        clear: both;
        display: block;
    }
    .vip-pay ul li{
        width: calc(33.333333% - 10px);
        float: left;
        padding: 15px 5px;
        background: #fff;
        box-shadow: 0 1px 10px -5px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        text-align: center;
        margin: 0 5px 10px;
        border: 1px solid #fff;
    }
    .vip-pay ul .active{
        border: 1px solid #ff9800;
        background: rgba(255, 152, 0, 0.2);
    }
    .vip-pay ul li h1{
        color: #444;
        font-size: 16px;
    }
    .vip-pay ul li strong{
        color: #FF9800;
        font-size: 20px;
        line-height: 34px;
    }
    .vip-pay ul li strong em{
        font-size: 14px;
        font-weight: bold;
    }
    .vip-pay ul li p{
        text-decoration: line-through;
        color: #444;
    }
    .vip-type {
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 1px 10px -5px rgba(0, 0, 0, 0.2);
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 5px;
        font-size: 14px;
    }
    .vip-type .m-cell{
        margin: 0;
    }
    footer{
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: #fff;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 10px -5px rgba(0, 0, 0, 0.2);
    }
    footer .jiage{
        width: 100%;
        padding: 0 15px;
        font-size: 16px;
    }
    footer .zhifu{
        width: 140px;
        height: 100%;
        background: #FF9800;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    footer .zhifu button{
        border: 0;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<div class="g-view">
    <nav class="user">
        <img src="{#WWW}{$data.avatar.b}" alt="">
        <div class="title">
            <h1>{$data.user}</h1>
            <p>
                {if $vip_data}
                    {if $vip_data['atime'] < NOW_TIME}
                        已过期: {$vip_data['str_atime']}
                    {else}
                        到期时间: {#date('Y-m-d',$vip_data['atime'])}
                    {/if}
                {else}
                    未开通
                {/if}
            </p>
        </div>
        <div class="btn">
            <a href="{#HYBBS_URL('user','out')}">切换帐号</a>
        </div>
    </nav>
    <div class="vip-pay">
        <div class="nav">
            购买VIP
        </div>
        <div class="list">
            <ul>
                <?php
                $nd_inc = get_plugin_inc('nd_website_plus');
                $taocan = explode("\r\n",$nd_inc['vip_taocan']);
                ?>
                {foreach $taocan as $k => $v}
                {php $taocan_info = explode("|",$v)}
                <li onclick="xuanding(this)" data-money="{$taocan_info.1}" data-jinbi="{$taocan_info.3}" data-id="{$k}">
                    <h1>{$taocan_info.0}</h1>
                    <strong><em>￥</em>{$taocan_info.1}</strong>
                    <p>￥{$taocan_info.2}</p>
                </li>
                {/foreach}
            </ul>
        </div>
        <div class="nav" style="margin-top: 15px;">
            支付方式
        </div>
        <div class="vip-type">
            <div class="m-cell">
                <label class="cell-item">
                    <span class="cell-left">网站金币支付</span>
                    <label class="cell-right">
                        <input type="radio" name="radio" value="jinbi" checked="">
                        <i class="cell-radio-icon"></i>
                    </label>
                </label>
                <label class="cell-item">
                    <span class="cell-left">扫码支付</span>
                    <label class="cell-right">
                        <input type="radio" name="radio" value="saoma">
                        <i class="cell-radio-icon"></i>
                    </label>
                </label>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="jiage">
        总计: <span id="gongji">￥0 元</span>
    </div>
    <div class="zhifu">
        <button onclick="pay()">确认支付</button>
    </div>
</footer>
<script>
    function kefu(){
        if('{$nd_inc.vip_kefu}' == ''){
            return dialog.toast("站长没有设置客服QQ", 'none', 1000);
        }
        var u = navigator.userAgent;
        if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
            window.location.href = "mqqwpa://im/chat?chat_type=wpa&uin={$nd_inc.vip_kefu}&version=1&src_type=web";
        } else if (u.indexOf('iPhone') > -1) {//苹果手机
            window.location.href = "mqq://im/chat?chat_type=wpa&uin={$nd_inc.vip_kefu}&version=1&src_type=web";
        } else if (u.indexOf('Windows Phone') > -1) {//winphone手机
            // window.location.href = "mobile/index.html";
        }
    }
    function pay(){
        var money = $('.vip-pay .list .active').attr('data-money');
        var id = $('.vip-pay .list .active').attr('data-id');
        var type = $('[name="radio"]:checked').val();
        if(id == undefined || money == undefined){
            return dialog.toast("请选择一个套餐", 'none', 1000);
        }
        if(type == 'saoma'){
            return dialog.toast("暂不支持扫码支付", 'none', 1000);
        }
        $.ajax({
            type: "post",
            url: "{#HYBBS_URL('user','vip_pay')}",
            data: {id:id,type:type},
            dataType: "json",
            success: function (e) {
                if(e.erroe){
                    dialog.toast(e.info, 'none', 1000);
                }else{
                    dialog.toast(e.info, 'none', 1000);
                }
            }
        });
    }
    function xuanding(obj){
        $('.vip-pay .list li').removeClass('active')
        $(obj).addClass('active');
        var text = '';
        var type = $('[name="radio"]:checked').val();
        var jinbi = $(obj).attr('data-jinbi');
        var money = $(obj).attr('data-money');
        if(type == 'jinbi'){
            text = jinbi+' 金币';
        }else if(type == 'saoma'){
            text = '￥'+money+' 元';
        }
        $('#gongji').text(text)
    }
    $('[name="radio"]').click(function(){
        var type = $(this).val();
        var jinbi = $('.vip-pay .list .active').attr('data-jinbi');
        var money = $('.vip-pay .list .active').attr('data-money');
        var text = '';
        if(type == 'jinbi'){
            text = jinbi+' 金币';
        }else if(type == 'saoma'){
            text = '￥'+money+' 元';
        }
        if(jinbi != undefined || money != undefined){
            $('#gongji').text(text);
        }
    });
</script>
{include common/foot}