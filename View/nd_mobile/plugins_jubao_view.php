<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
{include common/header}
<style>
    .jubao_view{
        background: #fff;padding: 15px;margin-top: 15px;font-size: 16px;
    }
    .jubao_view div{
        padding: 10px 0;
    }
</style>
<div class="g-view">
    <div class="jubao_view">
        <?php
            $state = explode(',',$data['state']);
            $juser = M('User')->uid_to_user($data['uid']);
        ?>
        <div>标题：<a href="{#HYBBS_URL('thread',$data['tid'])}" data-pjax>{$data.title}</a></div>
        <div>时间：{#date('Y-m-d h:s',$data['atime'])}</div>
        <div>
            原因：
            {foreach $state as $v}
                {if $v == 1} <span>诱导行为</span> {/if}
                {if $v == 2} <span>欺诈</span> {/if}
                {if $v == 3} <span>色情</span> {/if}
                {if $v == 4} <span>违法犯罪</span> {/if}
                {if $v == 5} <span>骚扰</span> {/if}
                {if $v == 6} <span>其他</span> {/if}
            {/foreach}
        </div>
        <div>描述：{if $data['mess']}{$data.mess}{else}暂无描述！{/if}</div>
        <div>举报人：{if $data['uid']==0}游客{else} <a href="{#HYBBS_URL('my',$juser)}" data-pjax>{$juser}</a> {/if}</div>
        <div style="text-align: center">
            <button class="btn btn-danger" onclick="del_jubao({$data['tid']})">删除举报信息</button>
            <a href="{#HYBBS_URL('thread',$data['tid'])}" data-pjax class="btn btn-primary">查看帖子信息</a>
        </div>
    </div>
</div>
{include common/footer}
{include common/foot}