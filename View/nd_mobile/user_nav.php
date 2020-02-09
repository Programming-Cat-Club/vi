<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="user_nav">
    <div class="m-grids-5">
        <a href="{#HYBBS_URL('my',$data['user'])}" data-pjax class="grids-item {$menu_action.index}">
            <div class="grids-txt">
                <span>主页</span>
            </div>
        </a>
        <a href="{#HYBBS_URL('my',$data['user'],'thread')}" data-pjax class="grids-item {$menu_action.thread}">
            <div class="grids-txt">
                <span>文章</span>
            </div>
        </a>
        <a href="{#HYBBS_URL('my',$data['user'],'post')}" data-pjax class="grids-item {$menu_action.post}">
            <div class="grids-txt">
                <span>回帖</span>
            </div>
        </a>
        <a href="{#HYBBS_URL('my',$data['user'],'collection')}" data-pjax class="grids-item {$menu_action.collection}">
            <div class="grids-txt">
                <span>收藏</span>
            </div>
        </a>
        <a href="{#HYBBS_URL('my',$data['user'],'visitor')}" data-pjax class="grids-item {$menu_action.visitor}">
            <div class="grids-txt">
                <span>访客</span>
            </div>
        </a>
    </div>
</div>