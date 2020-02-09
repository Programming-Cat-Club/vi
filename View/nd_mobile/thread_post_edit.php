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
</style>
<textarea id="editor" placeholder="我来说两句" class="cell-textarea"></textarea>
<script>
    $(function(){
        editor_pinlun = new Simditor({
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
            }
        });
        $(document).on('click','#postedit',function(){
            editor_pinlun.focus();
        });
    })
    function post_pinlun(){
        dialog.loading.open('提交中');
        $.ajax({
            url: "{php HYBBS_URL('post','post')}",
            type: "POST",
            cache: false,
            data: {
                id:{$tid},
                content: editor_pinlun.getValue(),
                img:$('[name="img"]').val()
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