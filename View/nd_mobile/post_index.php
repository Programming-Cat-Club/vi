<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>

{include common/head}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        取消
    </a>
    <div class="navbar-center">
        <span class="navbar-title">帖子发布</span>
    </div>
    <a href="javascript:;" class="navbar-item" onclick="post()">
            发布
        </a>
    </header>
    <div class="g-view">
    <!--ajax-post start-->
    <div class="post">
        <div class="post_form" style="margin-top: 0px;">
            <input id="title" type="text" placeholder="标题" style="height: 41px;">
        </div>
        {hook nd_post_input}
        <div class="post_form">
            <div class="post_edit">
                <textarea id="editor" placeholder="内容" class="cell-textarea" autofocus></textarea>
                <a href="javascript:;" class="fenlei"  data-ydui-actionsheet="{target:'#fenleixuanxiang',closeElement:'#cancel'}">选择分类</a>
            </div>
        </div>
        <div class="post_mune" id="J_Tab">
            <div class="navbar">
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-biaoqing"></i>
                </a>
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-tupian"></i>
                </a>
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-chakantiezishipin" style="font-size: 24px;"></i>
                </a>
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-iconfontxianshirequ1" style="font-size: 26px;"></i>
                </a>
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-upload1" style="font-size: 24.1px;font-weight: 400;"></i>
                </a>
                <a class="" href="javascript:;" onclick="shuhru_code()">
                    <i class="iconfont icon-upload4" style="font-size: 24px;"></i>
                </a>
                {hook nd_post_menu}
                <a class="tab_nume" href="javascript:;">
                    <i class="iconfont icon-gengduo1"></i>
                </a>
            </div>
            <div class="tab-panel">
                <!-- inconfont 表情 -->
                <div class="tab-panel-item biaoqing">
                    <div class="m-grids-5" id="biaoqing">
                        {for $i=1; $i<30; $i++}
                        <a href="JavaScript:;" class="grids-item" onclick="setneirong('{$i}')">
                            <div class="grids-txt">
                            <img class="emoji" src="{#WWW}View/nd_mobile/img/emoji/emoji-{$i}.png" alt="">
                            </div>
                        </a>
                        {/for}
                    </div>
                </div>
                <!-- 图片上传 -->
                <div class="tab-panel-item" style="    padding-bottom: 0!important;">
                    <div class="m-grids-4" id="pic">
                        <a class="grids-item">
                            <img src="{#WWW}View/nd_mobile/img/plus.png" alt="" style="background: #fff; width: 76px;height: 76px;object-fit: cover;border: 1px dashed #8a8a8a;border-radius: 5px;">
                            <input id="upimg" class="fileInput" type="file" name="photo" accept="image/*" multiple="multiple" onchange="upload_pic(this,'{#HYBBS_URL('post','upload')}')">
                        </a>
                    </div>
                </div>
                <!-- 加入视屏 -->
                <div class="tab-panel-item">
                    
                    <input type="text" name="video" id="" style="background: #fff;margin-bottom: 5px;" placeholder="输入视频地址{hook video_input_text}">
                    <button class="btn btn-primary" onclick="post_video()">插入视频</button>
                    {hook nd_post_video_page}
                </div>
                <div class="tab-panel-item">
                    <input type="text" name="link_title" id="" style="background: #fff;margin-bottom: 5px;" placeholder="链接标题">
                    <input type="text" name="link_url" id="" style="background: #fff;margin-bottom: 5px;" placeholder="链接地址">
                    <button class="btn btn-primary" onclick="post_link()">插入超链接</button>
                </div>
                <!-- 文件上传 -->
                <div class="tab-panel-item">
                    <div class="uploadfile">
                        <button class="btn btn-primary" style="position: relative;">上传文件
                                <input id="upfile" type="file" multiple="multiple" name="photo" accept="application/*" onchange="upload_file(this,'{#HYBBS_URL('post','uploadfile')}')">
                        </button>
                        <div class="file_list" style="margin-top: 10px;">
                        </div>
                    </div>
                </div>
                {hook nd_post_menu_page}
                <!-- 附加设置 -->
                <div class="tab-panel-item">
                        <div class="m-cell" style="margin-bottom: 0">
                            <label class="cell-item">
                                <span class="cell-left">回复可见:</span>
                                <label class="cell-right">
                                    <input type="checkbox" name="checkbox" id="thread-hide"/>
                                    <i class="cell-checkbox-icon"></i>
                                </label>
                            </label>
                            <div class="cell-item">
                                <div class="cell-left">购买可见:</div>
                                <div class="cell-right"><input id="tgold" name="post_gold" type="number" pattern="[0-9]*" class="cell-input" placeholder="请输入出售金额" autocomplete="off" style="background: #fff"/></div>
                            </div>
                        </div>
                </div>
                
            </div>
        </div>

    </div>
