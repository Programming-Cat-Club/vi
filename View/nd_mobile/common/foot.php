    <?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
    <audio id="play-msg">
        <source src="{#WWW}View/nd_mobile/img/mess.mp3" type="audio/mp3">
    </audio>
    <div class="top" >
        {if ACTION_NAME == 'Forum' || ACTION_NAME == 'Thread'}
        <a href="{if !IS_LOGIN}{#HYBBS_URL('user','login')}{else}javascript:;{/if}" {if IS_LOGIN}data-ydui-actionsheet="{target:'#ajax_post_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{#HYBBS_URL('post')}','post')"{else}data-pjax{/if} style="background:rgba(3, 169, 244, 0.8);"><i class="icon-jia2"></i></a>
        {/if}
        <a href="javascript:;" onclick="top_t()"><i class="icon-fanhuidingbu"></i></a>
    </div>
    </div>
    <!-- 引入组件库 -->
    {hook nd_mobile_foot}
    <script src="{#WWW}View/nd_mobile/js/ydui.js?var={#ND_MOBILE_V}"></script>
          <!-- 用户 -->
    <script src="{#WWW}View/nd_mobile/js/hyphp.js?var={#ND_MOBILE_V}"></script>
    <script src="{#WWW}View/nd_mobile/js/app.js?var={#ND_MOBILE_V}"></script>  
</body>
</html>