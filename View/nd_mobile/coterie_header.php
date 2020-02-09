<?php !defined('HY_PATH') && exit('HY_PATH not defined.'); ?>
<header class="m-navbar navbar-fixed coterie">
    <a href="javascript:history.back(-1);" class="navbar-item">
        <i class="icon-fanhui"></i>
    </a>
    <div class="navbar-center">
        <a href="{#HYBBS_URL('coterie')}" data-pjax><span class="navbar-title {if METHOD_NAME =='Index'}active{/if}">热门</span></a>
        <a href="{#HYBBS_URL('coterie','follow')}" data-pjax><span class="navbar-title {if METHOD_NAME =='Follow'}active{/if}">关注</span></a>
        <a href="{#HYBBS_URL('coterie','lookfor')}" data-pjax><span class="navbar-title {if METHOD_NAME =='Lookfor'}active{/if}">找人</span></a>
    </div>
</header>
<style>
    .coterie .navbar-center .navbar-title {
        width: auto;
        padding: 5px 0;
        margin: 0 10px;
    }

    .coterie .navbar-center .active {
        color: #03A9F4;
        position: relative;
        /* border-bottom: 1px solid #fff; */
    }
    .coterie .navbar-center .active::after{
        content: '';
        position: absolute;
        bottom: 3px;
        height: 3px;
        background: #fff;
        left: 11px;
        width: 16px;
        border-radius: 20px;
    }
    .navbar-center .navbar-title{
        font-size: 18px;
    }
</style>