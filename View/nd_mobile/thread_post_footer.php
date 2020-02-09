<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<!-- 回帖编辑器 -->
<style>
    .simditor{text-align: left;border:none}
    .simditor .simditor-body{
        height: 100px;
        overflow-y: scroll;
        min-height: inherit;
        padding: 15px;
    }
    .simditor .simditor-wrapper{
        background: none;
    }
    .simditor .simditor-body p, .simditor .simditor-body div, .editor-style p, .editor-style div{
        margin: 0;
    }
    .simditor .simditor-wrapper .simditor-placeholder{
        padding: 15px;
    }
    .footer a {
        height: 40px;
        color: #656565;
        line-height: 39px;
    }

    .footer .back {
        width: 40px;
        text-align: center;
    }

    .footer .huifu {
        background: #f0f2f3;
        line-height: 30px;
        padding: 0 10%;
        border-radius: 15px;
        font-size: 14px;
    }

    .footer .right {
        display: flex;
        /* flex: 1; */
        justify-content: center;
        align-items: center;
        width: calc(100% - 40px - 43%);
    }

    .footer .right a {
        width: 30%;
        text-align: center;
    }

    .footer .right span {
        margin-right: 0;
        font-size: 11px;
        position: absolute;
        line-height: 15px;
        top: -5px;
        right: -10px;
        padding: 0 5px;
    }

    .footer i {
        position: relative;
        font-size: 26px;
    }
    #pinglun .cell-item,
    #pinglun .cell-textarea{
        background: #f5f5f5;
    }
    #pinglun .m-cell:after{
        border-bottom:none;
    }

    .biaoqing .m-grids-4{
        padding: 15px 10px 0;
    }
    .biaoqing .m-grids-4 input{
        position: absolute;
        display: block;
        width: calc(100% - 20px);
        height: calc(100% - 20px);
        opacity: 0;
        top: 10px;
    }

    .biaoqing .m-grids-4 .grids-item{
        position: relative;
        padding: 0 0 10px;
    }
    .biaoqing .m-grids-4 .grids-item img{
        margin-left: 4px;
        border-radius: 5px;
    }
    .biaoqing .m-grids-4,
    .biaoqing .m-grids-5{
        background: #f5f5f5;
        height: 190px;
        overflow-y: scroll;
    }
    .biaoqing .m-grids-4 .grids-item:after,
    .biaoqing .m-grids-5:before,
    .biaoqing .m-grids-5 .grids-item:after
    {
        border-bottom:none
    }
    .biaoqing .m-grids-4 .grids-item:not(:nth-child(4n)):before,
    .biaoqing .m-grids-5 .grids-item:not(:nth-child(5n)):before
    {
        border-right:none;
    }
    .pinglun_nav{
        display: flex;justify-content: space-between;background:#fff;line-height: 40px;padding: 0 15px;
    }
    .pinglun_mune{
        display: flex;background:#fff;    line-height: 30px;
    padding: 5px 15px 0;
    }
    </style>

<footer class="m-tabbar tabbar-fixed footer">
    <div class="huifu" style="padding: 5px;width: 100%;margin: 2px 6px;border-radius: 3px;"  id="postedit" {if IS_LOGIN}data-ydui-actionsheet="{target:'#pinglun',closeElement:'#cancel'}"{else} onclick="is_login()"{/if}>我来说两句</div>
</footer>
{if IS_LOGIN}
<div class="m-actionsheet" id="pinglun">
    <div class="pinglun_nav">
        <a href="javascript:;" id="cancel">取消</a>
        <a href="javascript:;" onclick="post()" style="color: #03A9F4;">发布</a>
    </div>
    <textarea id="editor" placeholder="我来说两句" class="cell-textarea"></textarea>
</div>
{/if}
<script>
    $(function(){
        editor = new Simditor({
            textarea: $('#editor'),
            //optional options
            toolbarHidden:true,
            params:{'img':''},
            allowedTags:['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'h1', 'h2', 'h3', 'h4', 'hr','svg','use'],
            allowedAttributes:{
                img: ['src', 'alt', 'width', 'height', 'data-non-image'],
                a: ['href', 'target'],
                font: ['color'],
                code: ['class'],
                svg:['class','aria-hidden'],
                use:['xlink:href']
            },
            toolbar:false
        });
        $(document).on('click','#postedit',function(){
            editor.focus();
        });
    })
    function post(){
        dialog.loading.open('提交中');
        $.ajax({
            url: "{php HYBBS_URL('post','post_post')}",
            type: "POST",
            cache: false,
            data: {
                pid:{$post_data.pid},
                content: editor.getValue()
            },
            dataType: 'json'
        }).then(function(e) {

            if (e.error) {

                window.location.reload();
            } else {
                dialog.loading.close();
                dialog.toast(e.info, 'error', 1500);
            }
        }, function() {
            dialog.toast(e.info, 'error', 1500);
        });
    }
</script>