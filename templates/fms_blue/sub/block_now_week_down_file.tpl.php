<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_now_week_down_file.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="panel panel-default">
	<div class="panel-heading"><?=__('now_week_down_file')?></div>
	<ul class="list-group">
	<!--#
	if(count($C[now_week_down_file])){
		foreach($C[now_week_down_file] as $v){
	#-->
		<li class="list-group-item">{$v['file_size']}<a href="{$v['a_viewfile']}" target="_blank">{$v[file_icon]}{$v['file_name']}</a></li>
	<!--#
		}
	}
	#-->
	</ul>
</div>