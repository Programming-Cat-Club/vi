<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">设置</span>
    </div>
</header>
<style>

.fileInputContainer{
    height:75px;
    background:url('{#WWW}{$data.avatar.b}?s={#NOW_TIME}');
    position:relative;
    width: 75px;
    background-repeat: round;
    border-radius: 100%
}
.fileInputContainer span{
    position: absolute;
    right: -7px;
    bottom: 3px;
}
.fileInputContainer span i{
    color: #9C27B0;
    font-size: 20px;
}
.fileInputContainer .fileInput{
    height:75px;
    overflow: hidden;
    font-size: 300px;
    position:absolute;
    right:0;
    top:0;
    opacity: 0;
    filter:alpha(opacity=0);
    cursor:pointer;
}
</style>
<div class="g-view">
    <div class="text-center" style="padding: 15px;background: #fff;justify-content: center;align-items: center;display: flex;">
        <div class="fileInputContainer">
            <form action="" enctype="multipart/form-data">
                <input id="upfile" class="fileInput" type="file" name="photo" accept="image/*" multiple="multiple" onchange="updata_avatar()"/>
            </form>
            <span><i class="iconfont icon-shangchuan"></i></span>
        </div> 
    </div>
    <div class="m-celltitle">邮箱验证</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-left">
                <input type="text" name="email" class="cell-input" placeholder="邮箱地址" value="{$data.email}" {if $data['email_state'] ==1}disabled{/if}/>
            </div>
            <div class="cell-right">
                {if $data['email_state'] ==0}
                <a href="javascript:;" class="btn btn-primary" style="margin:10px 0;" id="J_GetCode">发送验证</a>
                {else}
                <i class="iconfont icon-gou_1" style="color: #04BE02;"></i>
                {/if}
            </div>
        </div>
    </div>
    <div class="m-celltitle">基本信息</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" class="cell-input" placeholder="用户名"value="{$data.user}" disabled/>
            </div>
        </div>
        <div class="cell-item">
            <label class="cell-right cell-arrow">
                <select class="cell-select" style="color: #7d7d7d;margin-left: 0px;">
                    <option name="sex" value="0" {if $data['sex'] == 0}selected{/if}>性别</option>
                    <option name="sex" value="1" {if $data['sex'] == 1}selected{/if}>男</option>
                    <option name="sex" value="2" {if $data['sex'] == 2}selected{/if}>女</option>
                </select>
            </label>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input id="date" class="cell-input" type="date" name="age" value="{if $data['age'] != '0'}{#date('Y-m-d',$data['age'])}{/if}" placeholder="年龄">
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" name="sign" class="cell-input" placeholder="签名" value="{$data.ps}"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <!-- <input type="text" name="city" class="cell-input" placeholder="城市" value="{$data.city}"/> -->
                <input type="text" name="city" class="cell-input" readonly id="J_Address" placeholder="{if $data['city']}{$data.city}{else}城市{/if}">
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <a href="javascript:;" class="btn-block btn-primary" style="margin:10px 0;" onclick="modify()">修改资料</a>
            </div>
        </div>
    </div>
    {hook nd_user_op}
    <div class="m-celltitle">修改密码</div>
    <div class="m-cell">
        <div class="cell-item">
            <div class="cell-right">
                <input type="hidden" id="pass0" name="gn" class="cell-input" value="pass">
                <input type="text" name="pass0" class="cell-input" placeholder="旧密码"/>
            </div>
        </div>
        <div class="cell-item">

            <div class="cell-right">
                <input type="text" name="pass1" class="cell-input" placeholder="新密码"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <input type="text" name="pass2" class="cell-input" placeholder="重复新密码"/>
            </div>
        </div>
        <div class="cell-item">
            <div class="cell-right">
                <a href="javascript:;" class="btn-block btn-danger" style="margin:10px 0;" onclick="pass()">修改密码</a>
            </div>
        </div>
    </div>
</div>
<script>
    // 头像上传
    function updata_avatar(){
        var formData = new FormData();
            formData.append("photo",document.getElementById("upfile").files[0]);
            YDUI.dialog.loading.open('上传中');
            $.ajax({
                type: "POST", // 数据提交类型
                url: "{php HYBBS_URL('user','ava');}", // 发送地址
                data: formData, //发送数据
                async: true, // 是否异步
                processData: false, //processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
                contentType: false, //
                success:function(e){
                    if(e.error){
                        YDUI.dialog.loading.close();
                        YDUI.dialog.toast(e.info, 'success', 1500);
                        // window.location.reload();
                    }else{
                        YDUI.dialog.loading.close();
                        YDUI.dialog.toast(e.info, "error", 1500);
                    }
                }
            });
    }
    function pass(){
        var data = {
                uid:'{$data.uid}',
                gn:$('#pass0').val(),
                pass0:$('[name="pass0"]').val(),
                pass1:$('[name="pass1"]').val(),
                pass2:$('[name="pass2"]').val()
            };
            YDUI.dialog.loading.open('提交中');
            $.post("{#HYBBS_URL('user','Edit')}",data,function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');        
    }
    function modify(){
        var data = {
                uid:'{$data.uid}',
                age:$('[name="age"]').val(),
                sex:$('[name="sex"]option:selected').val(),
                city:$('[name="city"]').val(),
                sign:$('[name="sign"]').val()
            };
            YDUI.dialog.loading.open('提交中');
            $.post("{#HYBBS_URL('plugins','modify')}",data,function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');
    }

    $(function(){
        
        var $getCode = $('#J_GetCode');
        /* 定义参数 */
        $getCode.sendCode({
            disClass: 'btn-disabled',
            secs: 15,
            run: false,
            runStr: '{%s}秒后重新获取',
            resetStr: '重新发送'
        });
        $getCode.on('click', function () {
            /* ajax 成功发送验证码后调用【start】 */
            YDUI.dialog.loading.open('发送中');
            $.post("{#HYBBS_URL('plugins','Activate_mail')}",{email:$('[name="email"]').val()},function(e){
                if(e.error){
                    YDUI.dialog.loading.close();
                    $getCode.sendCode('start');
                    YDUI.dialog.toast(e.info, 'success', 1500);
                }else{
                    YDUI.dialog.loading.close();
                    YDUI.dialog.toast(e.info, "error", 1500);
                }
            },'json');     
        });
        // 解决移动端输入框dete属性placeholder无效
        var o = document.getElementById('date');
        o.onfocus = function(){
            this.removeAttribute('placeholder');
        };
        o.onblur = function(){
            if(this.value == ''){
                this.setAttribute('placeholder','年龄');
            }
        };
        // 省级联动
        $("head").append('<script src="{#WWW}View\/nd_mobile\/js\/ydui.citys.js"><\/script>');
        var $address = $('#J_Address');

        $address.citySelect();

        $address.on('click', function () {
            $address.citySelect('open');
        });

        $address.on('done.ydui.cityselect', function (ret) {
            /* 省：ret.provance */
            /* 市：ret.city */
            /* 县：ret.area */
            $(this).val(ret.provance + ' ' + ret.city + ' ' + ret.area);
        });
    });
</script>

{include common/footer} {include common/foot}