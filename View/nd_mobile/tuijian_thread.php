<div class="nd_content">
    <div style="position: relative;text-align:center">
        <h4>推荐阅读</h4>
    </div>
    <article class="m-list list-theme1" style="overflow-y: hidden;overflow-x: scroll;">
        <?php
            // 查询最新推送的4条数据
            $tuidata = M('Thread')->select('*',[
                'jing'=>5,
                // 'img[!]'=>'',
                'ORDER'=>['atime'=>'DESC'],
                'LIMIT'=>view_form('nd_mobile','tuijian_thread')  //返回4条
            ]);
            $User = M('User');
        ?>
        <div style="width:9999px">
        {foreach $tuidata as $v}
        <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax class="list-item" style="width:190px;border:1px solid #e0e0e0;padding:0;margin:0 2px;">
            <div class="list-img" style="padding:0;height:160px;">
                {if $v['img']}
                {php $img = explode(',',$v['img'])}
                {/if}
                <img class="lazyload" src="{#WWW}View/nd_mobile/img/load_q.svg" data-original="{if $v['img']}{$img.0}{else}{#WWW}View/nd_mobile/img/nopic.png{/if}">
            </div>
            <div class="list-mes" style="background:#eee;">
                <h3 class="list-title">{$v.title}</h3>
                <div class="list-mes-item">
                    <div>
                        <span class="list-price">
                            <em style="color:rgba(3, 169, 244, 0.92)">{php echo $forum[$v['fid']]['name']}</em></span>
                        <span>{php echo humandate($v['atime']);}</span>
                    </div>
                    <div>{php echo $User->uid_to_user($v['uid'])}</div>
                </div>
            </div>
        </a>
        {/foreach}
        </div>
        
    </article>
</div>