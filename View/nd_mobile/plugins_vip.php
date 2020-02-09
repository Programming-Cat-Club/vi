{include common/head}
{include common/header}
<style>
.tab-panel{
    background: #f5f5f5;
}
.plugins .cell-left{
    width: 50%;
    
}
</style>
<div class="g-view">
    <div id="J_Tab_VIP" class="m-tab">
        <ul class="tab-nav">
            <li class="tab-nav-item tab-active"><a href="javascript:;">VIP列表</a></li>
            <li class="tab-nav-item"><a href="javascript:;">开通</a></li>
        </ul>
        <div class="tab-panel">
            <div class="tab-panel-item tab-active">
                <div id="list" class="m-cell plugins">
                    {foreach $data as $v}
                    <div class="cell-item">
                        <div class="cell-left"><a href="" data-pjax>{$v.user}</a></div>
                        <div class="cell-right"><a href="javascript:;" onclick="close_jing(1,this)">到期:{$v['atime']}</a></div>
                    </div>
                    {/foreach}
                    {if empty($data)}
                    <div class="no_thread">
                            <i class="icon-nuandou"></i>
                            <p>暂无数据...</p>
                        </div>
                    {/if}
                </div>
                {if $page_count !=1}
                <div style="text-align: center">
                    <button id="pageid" date-page="{$pageid}" class="btn btn-primary" onclick="ajax_list(this)" >加载更多</button>
                </div>
                {/if}
            </div>
            <!-- 待审核 -->
            <div class="tab-panel-item">
                <div class="m-cell">
                    <div class="cell-item">
                        <div class="cell-left">用户ID：</div>
                        <div class="cell-right"><input type="number" name="uid" pattern="[0-9]*" class="cell-input" placeholder="用户ID" /></div>
                    </div>
                    <div class="cell-item">
                        <div class="cell-left">开通天数：</div>
                        <div class="cell-right"><input type="number" name="tian" pattern="[0-9]*" class="cell-input" placeholder="输入天数" /></div>
                    </div>
                </div>
                <button onclick="post(this)" class="btn-block btn-primary" style="background: #03A9F4;margin: 0 10px;width: calc(100% - 20px);">确定开通</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var $tab = $('#J_Tab_VIP');
            $tab.tab({
                nav: '.tab-nav-item',
                panel: '.tab-panel-item',
                activeClass: 'tab-active'
            });
    })
    function post(obj){
        $(obj).attr('disabled','disabled').text('提交中...');
        $.ajax({
            type: "post",
            url: "{#HYBBS_URL('plugins','vip')}",
            data: {uid:$('[name="uid"]').val(),tian:$('[name="tian"]').val()},
            dataType: "json",
            success: function (e) {
                if(e.error){
                    dialog.toast(e.info, 'none', 1000);
                }else{
                    dialog.toast(e.info, 'none', 1000);
                }
                $(obj).removeAttr('disabled').text('确认开通');
            }

        });
    }
    function ajax_list(obj){
        var pageid = parseInt($('#pageid').attr('date-page'))+1;
        $(obj).attr('disabled','disabled').text('加载中...');
        $.ajax({
            type: "get",
            url: "{#HYBBS_URL('plugins','vip')}?ajax=true&pageid="+pageid,
            dataType: "json",
            success: function (e) {
                if(e.list.length){
                    var html = '';
                    $.each(e.list, function (i, v) { 
                        html += [
                        '<div class="cell-item">',
                        '<div class="cell-left"><a href="" data-pjax>'+v.user+'</a></div>',
                        '<div class="cell-right"><a href="javascript:;" onclick="close_jing(1,this)">到期:'+v.atime+'</a></div>',
                        '</div>'
                        ].join("");
                    });
                    $('#list').append(html);
                    $('#pageid').attr('date-page',pageid)
                }else{
                    $('#pageid').hide()
                    dialog.toast('没有数据了', 'none', 1000);
                }
                $(obj).removeAttr('disabled').text('加载更多');
            }
        });
    }
</script>

{include common/foot}