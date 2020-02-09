<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}

<style>
    .nd_sign .m-navbar{
        background: rgba(255, 255, 255, 0);
        padding: 10px;
    }
    .nd_sign .m-navbar .navbar-item{color: #03A9F4;}
    .sign{
        background-image: url({#WWW}View/nd_mobile/img/rect3059.png);
        background-position: 0% 0%;
        position: relative;
        text-align: center;
        padding: 30px 20px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
        background-repeat: no-repeat;
        background-size: cover;
        height: 174px;
    }
    .sign .scspan{
        margin-top: 40px;
    }
    .sign p{
        margin-top: 10px;
    }
    .sign .signin-days{
        color: #673AB7;

    }
    .m-grids-7{
        background: #fff;
        overflow: hidden;
    }
    .m-grids-7 .grids-item{
        width: 14.2857%;
    }
    .signs{
        margin: 15px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .signs .grids-item{
        position: relative;
        line-height: 42px;
        height: 42px;
        padding: 0;
        overflow: hidden;
    }
    .signs .grids-item i{
        font-size: 18px;
        position: absolute;
        width: 25px;
        border: 1px solid #03A9F4;
        height: 25px;
        border-radius: 50%;
        top: 49%;
        left: 50%;
        transform: translate(-50%, -52%);
    }

    .signs .grids-item .guoqu{
        color: #adadad;
    }
    .signs .grids-item .qiandao{
        position: absolute;
        background: #03A9F4;
        color: #fff;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 2px 16px -4px #03A9F4;
        width: 32px;
        height: 32px;
        border-radius: 19px;
    }
    .signs .grids-item .wancheng{
        background: rgba(3, 169, 244, 0.44);
    }
    .signs .grids-item .qiandao span{
        position: absolute;
        color: #fff;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -49%);
        font-size: 12px;
    }
    .signs .grids-item .jinri{
        background: #38c1ff;
        color: #fff;
    }
    .signs .grids-item .ok{
        color: #38c1ff;
    }
    .signs .grids-item .zhou{
        background: rgba(3, 169, 244, 0.2);
        color: #38c1ff;
    }
    .shuoming{
        margin: 15px;
        background: #fff;
        padding: 15px;
        font-size: 14px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .shuoming h5{
        color: #03A9F4;
    }
    .shuoming ol{
        color: #73c7ec;
        list-style: cjk-ideographic;
        padding: 2px 22px;
    }
    .g-view:after {
        display: block;
        height: 55px;
    }
    .btn-primary {
        box-shadow: 0 3px 19px -3px #03A9F4;
    }
</style>
{php $inc = get_plugin_inc("nd_website_plus");}
<div class="g-view nd_sign">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
        </div>
    </header>
    <div style="margin-top: -50px;background: #fff;">
            <div class="sign">
                <div class="scspan">
                    <button class="btn btn-primary {if $sign_jinri}btn-disabled{/if}"{if $isLogin} onclick="sign()"{/if}>{if $sign_jinri}今日已签到{else}点击签到{/if}</button>
                    <p><span class="signin-days">已连累计到<cite id="sign_leiji">{if $sign_data['count']}{$sign_data.count}{else}0{/if}</cite>天</span> <span class="signin-days">已连续签到<cite id="sign_lianxu">{if $sign_data['signcount']}{$sign_data.signcount}{else}0{/if}</cite>天</span></p>
                </div>
            </div>
    </div>
    <?php
        $riqi   = ['日','一','二','三','四','五','六'];
        $qishi  = 0; // 记录起始位置
        $rili   = 0; // 记录 日 用于1-31的天数记录
    ?>
    <div class="m-grids-7 signs">
        {foreach $riqi as $v}
        <a href="javascript:;" class="grids-item">
            <div class="grids-txt zhou">
                {$v}
            </div>
        </a>
        {/foreach}
        
        {for $i=1;$i <= date('t')+date("w",strtotime(date('Y-m-')."1"));$i++}
            {if $qishi < date("w",strtotime(date('Y-m-')."1"))}
                <!-- 这里用于占位 -->
                <a href="javascript:;" class="grids-item">
                    <div class="grids-txt jinri"></div>
                </a>
                {php $qishi+=1}
            {else}
                {php $rili += 1}
                {if $rili == date('d')}
                    {if $sign_jinri}
                    <a href="javascript:;" class="grids-item" id='wanchengqiandao'>
                        <div class="grids-txt qiandao wancheng">
                            <span>完成</span>
                        </div>
                    </a>
                    {else}
                    <a href="javascript:;" class="grids-item" id='wanchengqiandao'>
                        <div class="grids-txt qiandao" onclick="sign()">
                            <span>签到</span>
                        </div>
                    </a>
                    {/if}
                {else}
                    <a href="javascript:;" class="grids-item">
                        <div class="grids-txt">
                            {if $rili == in_array($rili, $sign_riqi)} <i class=""></i> <span class="ok">{$rili}</span>{else} <span class="{if $rili < date('d')}guoqu{/if}">{$rili}</span> {/if}
                        </div>
                    </a>
                {/if}
            {/if}
        {/for}
        
    </div>
    <div class="shuoming">
        <h5>签到规则</h5>
        <ol>
            {$inc.sign_mess}
        </ol>
    </div>
</div>
{include common/footer}
{include common/foot}