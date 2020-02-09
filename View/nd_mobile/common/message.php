<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

<div class="user_mess">
    <div id="actionSheet" class="m-actionsheet">
        <header class="m-navbar navbar-fixed">
            <a href="javascript:;" class="navbar-item" id="cancel">
                <i class="icon-cha"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title">消息</span>
            </div>
        </header>
        <div class="g-view">
            <div class="m-tab" id="haoyou">
                <!-- 这里添加data-ydui-tab就可以啦 -->
                <ul class="tab-nav">
                    <li class="tab-nav-item tab-active">
                        <a href="javascript:;">消息</a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">粉丝</a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">陌生人</a>
                    </li>
                </ul>
                <div class="tab-panel">
                    <div id="friend-1" class="tab-panel-item tab-active">
                    </div>
                    <div id="friend-3" class="tab-panel-item"></div>
                    <div id="friend-0" class="tab-panel-item"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- 聊天 -->
    <div id="liaotian" class="m-actionsheet m-bg">
        <header class="m-navbar navbar-fixed">
            <a href="javascript:;" class="navbar-item" id="cancel_liaotian">
                <i class="back-ico"></i>
            </a>
            <div class="navbar-center">
                <span class="navbar-title navbar-title3">系统消息</span>
            </div>
        </header>
        <div class="g-view">
            <div class="m-tab" data-ydui-tab>
                <!-- 这里添加data-ydui-tab就可以啦 -->
                <div class="tab-panel">
                    <div id="lt" class="tab-panel-item tab-active">
                    </div>
                </div>
            </div>
        </div>
        <footer class="m-tabbar tabbar-fixed">
            <div class="footer-center">
                <input id="msg-text" type="text" class="input-text">
                <div class="footer-right">
                    <button onclick="send_lt(1,this)" class="btn btn-primary" type="button" style="height:36px">Send</button>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    $(function(){
        var $tab = $('#haoyou');
        $tab.tab({
            nav: '.tab-nav-item',
            panel: '.tab-panel-item',
            activeClass: 'tab-active'
        })
    })
</script>