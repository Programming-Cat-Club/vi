window.debug = true;
function HYBBS_URL(action, method = '') {
    return WWW+rewrite+action+exp+method;
}
var dialog = YDUI.dialog;
// 取消精华
function close_jing(tid,obj){
	var obj = $(obj);
	dialog.loading.open('提交传中');
	$.ajax({
		type: "post",
		url: WWW+"plugins"+exp+"jing",
		data: {tid:tid},
		dataType: "json",
		success: function (e) {
			if(e.error){
				dialog.loading.close();
				obj.parent().parent().remove();
				dialog.toast(e.info, 'success', 1500);
			}else{
				dialog.loading.close();
				dialog.toast(e.info, "error", 1500);
			}
		}
	});
}
// 取消推送
function close_tuisong(tid,obj){
	var obj = $(obj);
	dialog.loading.open('提交传中');
	$.ajax({
		type: "post",
		url: WWW+"plugins"+exp+"tuijian",
		data: {tid:tid},
		dataType: "json",
		success: function (e) {
			if(e.error){
				dialog.loading.close();
				obj.parent().parent().remove();
				dialog.toast(e.info, 'success', 1500);
			}else{
				dialog.loading.close();
				dialog.toast(e.info, "error", 1500);
			}
		}
	});
}
// 发帖界面选着分类
function addfenlei(){
	var $as = $('#fenleixuanxiang');
	var fid = $('[name="fenlei"]:checked');
		if(fid.length != 0){
			var fname = fid.parent().parent().children('.cell-left').text();
				$('[name="fid"]').val(fid.val());
				$('.fenlei').text(fname);
				$as.actionSheet('close');
				// $('.g-view').attr('style','')
		}else{
			dialog.toast('请选着一个分类', 'error', 2500);
		}
}
// 编辑器插入表情
function setneirong(size){
	var $img = '<img class="thread-emoji" src="'+WWW+'View/nd_mobile/img/emoji/emoji-'+size+'.png">';
		editor.focus();
		$('.simditor-placeholder').hide();
		editor.selection.insertNode($img);
		$(".simditor-placeholder").hide();
}
// 评论编辑器插入表情
function setneirong_pinlun(size){
	var $img = '<img class="thread-emoji" src="'+WWW+'View/nd_mobile/img/emoji/emoji-'+size+'.png">';
		editor_pinlun.focus();
		$('.simditor-placeholder').hide();
		editor_pinlun.selection.insertNode($img);
		$(".simditor-placeholder").hide();
}
// 编辑器插入视屏
function post_video(){
	editor.focus();
	var vad = $('[name="video"]');
	var $video = '<video src="'+vad.val()+'" width="320" height="240" controls="controls"></video>';
		editor.selection.insertNode($video);
		vad.val('');
		$(".simditor-placeholder").hide();
}
// 编辑器插入链接
function post_link(){
	editor.focus();
	var title = $('[name="link_title"]'),
		url = $('[name="link_url"]');
		if(title.val() != '' && url.val() !=''){
			var $link_url = '<a href="'+url.val()+'">'+title.val()+'</a>';
				editor.selection.insertNode($link_url);
				title.val('');
				url.val('');
				$(".simditor-placeholder").hide();  
		}else{
			dialog.toast('链接标题和地址不能为空!', "error", 2000);
		}

}
function shuhru_code(){
	editor.focus();
	var title = $('[name="link_title"]'),
	url = $('[name="link_url"]');
	var $link_url = '<pre></pre>';
	editor.selection.insertNode($link_url);
	title.val('');
	url.val('');
	$(".simditor-placeholder").hide(); 
}
// 编辑器上传图片
function upload_pic(obj,path){
	var obj = $(obj);
	var formData = new FormData();
		formData.append("photo",document.getElementById("upimg").files[0]);
		dialog.loading.open('上传中');
		$.ajax({
			type: "POST",       // 数据提交类型
			url: path, // 发送地址
			data: formData,     // 发送数据
			async: true,        // 是否异步
			dataType:'json',    // 数据类型
			processData: false, // processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			contentType: false, //
			success:function(e){
				if(e.success){
					dialog.loading.close();
					dialog.toast(e.msg, 'success', 1500);
					$('[name="img"]').val(function(n,c){
						return c==''? c + e.file_path : c + "," + e.file_path;
					});
					var img = '<a class="grids-item"><div class="del_img" onclick="del_img(this)"><i class="iconfont icon-guanbi"></i></div><img onclick="add_img(this)" src="'+e.file_path+'" alt=""></a>'
						obj.parent().before(img);
				}else{
					dialog.loading.close();
					dialog.toast(e.msg, "error", 1500);
				}
			}
		});
}
// 编辑器图片穿插
function add_img(obj){
	var obj = $(obj);
		$img = obj.attr('src');
		$img = '<p><img src="'+$img+'"></p>';
		editor.focus();
		editor.selection.insertNode($img);
}
// 删除上传图片
function del_img(obj){
	var obj = $(obj);
	var url = obj.parent().children('img').attr('src');
		console.log(url);
		$img_val = $('[name="img"]').val();
	var reg = new RegExp(url,"g");
		$img_val = $img_val.replace(reg, "");
		$('[name="img"]').val($img_val);
		obj.parent().remove();
}
// 编辑器上传文件
function upload_file(obj,path){
	var obj = $(obj);
	var formData = new FormData();
		formData.append("photo",document.getElementById("upfile").files[0]);
		formData.append('tmp_md5',tmp_md5);
		dialog.loading.open('上传中'); 
		$.ajax({
			type: "POST",       // 数据提交类型
			url: path, // 发送地址
			data: formData,     // 发送数据
			async: true,        // 是否异步
			dataType:'json',    // 数据类型
			processData: false, // processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			contentType: false, //
			success:function(e){
				if(e.error){
					dialog.loading.close();
					dialog.toast(e.info, 'success', 1500);
					var html =  '<div class="m-cell">'+
								'   <div class="cell-item">'+
								'      <div class="cell-left">文件名称:</div>'+
								'      <div class="cell-right filename">'+e.name+'<input type="hidden" name="checkbox" class="fileid" value="'+e.id+'"/></div>'+
								'   </div>'+
								'   <label class="cell-item">'+
								'      <span class="cell-left">回复可见:</span>'+
								'      <label class="cell-right">'+
								'           <input type="checkbox" name="checkbox" class="filehide"/>'+
								'           <i class="cell-checkbox-icon"></i>'+
								'      </label>'+
								'   </label>'+
								'   <div class="cell-item">'+
								'      <div class="cell-left">出售价格:</div>'+
								'      <div class="cell-right"><input type="number" pattern="[0-9]*" class="cell-input filegold" placeholder="输入出售金额" autocomplete="off" style="background: #fff"/></div>'+
								'   </div>'+
								'   <div class="cell-item">'+
								'      <div class="cell-left">文件描述:</div>'+
								'      <div class="cell-right"><input type="text" class="cell-input filemess" placeholder="输入文件描述" autocomplete="off" style="background: #fff"/></div>'+
								'   </div>'+
								'   <div class="cell-item">'+
								'      <div class="cell-left">文件操作:</div>'+
								'      <div class="cell-right"><button class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">删除</button></div>'+
								'   </div>'+
								'</div>';
						$('.file_list').append(html);
				}else{
					dialog.loading.close();
					dialog.toast(e.info, "error", 1500);
				}
			}
		});
}
// 上传板块图片
function forum_icon(obj,fid){
	var obj = $(obj);
	var formData = new FormData();
		formData.append("photo",document.getElementById("forum_icon").files[0]);
		formData.append("fid",fid);
		dialog.loading.open('上传中');
		$.ajax({
			type: "POST",       // 数据提交类型
			url: WWW+'plugins'+exp+'forum_icon', // 发送地址
			data: formData,     // 发送数据
			async: true,        // 是否异步
			dataType:'json',    // 数据类型
			processData: false, // processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			contentType: false, //
			success:function(e){
				if(e.error){
					dialog.loading.close();
					dialog.toast(e.info, 'success', 1500);
					$('.forun_icon').attr('src',WWW+e.url+'?s='+Math.round(10));
				}else{
					dialog.loading.close();
					dialog.toast(e.info, "error", 1500);
				}
			}
		});
}
// 上传板块背景图片
function upload_bg(obj,fid){
	var obj = $(obj);
	var formData = new FormData();
		formData.append("photo",document.getElementById("bgimg").files[0]);
		formData.append("fid",fid);
		dialog.loading.open('上传中');
		$.ajax({
			type: "POST",       // 数据提交类型
			url: WWW+'plugins'+exp+'bg_uploadimg', // 发送地址
			data: formData,     // 发送数据
			async: true,        // 是否异步
			dataType:'json',    // 数据类型
			processData: false, // processData 默认为false，当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			contentType: false, //
			success:function(e){
				if(e.error){
					dialog.loading.close();
					dialog.toast(e.info, 'success', 1500);
					$('.forum_thread_header').attr('style','background-image:url('+WWW+e.url+'?s='+Math.round(10)+');')
				}else{
					dialog.loading.close();
					dialog.toast(e.info, "error", 1500);
				}
			}
		});
}
// 修改板块信息
function xiuforum(obj,fid){
	var forum_color = $('[name="forum_color"]');
	var forum_mess = $('[name="forum_mess"]');
	var forum_bangui = $('[name="forum_bangui"]');
	var forum_forumg = $('[name="forumg"]');
		$.ajax({
			url: www + "plugins" + exp + "xiuforum",
			type: "POST",
			cache: false,
			data: { 
				'fid': fid,
				'forumg': forum_forumg.val(),
				'color': forum_color.val(),
				'html': forum_mess.val(),
				'bangui': forum_bangui.val()
			},
			dataType: 'json'
		}).then(function(e) {
			if(e.error){
					$('.info .title h3').css('color',forum_color.val());
					$('.info .title p').css('color',forum_color.val());
					$('.mess').html(forum_mess.val());
					dialog.loading.close();
					dialog.toast(e.info, 'success', 1500);
				
				// $('.forum_thread_header').attr('style','background-image:url('+WWW+e.url+'?s='+Math.round(10)+');')
			}else{
				dialog.loading.close();
				dialog.toast(e.info, "error", 1500);
			}

		}, function() {
			dialog.toast('请尝试重新提交', "error", 1500);
		});


}
// 点击评论图标数据库获得焦点（该功能手机端比较明显）
function forum_post_edit(tid){
	$('#input_'+tid).focus();
}
// 板块列表评论
function forum_post(obj,tid,user){
	var content = $(obj).parent().children('[name="post"]');
	var posts	= $('#posts_'+tid);
		dialog.loading.open('评论中');
		$.ajax({
			url: WWW+'post'+exp+'post',
			type: "POST",
			cache: false,
			data: {
				id:tid,
				content: content.val(),
			},
			dataType: 'json'
		}).then(function(e) {
			dialog.loading.close();
			if (e.error) {
				$('#post_list_'+tid).children('li:first-child').before('<li><a href="'+WWW+'my/'+user+'">'+user+'</a>: '+content.val()+'</li>');
				posts.text(parseInt(posts.text())+1);
				dialog.toast(e.info, 'success', 1500);
				content.val('');
			} else {
				dialog.toast(e.info, 'error', 1500);
			}
		}, function() {
			dialog.toast(e.info, 'error', 1500);
		});
}
// 板块列表点赞
function forum_vote(obj,tid,user){
	var vote_size = $('#vote_'+tid);
	var vote_user = $('#vote_user_'+tid);
		$.ajax({
			url: www + 'post' + exp + 'vote',
			type: "POST",
			cache: false,
			data: { type: 'thread1', id: tid },
			dataType: 'json'
		}).then(function(data) {
			if (obj != "" || obj != undefined || obj != null) {
				if (data.error == true) {
					dialog.toast(data.info, 'none', 1000);
					vote_size.text(parseInt(vote_size.text())+1);
					if(vote_user.text() != ''){
						vote_user.append(',<a href="'+WWW+'my/'+user+'">'+user+'</a>');
					}else{
						vote_size.parent().show();
						vote_user.append('<a href="'+WWW+'my/'+user+'">'+user+'</a>');
					}
				} else {
					dialog.toast(data.info, 'none', 1000);
				}

			}
			if (!data.error)
				dialog.toast(data.info, 'none', 1000);
		}, function() {


		});
}
// 赞踩 投票系统
function tp(type, id, obj) {
	var size = $(obj).children('p').text();
    $.ajax({
        url: www + 'post' + exp + 'vote',
        type: "POST",
        cache: false,
        data: { type: type, id: id },
        dataType: 'json'
    }).then(function(data) {
        if (obj != "" || obj != undefined || obj != null) {
            if (data.error == true) {
				dialog.toast(data.info, 'none', 1000);
				if(size == ''){
					$(obj).children('p').text(1);
				}else{
					$(obj).children('p').text(parseInt(size)+1);
				}
            } else {
                dialog.toast(data.info, 'none', 1000);
            }

        }
        if (!data.error)
			dialog.toast(data.info, 'none', 1000);


    }, function() {


    });
}

