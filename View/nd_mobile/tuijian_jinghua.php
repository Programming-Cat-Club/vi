<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>精华文章</h4>
    </div>
    <article class="m-list list-theme1">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                'jing'=>1,
                // 'img[!]'=>'',
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','jinghua')  //返回4条
            ]);
        ?>
        <div class="swiper-2">
            <div class="swiper-wrapper">
                {foreach $tuidata as $v}
                <div class="swiper-slide" style="padding:0 10px;">
                <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax class="list-item" style="width:100%;padding:0;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);margin-bottom: 10px;">
                    <div class="list-img" style="padding:0;height:160px;border-radius: 5px 5px 0 0;box-shadow: none;position: relative;">
                        <span style="position: absolute;background: #70d3ff;color: #fff;padding: 2px 6px;border-radius: 5px 0;">{php echo $forum[$v['fid']]['name']}</span>
                        {if $v['img']}
                        {php $img = explode(',',$v['img'])}
                        {/if}
                        <img class="lazyload swiper-lazy" src="{#WWW}View/nd_mobile/img/load_q.svg" data-src="{if $v['img']}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
                        
                        <span style="position: absolute;right: 10px;bottom: 10px;padding: 2px 6px;border-radius: 2px;color: #fff;align-items: center;display: flex;font-size: 14px;text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);"><i class="iconfont icon-yduizuji" style="font-size: 14px;"></i>&nbsp;{$v.views}</span>
                    </div>
                    <div class="list-mes" style="background:#fff;padding:8px 10px;border-radius:0 0 5px 5px;">
                        <h3 class="list-title" style="font-size:14px">{$v.title}</h3>
                    </div>
                </a>
                </div>
                {/foreach}
            </div>
        </div>

        <!-- Initialize Swiper -->
        <script>
            var swiper1 = new Swiper('.swiper-2', {
            slidesPerView: 1,
            lazy: {
                lazyLoading: true,
            },
            spaceBetween : -13,
            });
        </script>
    </article>
</div>