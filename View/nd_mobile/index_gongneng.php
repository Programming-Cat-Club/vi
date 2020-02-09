<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<style>
    .forum_list{
        margin: 10px;
        border-radius: 5px;
        box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);
    }
</style>
<style>
    .dis .swiper-container {
      width: 100%;
      height: auto;
      margin-left: auto;
      margin-right: auto;
    }
    .dis .swiper-slide {
      text-align: center;
      font-size: 16px;
      height: 85px;
      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
    .dis>.swiper-pagination-bullets{
        bottom: 10px;
    }
  </style>
  <!-- Swiper -->
  <div style="margin: 10px;padding: 10px 0px 20px;background: #fff;overflow: hidden;border-radius: 5px;box-shadow:0 3px 17px -7px rgba(96, 125, 139, 0.31);position: relative;">

      <div class="dis">
        <div class="swiper-wrapper">
            {php $forums = S('forum')->select('*',['id'=>explode(",",view_form('nd_mobile','bankuai'))]);}
            {foreach $forums as $key => $v}
            <div class="swiper-slide">
                <a href="{#HYBBS_URL('forum',$v['id'])}" data-pjax>
                    <div>
                        <img src="{#WWW}upload/forum{$v.id}.png" style="width: 45px;height: 45px;border-radius: 50%;" onerror="this.src='{#WWW}upload/de.png'" alt="{$v.name}">
                        <p style="width: 100%;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;color: #444;font-size: 14px;">{$v.name}</p>
                    </div>
                </a>
            </div>
            {/foreach}
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>
  </div>
  <!-- Initialize Swiper -->

  <script>
    var swiper = new Swiper('.dis', {
      slidesPerView: 4,
      slidesPerColumn: 2,
      spaceBetween: 0,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  </script>