//删除主题
function del_thread(id, type) {
	dialog.confirm('真的删除?', type == 'thread' ? "该主题的所有评论也随着删除!" : '删除该评论', function () {
		$.ajax({
			url: www + type + exp + "del",
			type: "POST",
			cache: false,
			data: {
				id: id
			},
			dataType: 'json'
		}).then(function(e) {
			dialog.toast(e.error ? "操作成功" : "操作失败", e.info, e.error ? "success" : "error", 1500);
			if (e.error) {
				setTimeout(function() {
					if (type == 'thread')
						window.location.href = www;
					else
						window.location.reload();

				}, 1000);
			}

		}, function() {
			dialog.toast('请尝试重新提交', "error", 1500);
		});
	});
}
//置顶主题
function thread_top(id, type, top) {
	dialog.confirm('真的要这么做?', "置顶操作!", function () {
		$.post(www + "thread" + exp + "top", { id: id, type: type, top: top }, function(e) {
			dialog.toast(e.error ? "操作成功" : "操作失败", e.info, e.error ? "success" : "error", 1000);
			if (e.error) {

				setTimeout(function() {
					window.location.reload();
				}, 1000)
			}
		}, 'json');
	});
}
//置精主题
function thread_jing(id, type) {
	dialog.confirm('真的要这么做?', type == 'on' ? "帖子加精!" : '取消帖子置精', function () {
		$.post(WWW + "plugins" + exp + "thread_jing", { id: id, type: type}, function(e) {
			dialog.toast(e.error ? "操作成功" : "操作失败", e.info, e.error ? "success" : "error", 1000);
			if (e.error) {

				setTimeout(function() {
					window.location.reload();
				}, 1000)
			}
		}, 'json');
	});
}
//购买主题
function buy_thread(id, gold) {
	dialog.confirm('温馨提示', '你需要花费'+ gold +'金币购买主题', function () {
		$.ajax({
			url: www + 'ajax' + exp + 'buythread',
			type: "POST",
			cache: false,
			data: {
				id: id
			},
			dataType: 'json'
		}).then(function(e) {
			if (e.error) {
				window.location.reload();
			} else {
				dialog.toast(e.info, 'error', 2000);

			}
		}, function() {
			dialog.toast("购买失败", 'error', 2000);
		});
	})
}

