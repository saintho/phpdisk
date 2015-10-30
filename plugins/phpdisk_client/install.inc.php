<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: install.inc.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
function install_plugin(){
	global $db,$tpf,$db_charset;

	$sql = "CREATE TABLE IF NOT EXISTS `{$tpf}uploadx_files` (
  `id` char(8) NOT NULL,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(30) NOT NULL,
  `file_size` int(10) unsigned NOT NULL DEFAULT '0',
  `file_parts` int(10) unsigned NOT NULL DEFAULT '0',
  `file_local_path` varchar(255) NOT NULL,
  `file_store_path` varchar(100) NOT NULL,
  `file_real_name` varchar(255) NOT NULL,
  `file_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `file_time` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_state` (`file_state`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET={$db_charset};";
	$db->query($sql);	
	
	return true;
}
function uninstall_plugin(){
	global $db,$tpf;
	$db->query("DROP TABLE IF EXISTS `{$tpf}uploadx_files`;");
	return true;
}
?>