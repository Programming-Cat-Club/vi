<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="m-slider" style="height: 220px;margin-top:-50px;" id="J_Slider">
   
        <!-- 参数在这里 -->
    <div class="slider-wrapper">
    {php $tmp = array_filter(explode("\r\n",view_form('nd_mobile','huandeng')))}

    {foreach $tmp as $sky=>$v}
    {php $tmp1 = explode(",",$v)}
        <div class="slider-item">
            <a href="{$tmp1.0}">
                <img src="{$tmp1[2]}" style="height: 100%;">
            </a>
            <div class="title">{$tmp1[1]}</div>
        </div>
    {/foreach}
    </div>
    <!-- 分页标识 -->
</div>
<div style="position: relative;">
    <div class="imui_water cube">
        <div class="imui_water_1"></div>
        <div class="imui_water_2"></div>
    </div>
</div>
<script>
    $(function(){
        $('#J_Slider').slider({
            speed: 200,
            autoplay: 2000,
            lazyLoad: true
        });
    })
</script>