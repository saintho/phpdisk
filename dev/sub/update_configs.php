<?php 
##
#	Project: PHPDisk Enterprice Edition
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: update_configs.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##

include "includes/commons.inc.php";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHPDisk Remote Server</title>
<style type="text/css">body{font-size:12px}</style>
</head>

<body>
<div id="tips" style="padding:10px"><img src="images/ajax_load_bar.gif" align="absmiddle" border="0"><Br><?=__('sub_server_config_processing')?></div>
<script type="text/javascript">
<?
$code = gpc('code','G','');
$up_size = gpc('up_size','G','');
$dir = PHPDISK_ROOT.'system/global/';
make_dir($dir);
$upload_max = get_byte_value(ini_get('upload_max_filesize'));
$post_max = get_byte_value(ini_get('post_max_size'));
$max_php_file_size = min($upload_max, $post_max);
$up_size = $max_php_file_size;
if($up_size==$max_php_file_size){
	$str = '您的网盘支持单个文件上传最大 <u style=\"font-size:14px;\">'.str_replace(' ','',get_size($max_php_file_size,'B',0)).'B</u>';
}else{
	$str = '您的网盘支持单个文件上传信息:<br>网盘主站, <u>'.str_replace(' ','',get_size($max_php_file_size,'B',0)).'B</u> ; 子服, <u>'.str_replace(' ','',get_size($up_size,'B',0)).'B</u><br><span <span style=\"color:red\">两个服务配置不一致！请重新配置，否则文件上传将可能会出现异常。</span>';
}

if($code && ($code==$configs['server_key'])){
	settings_cache();
	lang_cache();
	tpl_cache();
	group_settings_cache();
	echo 'var callback="[PHPDisk Tips] <span style=\"color:blue;\">'.__('sub_server_config_update_success').'</span><br><br>'.$str.'";';
}else{
	echo 'var callback="[PHPDisk Tips] <span style=\"color:red\">'.__('sub_server_config_update_fail').'</span><br><br>'.$str.'";';
}

?>
function update_config(){
	document.getElementById('tips').innerHTML = callback;
	document.getElementById('tips').innerHTML += '<br><br><div align="center"><input type="button" class="btn" onclick="javascript:window.close();" value="<?=__('btn_close')?>"></div>';
}
setTimeout('update_config()',1250);
setTimeout(function(){window.close();},8000);
</script>
</body>
</html>
