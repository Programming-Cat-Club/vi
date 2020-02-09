<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde" style="margin-top:0">
    <div style="position: relative;text-align:center">
        <h4>精彩贴图</h4>
    </div>
    <article class="m-list list-theme1 meitu" style="padding: 0 5px;">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                // 'jing'=>3,
                // 'fid'=>[1,2,3,4], //板块id
                'img[!]'=>'',
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','tupian')  //返回4条
            ]);
            $User = M('User');
        ?>
        {foreach $tuidata as $v}
        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax class="list-item">
            <div class="list-img" style="padding:0;height:150px;position: relative;">
            <span style="position: absolute;right: 10px;top: 10px;color: #fff;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);display: flex;align-items: center;"><i class="icon-zansel"></i> &nbsp;{$v.goods}</span>
                {if $v['img']}
                {php $img = explode(',',$v['img'])}
                {/if}
                <img class="lazyload" src="{#WWW}View/nd_mobile/img/load_q.svg" data-original="{if $v['img']}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
                <div class="list-mes" style="background: rgba(0, 0, 0, 0.22);height: 28px;">
                    <h3 class="list-title">{$v.title}</h3>
                </div>
            </div>
        </a>
        {/foreach}
        
    </article>
</div>