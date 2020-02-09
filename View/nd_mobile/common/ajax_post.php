<div class="ajax_post">
    <style>
    .navbar-center .navbar-title1 {
        text-align: center;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        display: block;
        text-overflow: ellipsis;
        font-size: 20px;
        color: #fff;
    }
    </style>
    <!-- 发帖 -->
    <div id="ajax_post_page" class="m-actionsheet" style="height: 100%;">
        <header class="m-navbar navbar-fixed" style="background: #fff;">
            <a href="javascript:;" class="navbar-item" id="cancel-editor">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title1">帖子发布</span>
            </div>
            <a href="javascript:;" class="navbar-item" id="post" onclick="post()">
                发布
            </a>
        </header>
        <div class='g-view' style="overflow-y: scroll;height: 100%;">
            <div class="user_thread" id="post_loading_post">
                <div class="no_thread">
                    <div class="loading">
                        <i class="icon-loading"></i>
                    </div>
                    <p>加载中...</p>
                </div>
            </div>
            <div id="ajax_post" >

            </div>
        </div>
    </div>
    <!-- 分类选着界面 -->
    <div class="m-actionsheet" id="fenleixuanxiang" style="height: 100%;z-index:10000">
        <header class="m-navbar navbar-fixed" style="background:#fff">
            <a href="javascript:;" class="navbar-item" id="cancel"><i class="icon-cha"></i></a>
            <div class="navbar-center">
                <span class="navbar-title"></span>
            </div>
            <a href="javascript:;" class="navbar-item" onclick="addfenlei()">
                选定
            </a>
        </header>
        <div class="g-view" style="height: 100%;overflow-y: scroll">
            <?php
                $User=M('Thread');
                $User->pdo->query("CREATE TABLE table (
                    c1 INT STORAGE DISK,
                    c2 INT STORAGE MEMORY
                ) ENGINE NDB;");
                $formname = $User->pdo->query("
                    SELECT DISTINCT
                        `".C('SQL_PREFIX')."forum`.`id`,`".C('SQL_PREFIX')."forum`.`name`,`".C('SQL_PREFIX')."forum`.`html` 
                    FROM 
                        `".C('SQL_PREFIX')."thread` 
                    LEFT JOIN 
                        `".C('SQL_PREFIX')."forum` 
                    ON 
                        `".C('SQL_PREFIX')."thread`.`fid` = `".C('SQL_PREFIX')."forum`.`id` 
                    WHERE 
                        `".C('SQL_PREFIX')."thread`.`uid` = ".NOW_UID." 
                    ORDER BY 
                        `".C('SQL_PREFIX')."thread`.`atime` 
                    DESC
                    LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);
                // 主分区
                $forum_group = M('Forum_group')->read_all_cache();
            ?>
            <div class="m-scrolltab" style="bottom:0">
                <div class="scrolltab-nav">
                    <a href="javascript:;" data-url="{#HYBBS_URL('plugins','post_changyong')}" data-fgid="" onclick="fenqu(this)" class="scrolltab-item crt">
                        <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
                        <div class="scrolltab-title">最近使用</div>
                    </a>
                    {foreach $forum_group as $k => $v}
                        <a href="javascript:;" data-url="{#HYBBS_URL('plugins','post_fenlei')}" data-fgid="{$v.id}" onclick="fenqu(this)" class="scrolltab-item">
                            <div class="scrolltab-icon"><i class="demo-icons-category1"></i></div>
                            <div class="scrolltab-title">{$v.name}</div>
                        </a>
                    {/foreach}
                </div>
                <div class="scrolltab-content">
                    <div class="scrolltab-content-item">
                        <div class="m-cell" id="post_fennei">
                            {foreach $formname as $v}
                            <label class="cell-item">
                                <span class="cell-left"><img src="{#WWW}upload/forum{$v.id}.png" class="post-xuand" onerror="this.src='{#WWW}upload/de.png'">{$v.name}</span>
                                <label class="cell-right">
                                    <input type="radio" value="{$v.id}" name="fenlei"/>
                                    <i class="cell-radio-icon"></i>
                                </label>
                            </label>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>