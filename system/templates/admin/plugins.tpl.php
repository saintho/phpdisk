<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:38:40

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: plugins.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action =='shortcut'){ ?>
<div id="container">
<h1><?=__('plugin_shortcut')?><?php sitemap_tag(__('plugin_shortcut')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('plugin_shortcut_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=plugin")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('open_plugins_cp')?></span>: <br /><span class="txtgray"><?=__('open_plugins_cp_tips')?></span></td>
	<td><input type="radio" name="setting[open_plugins_cp]" value="1" <?=ifchecked(1,$setting['open_plugins_cp'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_plugins_cp]" value="0" <?=ifchecked(0,$setting['open_plugins_cp'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_plugins_last')?></span>: <br /><span class="txtgray"><?=__('open_plugins_last_tips')?></span></td>
	<td><input type="radio" name="setting[open_plugins_last]" value="1" <?=ifchecked(1,$setting['open_plugins_last'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_plugins_last]" value="0" <?=ifchecked(0,$setting['open_plugins_last'])?>/> <?=__('no')?></td>
</tr>
</table>
<table align="center" width="100%" cellpadding="4" cellspacing="4" border="0" class="td_line">
<tr>
	<td colspan="5"><span class="bold"><?=__('current_plugin')?></span>:<br /><span class="txtgray"><?=__('current_plugin_tips')?></span></td>
</tr>
<?php 
if(count($plugins_list)){
 ?>
<tr>
<?php 
	foreach($plugins_list as $k => $v){
 ?>
	<td width="20%">
	<?php if($v['installed'] && $v['actived']){ ?>
	<input type="checkbox" name="plugin_ids[<?=$v['plugin_dir']?>]" id="cp_<?=$v['plugin_dir']?>" value="1" /><?=get_name($v['plugin_name'],$v['admin_url'],$v['actived'])?>
	<?php }else{ ?>
	<input type="checkbox" disabled="disabled" /><?=get_name($v['plugin_name'],$v['admin_url'],$v['actived'])?>
	<?php } ?>
	</td>
<?php 
		if(($k+1)%5==0) echo '</tr><tr>';
	}
 ?>
</tr>
<?php 	
	unset($plugins_list);
}else{
 ?>
<tr>
	<td colspan="5"><?=__('plugin_not_found')?></td>
</tr>	
<?php 
}
 ?>
<tr>
	<td colspan="5" align="center"><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
<?=$shortcut_status?>
</script>
<?php }else{ ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#container table tbody").mouseover(function(){
		$(this).addClass("color4");
	}).mouseout(function(){
		$(this).removeClass("color4");
	});
});
</script>
<div id="container">
<h1><?=__('plugins_manage')?><?php sitemap_tag(__('plugins_manage')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('plugins_manage_tips')?></span>
</div>
<div class="search_box">
<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu")?>" id="n_"><?=__('all_plugins')?>(<?=$all_plugins_count?>)</a>&nbsp;&nbsp;
<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&action=actived_plugins")?>" id="n_actived_plugins"><?=__('active_plugins')?>(<?=$actived_plugins_count?>)</a>&nbsp;&nbsp;
<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&action=inactived_plugins")?>" id="n_inactived_plugins"><?=__('inactive_plugins')?>(<?=$inactived_plugins_count?>)</a>&nbsp;&nbsp;
<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&action=last_plugins")?>" id="n_last_plugins"><?=__('last_plugins')?>(<?=$last_plugins_count?>)</a>&nbsp;&nbsp;
</div>
<form name="frm" action="<?=urr(ADMINCP,"item=plugins&menu=plugin")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
	<tr class="bold">
		<td width="25%" class="plugin_fix"><?=__('plugin_name')?></td>
		<td width="15%" class="plugin_fix"><?=__('plugin_dir')?></td>
		<td class="plugin_fix"><?=__('plugin_desc')?></td>
	</tr>
	<?php 
	if(count($plugins_arr)){
		foreach($plugins_arr as $v){
	 ?>
	<tbody>
	<tr>
		<td rowspan="2" class="plugin_fix f14">
		<?php if($v['installed'] && $v['actived']){ ?>
		<input type="checkbox" name="plugin_ids[]" id="plugin_ids" value="<?=$v['plugin_dir']?>" />
		<?php }else{ ?>
		<input type="checkbox" disabled="disabled" />
		<?php } ?>
		<?=get_name($v['plugin_name'],$v['admin_url'],$v['actived'])?></td>
		<td rowspan="2" class="plugin_fix"><?=$v['plugin_dir']?>/</td>
		<td style="word-break:break-all;padding-top:8px"><?=$v['plugin_desc']?></td>
	</tr>
	<tr>	
		<td class="plugin_fix">
		<?php if($v['installed']){ ?>
			<?php  if($v['actived']){ ?>
			<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&plugin_name=".$v['plugin_dir']."&action=inactive")?>" class="txtred"><?=__('inactive')?></a>&nbsp;
			<?php  }else{ ?>
			<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&plugin_name=".$v['plugin_dir']."&action=active")?>" class="txtblue"><?=__('active')?></a>&nbsp;
			<?php } ?>
			<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&plugin_name=".$v['plugin_dir']."&action=uninstall")?>" class="txtred" onclick="return confirm('<?=__('confirm_uninstall_plugin')?>');"><?=__('uninstall')?></a>&nbsp;
		<?php }else{ ?>
		<a href="<?=urr(ADMINCP,"item=plugins&menu=$menu&plugin_name=".$v['plugin_dir']."&action=install")?>" class="txtgreen" onclick="return confirm('<?=__('confirm_install_plugin')?>');"><?=__('install')?></a>&nbsp;
		<?php } ?>
		<span class="txtgray"><?=__('plugin_author')?>:</span><a href="<?=$v['plugin_site']?>" target="_blank"><?=$v['plugin_author']?></a>&nbsp;
		<span class="txtgray"><?=__('plugin_version')?>:<?=$v['plugin_version']?></span>&nbsp;
		<span class="txtgray"><?=__('phpdisk_core')?>:<?=$v['phpdisk_core']?></span>
		</td>
	</tr>	
	</tbody>
	<?php 
		}
		unset($plugins_arr);
	 ?>
	<?php if($page_nav){ ?>
	<tr>
		<td colspan="6" height="40"><?=$page_nav?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.frm.plugin_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.frm.plugin_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
		<input type="radio" name="task" id="active" value="active" /><label for="active"><?=__('active')?></label>
		<input type="radio" name="task" id="inactive" value="inactive" /><label for="inactive"><?=__('inactive')?></label>&nbsp;&nbsp;
		<input type="submit" class="btn" value="<?=__('btn_submit')?>" />
		</td>
	</tr>
	<?php 
	}else{
	 ?>
	<tr>
		<td colspan="6" height="40">
		<?php if($action =='last_plugins'){ ?>
		<?=__('last_not_found')?>
		<?php }else{ ?>
		<?=__('plugin_not_found')?>
		<?php } ?>
		</td>
	</tr>
	<?php 
	}
	 ?>
</table>
</form>
<script type="text/javascript">
function dosubmit(o){
	if(checkbox_ids("plugin_ids[]") != true){
		alert("<?=__('please_select_plugins')?>");
		return false;
	}
}
getId('n_<?=$action?>').className = 'sel_a';
<?php 
if(count($plugins_arr)){
	if($action=='inactived_plugins'){
 ?>
getId('active').checked =true;
	<?php }else{ ?>
getId('inactive').checked =true;
<?php 
	}
} ?>
</script>
</div>
</div>
<?php } ?>
