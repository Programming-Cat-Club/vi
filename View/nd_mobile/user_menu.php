<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="user_ipc">
        {php $user_img = S('user_style')->find('*',['uid'=>$data['uid']]);}
        {php $inc = get_plugin_inc('nd_user_img');}
    <div style="background-image:url({if $user_img}{$user_img['img']}?r={#time()}{else}{$inc.user_d_img}{/if});" class="forum_thread_header">
        <div class="user_info">

        </div>
    </div>
</div>
