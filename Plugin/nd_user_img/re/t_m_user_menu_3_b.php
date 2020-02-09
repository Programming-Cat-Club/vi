*/
?>
<!--{hook t_m_user_menu_3}-->
{php $user_img = S('user_style')->find('*',['uid'=>$data['uid']]);}
{if $user_img}
<style>
    .user-index-top{
        background: url({$user_img['img']}?r={#time()}) no-repeat 0 0;
        background-size: cover;
    }
</style>
{else}
{php $inc = get_plugin_inc('nd_user_img');}
<style>
    .user-index-top{
        background: url({$inc.user_d_img}) no-repeat 0 0;
        background-size: cover;

    }
</style>
{/if}
<!--{hook t_m_user_menu_1}-->
<div class="user-index-top">
	<div>
		<img src="{#WWW}{$data.avatar.a}">
        <p style="margin-top: 14px;color: rgba(255, 255, 255, 0.91);font-size: 14px;"><span>{$_LANG['关注']} {$data.follow}</span> <span style="margin:0 10px;color:#bdbdbd">|</span> <span>{$_LANG['粉丝']} {$data.fans}</span></p>
        <!--{hook t_m_user_menu_2}-->
        <p style="margin-top: 14px;color: rgba(255, 255, 255, 0.91);font-size: 14px;text-shadow: 2px 1px 10px rgba(0, 0, 0, 0.64);">
		<span>{$data.ps}</span>
		</p>
	</div>
</div>
<!--{hook t_m_user_menu_3}-->