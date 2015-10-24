<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-23 17:33:00

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: cache.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action =='update'){ ?>
<div id="container">
<h1><?=__('update_cache_title')?><?php sitemap_tag(__('update_cache_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('update_cache_tips')?></span>
</div>
<div>
<br />
<br />
<br />
<form name="frm" action="<?=urr(ADMINCP,"item=cache&menu=tool")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<ul>
	<li><input type="checkbox" name="datas[cache]" value="cache" id="_c" checked="checked" /><label for="_c"><?=__('cache_data')?></label>&nbsp;&nbsp;
	<input type="checkbox" name="datas[tpl]" value="tpl" id="_t" /><label for="_t"><?=__('tpl_data')?></label>&nbsp;&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/></li>
	<li>&nbsp;</li>
</ul>
</form>
<br />
<br />

</div>
</div>
</div>
<?php }elseif($action =='search_index'){ ?>
<div id="container">
<h1><?=__('search_index')?><?php sitemap_tag(__('search_index')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('search_index_tips')?></span>
</div>
<div>
<form name="frm" action="<?=urr(ADMINCP,"item=cache&menu=tool")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($C['search_list'])){
 ?>
<tr class="bold">
	<td width="50%"><?=__('search_word')?></td>
	<td><?=__('search_time')?></td>
	<td><?=__('search_count')?></td>
</tr>
<?php 
	foreach($C['search_list'] as $v){
 ?>
<tr>
	<td><input type="checkbox" name="searchids[]" id="searchids" value="<?=$v['searchid']?>" />&nbsp;<a href="<?=urr("search","action=search&word=".rawurlencode($v[word])."&scope=$v[scope]")?>" target="_blank"><?=$v[word]?></a></td>
	<td><?=date("Y-m-d H:i:s",$v['search_time'])?></td>
	<td><?=$v['total_count']?></td>
</tr>	
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="4"><?=$page_nav?>&nbsp;</td>
</tr>
<?php } ?>	
<tr>
	<td colspan="4"><input type="submit" class="btn" value="<?=__('btn_delete')?>"/>&nbsp;<a href="<?=urr(ADMINCP,"item=$item&menu=tool&action=truncate")?>" onclick="return confirm('<?=__('confirm_truncate')?>');"><?=__('btn_truncate')?></a></td>
</tr>
<?php 
}else{
 ?>
<tr>
	<td><?=__('search_index_not_found')?></td>
</tr>
<?php 
}
 ?>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("searchids[]") != true){
		alert("<?=__('please_select_operation_index')?>");
		return false;
	}
}
</script>
</div>
</div>
</div>
<?php } ?>