<script type="text/javascript" src="{#WWW}View/nd_mobile/src/simditor/module.js"></script>
<script type="text/javascript" src="{#WWW}View/nd_mobile/src/simditor/hotkeys.js"></script>
<script type="text/javascript" src="{#WWW}View/nd_mobile/src/simditor/simditor.js"></script>
<?php $tmp_md5 = rand_str(5); ?>
<script>
        var tmp_md5 = '{$tmp_md5}';
        // 菜单栏切换
        $(function(){
            var $tab = $('#J_Tab');
                $tab.tab({
                    nav: '.tab_nume',
                    panel: '.tab-panel-item',
                    activeClass: 'tab-active'
                });
        })
        // 初始化编辑器
        var editor = new Simditor({
            textarea: $('#editor'),
            //optional options
            toolbarHidden:true,
            params:{'img':'','fid':""},
            allowedTags:['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre', 'code', 'h1', 'h2', 'h3', 'h4', 'hr','svg','use','video','iframe'],
            allowedAttributes:{
                img: ['src', 'alt', 'width', 'height', 'data-non-image'],
                a: ['href', 'target'],
                font: ['color'],
                code: ['class'],
                svg:['class','aria-hidden'],
                use:['xlink:href'],
                video:['src','height','width','controls']
            }
        });
        // 提交帖子
        function post(){
            var fileid='';
            var filegold='';
            var filemess='';
            var filehide = '';
                dialog.loading.open('发布中');
                $(".fileid").each(function(e){
                    fileid+=$(this).val()+'||';
                });
                $(".filegold").each(function(e){
                    filegold+=$(this).val()+'||';
                });
                $(".filemess").each(function(e){
                    filemess+=$(this).val()+'||';
                });
                $(".filehide").each(function(e){
                    filehide+=($(this).is(':checked')?'1':0)+'||';
                });

                $.ajax({
                    url: "{#HYBBS_URL('post')}",
                    type:"POST",
                    cache: false,
                    data:{
                        title:$("#title").val(),
                        content:editor.getValue(),
                        forum:$('[name="fid"]').val(),
                        tmp_md5:'{$tmp_md5}',
                        fileid:fileid,
                        filegold:filegold,
                        filemess:filemess,
                        filehide:filehide,
                        img:$('[name="img"]').val(),
                        thide:($("#thread-hide").is(':checked')?1:0),
                        tgold:$('[name="post_gold"]').val(),
                        {hook nd_post_post}
                    },
                    dataType: 'json'
                }).then(function(e) {
                    if(e.error){ 
                        dialog.toast(e.info, 'success', 2000);
                        window.location.href="<?php HYBBS_URL('thread','','',EXP);?>"+e.id + "{#EXT}";
                    }else{
                        dialog.loading.close();
                        dialog.toast(e.info, 'error', 2000);
                    }
                }, function() {

                });
        }
        
</script>

{hook t_post_editer_top}
<!--ajax-post end-->
</div>
{include common/foot}
