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
	$sql = "CREATE TABLE IF NOT EXISTS `{$tpf}vip_orders` (
  `order_id` int(11) unsigned NOT NULL auto_increment,
  `pay_method` varchar(10) NOT NULL,
  `userid` int(10) unsigned NOT NULL default '0',
  `vip_id` int(10) unsigned NOT NULL default '0',
  `order_number` varchar(50) NOT NULL,
  `total_fee` float unsigned NOT NULL default '0',
  `pay_status` varchar(10) NOT NULL,
  `retcode` tinyint(3) unsigned NOT NULL default '0',
  `in_time` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`order_id`),
  KEY `pay_method` (`pay_method`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET={$db_charset} AUTO_INCREMENT=1 ;";
	$db->query($sql);

	return true;
}
function uninstall_plugin(){
	global $db,$tpf;
	$db->query("DROP TABLE IF EXISTS `{$tpf}vip_orders`;");
	return true;
}
?>