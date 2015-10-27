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
<div class="panel panel-default">
	<div class="panel-heading">分类列表</div>
	<ul class="list-group">
		<!--#
		if(count($C[cate_list])){
			foreach($C[cate_list] as $k => $v){
		#-->
			<a class="list-group-item" href="{$v[a_public]}" id="a_cate_{$v[cate_id]}"><span>{$v['cate_name']}</span></a>
		<!--#
			if(($k+1)%5==0){ echo '<div class="clear"></div>';}
			}
			if($cate_id){
		#-->
			<script type="text/javascript">
				var classname = jQuery('#a_cate_{$cate_id}').prop('class');
				jQuery('#a_cate_{$cate_id}').prop('class',classname+' active');
			</script>
		<!--#
			}
		}
		#-->
	</ul>
</div>
