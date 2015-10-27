<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_header.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if(!$inner_box){#-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--#}#-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>{$title}</title>
<? if($settings[meta_ext]){echo base64_decode($settings[meta_ext]).LF;}?>
<meta name="keywords" content="{$keywords}" />
<meta name="description" content="{$description}" />
<base href="{$settings[phpdisk_url]}" />
<link rel="shortcut icon" href="favicon.ico">
<meta name="Copyright" content="Powered by PHPDisk Team, {PHPDISK_EDITION} {PHPDISK_VERSION} build{PHPDISK_RELEASE}" />
<meta name="generator" content="PHPDisk Team" />

<script type="text/javascript" src="includes/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="includes/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-zh-CN.js"></script>
<link type="text/css" rel="stylesheet" href="images/js/skins/blue/jbox.css"/>
<script type="text/javascript" src="includes/js/common.js"></script>
<script type="text/javascript" src="includes/js/tree.js"></script>
<script type="text/javascript" src="includes/js/bootstrap.min.js"></script>
<script type="text/javascript">
<!--#if($settings['cookie_domain']){#-->
document.domain = "{$settings['cookie_domain']}";
<!--#}#-->
</script>
<link rel="stylesheet" href="images/bootstrap.min.css" type="text/css">
<link href="images/common.css" rel="stylesheet" type="text/css">
<link href="{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">
</head>

<!--#if($inner_box){#-->
<body style="background:#FFFFFF">
<!--#}else{#-->
<body>
  <div class="body_top">
  <div class="wrap">
  <div class="l">{#base64_decode($settings['site_notify']);#}</div>
  <div class="m">
  <!--#if($pd_uid){#-->
  {#menu_guest_reg()#}
  <a href="{$a_index_share}">{$pd_username}</a>{#get_vip_icon()#}
  <a href="{#urr("mydisk","")#}"><?=__('mydisk')?></a>
  <a href="{#urr("mydisk","item=profile&action=multi_upload")#}"><?=__('multi_upload')?></a>
  <a href="{#urr("mydisk","item=profile&action=files")#}"><?=__('manage_file')?></a>
  <!--#if($pd_gid ==1){#-->
  <a href="{#urr(ADMINCP,"")#}" target="_blank"><?=__('admincp')?></a>
  <!--#}#-->
  <!--#}else{#-->
  <!--#if($settings[open_qq_fl]){#-->
  <a href="fastlogin/qq/oauth/qq_login.php" target="_blank"><img src="fastlogin/qq/img/qq_login.png" align="absmiddle" border="0" style="margin-top:-5px"/></a>
  <!--#}#-->
  <!--#if($settings[open_weibo_fl] && $auth[open_weibo]){#-->
  <a href="fastlogin/weibo/weibo_login.php" target="_blank"><img src="fastlogin/weibo/sina_login_btn.png" align="absmiddle" border="0" style="margin-top:-5px"/></a>
  <!--#}#-->
  <a href="{#urr("account","action=login")#}"><?=__('login')?></a>
  <a href="{#urr("account","action=register")#}"><?=__('register')?></a>
  <!--#}#-->
  <!--#include sub/block_navigation_top#-->
  <!--#if($pd_uid){#-->
  <a href="{#urr("account","action=logout")#}" onclick="return confirm('<?=__('confirm_logout')?>');"><?=__('logout')?></a>
  <!--#}#-->
  </div>
  </div>
  <div class="clear"></div>
  </div>

<div class="circle_box">
  <!--
<div class="logo_l">
<a href="./"><img src="{$user_tpl_dir}images/logo.png" align="absmiddle" border="0" alt="{$settings['site_title']}"></a>
</div>-->
<div class="logo_r">
	<!--#show_adv_data('adv_top');#-->
</div>
<div class="clear"></div>

<div class="menu">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Momoxue</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <!--#
	        foreach($C['sub_nav'] as $v){
          #-->
          <li id="nav-{$v[cate_id]}"><a href="{#urr("public","cate_id=$v[cate_id]")#}"><span>{$v[cate_name]}</span></a></li>
          <!--#
              }
          #-->
          <!--<li><a href="{#urr("public","")#}" id="nv_public"><span><?=__('share_file')?></span></a></li>-->
          <!--<li><a href="{#urr("extract","")#}" id="nv_extract"><span><?=__('file_extract')?></span></a></li>-->
          <!--<li><a href="{#urr("tag","")#}" id="nv_tag"><span><?=__('tag')?></span></a></li>
          <li><a href="{#urr("hotfile","")#}" id="nv_hotfile"><span><?=__('hotfile')?></span></a></li>
          <li><a href="{#urr("search","")#}" id="nv_search"><span><?=__('search_file')?></span></a></li>-->
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form navbar-left" role="search" method="get" action="{#urr("search","")#}">
            <div class="form-group">
              <input type="hidden" name="action" value="search">
              <input type="hidden" name="scope" value="all">
              <input type="text" name="word" class="form-control" placeholder="视频名称">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
          </form>
          <!--#if($pd_uid){#-->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$pd_username}<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!--#if($pd_gid == 1 ||$pd_gid == 5){#-->
                  <li><a href="{#urr("mydisk","")#}"><?=__('mydisk')?></a></li>
                  <li><a href="{#urr("mydisk","item=profile&action=multi_upload")#}"><?=__('multi_upload')?></a></li>
                  <li><a href="{#urr("mydisk","item=profile&action=files")#}"><?=__('manage_file')?></a></li>
                  <!--#if($pd_gid ==1){#-->
                  <li><a href="{#urr(ADMINCP,"")#}" target="_blank"><?=__('admincp')?></a></li>
                  <!--#}#-->
                <!--#}#-->
                <li><a href="{#urr("account","action=logout")#}" onclick="return confirm('<?=__('confirm_logout')?>');"><?=__('logout')?></a></li>
              </ul>
            </li>
          <!--#}else{#-->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">登陆/注册<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{#urr("account","action=login")#}"><?=__('login')?></a></li>
              <li><a href="{#urr("account","action=register")#}"><?=__('register')?></a></li>
            </ul>
          </li>
          <!--#}#-->
        </ul>
      </div>
    </div>
  </nav>
</div>


<div class="clear"></div>
<script type="text/javascript">
  jQuery("#nav-{$curr_nav}").prop('class', jQuery('#nav-{$curr_nav}').prop('class')+' active');
</script>
<!--#
if(!count($C['sub_nav'])){
#-->
<div class="sub_nav">
<ul>
<li><img src="images/icon_nav.gif" align="absmiddle" border="0" /></li>
<!--#
	foreach($C['sub_nav'] as $v){
#-->
	<li><a href="{#urr("public","cate_id=$v[cate_id]")#}">{$v[cate_name]}</a></li>
<!--#
	}
#-->
</ul>
</div>
<div class="clear"></div>
<!--#}#-->

<!--#}#-->