<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 19:22:36

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: tag.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('tag_manage')?><?php sitemap_tag(__('tag_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('tag_manage_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=file")?>" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<?php 
if(count($tags)){
 ?>
<tr class="bold">
	<td width="50%"><?=__('tag_name')?></td>
	<td align="center"><?=__('tag_count')?></td>
	<td align="center"><?=__('status')?></td>
</tr>
<?php 
	foreach($tags as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td>
	<input type="checkbox" name="tagids[]" id="tagids" value="<?=$v['tag_id']?>"  /> <a href="<?=$v['a_tag']?>" target="_blank"><?=$v['tag_name']?></a>
	</td>
	<td align="center"><?=$v['tag_count']?></td>
	<td align="center"><?=$v['status']?></td>
</tr>	
<?php 
	}
	unset($tags);
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php } ?>
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.tagids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.tagids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="chg_show" id="chg_show" /><label for="chg_show"><?=__('is_show')?></label>&nbsp;
	<input type="radio" name="task" value="chg_hidden" id="chg_hidden" /><label for="chg_hidden"><?=__('is_hidden')?></label>&nbsp;
	<input type="radio" name="task" value="del_tag" id="del_tag" /><label for="del_tag"><?=__('delete')?></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td align="middle"><?=__('tags_not_found')?></td>
</tr>
<?php 
}
 ?>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("tagids[]") != true){
		alert("<?=__('please_select_tags')?>");
		return false;
	}
	if(getId('chg_show').checked ==false && getId('chg_hidden').checked ==false && getId('del_tag').checked ==false){
		alert("<?=__('please_select_tag_op')?>");
		return false;
	}
}
</script>
</div>
</div>
