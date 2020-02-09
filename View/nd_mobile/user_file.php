<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
{include common/head}
<header class="m-navbar navbar-fixed">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <span class="navbar-title">我的文件</span>
    </div>
</header>
<?php
    // 我的文件查询
    $File = S('fileinfo');
    $file = $File->select(
        [
            '[>]file'=>['fileid'=>'id']
        ],
        [
            'fileinfo.tid',
            'file.filesize',
            'file.filename',
            'file.atime',
        ],
        [
            'fileinfo.uid'=>NOW_UID,
            "ORDER" => ["file.atime"=>'DESC'],
        ]
    );
?>
<style>
    .file{
        background: #fff;
        margin-top: 15px;
        padding: 10px;
    }
    .file li{
        list-style: none;
        font-size: 16px;
        color: #444;
        line-height: 43px;
        border-bottom: 1px solid #f3f3f3;
    }
    .file li:last-child{
        border-bottom: none;
    }
    .file a{
        display: flex;
        align-items: center;
    }
    .file .name{
        color: #00BCD4;
        width: 100%;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
</style>
<div class="g-view">
    <div class="user_thread">
        {if $file}
        <div class="file">
        {foreach $file as $v}
            <li>
                <a href="{#HYBBS_URL('thread',$v['tid'])}" data-pjax>
                    <span class="name">{$v.filename}</span>
                    <span style="width:75px;text-align: right;">{php echo round($v['filesize']/1024/1024,2);}M</span>
                    <span style="width:160px;text-align: right;">{php echo humandate($v['atime'])}上传</span>
                </a>
            </li>
            {/foreach}
        </div>
        {else}
        <div class="no_thread">
            <i class="icon-meiyouguanzhu"></i>
            <p>还没有上传过附件!</p>
        </div>
        {/if}
    </div>
</div>

{include common/footer} {include common/foot}