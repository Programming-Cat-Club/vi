<div class="g-view" style="background:#fff;height:100vh">
    <header class="m-navbar navbar-fixed" style="background: #fff;padding: 0.75rem;">
        <a href="javascript:history.back(-1);" class="navbar-item" style="color:#6f17ff">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title"></span>
        </div>
    </header>
    <section>
        <style>
            .g-view:after{
                height:0px;
            }
        </style>
        <div style="text-align: center;">
            <img src="{#WWW}View/nd_mobile/img/extreme.png" style="margin-top:1.8rem;width: 6rem;">
        </div>
        <form id="user-login-form" method="post" onsubmit="return user_login()">
            <!--{hook t_m_user_login_1}-->
            <div style="margin:1.8rem">
                <input class="login_input" type="text" name="user" placeholder="用户名">
            </div>
            <!--{hook t_m_user_login_2}-->
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass" placeholder="密码">
            </div>
            <!--{hook t_m_user_login_3}-->
            <!--{hook t_m_user_login_33}-->
            <div style="margin:1.8rem 1.8rem 0">
                <button class="login_button" id="login">登录</button>
            </div>
        </form>
        <div style="margin: 25px 1.8rem 10px;display: flex;justify-content: space-between;">
            <a href="{#HYBBS_URL('user','repass')}" class="login_zhaohui">忘记了密码？</a>
            <a href="{#HYBBS_URL('user','add')}" class="login_zhaohui">现在注册一个</a>

        </div>
        <div style="text-align: center;margin-top:2rem;width: 100%;">
            <div class="login_disanf">
                <span></span>
            </div>
            <div class="login_disanf_btn">
                {if is_plugin_on('hy_qq_login')}
                <a href="{php HYBBS_URL('user','qqlogin')}" class="btn btn-icon login_icon login_icon_qq"><div><i class="icon-qq1"></i></div></a>
                {/if}
                {if is_plugin_on('hy_weibo_login')}
                <a href="{php HYBBS_URL('user','weibologin')}" class="btn btn-icon login_icon login_icon_wb"><div><i class="icon-weibo1"></i></div></a>
                {/if}
                {if is_plugin_on('hy_weixin_login')}
                <a href="{php HYBBS_URL('user','weixin_login')}" class="btn btn-icon login_icon login_icon_wx"><div><i class="icon-weixin"></i></div></a>
                {/if}
                <!--{hook t_m_user_login_100}-->
                <a href="javascript:login_no();" class="btn btn-icon login_icon login_icon_github"><div><i class="icon-github"></i></div></a>
                <a href="javascript:login_no();" class="btn btn-icon login_icon login_icon_tb"><div><i class="icon-taobao"></i></div></a>
            </div>
        </div>
    </section>
    <script>
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-login-form').serialize();
            $("#login").attr('disabled','disabled').text('登录中...');
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
                        dialog.toast("登录成功", 'success', 1000);
                        setInterval(function(){
                            if(e.url !=''){
                                window.location.href=e.url;
                            }else{
                                window.location.href="{#WWW}";
                            }
                        },1500);
                    }else{
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
        function login_no(){
            dialog.toast("功能尚在开发中", 'none', 1000);
        }
    </script>
</div>