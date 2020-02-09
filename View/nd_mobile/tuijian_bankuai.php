<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>{php echo view_form('nd_mobile','title')}</h4>
    </div>
        <article class="m-list list-theme1">
            <?php
                // 查询最新推送的4条数据
                $tuidata = M('Thread')->select('*',[
                    // 'jing'=>5,
                    'fid'=>view_form('nd_mobile','fid'),
                    'ORDER'=>['atime'=>'DESC'],
                    'LIMIT'=>view_form('nd_mobile','tiaoshu')  //返回4条
                ]);
                $User = M('User');
            ?>
            <style>
            </style>
            <div class="swiper-container swiper-2">
                <div class="swiper-wrapper">
                    {foreach $tuidata as $v}
                    <div class="swiper-slide" style="padding:0 10px;">
                    <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax class="list-item" style="width:100%;padding:0">
                        <div class="list-img" style="padding:0;height:160px;position: relative;box-shadow:none;border-radius:5px 5px 0 0;">
                            <span style="position: absolute;right: 10px;top: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 14px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size: 14px;"></i>&nbsp;{$v.views}&nbsp;&nbsp;<i class="iconfont icon-huifu1" style="font-size: 14px;"></i>&nbsp;{$v.posts}</span>
                            {if $v['img']}
                            {php $img = explode(',',$v['img'])}
                            {/if}
                            <img class="lazyload swiper-lazy" src="{#WWW}View/nd_mobile/img/load_q.svg" data-src="{if $v['img']}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
                        </div>
                        <div class="list-mes" style="background: #fdfdfd;box-shadow: 0 3px 17px -10px #607D8B;margin-bottom: 10px;border-radius: 0 0 5px 5px;padding: 10px;">
                            <h3 class="list-title" style="font-size: 16px;">{$v.title}</h3>
                            <div class="list-mes-item" style="font-size: 14px;text-transform: capitalize;">
                                <div>
                                    <span class="list-price" style="color:rgba(3, 169, 244, 0.92)">
                                        {php echo $forum[$v['fid']]['name']}</span>
                                    <span>{php echo humandate($v['atime']);}</span>
                                </div>
                                <div>{php echo $User->uid_to_user($v['uid'])}</div>
                            </div>
                        </div>
                    </a>
                    </div>
                    {/foreach}
                </div>
            </div>
        </article>
    </div>