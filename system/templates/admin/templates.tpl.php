<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 16:45:39

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: templates.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('tpl_title')?><?php sitemap_tag(__('tpl_title')); ?></h1>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle"> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('template_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=templates&menu=lang_tpl")?>" method="post">
<input type="hidden" name="action" value=""/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_switch_tpls')?></span>: <br /><span class="txtgray"><?=__('open_switch_tpls_tips')?></span></td>
	<td><input type="radio" name="setting[open_switch_tpls]" value="1" <?=ifchecked(1,$settings['open_switch_tpls'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_switch_tpls]" value="0" <?=ifchecked(0,$settings['open_switch_tpls'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" onclick="scan_tpl();" value="检测模板入库" /></td>
</tr>
</table>
</form>
<br />
<script type="text/javascript">
function scan_tpl(){
	if(confirm("确认检测入库新模板吗？已验证的模板状态装会全部清除，\r\n已验证的模板需要重新授权验证，请谨慎操作！")){
		top.document.location="<?=urr(ADMINCP,"item=templates&menu=lang_tpl&action=scan_tpl")?>";
	}
}
</script>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold" width="180"><?=__('tpl_snapshot')?></td>
	<td class="bold" width="120"><?=__('style_dir')?></td>
	<td class="bold" width="50%"><?=__('tpl_des')?></td>
	<td class="bold" align="right" width="80"><?=__('operation')?></td>
</tr>
<?php 
if(count($templates_arr)){
	foreach($templates_arr as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
		$tpl_type = (trim($v['tpl_type']) =='admin') ? "<span class='txtgreen'>(".__('admin_tpl').")</span>" : "<span class='txtblue'>(".__('user_tpl').")</span>";
 ?>
<tr class="<?=$color?>">
	<td><img src="templates/<?=$v['tpl_dir']?>/images/snapshot.gif" align="absmiddle" border="0" style="margin-bottom:8px"  /><br /><?=$v['tpl_title']?></td>
	<td><?=$v['tpl_dir']?><?=$tpl_type?></td>
	<td>
	<table>
		<tr>
			<td><?=$v['tpl_desc']?></td>
		</tr>
		<tr>
			<td><?php if($v[authed_tpl]==2){ ?><span class="txtgreen">此模板授权检测成功，可直接使用</span><?php  }elseif($v[authed_tpl]==1){ ?><span class="txtred">此模板或对应域名未授权，暂时无法使用</span><?php } ?></td>
		</tr>
		<tr>
			<td>	
				<span class="txtgray"><?=__('tpl_author')?>:</span><a href="<?=$v['tpl_site']?>" target="_blank"><?=$v['tpl_author']?></a>&nbsp;
				<span class="txtgray"><?=__('tpl_version')?>:<?=$v['tpl_version']?></span>&nbsp;
				<span class="txtgray"><?=__('phpdisk_core')?>:<?=$v['phpdisk_core']?></span>
			</td>
		</tr>
	</table>
	</td>
	<td align="right">
	<?php if($v[authed_tpl]==2 || !$v[authed_tpl]){ ?>
	<?php  if($v['actived']){ ?>
	<span class="txtgray"><?=__('actived_tpl')?></span>
	<?php  }else{ ?>
	<a href="<?=urr(ADMINCP,"item=templates&menu=lang_tpl&tpl_id=".$v['tpl_dir']."&action=active")?>" class="txtblue"><?=__('set_active_tpl')?></a>
	<?php } ?>
	<?php  }else{ ?>
	<a href="<?=urr(ADMINCP,"job=auth_tpl&tpl_name=$v[tpl_dir]")?>" class="txtgreen">模板授权验证</a>
	<?php } ?>
	</td>
</tr>
<?php 
	}
	unset($templates_arr);
}
 ?>
</table>
</div>