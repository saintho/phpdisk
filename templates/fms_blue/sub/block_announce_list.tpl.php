<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_announce_list.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="panel panel-default">
	<div class="panel-heading"><span style="float:right; font-size:12px"><a href="{#urr("ann_list","")#}"><?=__('more')?></a></span><?=__('disk_announce')?></div>
		<ul class="list-group">
		<!--#
		if(count($C[ann_list])){
			foreach($C[ann_list] as $v){
		#-->
		<li class="list-group-item"><span class="txtgray f10" style="float:right">{$v[in_time]}</span><a href="{$v[a_ann_href]}" target="_blank"><img src="images/icon_nav.gif" align="absmiddle" border="0" />{$v[subject]}</a></li>
		<!--#
			}
		}else{
		#-->
		<li><?=__('announce_not_found')?></li>
		<!--#
		}
		#-->
		</ul>
</div>
