<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="nd_crde">

    {php $tmp = array_filter(explode("\r\n",view_form('nd_mobile','huodong_banner')))}
    <div style="position: relative;">
        <h4>{php echo view_form('nd_mobile','huodong_name')}</h4>
    </div>
    <article class="m-list list-theme1 yuedu" style="padding:0">
    <!-- Swiper -->
    <style>
    .yuedu .swiper-container-horizontal>.swiper-pagination-bullets{
        bottom: 25px;
    }
    .zhuanti .img_row{
        height: 130px;width:100%
    }
    .zhuanti .img_row img{
        width: 100%;height:100%;border-radius: 5px;box-shadow: 0 3px 17px -7px #607D8B;
    }
    </style>
    <div class="zhuanti">
        <div class="swiper-wrapper">
            {foreach $tmp as $v}
            {php $lianjie = explode("|",$v)}
            <div class="swiper-slide" style="padding: 10px;">
                <div class="img_row">
                    <a href="{$lianjie.0}">
                        <img class="swiper-lazy" src="{#WWW}View/nd_mobile/img/load_q.svg" data-src="{$lianjie.1}">
                    </a>
                </div>
            </div>
            {/foreach}
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <script>
        var swiper = new Swiper('.zhuanti',{
            lazy: {
                lazyLoading: true
            },
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
            },
        });
    </script>
    </article>
</div>