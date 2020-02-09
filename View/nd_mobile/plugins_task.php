
<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">{$title}</span>
    </div>

</header>
<style>
    .right span {
        width: inherit;
    }
    .m-celltitle {
        padding: 0 20px 8px;
        font-size: 15px;
        text-align: left;
        color: #888;
        position: relative;
        z-index: 1;
        margin-bottom: -10px;
        margin-top: 15px;
    }
</style>
 {php $inc = get_plugin_inc("nd_website_plus");}
<div class="g-view">
    <div class="m-celltitle">完成每日任务可以获得相应的奖励</div>
    <div class="lookfor">
        <ul id="user_thread">
            <li>
                <div class="content">
                    <a href="{#HYBBS_URL('plugins','sign')}">
                        <h1>
                            每日签到
                        </h1>
                    </a>
                    <p>每日签到，签到送大量金币。</p>
                </div>
                <div class="right" class="actionsheet-item">
                    {if date("Y-d",strtotime(S('user_sign')->find('lastModifyTime',['sign_uid'=>NOW_UID]))) == date("Y-d")}
                    <span class="badge badge-radius badge-primary" style="background: #04BE02">已完成</span>
                    {else}
                    <span class="badge badge-radius badge-danger" style="background: #EF4F4F">未完成</span>
                    {/if}
                </div>
            </li>
            <li>
                <div class="content">
                    <a href="{#HYBBS_URL('post')}">
                        <h1>
                            发表主题（{$inc['thread']}金币）
                        </h1>
                    </a>
                    <p>发表主题奖励金币，每日最多可以获得{$inc['thread_cishu']}次奖励。</p>
                </div>
                <div class="right" class="actionsheet-item">
                    {if $thread_state}
                    <span class="badge badge-radius badge-primary" style="background: #04BE02">已完成</span>
                    {else}
                    <span class="badge badge-radius badge-danger" style="background: #EF4F4F">未完成</span>
                    {/if}
                </div>
            </li>
            <li>
                <div class="content">
                    <a href="{#WWW}">
                        <h1>
                            评论帖子（{$inc['post']}金币）
                        </h1>
                    </a>
                    <p>发表评论奖励金币，每日最多可以获得{$inc['post_cishu']}次奖励。</p>
                </div>
                <div class="right" class="actionsheet-item">
                    {if $post_state}
                    <span class="badge badge-radius badge-primary" style="background: #04BE02">已完成</span>
                    {else}
                    <span class="badge badge-radius badge-danger" style="background: #EF4F4F">未完成</span>
                    {/if}
                </div>
            </li>
            <li>
                <div class="content">
                    <a href="{#HYBBS_URL('my',$user['user'],'op')}">
                        <h1>
                            上传头像（{$inc['touxiang']}金币）
                        </h1>
                    </a>
                    <p>上传我的头像</p>
                </div>
                <div class="right" class="actionsheet-item">
                    {if $this->_user['avatar_state'] == 1}
                    <span class="badge badge-radius badge-primary" style="background: #04BE02">已完成</span>
                    {else}
                    <span class="badge badge-radius badge-danger" style="background: #EF4F4F">未完成</span>
                    {/if}
                </div>
            </li>
            <li>
                <div class="content">
                    <a href="{#HYBBS_URL('my',$user['user'],'op')}">
                        <h1>
                            激活邮箱（{$inc['email']}金币）
                        </h1>
                    </a>
                    <p>验证邮箱可以用于找回密码，以及接收系统重要邮件。</p>
                </div>
                <div class="right" class="actionsheet-item">
                    {if $user['email_state']==1}
                    <span class="badge badge-radius badge-primary" style="background: #04BE02">已完成</span>
                    {else}
                    <span class="badge badge-radius badge-danger" style="background: #EF4F4F">未完成</span>
                    {/if}
                </div>
            </li>
        </ul>
    </div>
</div>
{include common/footer}
{include common/foot}