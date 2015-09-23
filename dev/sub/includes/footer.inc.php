<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: footer.inc.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
*/

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

$site_index = '<a href="./">'.$L['site_index'].'</a>';
$contact_us = $settings['contact_us'] ? '&nbsp;<a href="mailto:'.$settings['contact_us'].'">'.$L['contact_us_txt'].'</a>' : '';
$miibeian = $settings['miibeian'] ? '&nbsp;<a href="http://www.miibeian.gov.cn/" target="_blank">'.$settings['miibeian'].'</a>' : '';
$site_stat = $settings['site_stat'] ? '&nbsp;'.html_entity_decode($settings['site_stat']) : '';
$pageinfo = page_end_time();	

if($in_front){
	require_once template_echo('pd_footer',$user_tpl_dir);
}
if($q){
	$db->free($q);
}
$db->close();
unset($C,$L,$tpf,$configs,$rs);
ob_end_flush();

?>