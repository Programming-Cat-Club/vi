{php $thread_user = M('Thread')->select('*',['uid'=>$thread_data['uid'],'tid[!]'=>$thread_data['tid'],'ORDER'=>['atime'=>'DESC'],'LIMIT'=>4])}
{if $thread_user}
<div class="nd_crde louzhu_thread">
    <div style="position: relative;">
        <h4>楼主帖子</h4>
    </div>
    <div class="m-cell thread_user_tz">
        {foreach $thread_user as $user_val}
            <a class="cell-item" href="{#HYBBS_URL('thread',$user_val['tid'])}" data-pjax>
                <div class="cell-left"><i class="icon-mn_xiaoxi2"></i>&nbsp;{$user_val['title']}</div>
                <div class="cell-right"></div>
            </a>
        {/foreach}
    </div>
</div>
{/if}