//下载附件
function hy_downfile(id) {

    $.ajax({
        url: www + 'ajax' + exp + 'downfile' + exp + 'id' + exp + id,
        type: "GET",
        cache: false,
        dataType: 'json'
    }).then(function(e) {

        if (e.error) {
            $('body').append("<iframe style='display:none' src='" + www + 'ajax' + exp + 'downfile' + exp + 'id' + exp + id + "'></iframe>");
        } else {
            if (e.errorid == 3) {
				dialog.confirm('温馨提示', '你需要花费'+ e.info +'金币购买附件', function () {
					$.post(www + "ajax" + exp + "buyfile", { id: id }, function(e) {
						if (e.error) {
							dialog.toast(e.info, 'success', 2000);
							hy_downfile(id);
						} else {
							dialog.toast(e.info, 'error', 2000);
						}
					}, 'json');
				});
            } else {
                dialog.toast(e.info, 'error', 2000);
            }
        }
    }, function() {
		dialog.toast('请尝试重新提交', 'error', 2000);
    });
}
//锁帖 解锁 禁止回复
function set_state(id, state) {
	dialog.confirm(
		(state == 1) ? "你要解锁主题?" : '你要锁定主题?',
		(state == 1) ? "解锁后帖子可回复" : "锁定后他人无法回复该帖子，但你自己可以回复！",
		function () {
	        $.ajax({
	            url: www + 'thread' + exp + 'set_state',
	            type: "POST",
	            cache: false,
	            data: {
	                id: id,
	                state: state,
	            },
	            dataType: 'json'
	        }).then(function(e) {
	            if (e.error)
	                return window.location.reload();

				dialog.toast(e.info, "error", 1500);

	        }, function() {
	            dialog.toast('请尝试重新提交', "error", 1500);
	        });
		});

}
//添加好友
function friend_state(uid, callback) {
    $.ajax({
        url: www + 'friend' + exp + 'friend_state',
        type: "POST",
        cache: false,
        data: {
            uid: uid,
        },
        dataType: 'json'
    }).then(function(e) {
        callback(e.error, e);
    }, function() {
		dialog.toast('请尝试重新提交', "error", 1500);
    });
}
// 签到
function sign(){
	$.post(WWW+"plugins"+exp+"sign",{},function(data){
		if(data.err == 0)
		{
			dialog.toast(data.info, "none", 1500);
			$('.sign button').addClass('btn-disabled').text('今日已签到');
			$('#sign_leiji').text(data.leiji);
			$('#sign_lianxu').text(data.lianxu);
			var js_date = new Date();
			var htmlCodes = [
				'<div class="grids-txt qiandao wancheng">',
				'<span>完成</span>',
				'</div>'
				].join("");
			$('#wanchengqiandao').html(htmlCodes);
		  }else{
			dialog.toast(data.info, "none", 1500);
		}
	},"json");
}
function ajax_api(url,data,success,error){
	success = success|| null;
	error = error || null;

	$.ajax({
		url: url,
        type: "POST",
        cache: false,
        data: data,
        dataType: 'json',
        success:success,
        error:error
	});
}

