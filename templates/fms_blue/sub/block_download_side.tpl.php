<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_download_side.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="idx_r_box"> 
<div class="tit"><?=__('your_like_file')?></div>
<ul>
<!--#
if(count($C[you_like_file])){
	foreach($C[you_like_file] as $v){
#-->
	<li>{$v['file_size']}<a href="{$v['a_viewfile']}" target="_blank">{$v[file_icon]}{$v['file_name']}</a></li>
<!--#
	}
}else{
#-->
<li><?=__('file_not_found')?></li>
<!--#
}
#-->
</ul>
</div>
<br />
