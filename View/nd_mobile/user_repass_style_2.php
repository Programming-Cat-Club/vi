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
            <img src="{#WWW}View/nd_mobile/img/repass.svg" style="margin-top:1.8rem;width: 6rem;">
        </div>
        <form id="user-repass-form" method="post" onsubmit="return user_login()">
            <div style="margin:1.8rem">
                <input class="login_input" type="text" name="email" placeholder="邮箱地址">
            </div>
            <div style="margin:1.8rem;position: relative;">
                <input class="login_input" type="text" name="code" placeholder="验证码">
                <button type="button" class="repass_email" onclick="send_code(this)">获取验证码</button>
            </div>
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass1" placeholder="新密码">
            </div>
            <div style="margin:1.8rem">
                <input class="login_input" type="password" name="pass2" placeholder="重复密码">
            </div>

            <div style="margin:1.8rem 1.8rem 0">
                <button class="login_button" id="login">确定</button>
            </div>
        </form>
        <div style="margin: 25px 1.8rem 10px;display: flex;justify-content: space-between;">
            <a href="{#HYBBS_URL('user','login')}" class="login_zhaohui">返回登录</a>
            <a href="{#HYBBS_URL('user','add')}" class="login_zhaohui">放弃治疗注册一个</a>

        </div>
    </section>
    <script>
        function send_code(obj){
            var obj = $(this);
            YDUI.dialog.loading.open('发送中');
            $.ajax({
                url:"{php HYBBS_URL('user','recode')}",
                type:'post',
                data:{
                    email:$('[name="email"]').val(),
                    {hook nd_mobile_repass_js_data}
                },
                dataType:'json',
                success:function(e){
                    if(e.error){
                        YDUI.dialog.loading.close();
                        dialog.toast(e.info, 'none', 1000);
                    }else{
                        YDUI.dialog.loading.close();
                        dialog.toast(e.info, 'none', 1000);
                    }
                },
                error:function(e){
                }
            });
            
        }
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-repass-form').serialize();
            $("#login").attr('disabled','disabled').text('提交中...');
            $.ajax({
                url:"{php HYBBS_URL('user','recode2')}",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    $("#login").removeAttr('disabled').text('确定');
                    if(e.error){
                        dialog.toast("找回成功", 'success', 1000);
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
                },
                error:function(e){
                    $("#login").removeAttr('disabled').text('确定');
                }
            });
            return false;
        })
    </script>
</div>