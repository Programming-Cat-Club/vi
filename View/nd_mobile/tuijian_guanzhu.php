<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>推荐关注</h4>
    </div>
        <article class="m-list list-theme1">
            <?php
                $num = view_form('nd_mobile','guanzhu');
                $pdo = S('Plugin')->query("select * from hy_user order by rand() limit $num");
                $data = $pdo->fetchAll(\PDO::FETCH_ASSOC);
                // 查询最新推送的4条数据
            ?>
            <div class="swiper-container guanzhu">
                <div class="swiper-wrapper" style="margin: 10px 0;">
                    {foreach $data as $v}
                    <div class="swiper-slide tuijian_guanzhu_1" style="padding:0 10px;">
                        <div style="text-align: center;background: #fff;padding: 15px 10px;border-radius: 5px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
                            <a href="{#HYBBS_URL('my',$v['user'])}">
                                <div style="position: relative;">
                                    <span style="position: relative;">
                                    {if is_vip($v['uid'])}<i style="position: absolute;left: -7px;font-size: 2.5rem;top: -64px;color: #FF5722;transform: rotate(274deg);" class="iconfont icon-huangguan2"></i>{/if}
                                    <img class="swiper-lazy" src="{#WWW}View/nd_mobile/img/load_q_2.svg" data-src="{#WWW}{php echo get_avatar($v['uid'])['b']}" style="border-radius: 50%; width: 65px;{if is_vip($v['uid'])}border:3px solid #FF5722;{/if}">
                                
                                    </span>
                                </div>
                                <?php

                                ?>
                                <div class="name">
                                <?php
                                    $renzheng_inc = get_plugin_inc('nd_website_plus');
                                ?>
                                <span class="user_name" style="{if is_vip($v['uid'])}color:{$renzheng_inc.color}{/if}">
                                    {$v.user}
                                    <?php
                                    // 查询验证
                                    $is_renzheng = S('user')->find('renzheng',['uid'=>$v['uid']]);
                                    ?>
                                    {if $is_renzheng}
                                    <i style="color:{$renzheng_inc.yan_color}" class="iconfont icon-renzheng"></i>
                                    {/if}
                                </span>
                                </div>
                                <div class="thread">帖子 {$v.threads}</div>
                                <div class="sign">{if $v['ps']}{$v.ps}{else}还没有留下签名！{/if}</div>
                            </a>
                            <div>
                                <button class="{if $v['sex'] == 0}weizhi{elseif $v['sex'] == 1}nan_1{else}nv_1{/if}" onclick="friend({$v.uid},this)">{if M("Friend")->get_state(NOW_UID,$v['uid'])}取消关注{else}<i class="icon-plus"></i>关注{/if}</button>
                            </div>
                        </div>
                    </div>
                    {/foreach}
                </div>
                <script>
                    var swiper1 = new Swiper('.guanzhu', {
                        slidesPerView: 2,
                        spaceBetween : -13,
                        freeMode: true,
                        lazy: {
                            lazyLoading: true
                        },
                    });
                </script>
            </div>
        </article>
    </div>