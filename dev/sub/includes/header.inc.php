<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: header.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
$folder_id = (int)gpc('folder_id','G',0);
$a_index_share = urr("space","username=".rawurlencode($pd_username));
$a_upload_file = urr("mydisk","item=upload&folder_id=$folder_id&uid=$pd_uid");
$a_income = urr("income","");
$a_profile = urr("mydisk","item=profile");

require_once template_echo('pd_header',$user_tpl_dir);

?>