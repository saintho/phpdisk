<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: block_public_cate_list.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="cl_box">
<div class="tit2"><?=__('cate_list')?></div>
<div class="a_list">
<!--#
if(count($C[cate_list])){
	foreach($C[cate_list] as $k => $v){
#-->
	<a href="{$v[a_public]}" id="a_cate_{$v[cate_id]}"><span>{$v['cate_name']}</span></a>
<!--#
	if(($k+1)%5==0){ echo '<div class="clear"></div>';}
	}
	if($cate_id){
#-->
<script type="text/javascript">getId('a_cate_{$cate_id}').className='cate_sel';</script>	
<!--#
	}
}
#-->
<div class="clear"></div>
</div>
</div>
