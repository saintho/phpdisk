<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_navigation_bottom.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if(count($C[navi_bottom_link])){
	foreach($C[navi_bottom_link] as $v){
#-->
<a href="{$v['href']}" target="{$v['target']}" title="{$v['title']}">{$v['text']}</a>&nbsp;
<!--#
	}
}
#-->
