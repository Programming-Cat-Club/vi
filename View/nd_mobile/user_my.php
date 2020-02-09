{include common/head}
<div class="user">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"></span>
        </div>
        <a href="{#HYBBS_URL('my',$data['user'],'user_style')}" data-pjax class="navbar-item">
            <i class="icon-zhuti"></i>
        </a>
    </header>
</div>
<style>
    .user-gengduo a {
        justify-content: center;
    }

    .user>.m-navbar {
        background-color: rgba(255, 255, 255, 0);
        -webkit-transition: background-color .2s ease-in;
        transition: background-color .2s ease-in;
    }

    .m-bg {
        background: #fff;
    }
    .m-bg .navbar-item, 
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before, 
    .m-bg .navbar-center .navbar-title,
    .m-bg .navbar-item .back-ico:before, 
    .m-bg .navbar-item .next-ico:before
     {
        color: #5C5C5C;
    }
    .user>.m-navbar:after {
        border-bottom: none;
    }

    .user>.navbar-item>i,
    .user>.navbar-item .icon-fanhui::before,
    .user>.navbar-item .next-ico::before {
        color: #fff;
    }
    .user_tongji{
        position: absolute;
        top: 175px;
        background: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        margin: 0 10px;
        width: calc(100% - 20px);
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
    .user_tongji li {
        text-align: center;
        list-style: none;
        width: 33.333333%;
        float: left;
        position: relative;
        z-index: 0;
        padding: 10px 0;
        font-size: 18px;
        color:#4CAF50;
        font-weight: bold;
    }
    .user_tongji li span{
        font-size: 12px;
        color: #444;
        font-weight:200
    }
    .navbar-item,
    .navbar-item .back-ico:before, 
    .navbar-item .next-ico:before{
        color: #fff;
    }
</style>
<?php
    $collection = S('plugins_collection')->count(['uid'=>NOW_UID])
?>
<div class="user_ipc">
    {php $user_img = S('user_style')->find('*',['uid'=>$data['uid']]);}
    {php $inc = get_plugin_inc('nd_user_img');}
    <div style="background-image:url({if $user_img}{$user_img['img']}?r={#time()}{else}{$inc.user_d_img}{/if});" class="forum_thread_header">
        <div class="user_info">
            <img src="{#WWW}{$data.avatar.a}" alt="{$data.user}">
            <div class="title">
                <div>
                    <h3 style="text-transform:capitalize;">
                        <?php
                        $renzheng_inc = get_plugin_inc('nd_website_plus');
                        ?>
                            <?php
                            // 查询验证
                            $is_renzheng = S('user')->find('renzheng',['uid'=>$user['uid']]);
                            ?>
                        <span class="user_name" style="{if is_vip($user['uid'])||$is_renzheng}color:{$renzheng_inc.color}{/if}">
                            {$user.user}
                            {if $is_renzheng}
                            <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                            {/if}
                        </span>
                    </h3>
                    <P>{if $data['ps']}{$data.ps}{else}这家伙很懒没有留下签名{/if}</P>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="user_tongji">
    <div class="user_tongji_bg">
        <li>
                <a href="{#HYBBS_URL('coterie','follow')}">{$user.follow} <span>关注</span></a>
        </li>
        <li>
                <a href="javascript:;" data-ydui-actionsheet="{target:'#actionSheet',closeElement:'#cancel'}">{$user.fans} <span>粉丝</span></a>
        </li>
        <li>
                <a href="{#HYBBS_URL('my',$user['user'],'log')}" data-pjax>{$user.gold} <span>金币</span></a>
        </li>
    </div>
</div>
<div class="g-view">
    <div style="margin-top:50px;"></div>
    <div class="user_zil">
        <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'])}" data-pjax>个人主页</a></div>
                <a class="cell-right cell-arrow" href="{#HYBBS_URL('my',$user['user'])}" data-pjax></a>
            </div>
        
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'],'thread')}" data-pjax>我的帖子</a></div>
                <a class="cell-right cell-arrow" href="{#HYBBS_URL('my',$user['user'],'thread')}" data-pjax>{$user.threads}</a>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'],'collection')}" data-pjax>我的收藏</a></div>
                <a class="cell-right cell-arrow" href="{#HYBBS_URL('my',$user['user'],'collection')}" data-pjax>{$collection}</a>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'],'post')}" data-pjax>我的回帖</a></div>
                <a class="cell-right cell-arrow" href="{#HYBBS_URL('my',$user['user'],'post')}" data-pjax>{$user.posts}</a>
            </div>
            <div class="cell-item">
                <div class="cell-left">我的UID</div>
                <div class="cell-right">{$user.uid}</div>
            </div>
        </div>
        <div class="m-cell" style="margin: 10px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <?php
                $Uvip = S('uvip');
                $vip_data = $Uvip->find('*',['uid'=>$data['uid']]);
            ?>
            <div class="cell-item">
                <div class="cell-left">我的 VIP</div>
                <a href="{#HYBBS_URL('my',$data['user'],'vip')}" class="cell-right cell-arrow" data-pjax>{if $vip_data}到期时间:{#date('Y-m-d',$vip_data['atime'])}{else}未开通{/if}</a>
            </div>
            <div class="cell-item">
                <div class="cell-left">用户认证</div>
                <div class="cell-right cell-arrow" {if $data['renzheng'] == 0}onclick="shenqing()"{/if}>{if $data['renzheng']}已认证{else}未认证{/if}</div>
            </div>
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'],'mytag')}" data-pjax>我的标签</a></div>
                <?php 
                    $usertagid = S('user')->find('tagid',['uid'=>$user['uid']]);
                    $usertag = S('user_tag')->find('*',['tag_id'=>array_filter(explode(",",$usertagid))]);
                ?>
                <a href="{#HYBBS_URL('my',$user['user'],'mytag')}" data-pjax class="cell-right cell-arrow"><?php echo $usertag['name'];?></a>
            </div>
            {hook nd_my_0}
            <div class="cell-item">
                <div class="cell-left"><a href="{#HYBBS_URL('my',$user['user'],'op')}" data-pjax>账号设置</a></div>
                <a class="cell-right cell-arrow" href="{#HYBBS_URL('my',$user['user'],'op')}" data-pjax></a>
            </div>
            <div class="cell-item">
                <a href="{#HYBBS_URL('user','out')}" class="btn-block btn-danger" style="margin: 10px 10px 10px 0;height: 40px;line-height: 40px;">退出登录</a>
            </div>
        </div>
    </div>
</div>
<script>
    function shenqing(){
        dialog.confirm('申请认证码?', '通过认证后名称后面会显示认证标志', function () {
            $.ajax({
                type: "post",
                url: "{#HYBBS_URL('plugins','shenqing')}",
                data: {uid:'{$data.uid}'},
                dataType: "json",
                success: function (e) {
                    if(e.error){
                        dialog.toast(e.info, 'none', 1000);
                    }else{
                        dialog.toast(e.info, 'none', 1500);
                    }
                }
            });
        });
    }
</script>
<script>
    $(function () {
        $('[data-ydui-actionsheet]').click(function(){
            if(!$('.tab-nav-item:eq(1)').hasClass('tab-active')){
                $(".tab-nav-item:eq(1)").trigger("click");
            }
            $('#actionSheet').addClass('m-bg');
        })
    });
</script>
{include common/foot}