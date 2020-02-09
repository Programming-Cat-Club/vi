{include common/head}
<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<div class="user">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:history.back(-1);" class="navbar-item">
            <i class="icon-fanhui"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">{$title}</span>
        </div>
        <a href="javascript:;" class="navbar-item" onclick="tijiao()">
            提交
        </a>
    </header>
</div>
<style>
    .tag-list{
        background: #fff;
        padding: 10px;
    }
    .tag-list a{
        color: #00BCD4;
        border: 1px solid #00BCD4;
        border-radius: 18px;
        font-size: 14px;
        padding: 2px 4px;
    }
</style>
<div class="g-view">
    <div class="m-celltitle">已选择</div>
    <div class="tag-list" id="xuanze">
        {foreach $xuanze as $k=>$v}
        <a class="shanchu" href="javascript:;" data-id="{if $k != 0},{/if}{$v.tag_id}">{$v.name}</a>
        {/foreach}
    </div>
    <input type="hidden" name="xuanze" value="{$xuanze_val}">
    {foreach $tag_group as $v}
    <div class="m-celltitle">{$v.name}</div>
        <div class="tag-list">
            {foreach $tags as $vv}
                {if $v['id'] == $vv['tag_fid']}
                    <a class="btntag" href="javascript:;" data-id="{$vv.tag_id}" data-name="{$vv.name}">{$vv.name}</a>
                {/if}
            {/foreach}
        </div>
    {/foreach}
</div>
<script>
function tijiao(){
    var tags = $('input[name="xuanze"]').val();
    $.ajax({
        type: "post",
        url: "{#HYBBS_URL('my',$user['user'],'mytag')}",
        data: {
            tags:tags
        },
        dataType: "json",
        success: function (e) {
            if(e){
                dialog.toast(e.info, 'none', 1000);
            }else{
                alog.toast(e.info, 'none', 1000);
            }
        }
    });
}
$('.btntag').click(function(){
    var tagid = $(this).attr('data-id');
    var tagname = $(this).attr('data-name');
    var xuanze = $('input[name="xuanze"]');
    if(xuanze.val() == ""){
        xuanze.val(tagid)
        $('#xuanze').append('<a class="shanchu" href="javascript:;" data-id="'+tagid+'">'+tagname+'</a> ')
    }else{
        var ce = xuanze.val().indexOf(tagid)
        if(ce != -1){
            return dialog.toast('已经存在', 'none', 1000);
        }
        xuanze.val(xuanze.val()+','+tagid)
        $('#xuanze').append('<a class="shanchu" href="javascript:;" data-id=",'+tagid+'">'+tagname+'</a> ')

    }
})
$(document).on('click','.shanchu',function(){
    var str = $('input[name="xuanze"]').val();
    var tagid = $(this).attr('data-id');
    str = str.replace(new RegExp(tagid,'g'),"");
    $('input[name="xuanze"]').val(str)
    console.log(str)

    $(this).remove()
})
</script>
{include common/foot}