<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: union.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('union_manage')?><!--#sitemap_tag(__('union_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('union_manage_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('open_thunder')?></span>: <br /><span class="txtgray"><?=__('open_thunder_tips')?></span></td>
	<td><input type="radio" id="ot1" name="setting[open_thunder]" value="1" {#ifchecked(1,$setting['open_thunder'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_thunder]" value="0" {#ifchecked(0,$setting['open_thunder'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('thunder_pid')?></span>:<br /><span class="txtgray"><?=__('thunder_pid_tips')?></span></td>
	<td><input type="text" id="thunder_pid" name="setting[thunder_pid]" value="{$setting['thunder_pid']}" maxlength="30"/></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_flashget')?></span>: <br /><span class="txtgray"><?=__('open_flashget_tips')?></span></td>
	<td><input type="radio" id="fg1" name="setting[open_flashget]" value="1" {#ifchecked(1,$setting['open_flashget'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="fg0" name="setting[open_flashget]" value="0" {#ifchecked(0,$setting['open_flashget'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('flashget_uid')?></span>:<br /><span class="txtgray"><?=__('flashget_uid_tips')?></span></td>
	<td><input type="text" id="flashget_uid" name="setting[flashget_uid]" value="{$setting['flashget_uid']}" maxlength="30"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(getId('ot1').checked ==true && getId('thunder_pid').value.strtrim().length <2){
		alert("<?=__('thunder_pid_error')?>");
		getId('thunder_pid').focus();
		return false;
	}
	if(getId('fg1').checked ==true && getId('flashget_uid').value.strtrim().length <2){
		alert("<?=__('flashget_uid_error')?>");
		getId('flashget_uid').focus();
		return false;
	}
}
</script>
