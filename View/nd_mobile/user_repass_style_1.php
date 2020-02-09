{include common/header}
<div class="g-view">
    <div class="m-cell demo-small-pitch" style="margin-top: 10px;">
        <form id="user-login-form" method="post" onsubmit="return user_login()">
            <div class="cell-item">
                <div class="cell-left">
                    <input type="text" id="email" name="email" class="cell-input" placeholder="邮箱地址"/>
                </div>
                <div class="cell-right">
                    <a href="javascript:;" class="btn btn-primary" style="margin:10px 0;" onclick="send_code(this)">发送验证</a>
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="text" name="code" class="cell-input" placeholder="验证码" autocomplete="off">
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="password" name="pass1" class="cell-input" placeholder="密码" autocomplete="off">
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="password" name="pass2" class="cell-input" placeholder="重复密码" autocomplete="off">
                </div>
            </div>
        </form>
        </div>
        <div style="margin:0 10px;"><button id="login" class="btn-block btn-primary">修改</button></div>
        <div class="cell-item">
            <div class="cell-left"><a href="{#HYBBS_URL('user','login')}" data-pjax style="color: #2196F3">已有账号现在登录</a></div>
            <div class="cell-right" style="font-size: 15px;"></div>
        </div>
    <script>
        function send_code(obj){
            var obj = $(this);
            YDUI.dialog.loading.open('发送中');
            $.ajax({
                url:"{php HYBBS_URL('user','recode')}",
                type:'post',
                data:{email:$('#email').val()},
                dataType:'json',
                success:function(e){
                    if(e.error){
                        YDUI.dialog.loading.close();
                        dialog.toast(e.info, 'none', 1000);
                    }else{
                        YDUI.dialog.loading.close();
                        // $.hy.warning(e.info);
                        dialog.toast(e.info, 'none', 1000);
                    }
                },
                error:function(e){
                }
            });
            
        }
        $('#login').on('click',function(){
            var dialog = YDUI.dialog;
            var postdata = $('#user-login-form').serialize();
            $(".id-login").attr('disabled','disabled').text('正在登录中...');
            $.ajax({
                url:"{php HYBBS_URL('user','recode2')}",
                type:'post',
                data:postdata,
                dataType:'json',
                success:function(e){
                    $(".id-login").removeAttr('disabled').text('登录');
                    if(e.error){
                        if(e.url !='')
                            window.location.href=e.url;
                        else
                            window.location.href="{#WWW}";
                    }else{
                        // $.hy.warning(e.info);
                        dialog.toast(e.info, 'none', 1000);
                    }
                },
                error:function(e){
                    $(".id-login").removeAttr('disabled').text('登录');
                }
            });
            return false;
        })
    </script>
</div>