// 收藏
function collection(tid,obj){
	var obj =$(obj);
	var size = parseInt(obj.children('p').text());
	$.ajax({
		url:WWW+"plugins"+exp+"collection",
		type:'post',
		dataType:'json',
		data:{'tid':tid},
		success:function(e){
			if(e.error){
				dialog.toast(e.info, 'none', 1000);
				if(e.info == '收藏成功'){
					obj.css('color','#F44336')
					obj.children('p').text(size+1);
				}else if(e.info == '已取消收藏'){
					obj.css('color','')
					obj.children('p').text(size-1);
				}
			}else{
				dialog.toast(e.info, 'none', 1000);
			}
		},
		error:function(){}
	});
}
// 登录提示
function is_login(){
    dialog.confirm('温馨提示', '需要登录后才能执行当前操作！', function () {
       window.location.href = WWW+'user'+exp+'login';
    });
}
// 内容举报
function jubao(tid){
    var jubaodata = '',
        content = $('[name="mess"]').val();
        $("[name='jubao']:checked").each(function(){
            jubaodata += jubaodata=='' ? $(this).val() : ","+$(this).val();
        });
        $.ajax({
            url: www + "plugins" + exp + "jubao",
            type: "POST",
            data: {
                tid:tid,
                state:jubaodata,
                mess:content,
            },
            dataType: 'json'
        }).then(function(e) {
            if(e.error){
                    dialog.loading.close();
                    dialog.toast(e.info, 'success', 1500);
                
                // $('.forum_thread_header').attr('style','background-image:url('+WWW+e.url+'?s='+Math.round(10)+');')
            }else{
                dialog.loading.close();
                dialog.toast(e.info, "error", 1500);
            }

        }, function() {
            dialog.toast('请尝试重新提交', "error", 1500);
        });
}
// 内容增加图章

function stamp(tid){
    var stamp = '';
        $("[name='stamp']:checked").each(function(){
            stamp += stamp=='' ? $(this).val() : ","+$(this).val();
        });
        $.ajax({
            url: www + "plugins" + exp + "stamp",
            type: "POST",
            data: {
                tid:tid,
                type:stamp,
            },
            dataType: 'json'
        }).then(function(e) {
            if(e.error){
                    dialog.loading.close();
					dialog.toast(e.info, 'success', 1500);
					setTimeout(function() {
						window.location.reload();
					}, 1500);9
					
            }else{
                dialog.loading.close();
                dialog.toast(e.info, "error", 1500);
            }

        }, function() {
            dialog.toast('请尝试重新提交', "error", 1500);
        });
}

