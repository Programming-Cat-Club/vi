<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

<style>
    .footer a {
        height: 40px;
        color: #656565;
        line-height: 39px;
    }

    .footer .back {
        width: 40px;
        text-align: center;
    }

    .footer .huifu {
        background: #f0f2f3;
        line-height: 30px;
        padding: 0 10%;
        border-radius: 15px;
        font-size: 14px;
    }

    .footer .right {
        display: flex;
        /* flex: 1; */
        justify-content: center;
        align-items: center;
        width: calc(100% - 40px - 43%);
    }

    .footer .right a {
        width: 30%;
        text-align: center;
    }

    .footer .right span {
        margin-right: 0;
        font-size: 11px;
        position: absolute;
        line-height: 15px;
        top: -5px;
        right: -10px;
        padding: 0 5px;
    }

    .footer i {
        position: relative;
        font-size: 26px;
    }
    #pinglun .cell-item,
    #pinglun .cell-textarea{
        background: #f5f5f5;
    }
    #pinglun .m-cell:after{
        border-bottom:none;
    }

    .biaoqing .m-grids-4{
        padding: 15px 10px 0;
    }
    .biaoqing .m-grids-4 input{
        position: absolute;
        display: block;
        width: calc(100% - 20px);
        height: calc(100% - 20px);
        opacity: 0;
        top: 10px;
    }

    .biaoqing .m-grids-4 .grids-item{
        position: relative;
        padding: 0 0 10px;
    }
    .biaoqing .m-grids-4 .grids-item img{
        margin-left: 4px;
        border-radius: 5px;
    }
    .biaoqing .m-grids-4,
    .biaoqing .m-grids-5{
        background: #f5f5f5;
        height: 190px;
        overflow-y: scroll;
    }
    .biaoqing .m-grids-4 .grids-item:after,
    .biaoqing .m-grids-5:before,
    .biaoqing .m-grids-5 .grids-item:after
    {
        border-bottom:none
    }
    .biaoqing .m-grids-4 .grids-item:not(:nth-child(4n)):before,
    .biaoqing .m-grids-5 .grids-item:not(:nth-child(5n)):before
    {
        border-right:none;
    }
    .pinglun_nav{
        display: flex;justify-content: space-between;background:#fff;line-height: 40px;padding: 0 15px;
        font-size: 16px;
    }
    .pinglun_mune{
        display: flex;background:#fff;    line-height: 30px;
    padding: 5px 15px 0;
    }


    .foot_nav{
        position: fixed;
        display: block;
        z-index: 90;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 48px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 0px 2px rgba(0, 0, 0, 0.09);
    }
    .foot_nav li{
        float: right;
        height: 48px;
        margin-left: 8px;
        margin-right: 5px;
        overflow: hidden;
    }
    .foot_nav li a{
        display: block;
        width: 35px;
        height: 35px;
        padding: 2px 8px;
        margin: 8px 0;
        position: relative;
    }
    .foot_nav li a i{
        width: 22px;
        height: 22px;
        line-height: 22px;
        font-size: 22px;
    }
    .foot_nav li a span {
        position: absolute;
        display: block;
        font-size: 10px;
        height: 14px;
        line-height: 14px;
        padding: 0 2px;
        right: 1px;
        top: -1px;
        overflow: hidden;
        border-radius: 10px;
    }
    .foot_nav .foot_nav_left{
        float:none
    }
    .foot_nav .foot_nav_left a {
        position: relative;
        display: block;
        width: auto;
        height: 28px;
        line-height: 28px;
        font-size: 14px;
        padding: 0px 12px;
        margin: 10px 9px 0 4px;
        border-radius: 30px;
        overflow: hidden;
        background: #f3f3f3;
    }
    .tn_fabu{
        color: #fff;
        float: right;
        padding: 0px 10px;
        font-weight: bold;
        font-size: 14px;
        background: #03A9F4;
        border-radius: 1.5px;
        margin-right: -10px;
    }
</style>
<footer class="m-tabbar tabbar-fixed footer">
<div class="foot_nav ">
    <ul>
        <li><a href="javascript:;" data-ydui-actionsheet="{target:'#fenxiang',closeElement:'#cancel'}"><i class="iconfont icon-fenxiang2"></i></a></li>
        <li><a href="javascript:;" {if S('plugins_collection')->count(['uid'=>NOW_UID,'tid'=>$thread_data['tid']])}style="color:#F44336"{/if} onclick="collection('{$thread_data.tid}',this)"><i class="icon-shoucang1"></i></a></li>
        <li><a href="javascript:;" class=""><i class="iconfont icon-huifu"></i><span class="adge badge-radius {if $thread_data['posts']}badge-danger{/if}">{if $thread_data['posts'] != 0}{$thread_data.posts}{/if}</span></a></a></li>
        <li class="foot_nav_left"><a href="javascript:;" id="postedit" {if IS_LOGIN}data-ydui-actionsheet="{target:'#pinglun',closeElement:'#cancel'}"{else} onclick="is_login()"{/if}><i class=""></i><em>说点什么吧...</em></a></li>	
    </ul>
</div>
</footer>
{if IS_LOGIN}
<div class="m-actionsheet" id="pinglun">
    <div class="pinglun_nav">
        <a href="javascript:;">评论：</a>
        <a href="javascript:;" id="cancel">关闭</a>
    </div>
    {include thread_post_edit}
    <div class="pinglun_mune">
        <a href="javascript:;" data-tab="biaoqing">
            <i class="iconfont icon-biaoqing" style="font-size: 24px;"></i>
        </a>
        <a href="javascript:;" data-tab="tupian" style="margin-left: 15px;"><i class="iconfont icon-tupian" style="font-size: 24px;"></i></a>
        <div style="width:100%">
            <a href="javascript:;" onclick="post_pinlun()" class="tn_fabu">评论</a>
        </div>
    </div>
    <div class="biaoqing"> 

        <div class="m-grids-5" id="biaoqing" style="display: none">
            {for $i=1; $i<30; $i++}
            <a href="JavaScript:;" class="grids-item" onclick="setneirong_pinlun('{$i}')">
                <div class="grids-txt">
                    <div class="grids-txt">
                    <img class="emoji" src="{#WWW}View/nd_mobile/img/emoji/emoji-{$i}.png" alt="">
                    </div>
                </div>
            </a>
            {/for}
        </div>
        <div>
            <div class="m-grids-4" id="pic" style="display: none;">
                <a class="grids-item">
                    <img src="{#WWW}View/nd_mobile/img/plus.png" alt="" style="background: #fff; width: 76px;height: 76px;object-fit: cover;border: 1px dashed #8a8a8a;border-radius: 5px;">
                    <input id="upimg" class="fileInput" type="file" name="photo" accept="image/*" multiple="multiple" onchange="upload_pic(this,'{#HYBBS_URL('post','upload')}')">
                </a>
            </div>
        </div>

    </div>
</div>
{/if}