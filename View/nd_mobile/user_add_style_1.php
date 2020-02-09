{include common/header}
<div class="g-view">
    <div class="m-cell demo-small-pitch" style="margin-top: 10px;">
        <form id="user-add-form" method="post" onsubmit="return user_login()">
            <div class="cell-item">
                <div class="cell-right">
                    <input type="text" name="user" class="cell-input" placeholder="用户名" autocomplete="off">
                </div>
            </div>
            <div class="cell-item">
                <div class="cell-right">
                    <input type="email" name="email" class="cell-input" placeholder="邮箱" autocomplete="off">
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
        <div style="margin:0 10px;"><button id="add" class="btn-block btn-primary">注册</button></div>
        <div class="cell-item">
            <div class="cell-left"><a data-pjax href="{#HYBBS_URL('user','login')}" style="color: #2196F3">已有账号现在登录</a></div>
            <div class="cell-right" style="font-size: 15px;"></div>
        </div>
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