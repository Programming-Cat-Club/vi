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
            <img src="{#WWW}View/nd_mobile/img/register.svg" style="margin-top:1.8rem;width: 5rem;">
        </div>
        <form id="user-add-form" method="post" onsubmit="return user_login()">
            <div style="margin:1.8rem">
                <input class="login_input" type="text" name="user" placeholder="用户名">
            </div>
            <div style="margin:1.8rem;">
                <input class="login_input" type="text" name="email" placeholder="邮箱">
            </div>
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass1" placeholder="密码">
            </div>
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass2" placeholder="重复密码">
            </div>
            {hook nd_mobile_user_add_1}
            <div style="margin:1.8rem 1.8rem 0">
                <button class="login_button" id="add">注册</button>
            </div>
        </form>
        <div style="margin: 25px 1.8rem 10px;display: flex;justify-content: space-between;">
            <a href="{#HYBBS_URL('user','login')}" class="login_zhaohui">已有账号直接登录</a>

        </div>
    </section>
    <script>
        $('#add').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-add-form').serialize();
            $("#add").attr('disabled','disabled').text('提交中...');
            $.ajax({
                url:"{php HYBBS_URL('user','add')}",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    $("#add").removeAttr('disabled').text('注册');
                    if(e.error){
                        dialog.toast("注册成功", 'success', 1000);
                        setInterval(function(){
                            if(e.url !=''){
                                window.location.href=e.url;
                            }else{
                                window.location.href="{#WWW}";
                            }
                        },1500);
                    }else{
                        {hook nd_mobile_user_add_js_1}
                        dialog.toast(e.info, 'none', 1000);
                    }
                },
                error:function(e){
                    $("#add").removeAttr('disabled').text('注册');
                }
            });
            return false;
        })
    </script>
</div>