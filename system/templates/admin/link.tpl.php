<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-28 23:13:48

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: link.tpl.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if($action == 'index'){
 ?>
<div id="container">
<h1><?=__('links_manage')?><?php sitemap_tag(__('links_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('links_manage_tips')?></span>
</div>
<form name="link_form" action="<?=urr(ADMINCP,"item=link&menu=extend")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($links)){
 ?>
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold"><?=__('link_title')?></td>
	<td width="40%" class="bold"><?=__('link_url')?></td>
	<td class="bold"><?=__('link_logo')?></td>
	<td class="bold"><?=__('operation')?></td>
</tr>
<?php 
	foreach($links as $k => $v){
 ?>
<tr>
	<td>
	<input type="text" name="show_order[]" value="<?=$v['show_order']?>" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="linkids[]" value="<?=$v['linkid']?>" />
	</td>
	<td><input type="text" name="link_titles[]" value="<?=$v['title']?>" /></td>
	<td><a href="<?=$v['url']?>" target="_blank"><?=$v['url']?></a></td>
	<td><?=$v['logo']?></td>
	<td><a href="<?=$v['a_modify_link']?>" id="p_<?=$k?>"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;<a href="<?=$v['a_change_status']?>"><?=$v['status_text']?></a>
	<div id="c_<?=$k?>" class="menu_box2 menu_common">
	<a href="<?=$v['a_modify_link']?>"><?=__('modify')?></a>
	<a href="<?=$v['a_delete_link']?>" onclick="return confirm('<?=__('links_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','-x','');</script>
	</td>
</tr>
<?php 
	}
	unset($links);
}else{	
 ?>
<tr>
	<td colspan="6" align="center"><?=__('links_not_found')?></td>
</tr>
<?php 
}
 ?>
<tr>
	<td align="center" colspan="5"><input type="button" class="btn" value="<?=__('add_links')?>" onclick="go('<?=urr(ADMINCP,"item=link&menu=extend&action=add_link")?>');" /> <input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<?php 
}elseif($action =='add_link' || $action =='modify_link'){
 ?>
<div id="container">
<?php if($action =='add_link'){ ?>
<h1><?=__('add_links_title')?></h1>
<?php }else{ ?>
<h1><?=__('modify_links_title')?></h1>
<?php } ?>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_links_list_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=link&menu=extend")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="linkid" value="<?=$linkid?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><?=__('link_title')?>:</td>
	<td><input type="text" name="link_title" value="<?=$link_title?>" maxlength="50" /></td>
</tr>
<tr>
	<td><?=__('link_url')?>:</td>
	<td><input type="text" name="link_url" size="50" value="<?=$link_url?>" maxlength="100" /></td>
</tr>
<tr>
	<td><?=__('link_logo')?>:</td>
	<td><input type="text" name="link_logo" size="50" value="<?=$link_logo?>" maxlength="200" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.link_title.value.strtrim().length <1){
		alert("<?=__('link_title_error')?>");
		o.link_title.focus();
		return false;
	}
	if(o.link_url.value.strtrim().length <7){
		alert("<?=__('link_url_error')?>");
		o.link_url.focus();
		return false;
	}
}
</script>
<?php 
}
 ?>
