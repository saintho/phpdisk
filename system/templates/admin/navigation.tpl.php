<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-09 17:38:37

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: navigation.tpl.php 121 2014-03-04 12:38:05Z along $
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
<h1><?=__('navigation_title')?><?php sitemap_tag(__('navigation_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('navigation_list_tips')?></span>
</div>
<form name="link_form" action="<?=urr(ADMINCP,"item=navigation&menu=extend")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($navigations)){
 ?>
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold"><?=__('name')?></td>
	<td width="35%" class="bold"><?=__('href')?></td>
	<td class="bold"><?=__('target')?></td>
	<td class="bold"><?=__('position')?></td>
	<td class="bold"><?=__('operation')?></td>
</tr>
<?php 
	foreach($navigations as $k => $v){
 ?>
<tr>
	<td>
	<input type="text" name="show_order[]" value="<?=$v['show_order']?>" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="navids[]" value="<?=$v['navid']?>" />
	</td>
	<td><input type="text" name="nav_texts[]" value="<?=$v['text']?>" /></td>
	<td><a href="<?=$v['href']?>" target="_blank"><?=$v['href']?></a></td>
	<td><?=$v['target']?></td>
	<td><?=$v['position']?></td>
	<td><a href="<?=$v['a_modify_nav']?>" id="p_<?=$k?>"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_<?=$k?>" class="menu_box2 menu_common">
	<a href="<?=$v['a_modify_nav']?>"><?=__('modify')?></a>
	<a href="<?=$v['a_delete_nav']?>" onclick="return confirm('<?=__('navigation_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','-x','');</script>
	</td>
</tr>
<?php 
	}
	unset($navigations);
}else{	
 ?>
<tr>
	<td><?=__('navigation_not_found')?></td>
</tr>
<?php 
}
 ?>
<tr>
	<td align="center" colspan="6"><input type="button" class="btn" value="<?=__('add_new_navigation')?>" onclick="go('<?=urr(ADMINCP,"item=navigation&menu=extend&action=add_nav")?>');" /> <input type="submit" class="btn" value="<?=__('btn_update')?>" /></td>
</tr>
</table>
</form>
</div>
</div>
<?php 
}elseif($action =='add_nav' || $action =='modify_nav'){
 ?>
<div id="container">
<?php if($action =='add_nav'){ ?>
<h1><?=__('add_navigation_title')?></h1>
<?php }else{ ?>
<h1><?=__('edit_navigation_title')?></h1>
<?php } ?>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_navigation_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=navigation&menu=extend")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="navid" value="<?=$navid?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><?=__('nav_text')?>:</td>
	<td><input type="text" name="nav_text" value="<?=$nav_text?>" maxlength="30" /></td>
</tr>
<tr>
	<td><?=__('nav_title')?>:</td>
	<td><input type="text" name="nav_title" value="<?=$nav_title?>" maxlength="50" /></td>
</tr>
<tr>
	<td><?=__('nav_href')?>:</td>
	<td><input type="text" name="nav_href" size="50" value="<?=$nav_href?>" maxlength="80" /></td>
</tr>
<tr>
	<td><?=__('nav_target')?>:</td>
	<td>
	<select name="nav_target">
		<option <?=ifselected('_self',$nav_target,'str')?>>_self</option>
		<option <?=ifselected('_blank',$nav_target,'str')?>>_blank</option>
		<option <?=ifselected('_parent',$nav_target,'str')?>>_parent</option>
		<option <?=ifselected('_top',$nav_target,'str')?>>_top</option>
	</select>
	</td>
</tr>
<tr>
	<td><?=__('nav_position')?>:</td>
	<td><input type="radio" name="nav_position" value="top" id="top" <?=ifchecked('top',$nav_position,'str')?> /><label for="top"><?=__('position_top')?></label>&nbsp;<input type="radio" name="nav_position" value="bottom" id="bottom" <?=ifchecked('bottom',$nav_position,'str')?>/><label for="bottom"><?=__('position_bottom')?></label></td>
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
	if(o.nav_text.value.strtrim().length <1){
		alert("<?=__('nav_text_error')?>");
		o.nav_text.focus();
		return false;
	}
	if(o.nav_href.value.strtrim().length <7){
		alert("<?=__('nav_href_error')?>");
		o.nav_href.focus();
		return false;
	}
}
</script>
<?php 
}
 ?>