// 删除举报信息
function del_jubao(tid){
	dialog.confirm('温馨提示', '确定要删除举报信息吗？', function () {
        $.ajax({
            url: www + "plugins" + exp + "del_jubao",
            type: "POST",
            data: {
                tid:tid
            },
            dataType: 'json'
        }).then(function(e) {
            if(e.error){
                    dialog.loading.close();
					dialog.toast(e.info, 'success', 1000);
					setTimeout(function() {
						window.location = WWW+'plugins'+exp+'jubao';
					}, 1500);

            }else{
                dialog.loading.close();
                dialog.toast(e.info, "error", 1500);
            }

        }, function() {
            dialog.toast('请尝试重新提交', "error", 1500);
		});
	});
}
// 打开发表页面
function ajax_post(url,type)
{
    $('body').css('overflow','hidden');
    $('#thread_caidan').actionSheet('close');
    $.get(url, function(s) {
        s = s.replace(/\\n|\\r/g, "");
		s = s.substring(s.indexOf("<!--ajax-"+type+" start-->"), s.indexOf("<!--ajax-"+type+" end-->"));
		setTimeout(function(){
			$('#ajax_'+type).html(s);
			$('#post').show();
			$('#post_loading_'+type).hide();
		},300);
    });
    $(document).on('click','#cancel-editor',function(){
		setTimeout(function(){
			$('body').css('overflow','scroll');
			$('#post_loading_'+type).show();
			$('#ajax_'+type).html('');
			$('#post').hide();
		},300);
    })
}
// post 页面 ajax获取分区
function fenqu(obj)
{
    var obj = $(obj);
	if(!obj.hasClass('crt')){
		$('.scrolltab-item').removeClass('crt');
		obj.addClass('crt');
		var fgid = obj.attr('data-fgid');
		var html ='';
		$.ajax({
			type: "post",
			url: obj.attr('data-url'),
			data: {fgid:fgid},
			dataType: "json",
			success: function (e) {
				if(e.code == 0){
					dialog.toast(e.error, "error", 1500);
				}
				if(e.code == 1){
					$.each(e.data, function (k, v) { 
						html += [
							'<label class="cell-item">',
							'    <span class="cell-left"><img src="'+WWW+'upload/forum'+v.id+'.png" class="post-xuand" onerror="this.src=\''+WWW+'upload/de.png\'">'+v.name+'</span>',
							'    <label class="cell-right">',
							'        <input type="radio" value="'+v.id+'" name="fenlei"/>',
							'        <i class="cell-radio-icon"></i>',
							'    </label>',
							'</label>'
						].join("");
					});
					$('#post_fennei').html(html);
				}
			}
		});
	}
}
// 板块页面获取分区
function get_form(fgid,obj){
	var obj = $(obj);
	var html= '';
		if(!obj.hasClass('crt')){
			$('.scrolltab-item').removeClass('crt');
			obj.addClass('crt');
			$('.style_list3').hide();
			$('#form_msg').html('');
			$('.no_thread').show();
			$('#no_follow').hide();
			$.ajax({
				type: "post",
				url: WWW+"Plugins"+exp+"post_fenlei",
				data: {fgid:fgid},
				dataType: "json",
				success: function (e) {
					console.log(fgid)
					if(e.code == 1){
						if(e.data != ''){
							$.each(e.data, function (k, v) { 
								var addfun = ((fgid=='my')?'follow_forum('+v.id+',\'q\',this,true)':'follow_forum('+v.id+',\'g\',this)');
								var gz = ((fgid=='my')?'取消':'关注');
								html += [
									'<li class="form_info">',
									'   <div>',
									'        <img src="'+WWW+'upload/forum'+v.id+'.png" onerror="this.src=\''+WWW+'upload/de.png\'">',
									'   </div>',
									'   <div class="form_right">',
									'      <a href="'+v.url+'" data-pjax>',
									'        <div class="form_name">'+v.name+'</div>',
									'        <div class="form_html">'+((v.html=='')?'没有板块描述':v.html)+'</div>',
									'      </a>',
									'   </div>',
									'   <div class="form_guanzhu">',
									'      '+((v.follow=='1')?'<a href="javascript:;" onclick="'+addfun+'">取消</a>':'<a href="javascript:;" onclick="'+addfun+'">'+gz+'</a>'),
									'   </div>',
									'</li>'
								].join("");
							});
							$('.style_list3').html('').html(html).show();
							$('.no_thread').hide();
						}else{
							$('.no_thread').hide();
							$('#no_follow').show();
						}
					}else{
						$('.no_thread').hide();
						html = [
							'<div class="">',
							'    <i class="icon-warn1"></i>',
							'</div>',
							'<p>'+e.error+'</p>'
						].join("");
						$('#form_msg').html(html).show();

					}
				}
			});
		}
}
// 关注与取消板块
function follow_forum(fid,type,obj,sc=false){
	var obj = $(obj);
	$.ajax({
		type: "post",
		url: www+"plugins"+exp+"follow_forum",
		data: {fid:fid,type:type},
		dataType: "json",
		success: function (e) {
			if(e.error){
				dialog.toast(e.info, "none", 1500);
				if(e.info == "关注成功"){
					obj.text('取消');
					obj.attr('onclick','follow_forum('+fid+',\'q\',this)');
				}
				if(e.info == "取消关注成功"){
					obj.text('关注');
					obj.attr('onclick','follow_forum('+fid+',\'g\',this)');
					if(sc){
						obj.parent().parent().remove();
						if(obj.parent().parent().parent().children().length == 0){
							$('#no_follow').show();
						}
					}
				}
				
			}else{
				dialog.toast(e.info, "none", 1500);
			}
		}
	});
}
function log(a){
	if(window.debug)
		console.log(a);
}
function open_thread(url){
	window.location.href = url;
}
function open_post_box(obj){
	
	//document.removeEventListener('touchmove', touchmove_handler, false);
	$(".post-box").addClass("post-box-a");
	$(obj).after('<div class="hy-back" onclick="hide_post_box(this)"></div>').addClass("hy-body-overflow");
	$("body").attr('hide_size',parseInt($("body").attr('hide_size'))+1 );
	setTimeout(function(){$(".hy-back").addClass('in');},1);

}
function hide_post_box(obj){
	//document.addEventListener('touchmove', touchmove_handler, false);
	if(obj == undefined)
		obj = '.hy-back';
	$(".post-box").removeClass("post-box-a");
	$.hy.overflow_show();
	$(".hy-back").removeClass('in');
	setTimeout(function(){
		$(obj).remove();
	},300);
	
}
function hide_lt(uid){
	 var i = parseInt($("body").attr('hide_size'))-1;
		$("body").attr('hide_size', (i<0)?0:i );
	$.hy.hide_iframe($('#lt-'+uid));
}
//点击好友 打开聊天窗口
function open_lt(username,uid,avatar){

	$("#friend-span-"+uid).removeClass("friend-show").addClass("friend-hide");
	$('#liaotian .navbar-title').text(username);
	var v = parseInt($("#message").text()) - parseInt($("#friend-span-"+uid).text());
	$(".xx").text(v);
	$("#message").html('<span class="badge badge-danger" style="position: absolute; right: 15%;">'+v+'</span>');
	if(v<1 || isNaN(v)){
		$('.xx').hide();
		$(".xx").text('0');
		$("#message").html('');
		$("#mess_d").html('');
	}

	// var obj = $.hy.create_iframe('right','lt-'+uid);
	// $.hy.show_iframe(obj);
	// var box = $('<div style="background: #f1f4f9;width:100%;height:100%"><header class="hy-header hy-bo-b"><a class="hy-header-nav hy-header-left icon icon-chevron-small-left" onclick="hide_lt('+uid+')"></a><h1 class="hy-header-title">'+username+'</h1><a class="hy-header-nav hy-header-right" onclick=""></a></header></div>');
	// obj.append(box);
	// box.append('<div class="mui-content" id="is-obj-'+uid+'"><div id="msg-list" class="is-'+uid+'"><div class="lt-id-'+uid+'" user="'+username+'" avatar="'+avatar+'"></div></div></div>');
	$('#lt').html('<div class="mui-content" id="is-obj-'+uid+'"><div id="msg-list" class="is-'+uid+'"><div class="lt-id-'+uid+'" user="'+username+'" avatar="'+avatar+'"></div></div></div>');

	// box.append('<footer class="footer-lt"><div class="footer-center"><textarea id="msg-text" type="text" class="input-text lt-text-'+uid+'"></textarea></duv><div class="footer-right"><button onclick="send_lt('+uid+',this)" class="hy-btn hy-btn-primary" type="button" style="height:36px">Send</button></div></footer>');


	get_old_chat(uid,username,avatar);

	$('.footer-right button').attr('onclick','send_lt('+uid+',this)');
	$('#msg-text').addClass('lt-text-'+uid);
	//eval('window.is_'+uid+' = null');
		
	// $.hy.show_iframe(_this);
	
	
	//console.log(document.getElementById('is-obj-'+uid).iscroll);


}

