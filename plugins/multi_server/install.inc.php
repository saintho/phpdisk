<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: install.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
function install_plugin(){
	global $db,$tpf,$db_charset;
	$sql = "CREATE TABLE IF NOT EXISTS `{$tpf}servers` (
  `server_id` smallint(5) unsigned NOT NULL auto_increment,
  `server_oid` smallint(5) unsigned NOT NULL default '0',
  `server_name` varchar(50) NOT NULL,
  `server_host` varchar(100) NOT NULL,
  `server_dl_host` TEXT NOT NULL,
  `server_closed` tinyint(1) unsigned NOT NULL default '0',
  `server_store_path` varchar(50) NOT NULL,
  `server_key` varchar(50) NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`server_id`),
  KEY `server_oid` (`server_oid`)
) ENGINE=MyISAM  DEFAULT CHARSET={$db_charset} AUTO_INCREMENT=2 ;";

	$db->query($sql);
	
	$sql = "INSERT INTO `{$tpf}servers` (`server_id`, `server_oid`, `server_name`, `server_host`, `server_closed`, `server_store_path`, `server_key`, `is_default`) VALUES (1, 0, 'Local Server', '-', 0, '-', '', 9);";
	$db->query($sql);
	return true;
}
function uninstall_plugin(){
	global $db,$tpf;
	$db->query("DROP TABLE IF EXISTS `{$tpf}servers`;");
	return true;
}
?>