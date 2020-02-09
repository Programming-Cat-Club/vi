<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">设置背景图</span>
    </div>
</header>

<div class="g-view">
        <link rel="stylesheet" href="//at.alicdn.com/t/font_695745_v2nin5dhkfd8ia4i.css">
        <style>
            h3{font-size: 16px;}
            .ac_img ul{
                list-style:none;
                
            }
            .ac_img ul img{
                width: 100%;;
                height: 100%;
                background-size: cover;
                border-radius: 5px;
                margin-bottom:2px;
                margin-right: 2px; 
            }
            .ac_img ul li{
                float: left;
                width: 25%;
                height: 75px;
                border-radius: 6px;
                border: 2px #fff solid;
            }
            .ac_img .active{
                border: 2px #E91E63 solid;
            }
            .ac_img_user{
                text-align: center;
                    margin-top: 10px;
                    border: 1px dashed #ddd;
                    padding-top: 19px;
                    height: 90px;
            }
        </style>
        <div style="background: #fff;margin-top:15px;padding: 10px;">
            <div>
                <h3>系统默认</h3>
            </div>
            <!-- 背景图片 -->
            <div class="ac_img">
                <ul>
                    {php $user_img = S('user_style')->find('*',['uid'=>NOW_UID]);}  
                    {php $simg = get_plugin_inc('nd_user_img');$img = explode("\r\n",$simg['user_img']);}
                    {foreach array_filter($img) as $v}
                    <li class="btn_img{if $user_img}{if $user_img['img'] == $v} active{/if}{/if}"><img src="{$v}" alt=""></li>
                    {/foreach}
                </ul>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="background: #fff;margin-top: 15px;padding: 10px;">
        <div>
            <h3>自定义上传</h3>
        </div>
        <div class="ac_img_user">
            <form class="form-horizontal" enctype="multipart/form-data">
                <input id="upfile" type="file" name="photo" accept="image/*" multiple="multiple" class="icon iconfont icon-ic_image_upload_mult" style="outline: 0;border: none;width: 50px;height: 48px;font-size: 50px;position: absolute;left: calc(50% - 23px);" onchange="updata_avatar()">
                <!-- <i class="iconfont icon-ic_image_upload_mult"></i> -->
            </form>
        </div>
        </div>
        <script>
            function updata_avatar(){
                var formData = new FormData();
                    formData.append("photo",document.getElementById("upfile").files[0]);
                    YDUI.dialog.loading.open('上传中');
                    $.ajax({
                        type: "POST", // 数据提交类型
                        url: "{php HYBBS_URL('user','style');}", // 发送地址
                        data: formData, //发送数据
                        async: true, // 是否异步
                        processData: false, //processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
                        contentType: false, //
                        success:function(e){
                            if(e.error){
                                YDUI.dialog.loading.close();
                                YDUI.dialog.toast(e.info, 'success', 1500);
                                window.location.href="{#HYBBS_URL('my',$data['user'])}";
                            }else{
                                YDUI.dialog.loading.close();
                                YDUI.dialog.toast(e.info, "error", 1500);
                            }
                        }
                    });
            }
            $('.btn_img').click(function(){
                $('.btn_img').removeClass('active');
                $(this).addClass('active');
                var url = $(this).children().attr('src');
                $.post({
                    url:"{#HYBBS_URL('user','user_img')}",
                    data:{url:url},
                    success:function(e){
                        if(e.error){
                            window.location.href="{#HYBBS_URL('my',$data['user'])}";
                        }else{
                            YDUI.dialog.toast(e.info, "error", 1500);
                        }
                    }
                });
            });
        </script>
</div>

{include common/footer} {include common/foot}