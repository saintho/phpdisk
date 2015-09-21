<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:36:23

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: main.tpl.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('admincp_statistics')?><?php sitemap_tag(__('admincp_statistics')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('stats_tips')?></span>
</div>
<div id="warning"></div>
<?php if($install_dir_exists){ ?>
<div id="install_exists_tips" class="msg_tips"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('install_exists_tips')?></div>
<?php } ?>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0">
<tr>
	<td width="15%" align="right"><?=__('users_count')?>: </td>
	<td><?=$stats['users_count']?> , <?=__('users_locked_count')?>&nbsp;&nbsp;<a href="<?=urr(ADMINCP,"item=users&menu=extend&action=index&gid=0&orderby=is_locked")?>"><span class="txtred bold"><?=$stats['users_locked_count']?></span></a>  , <?=__('users_open_count')?>&nbsp;&nbsp;<span class="txtblue bold"><?=$stats['users_open_count']?></span></td>
	<td rowspan="6" valign="top" width="50%"><div style="font-size:14px; border:1px solid #CCC; padding:8px; height:110px"><b><u>PHPDisk系统授权信息提示：</u></b><br /><br />您的系统是正版授权，已验证激活，您可以 <a href="<?=urr(ADMINCP,"job=auth")?>" onclick="return confirm('您需要更新域名授权？');">【修改\更新域名授权&raquo;】</a><br /><br />授权使用到期时间：<span class="txtblue"><?=get_auth_time()?></span></div></td>
</tr>
<tr>
	<td align="right"><?=__('user_files_count')?>: </td>
	<td><?=$stats['user_files_count']?>  , <?=__('in_storage')?> <b><?=$stats['user_storage_count']?></b></td>
</tr>
<tr>
	<td align="right"><?=__('other_stats')?>: </td>
	<td><?=__('user_folders_count')?> <?=$stats['user_folders_count']?> </td>
</tr>
<tr>
	<td align="right"><?=__('reporting_files')?>: </td>
	<td><a href="<?=$stats[a_report_href]?>"><?=$stats['report_count']?></a></td>
</tr>
<tr>
	<td align="right"><?=__('comment_files')?>: </td>
	<td><a href="<?=$stats[a_comment_href]?>"><?=$stats['comment_count']?></a></td>
</tr>
<tr>
	<td align="right"><?=__('public_cate_files')?>: </td>
	<td><a href="<?=$stats[a_public_href]?>"><?=$stats['cate_public_count']?></a></td>
</tr>
</table>
<br />
<table width="100%" cellpadding="4" cellspacing="1" class="tableborder" style="display:<?=$show_news_frame?>">
<tr>
	<td class="table_title"><?=__('phpdisk_site_news')?></td>
</tr>
<tr>
	<td><div id="phpdisk_news"></div></td>
</tr>
</table>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="1" class="tableborder">
<tr>
	<td class="table_title" colspan="2"><?=__('system_env')?></td>
</tr>
<?php if(!$settings['online_demo']){ ?>
<tr>
	<td class="tablerow"><?=__('system_host')?>: <?=$_SERVER['SERVER_NAME']?>(<?=$_SERVER['SERVER_ADDR']?>)</td>
	<td class="tablerow" valign="top" width="50%" rowspan="6"><div style="margin-bottom:5px;"><?=__('phpdisk_email_subscribe')?></div><script >var nId = "0e1bc68fa78ff8fd7d9841059b4313737169dd94b352cf7e",nWidth="500",sColor="light",sText="<?=__('phpdisk_email_subscribe2')?>" ;</script><script src="http://list.qq.com/zh_CN/htmledition/js/qf/page/qfcode.js" charset="gb18030"></script></td>
</tr>
<tr>
	<td class="tablerow"><?=__('system_server')?>: <?=$_SERVER['SERVER_SOFTWARE']?></td>
</tr>
<?php } ?>
<tr>
	<td class="tablerow"><?=__('system_base')?>: MySQL <?=$mysql_info?>, PHP <?=PHP_VERSION?>, <?=__('system_post_file')?> <span class="bold"><?=$post_max_size?></span>, <?=__('system_upload_file')?> <span class="bold"><?=$file_max_size?></span><span class="txtred">(<?=__('max_upload_file_tips')?>)</span></td>
<tr>
	<td class="tablerow"><?=__('system_gd_info')?>: <?=$gd_support?> (<?=$gd_info?>)</td>
</tr>
<tr>
	<td class="tablerow"><?=__('iconv_txt')?>: (<?=__('iconv_support')?>: <?=$iconv_support?> <?=__('or')?> <?=__('mbstring_support')?>: <?=$mbstring_support?> ) <span class="txtgray">(<?=__('iconv_tips')?>)</span></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_commend')?>: 
	<a href="http://bbs.google.com/viewthread.php?tid=1506" target="_blank"><?=__('phpdisk_prober')?></a>
	<a href="http://www.google.com/addvalue.html" target="_blank" class="txtred"><?=__('phpdisk_addvalue')?></a>
	<a href="http://www.google.com/store.html" target="_blank" class="txtblue">【找模板】</a>
	</td>
</tr>
</table>
<br />
<table align="center" width="100%" cellpadding="4" cellspacing="1" class="tableborder">
<tr>
	<td class="table_title"><?=__('about_system')?></td>
</tr>
<tr>
	<td class="tablerow"><?=__('program_develop')?>: <a href="http://bbs.google.com/space.php?uid=1" target="_blank">along</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('official_site')?>: <a href="http://www.google.com/" target="_blank">http://www.google.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_bbs')?>: <a href="http://bbs.google.com/" target="_blank">http://bbs.google.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_demo')?>: <a href="http://demo.google.com/" target="_blank">http://demo.google.com</a></td>
</tr>
<tr>
	<td class="tablerow"><?=__('version_info')?>: <b>PHPDisk <?=PHPDISK_EDITION?> <?=PHPDISK_VERSION?> [<?=$charset_info?>]</b> (Build<?=PHPDISK_RELEASE?>)</td>
</tr>
<tr>
	<td class="tablerow"><?=__('phpdisk_commend_tips')?></td>
</tr>
</table>

</div>
</div>
<script language="javascript">
function autoupdate(){
	document.write("<img src=http://www.google.com/autoupdate.php?edition=<?=rawurlencode(PHPDISK_EDITION)?>&version=<?=rawurlencode(PHPDISK_VERSION)?>&release=<?=rawurlencode(PHPDISK_RELEASE)?>&server=<?=rawurlencode($_SERVER['HTTP_HOST'])?> width=0 height=0>");
}
autoupdate();
$('#phpdisk_news').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />官方动态数据加载中...');
$.getScript('<?=$auth[com_news_url]?>',function(){
	var arr = cb.split('|');
	if(arr[2]!=''){
	$.jBox(arr[2],{title:arr[1], buttons: {}});
	}
	$('#phpdisk_news').html(arr[0]);
});
setTimeout(function(){
	$.getScript('<?=$auth[com_upgrade_url]?>?pr=<?=PHPDISK_RELEASE?>',function(){			
		if(dt!=''){
		var arr2 = dt.split('|');
		$.jBox.messager(arr2[1],arr2[0],0);
		}
	});
},3000);
</script>
