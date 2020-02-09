
$(function(){
    $(document).on('click','[data-tab]',function(){
        var obj = $(this);
            if(obj.attr('data-tab') == 'biaoqing'){
                if($('#biaoqing').attr('style') == 'display: block;'){
                    $('#biaoqing').css('display','none');
                }else{
                    $('#pic').css('display','none');
                    $('#biaoqing').css('display','block');
                }
            }else if(obj.attr('data-tab') == 'tupian'){
                if($('#pic').attr('style') == 'display: block;'){
                    $('#pic').css('display','none');
                }else{
                    $('#biaoqing').css('display','none');
                    $('#pic').css('display','block');
                }
            }
    });
    $(document).on('click','.jubao .cell-item',function(){
        var fid = $('[name="jubao"]:checked');
		if(fid.length != 0){
            $('#tijiao').removeClass('btn-disabled');
		}else{
            $('#tijiao').addClass('btn-disabled');
		}
    })
    // 投票选定
    $(document).on('click','.stamp .cell-item',function(){
        var fid = $('[name="stamp"]:checked');
		if(fid.length != 0){
            $('#btn-stamp').removeClass('btn-disabled');
		}else{
            $('#btn-stamp').addClass('btn-disabled');
		}
    })
    // 返回顶部
    $(window).scroll(function() {
        if ($(document).scrollTop() >= 100) {
            $('.top a').addClass('top-bg'); 
            // 首页
            $('.index-navbar').show();             
        }else{
            $('.top a').removeClass('top-bg');
            $('.index-navbar').hide();   
        }
        if ($(document).scrollTop() >= 290) {
            // 首页
            $('.index-navbar').show();             
        }else{
            $('.index-navbar').hide();   
        } 
    });
    // 懒加载
    $("img.lazyload").lazyload();

    // pjax
    $(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax',{timeout: 10000,maxCacheLength:20,container:'#pjax',fragment:'#pjax'});
    $(document).on('pjax:click', function() {
        // 关闭ActionSheet窗口
        $('#candan,#yd-popup').actionSheet('close');
    })
    $(document).on('pjax:send', function() {
        $('.loading-page').show()
    })
    $(document).on('pjax:complete', function() {
        $('.loading-page').fadeOut()
    })
    $(document).on('pjax:end', function(event) {

        $("img.lazyload").lazyload();
        $('.mask-black').remove();
    })

    // 分享
    $(document).on('click','.soshm-item',function(){
        var tid = $('[data-shear-id]').attr('data-shear-id');
        $.ajax({
            url:WWW+"plugins"+exp+"share",
            type:'post',
            dataType:'json',
            data:{'share':tid},
            success:function(e){
                if(e.error){
                    $('#shareBtn').children('p').text(parseInt($('#shareBtn').children('p').text())+1);
                }
            },
            error:function(){}
        });
    });
})

$('#sou').bind('input propertychange',function () { 
    var obj = $(this);
    if(obj.val() != ''){
        $('.shbtn').show();
    }
});

function top_t() {
    $('html,body').animate({
        scrollTop: 0
    },500);
}
// 经典样式
function loopjindian(data){
    if(data.forumlist.length){
        $.each(data.forumlist, function (i, v) {
            let htmlCodes = '',imgCodes = '';
            if(v.img.length){
                let loopimg = '';
                $.each(v.img, function (index, val) {
                    loopimg += [
                        '    <div href="#" class="grids-item">',
                        '        <a href="'+HYBBS_URL('thread',v.tid)+'" data-pjax="">',
                        '            <img class="lazyload" src="'+val+'" data-original="'+val+'" alt="'+v.tiele+'" style="">',
                        '        </a>',
                        '    </div>',
                    ].join("");
                });
                imgCodes = [
                    '<div class="m-grids-3">',
                    loopimg,
                    '</div>'
                ].join("");
            }
            htmlCodes += [
                '<div class="nd_list_1">',
                '   <div class="list_header">',
                '       <a href="'+HYBBS_URL('my',v.user)+'" style="position: relative;" data-pjax="">',
                '           <i style="position: absolute;left: -4px;font-size: 30px;top: -8px;color: #FF5722;transform: rotate(278deg);" class="iconfont icon-huangguan2"></i><img style="border:2px solid #FF5722;width:45px;height:45px;" src="'+v.avatar+'" alt="'+v.user+'">',
                '       </a>',
                '       <div class="title">',
                '           <div>',
                '               <div class="jcenter">',
                '                   <a href="'+HYBBS_URL('my',v.user)+'" data-pjax=""> ',
                '                        <span class="user_name" style="color:#ee124e">'+v.user+'</span>',
                '                   </a>',
                '               </div>                        ',
                '               <p style="margin-left:-3px;">',
                '                   <!-- 性别 -->',
                '                   <!-- 没设置 -->',
                '                   <span class="lv no">',
                '                       <i class="iconfont icon-xingbie">49</i>',
                '                   </span>',
                '                   <!-- 等级 -->',
                '                   <!-- 用户组 -->',
                '                   <span class="lv group" style="color:#FFF;background:#ff6a00;box-shadow: 0 1px 10px -2px #ff6a00;">管理员</span>',
                '               </p>',
                '           </div>',
                '       </div>',
                '   </div>',
                '    <div class="list_content" style="position: relative;">',
                '       <div class="content_img_list">',
                '            <div class="thread_content" style="box-shadow: none;">',
                '                <a class="forum_name" href="'+data.foruminfo.id+'" data-pjax="" style="color:;"><span>#'+data.foruminfo.name+'#</span></a> ',
                '                <a href="'+HYBBS_URL('thread',v.tid)+'" data-pjax="">',
                '                    <span>'+v.title+'</span>',
                '                </a>',
                '                <a href="'+HYBBS_URL('thread',v.tid)+'" data-pjax="">',
                '                    <div class="summary">'+v.summary+'</div>',
                '                </a>',
                '            </div>',
                '           '+(imgCodes)?imgCodes:' ',
                '       </div>',
                '    </div>',
                '    <div class="list_footer">',
                '        <div class="m-grids-3">',
                '            <a href="'+HYBBS_URL('thread',v.tid)+'#thread_post" data-pjax="" class="grids-item">',
                '                <div class="grids-txt">',
                '                    <span>',
                '                        <i class="icon-huifu1"></i> '+v.posts+'回复</span>',
                '                </div>',
                '            </a>',
                '            <a href="javascript:;" class="grids-item">',
                '                <div class="grids-txt">',
                '                    <span>',
                '                        <i class="iconfont icon-yduizuji"></i> '+v.views+'浏览</span>',
                '                </div>',
                '            </a>',
                '            <a href="javascript:;" class="grids-item">',
                '                <div class="grids-txt">',
                '                    <span class="zan" onclick="tp(\'thread1\','+v.tid+',this)">',
                '                        <i class="icon-zansel"></i> <p></p><span>'+v.goods+'喜欢</span></span>',
                '                </div>',
                '            </a>',
                '        </div>',
                '    </div>',
                '</div>'
            ].join("");
            $('#forun_list_'+data.foruminfo.id).append(htmlCodes);
        });
        
    }
}