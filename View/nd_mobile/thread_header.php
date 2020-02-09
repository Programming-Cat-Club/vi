<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">帖子详情</span>
    </div>
    <a href="javascript:;" class="navbar-item" data-ydui-actionsheet="{target:'#thread_caidan',closeElement:'#cancel'}">
        <i class="icon-yduigengduo"></i>
    </a>
</header>
{if IS_LOGIN }
    {if $thread_data['uid'] == NOW_UID || NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$thread_data['fid'])}
    {include common/ajax_edit}
    {/if}
{/if}
<div class="m-actionsheet" id="thread_caidan">
    {if IS_LOGIN }
        {if NOW_GID == C("ADMIN_GROUP")}
            {if $thread_data['top'] == 2}
            <a href="javascript:;" class="actionsheet-item" onclick="thread_top({$thread_data.tid},'off',2)">{$_LANG['取消全站置顶']} </a>
            {else}
            <a href="javascript:;" class="actionsheet-item" onclick="thread_top({$thread_data.tid},'on',2)">{$_LANG['全站置顶']} </a>
            {/if}
        {/if}
        {if NOW_GID == C("ADMIN_GROUP")}
            <a href="javascript:;" class="actionsheet-item" data-ydui-actionsheet="{target:'#tuzhang',closeElement:'#cancel'}">图章设置 </a>
        {/if}
        {if NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$thread_data['fid'])}
            {if $thread_data['top'] == 1}
            <a href="javascript:;" class="actionsheet-item" onclick="thread_top({$thread_data.tid},'off',1)">{$_LANG['取消板块置顶']} </a>
            {else}
            <a href="javascript:;" class="actionsheet-item" onclick="thread_top({$thread_data.tid},'on',1)">{$_LANG['板块置顶']} </a>
            {/if} 
        {/if}
        {if $thread_data['uid'] == NOW_UID || NOW_GID == C("ADMIN_GROUP") || is_forumg($forum,NOW_UID,$thread_data['fid'])}
            <a class="actionsheet-item" href="javascript:;" data-ydui-actionsheet="{target:'#ajax_edit_page',closeElement:'#cancel-editor'}" onclick="ajax_post('{php HYBBS_URL('post','edit',['id'=>$post_data['pid']]); }','edit')">{$_LANG['编辑文章']} </a>
            <a class="actionsheet-item" onclick="set_state({$thread_data.tid},{$thread_data.state})">{if $thread_data['state']}{$_LANG['解锁帖子']}{else}{$_LANG['锁定帖子']}{/if} </a>
        
            <a class="actionsheet-item" onclick="del_thread({$thread_data.tid},'thread')" style="color: #F44336">{$_LANG['删除帖子']} </a>
        {/if}
    {/if}
    <a href="javascript:;" class="actionsheet-item" data-ydui-actionsheet="{target:'#jubao',closeElement:'#cancel'}">举报</a>
    <a href="javascript:;" class="actionsheet-item" data-ydui-actionsheet="{target:'#fenxiang',closeElement:'#cancel'}">分享</a>
    <a href="javascript:;" class="actionsheet-action" id="cancel">取消</a>
</div>
<!-- 内容举报 -->
<div class="m-actionsheet" id="jubao" style="height: 100%;">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:;" class="navbar-item" id="cancel">
            <i class="icon-cha"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">内容举报</span>
        </div>
    </header>
    <div class="g-view" style="height: 100%;overflow-y: scroll">
        <div class="m-celltitle" style="margin-top: 15px;">举报原因</div>
            <form id="jubao">
                <div class="m-cell jubao">
                    <label class="cell-item">
                        <span class="cell-left">诱导行为</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="1"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">欺诈</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="2"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">色情</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="3"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">违法犯罪</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="4"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">骚扰</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="5"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">其他</span>
                        <label class="cell-right">
                            <input type="checkbox" name="jubao" value="6"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                </div>
                <div class="m-celltitle">描述</div>
                <div class="m-cell">
                    <div class="cell-item">
                        <div class="cell-right">
                            <textarea class="cell-textarea" name="mess" placeholder="输入一段描述" style="font-size: 16px;"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div style="margin: -10px 15px 0;">
                <button type="button" class="btn-block btn-primary btn-disabled" id="tijiao" onclick="jubao({$thread_data.tid})">举报</button>
            </div>
    </div>
</div>
<!-- 内容加图章 -->
<div class="m-actionsheet" id="tuzhang" style="height: 100%;">
    <header class="m-navbar navbar-fixed">
        <a href="javascript:;" class="navbar-item" id="cancel">
            <i class="icon-cha"></i>
        </a>
        <div class="navbar-center">
            <span class="navbar-title">增加图章</span>
        </div>
    </header>
    <div class="g-view" style="height: 100%;overflow-y: scroll">
        <div class="m-celltitle" style="margin-top: 15px;">选择类型</div>
            <form id="stamp">
                <div class="m-cell stamp">
                    <label class="cell-item">
                        <span class="cell-left">普通</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="0"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">精华</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="1"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">热帖</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="2"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">美图</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="3"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">优秀</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="4"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">推荐</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="5"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">原创</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="6"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">爆料</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="7"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">版主认证</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="8"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                    <label class="cell-item">
                        <span class="cell-left">版主推荐</span>
                        <label class="cell-right">
                            <input type="radio" name="stamp" value="9"/>
                            <i class="cell-checkbox-icon"></i>
                        </label>
                    </label>
                </div>
            </form>
            <div style="margin: -10px 15px 0;">
                <button type="button" class="btn-block btn-primary btn-disabled" id="btn-stamp" onclick="stamp({$thread_data.tid})">确定</button>
            </div>
    </div>
</div>

