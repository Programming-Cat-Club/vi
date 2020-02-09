{include common/header}
<div class="g-view">
    <div class="m-cell demo-small-pitch" style="margin-top: 10px;">
        <form id="user-login-form" method="post" onsubmit="return user_login()">
            <div class="cell-item">
                <div class="cell-right">
                    <input type="text" name="user" class="cell-input" placeholder="用户名" autocomplete="off">
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="password" name="pass" class="cell-input" placeholder="密码" autocomplete="off">
                </div>
            </div>
        </form>
        </div>
        <div style="margin:0 10px;"><button id="login" class="btn-block btn-primary">登录</button></div>
        <div class="cell-item">
            <div class="cell-left"><a href="{#HYBBS_URL('user','repass')}" data-pjax style="color: #2196F3">忘记了密码？</a></div>
            <div class="cell-right" style="font-size: 15px;"><a href="{#HYBBS_URL('user','add')}" data-pjax style="color: #2196F3">现在注册</a></div>
        </div>
        <style>
            .icondenglu{
                justify-content: center;
                align-items: center;
                display: flex;
                margin-top: 10px;
            }
            .icondenglu a {
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 100%;
                background: #03a9f4;
                color: #fff;
            }
            .icondenglu a i{
                font-size: 24px;
            }

        </style>
        <div  class="icondenglu">
            {if get_plugin_install_state('hy_qq_login')}
            {if is_plugin_on('hy_qq_login')}
            <a href="{#HYBBS_URL('user','qqlogin')}" class="btn btn-outline-info btn-icon rounded-circle mr-3">
                <i class="iconfont icon-qq"></i>
            </a>
            {/if}
            {/if}
            {if get_plugin_install_state('hy_weixin_login')}
                {if is_plugin_on('hy_weixin_login')}
                <a href="{#HYBBS_URL('user','weixin_login')}" class="btn btn-outline-success btn-icon rounded-circle mr-3" style="margin-left:10px;background:#35b94c;">
                      <div><i class="fa fa-weixin"></i></div>
                </a>
                {/if}
            {/if}
            {if get_plugin_install_state('hy_weibo_login')}
                {if is_plugin_on('hy_weibo_login')}
                <a href="{#HYBBS_URL('user','weibologin')}" class="btn btn-outline-danger btn-icon rounded-circle" style="margin-left:10px;background:#ef4f4f;">
                        <i class="iconfont icon-weibo"></i>
                </a>
                {/if}
            {/if}
        </div>
    <script>
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-login-form').serialize();
            $("#login").attr('disabled','disabled').text('正在登录中...');
            <!--{hook t_user_login_js_1}-->
            $.ajax({
                url:"{php HYBBS_URL('user','login')}",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    <!--{hook t_user_login_js_2}-->
                    $("#login").removeAttr('disabled').text('登录');
                    if(e.error){
                        if(e.url !='')
                            window.location.href=e.url;
                        else
                            window.location.href="{#WWW}";
                    }else{
                        // $.hy.warning(e.info);
                        dialog.toast(e.info, 'none', 1000);
                    }
                    <!--{hook t_user_login_js_3}-->
                },
                error:function(e){
                    <!--{hook t_user_login_js_33}-->
                    $("#login").removeAttr('disabled').text('登录');
                }
            });
            <!--{hook t_user_login_js_4}-->
            return false;
        })
    </script>
</div>