function send_lt(uid,obj){
    if($(".lt-text-"+uid).val()=='')
		return dialog.toast('内容不能为空', 'none', 1000);
    $(".lt-text-"+uid).attr('disabled','disabled');
    $(obj).attr('disabled','disabled');
    $.ajax({
        url: www + 'friend' + exp + 'send_chat',
        data: {content : $(".lt-text-"+uid).val(), uid:uid},
        type:'post',
        dataType:'json',
        success:function(e){
            if(!e.error){

				dialog.toast(e.info, 'none', 1000);
                $(obj).removeAttr('disabled');
                $(".lt-text-"+uid).removeAttr('disabled');
                return ;
            }
            add_lt(uid,'msg-item-self',window.hy_user,$(".lt-text-"+uid).val(),new Date().getHours() + ":"+ new Date().getMinutes() +":"+ new Date().getSeconds() ,window.hy_avatar);
            $(".lt-text-"+uid).val('');
            $(".lt-text-"+uid).removeAttr('disabled');
            $(obj).removeAttr('disabled');
            $(".lt-text-"+uid).focus();
            $(".is-"+uid).scrollTop(99999);

        },
        error:function(){
            $(".lt-text-"+uid).removeAttr('disabled');
            $(obj).removeAttr('disabled');
        }
    })
}

