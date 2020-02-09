<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<link rel="stylesheet" type="text/css" href="{#WWW}View/nd_mobile/src/GridLoadingEffects/css/default.css" />
<link rel="stylesheet" type="text/css" href="{#WWW}View/nd_mobile/src/GridLoadingEffects/css/component.css" />
<style>
    /* Effect 4: fall perspective */

    .grid.effect-4 {
        perspective: 1300px;
    }

    .grid.effect-4 li {
        transform-style: preserve-3d;
    }

    .grid.effect-4 li.animate {
        transform: translateZ(400px) translateY(300px) rotateX(-90deg);
        animation: fallPerspective .8s ease-in-out forwards;
    }

    @keyframes fallPerspective {
        100% {
            transform: translateZ(0px) translateY(0px) rotateX(0deg);
            opacity: 1;
        }
    }
</style>
<ul class="grid effect-4" id="grid">
    <!--ajax-index start-->
    {foreach $data as $v}
    <li class="shown">
        {php $img = array_filter(explode(',',$v['img']));}
        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
            <img src="{if isset($img['0'])}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
        </a>
        <div style="background: #fff;padding: 5px;">
            <div style="font-size: 14px;text-transform: capitalize;">
                <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>{$v.title}</a>
            </div>
            <div style="position: relative;">
                <a href="{#HYBBS_URL('my',$v['user'])}" data-pjax>{$v['user']}</a>
                <div style="position: absolute;right: 0;top: 0">
                    <span style="margin-right: 10px;">
                        <i class="iconfont icon-yduizuji"></i> {$v.views}
                    </span>
                    <span>
                        <i class="icon-huifu1"></i> {$v.posts}
                    </span>
                </div>
            </div>
        </div>

    </li>

    {/foreach}
    <!--ajax-index end-->
</ul>

