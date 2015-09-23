<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: mydisk.php 25 2011-03-04 07:36:51Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

define('IN_MYDISK' ,true);
$inner_box = true;

$uid = (int)gpc('uid','G',0);
$folder_id = (int)gpc('folder_id','G',0);
$plugin_type = trim(gpc('plugin_type','G',''));
$hash = trim(gpc('hash','G',''));

$md5_sign = md5($uid.$folder_id.$plugin_type.$settings[phpdisk_url]);

if($md5_sign<>$hash){
	exit('[PHPDisk] Error Params!');
}
require_once template_echo('my_header',$user_tpl_dir);
require_once PHPDISK_ROOT."modules/plugin_upload.inc.php";
require_once template_echo('pd_footer',$user_tpl_dir);


?>


