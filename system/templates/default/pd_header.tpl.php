<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:30:05

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
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
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if(!$inner_box){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>" />
<title><?=$title?></title>
<?php if($settings[meta_ext]){echo base64_decode($settings[meta_ext]).LF;} ?>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<base href="<?=$settings[phpdisk_url]?>" />
<link rel="shortcut icon" href="favicon.ico">
<meta name="Copyright" content="Powered by PHPDisk Team, <?=PHPDISK_EDITION?> <?=PHPDISK_VERSION?> build<?=PHPDISK_RELEASE?>" />
<meta name="generator" content="PHPDisk Team" />
<script type="text/javascript" src="includes/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="images/js/jquery.jBox-zh-CN.js"></script>
<link type="text/css" rel="stylesheet" href="images/js/skins/blue/jbox.css"/>
<script type="text/javascript" src="includes/js/common.js"></script>
<script type="text/javascript" src="includes/js/tree.js"></script>
<script type="text/javascript">
<?php if($settings['cookie_domain']){ ?>
document.domain = "<?=$settings['cookie_domain']?>";
<?php } ?>
</script>
<link href="images/common.css" rel="stylesheet" type="text/css">
<link href="<?=$user_tpl_dir?>images/style.css" rel="stylesheet" type="text/css">
</head>

<?php if($inner_box){ ?>
<body style="background:#FFFFFF">
<?php }else{ ?>
<body>
<?php require_once template_echo('sub/admincp_fast','templates/default/'); ?>
<div class="body_top">
<div class="l"><?=base64_decode($settings['site_notify']);?></div>
<div class="m">
<?php if($pd_uid){ ?>
<?=menu_guest_reg()?>
<a href="<?=$a_index_share?>"><?=$pd_username?></a><?=get_vip_icon()?>
<a href="<?=urr("mydisk","")?>"><?=__('mydisk')?></a>
<a href="<?=urr("mydisk","item=profile&action=multi_upload")?>"><?=__('multi_upload')?></a>
<a href="<?=urr("mydisk","item=profile&action=files")?>"><?=__('manage_file')?></a>
<a href="<?=urr("search","")?>"><?=__('search_file')?></a>
<?php if($pd_gid ==1){ ?>
<a href="<?=urr(ADMINCP,"")?>" target="_blank"><?=__('admincp')?></a>
<?php } ?>
<?php }else{ ?>
<?php if($settings[open_qq_fl]){ ?>
<a href="fastlogin/qq/oauth/qq_login.php" target="_blank"><img src="fastlogin/qq/img/qq_login.png" align="absmiddle" border="0"/></a>
<?php } ?>
<?php if($settings[open_weibo_fl] && $auth[open_weibo]){ ?>
<a href="fastlogin/weibo/weibo_login.php" target="_blank"><img src="fastlogin/weibo/sina_login_btn.png" align="absmiddle" border="0"/></a>
<?php } ?>
<a href="<?=urr("account","action=login")?>"><?=__('login')?></a>
<a href="<?=urr("account","action=register")?>"><?=__('register')?></a>
<a href="<?=urr("search","")?>"><?=__('search_file')?></a>
<?php } ?>
<?php require_once template_echo('sub/block_navigation_top','templates/default/'); ?>
<?php if($pd_uid){ ?>
<a href="<?=urr("account","action=logout")?>" onclick="return confirm('<?=__('confirm_logout')?>');"><?=__('logout')?></a>
<?php } ?>
</div>

<div class="clear"></div>
</div>

<div class="circle_box">
<?php show_adv_data('adv_top'); ?>
<br />
<?php if(in_array($curr_script,array('index','viewfile','space','account','download','download2'))){ ?>
<div align="center" class="logo">
<?php }else{ ?>
<div class="logo">
<?php } ?>
<?php if($curr_script=='space' || $curr_script=='viewfile'){ ?>
<a href="<?=$logo_url?>" target="_blank"><img src="<?=$logo?>" align="absmiddle" border="0"></a>
<?php }else{ ?>
<a href="./"><img src="<?=$user_tpl_dir?>images/logo.png" align="absmiddle" border="0" alt="<?=$settings['site_title']?>"></a>
<?php } ?>
</div>
<div class="clear"></div>
<?php } ?>