var friend_box = false;
var friend_obj = null;
function hide_friend_box(){
	// $.hy.overflow_show();

	if(friend_obj != null){
		// $.hy.hide_iframe(friend_obj);
	}
}
function tog_friend_box(){
	//$.hy.overflow_hide();
	$("#hy-mess").text("");

	
	if(friend_obj == null){
		friend_obj = '123';
		$.ajax({
	        url : www+'Friend'+exp+'friend_list',
	        type:'post',
	        dataType:'json',
	        success:function(e){
	            var html2 ='';
	            var html3 ='';
	            var html0 = '';
	            for(o in e){
	            	$(".xx").text(parseInt($(".xx").text()) + parseInt(e[o].c));
	            	if(e[o].c != 0)
	            		$(".xx").show();

	            	var time1 = new Date(parseInt(e[o].atime)*1000);
	            	var time = time1.getTime();
	            	var date=new Date();
					date.setHours(0);
					date.setMinutes(0);
					date.setSeconds(0);
					date.setMilliseconds(0);

					var time2=date.getTime();
					if(time < time2){ //非今天
						time = '16/'+time1.getMonth()+"/"+time1.getDate();
					}else{
						time = time1.getHours()+":"+time1.getMinutes();
					}
					if(e[o].atime =='0')
						time='';
	                if(e[o].state==0){
						html0 += '<a href="javascript:void(0)" onclick="open_lt(\''+e[o].user+'\','+e[o].uid+',\''+e[o].avatar.c+'\')" class="actionsheet-item" data-ydui-actionsheet="{target:\'#liaotian\',closeElement:\'#cancel_liaotian\'}"><img class="hy-ty right-10 " width="40" height="40" src="'+WWW+e[o].avatar.b+'"><div><h1>'+e[o].user+'</h1><p>'+((e[o].ps=='')?'这家伙很懒不肯写签名！':e[o].ps)+'</p><span class="badge badge-danger friend-'+(e[o].c=='0' ? 'hide' : 'show')+'" id="friend-span-'+e[o].uid+'">'+e[o].c+'</span></div></a>';
	                }else if(e[o].state==1 || e[o].state==2){
	                    html2 += '<a href="javascript:void(0)" onclick="open_lt(\''+e[o].user+'\','+e[o].uid+',\''+e[o].avatar.c+'\')" class="actionsheet-item" data-ydui-actionsheet="{target:\'#liaotian\',closeElement:\'#cancel_liaotian\'}"><img class="hy-ty right-10 " width="40" height="40" src="'+WWW+e[o].avatar.b+'"><div><h1>'+e[o].user+'</h1><p>'+((e[o].ps=='')?'这家伙很懒不肯写签名！':e[o].ps)+'</p><span class="badge badge-danger friend-'+(e[o].c=='0' ? 'hide' : 'show')+'" id="friend-span-'+e[o].uid+'">'+e[o].c+'</span></div></a>';
	                }else if(e[o].state==3){
						html3 += '<a href="javascript:void(0)" onclick="open_lt(\''+e[o].user+'\','+e[o].uid+',\''+e[o].avatar.c+'\')" class="actionsheet-item" data-ydui-actionsheet="{target:\'#liaotian\',closeElement:\'#cancel_liaotian\'}"><img class="hy-ty right-10 " width="40" height="40" src="'+WWW+e[o].avatar.b+'"><div><h1>'+e[o].user+'</h1><p>'+((e[o].ps=='')?'这家伙很懒不肯写签名！':e[o].ps)+'</p><span class="badge badge-danger friend-'+(e[o].c=='0' ? 'hide' : 'show')+'" id="friend-span-'+e[o].uid+'">'+e[o].c+'</span></div></a>';
	                } 
	            }
				$("#friend-1").append(html2);
	            $("#friend-3").append(html3);
	            $("#friend-0").append(html0);
	            $("#friend-1").prepend('<a href="javascript:void(0)" onclick="open_lt(\'系统消息\',0,\'View/hy_friend/bell.png\')" class="actionsheet-item" data-ydui-actionsheet="{target:\'#liaotian\',closeElement:\'#cancel_liaotian\'}"><img class="hy-ty right-10 " width="40" height="40" src="'+WWW+'View/hy_friend/bell.png"><div><h1>系统消息</h1><p>没有新消息</p><span class="badge badge-danger friend-hide" id="friend-span-0">0</span></div></a>');
	            window.friend_pm = 0;
	            setInterval(function(){
	                $.ajax({
	                    url:www+'Friend'+exp+'pm',
	                    type:'post',
	                    dataType:'json',
	                    data:{
	                        time:window.friend_pm
	                    },
	                    success:function(e){
	                        window.friend_pm = e.atime;
	                        if(e.error){
	                            var size =0;
	                            for(o in e.info.reverse()){
	                            	//判断聊天框是否打开 
	                                if(!$('.lt-id-'+e.info[o].uid2).length){ //未打开
	                                    if(!$('#friend-span-'+e.info[o].uid2).length){ //朋友列表不存在该用户
	                                        add_friend_li(e.info[o].uid2);//添加好友信息到好友列表
	                                    }
	                                    else{
	                                        $('#friend-span-'+e.info[o].uid2).removeClass('friend-hide').addClass('friend-show').text(e.info[o].c);
	                                        var obj = $('#friend-span-'+e.info[o].uid2).parent().parent();
											var html = obj.prop("outerHTML");
	                                        obj.parent().prepend(html);
	                                        obj.remove();
	                                    }
	                                }
	                                else{ //打开聊天框
	                                    var obj = $('.lt-id-'+e.info[o].uid2);
	                                    //判断是否已经创建
	                                    if(!obj.parent().parent().parent().hasClass('hy-iframe-a')){ 
		                                    $('#friend-span-'+e.info[o].uid2).removeClass('friend-hide').addClass('friend-show').text(e.info[o].c);
		                                    var obj1 = $('#friend-span-'+e.info[o].uid2).parent().parent();
	                                        var html = obj1.prop("outerHTML");
	                                        obj1.parent().prepend(html);
	                                        obj1.remove();
	                                    }
	                                    get_old_chat(e.info[o].uid2,obj.attr('user'),obj.attr('avatar'));
	                                }
	                                size+=parseInt(e.info[o].c);
	                            }
	                            if(size != 0 ){
	                                $(".xx").show().text(size);
	                                $("#message").html('<span class="badge badge-danger" style="position: absolute; right: 15%;">'+size+'</span>');
									$("#mess_d").html('<span class="tabbar-dot"></span>');
									var audio = document.getElementById("play-msg");
									audio.play();
									console.log('已加载');
	                            }
	                        }
	                    },error:function(){

	                    }
	                })
	            },2000);
	        },
	        error:function(){

	        }
	    })
	    return;
	}
	$("#fr-head").text("联系人");

	// $.hy.show_iframe(friend_obj);

}
function add_lt(id,pos,user,content,time,avatar){
    var c_obj = $(".lt-id-"+id);
    //console.log(c_obj);
	
	var html = '<div class="msg-item '+pos+'">'+'<img class="msg-user-img msg-user" src="'+WWW+avatar+'" alt=""><div class="msg-content"><div class="chat-body clearfix"><div class="msg-content-inner">'+ content+'</div><div class="msg-content-arrow"></div></div><div class="mui-item-clear"></div></div>';
                 
    
    c_obj.append(html);
    c_obj.scrollTop(9999);
	
	
    
	

}

function get_old_chat(uid,user,avatar){
    $.ajax({
        url:www+'Friend'+exp+'get_old_chat',
        data:{uid:uid},
        type:'post',
        dataType:'json',
        success:function(e){
			
            for(o in e.reverse()){
				//alert('1.4');
                //uid1 = 接收者
                //uid2 = 发送者
                //console.log(e[o]);
                if(e[o].uid1 == uid){
                    add_lt(uid,'msg-item-self',window.hy_user,e[o].content,e[o].time,window.hy_avatar);
                }
                else{
                    add_lt(uid,'',user,e[o].content,e[o].time,avatar);
                    if(uid == 0){
                    	e[o].content = e[o].content.replace(/<[^>]+>/g,"");
                    }
                    $("#friend-ps-"+uid).text(e[o].content);
                }


                
            }
            
            $(".is-"+uid).scrollTop(99999);
        }
        ,error: function(){

        }
    });
}

