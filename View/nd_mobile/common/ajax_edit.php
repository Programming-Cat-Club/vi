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
    .post .simditor .simditor-body{
        height: 100%
    }
    </style>
    <!-- 编辑 -->
    <div id="ajax_edit_page" class="m-actionsheet" style="height: 100%;">
        <header class="m-navbar navbar-fixed" style="background: #fff;">
            <a href="javascript:;" class="navbar-item" id="cancel-editor">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title1">帖子编辑</span>
            </div>
            <a href="javascript:;" class="navbar-item" id="post_edit" onclick="edit_thread()">
                发布
            </a>
        </header>
        <div class='g-view' style="overflow-y: scroll;height: 100%">
            <div class="user_thread" id="post_loading_edit">
                <div class="no_thread">
                    <div class="loading">
                        <i class="icon-loading"></i>
                    </div>
                    <p>加载中...</p>
                </div>
            </div>
            <div id="ajax_edit" >

            </div>
        </div>
    </div>

</div>