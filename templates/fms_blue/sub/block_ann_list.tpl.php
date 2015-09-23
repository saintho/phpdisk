<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_ann_list.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="fl_box">
<div class="tit2"><?=__('disk_announce')?></div>
<ul>
<li><a href="{#urr("ann_list","")#}"><img src="images/ann_icon.gif" align="absmiddle" border="0" /><?=__('all_ann_list')?></a></li>
<!--#
if(count($ann_list_sub)){
	foreach($ann_list_sub as $v){
#-->
<li><span class="txtgray f10" style="float:right">{$v[in_time]}</span><a href="{$v[a_ann_href]}"><img src="images/icon_nav.gif" align="absmiddle" border="0" />{$v[subject]}</a></li>
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