function add_friend_li(uid){
    $.ajax({
        url:www+'Friend'+exp+'user_info',
        type:'post',
        data:{uid:uid},
        dataType:'json',
        success:function(e){
            if(e.error){
                // var html = '<a href="javascript:void(0)" onclick="open_lt(\''+e.info.user+'\','+uid+',\''+e.info.avatar.c+'\')"><img class="hy-ty right-10" width="40" height="40" src="'+WWW+e.info.avatar.b+'"></span><span class="title">'+e.info.user+'</span><span class="hy-lable hy-lable-danger friend-show" id="friend-span-'+uid+'"  id="friend-span-'+uid+'">..</span></a>';
				var	html = '<a href="javascript:void(0)" onclick="open_lt(\''+e.info.user+'\','+uid+',\''+e.info.avatar.c+'\')" class="actionsheet-item" data-ydui-actionsheet="{target:\'#liaotian\',closeElement:\'#cancel_liaotian\'}"><img class="hy-ty right-10 " width="40" height="40" src="'+WWW+e.info.avatar.b+'"><div><h1>'+e.info.user+'</h1><p>'+((e.info.ps=='')?'这家伙很懒不肯写签名！':e.info.ps)+'</p><span class="badge badge-danger friend-show" id="friend-span-'+uid+'">...</span></div></a>';
	   


                $("#friend-0").prepend(html);
            }
        }
    })
}
function friend(uid,obj){
    friend_state(uid,function(b,m){
        var _obj = $(obj);
        if(m.id){
			dialog.toast(m.info, 'none', 1500);
            _obj.text("取消关注");
        }
        else{
			dialog.toast(m.info, 'none', 1500);
            _obj.text("+关注");
        }
    })
}

function url_back(test){
	//if(document.referrer =='')
		document.referrer=window.href_top;
	if(window.debug)
		console.log('来源:'+document.referrer);
	
	//return;
	if(
		document.referrer.search(WWW) == -1   || //别站跳转.
		document.referrer == '' //|| //无来路
		//document.referrer.search("/post") != -1 
		//|| document.referrer.search("/user") != -1
	){
		if(window.debug)
			console.log('后退1');
		window.location.href=WWW;
	}
	else{
		if(window.debug)
			console.log('后退2');
		if(test==true)
			$("body").attr('hide_size',parseInt($("body").attr('hide_size'))-1 );
		
		history.back(-1);
	}
}


window.iframe_size = 0;
window.now_href1 = window.location.href;
$(document).ready(function(){  
	// window.addEventListener("popstate",function(event){
	// 	if(window.debug){
	// 		console.log('触发后退事件 : '+iframe_size);
	// 		console.log("NOW_href: "+now_href1);
	// 		console.log("location: "+window.location.href);
	// 	}
	// 	if(now_href1 == window.location.href && iframe_size == 0)
	// 		return;
	// 	if(window.iframe_size >0){
	// 		if(window.debug)
	// 			console.log('iframe退');
	// 		var i = window.iframe_size--;
	// 		//document.addEventListener('touchmove', touchmove_handler, false);
	// 		if(window.debug)
	// 			console.log(i);
	// 		if(i==1){
	// 			$.hy.overflow_show();
	// 		}
	// 		$("#hy-iframe-box-"+(i)).removeClass("hy-iframe-a");
	// 		setTimeout(function(){
	// 			$("#hy-iframe-box-"+(i)).remove();
	// 		},500);
	// 		return;
	// 	}
	// 	if(window.debug)
	// 		console.log('结束后退事件');
	// 	window.location.reload()

    // });
});
var touchmove_handler = function (e) {
        e.preventDefault();
    };
    window.href_top = document.referrer;
function ajax_click(){
		if(window.debug)
	 		console.log('链接点击');
		var _this = $(this);
		var href = _this.attr('href');
		var now_href=window.location.href;
		window.href_top = now_href;
		var pos = _this.attr('pos');
		var hide_menu = _this.attr('hide_menu');
		if(pos != ''){
			var iframe = _this.attr('iframe');
			
			if(iframe=='undefined')
				iframe='';
			
			if(hide_menu =='true'){
				$.hy.canvas_hide('left');
			}
			if(iframe == 'true'){
				$(".body").html('<img src="'+WWW+'View/hy_moblie/loading.gif" style="width: 100%;">');
			}else{
				var obj = $.hy.create_iframe(pos,"hy-iframe-box-"+(++window.iframe_size));
				obj.html('<header class="hy-header hy-fix-t"><a href="javascript:history.back(-1)" class="hy-header-nav hy-header-left icon icon-chevron-small-left" ></a><h1 class="hy-header-title">加载中...</h1></header>');
				obj.append('<div class="body"><img src="'+WWW+'View/hy_moblie/loading.gif" style="width: 100%;"></div>');
				var rgb = _this.attr('rgb');
				
				if(rgb != '')
					obj.css('background',rgb);
				$.hy.show_iframe(obj);
			}
			
			
			$.ajax({
				url:href,
				type:'get',
				dataType:'html',
				success:function(data){
					$.ajaxSetup({ cache: true });
					if(iframe == 'true'){
						
						$(".body").html(data.match(/<section class="body".*?>([\s\S]*?)<\/section>/)[1]);
						$(".body a[ajax=true]").click(ajax_click);
						$(".hy-header-title").html(data.match(/<h1 class="hy-header-title".*?>([\s\S]*?)<\/h1>/)[1]);
					}else{
						setTimeout(function(){
							obj.html(data.match(/<body.*?>([\s\S]*?)<\/body>/)[1]);
							obj.find('a[ajax=true]').click(ajax_click);
						},400);
					}
            		$("title").text(data.match(/<title>([\s\S]*?)<\/title>/)[1]);
            		
				},
				error:function(){}
			});
			
			
			window.history.pushState("","",href);
		}
		return false;
	 }

$(function(){



	function iframe_forum_size(){
		$(".iframe_forum").height($(window).height() - $("#iframe-forum-top").height() -40);
	}
	iframe_forum_size();
	
	$(window).resize(iframe_forum_size);


	 $(".iframe_forum a").click(function(){
	 	$(".iframe_forum a").removeClass('active');
	 	$(this).addClass('active');
	 });
	 
	$("a[ajax=true]").click(ajax_click);
	

})

