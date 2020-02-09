{include common/head}
{include common/header}
<style>
.tab-panel{
    background: #f5f5f5;
}
.plugins .cell-left{
    width: 50%
}
</style>
<div class="g-view">
    <div id="J_Tab_RZ" class="m-tab">
        <ul class="tab-nav">
            <li class="tab-nav-item tab-active"><a href="javascript:;">已认证</a></li>
            <li class="tab-nav-item"><a href="javascript:;">待审核</a></li>
        </ul>
        <div class="tab-panel">
            <div class="tab-panel-item tab-active">
                <div id="list" class="m-cell plugins">
                    {foreach $data as $v}
                    <div class="cell-item">
                        <div class="cell-left"><a href="" data-pjax>{$v.user}</a></div>
                        <div class="cell-right"><button onclick="quxiao(this,{$v.uid})" class="btn btn-primary">已认证</button></div>
                    </div>
                    {/foreach}
                    {if empty($data)}
                    <div class="no_thread">
                            <i class="icon-nuandou"></i>
                            <p>没有任何举报内容...</p>
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
                <div class="m-cell plugins">

                    {foreach $ren_data as $v}
                    <div class="cell-item">
                        <div class="cell-left"><a href="" data-pjax>{$v.user}</a></div>
                        <div class="cell-right"><a href="javascript:;" class="btn btn-primary" onclick="tongyi({$v.uid},this)">通过</a> <a href="javascript:;" class="btn btn-danger" onclick="butongguo({$v.uid},this)">拒绝</a></div>
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var $tab = $('#J_Tab_RZ');
            $tab.tab({
                nav: '.tab-nav-item',
                panel: '.tab-panel-item',
                activeClass: 'tab-active'
            });
    })
    function ajax_list(obj){
        var pageid = parseInt($('#pageid').attr('date-page'))+1;
        $(obj).attr('disabled','disabled').text('加载中...');
        $.ajax({
            type: "get",
            url: "{#HYBBS_URL('plugins','aut')}?ajax=true&pageid="+pageid,
            dataType: "json",
            success: function (e) {
                if(e.list.length){
                    var html = '';
                    $.each(e.list, function (i, v) { 
                        html += [
                        '<div class="cell-item">',
                        '<div class="cell-left"><a href="" data-pjax>'+v.user+'</a></div>',
                        '<div class="cell-right"><button onclick="quxiao(this,'+v.uid+')" class="btn btn-primary">已验证</button></div>',
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
     /* 取消 */
    function quxiao(obj,uid){
        dialog.confirm('确认取消吗?', '取消后将失去授权', function () {
            $.ajax({
                type: "post",
                url: "{#HYBBS_URL('plugins','aut')}",
                data: {uid:uid},
                dataType: "json",
                success: function (e) {
                    if(e.error){
                        dialog.toast(e.info, 'none', 1000);
                        $(obj).parent().parent().remove()
                    }
                }
            });
        });
    }
    function tongyi(uid,obj){
        dialog.confirm('确认通过吗?', '通过后该用户将获得认证权限', function () {
            $.ajax({
                type: "post",
                url: "{#HYBBS_URL('plugins','aut')}?type=renzheng",
                data: {uid:uid},
                dataType: "json",
                success: function (e) {
                    if(e.error){
                        dialog.toast(e.info, 'none', 1000);
                        $(obj).parent().parent().remove()
                    }
                }
            });
        });
    }
    function butongguo(uid,obj)
    {
        dialog.confirm('提示:', '拒绝通过吗?', function () {
            $.ajax({
                type: "post",
                url: "{#HYBBS_URL('plugins','aut')}?type=jujue",
                data: {uid:uid},
                dataType: "json",
                success: function (e) {
                    if(e.error){
                        dialog.toast(e.info, 'none', 1000);
                        $(obj).parent().parent().remove()
                    }
                }
            });
        });
    }
</script>

{include common/foot}