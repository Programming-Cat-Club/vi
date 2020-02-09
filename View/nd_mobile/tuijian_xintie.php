<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<style>
.xintie li{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-size: 14px;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 5px
}
.xintie li .user_img{
    display: flex;
    align-items: center;
}
.xintie li .user_img img{
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 5px;
}
.xintie li em{
    color: #9a9a9a;
}
.xintie li a{
    width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    color: #444;
}
.xintie span{
    color: #8c8c8c;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
<div class="nd_crde">
    <div style="position: relative;text-align:center">
        <h4>社区新帖</h4>
    </div>
        <article class="m-list list-theme1" style="background: #fff;border-radius: 5px;margin: 10px;padding: 10px;box-shadow: 0 3px 17px -7px rgba(96, 125, 139, 0.31);">
            <?php
                // 查询最新推送的4条数据
                $tuidata = M('Thread')->select('*',[
                    'ORDER'=>['atime'=>'DESC'],
                    'LIMIT'=>view_form('nd_mobile','xintie')  //返回4条
                ]);
            ?>
            <ul class="xintie">
                {foreach $tuidata as $k=>$v}
                <li><div class="user_img"><img src="{#get_avatar($v['uid'])['c']}" alt=""></div><a data-pjax href="{#HYBBS_URL('thread',$v['tid'])}">{$v.title} <em>{php echo humandate($v['atime'])}</em></a></li>
                {/foreach}
            </ul>
        </article>
    </div>