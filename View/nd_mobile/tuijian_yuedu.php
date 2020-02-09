<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>推荐阅读</h4>
    </div>
    <article class="m-list list-theme1" style="padding: 0 5px;">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                'jing'=>5,
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','tuijian')  //返回4条
            ]);
            $User = M('User');
        ?>
        {foreach $tuidata as $v}
        <div style="box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax class="list-item" style="padding:0 5px;margin-bottom: 10px;">
                <div class="list-img" style="padding:0;height:130px;position: relative;box-shadow: none;border-radius: 5px 5px 0 0">
                    <span style="position: absolute;background: #70d3ff;color: #fff;padding: 0px 2px;border-radius: 4px 0;">{php echo $forum[$v['fid']]['name']}</span>
                    {if $v['img']}
                    {php $img = explode(',',$v['img'])}
                    {/if}
                    <img class="lazyload" src="{#WWW}View/nd_mobile/img/load_q.svg" data-original="{if $v['img']}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
                    <span style="position: absolute;right: 10px;bottom: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 12px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size:12px;"></i>&nbsp;{$v.views}</span>
                </div>
                <div class="list-mes" style="background:#fff;padding:8px 10px;border-radius:0 0 5px 5px;box-shadow: 0 3px 14px -7px rgba(96, 125, 139, 0.31)">
                    <h3 class="list-title" style="font-size:14px">{$v.title}</h3>
                </div>
            </a>
        </div>
        {/foreach}
    </article>
</div>