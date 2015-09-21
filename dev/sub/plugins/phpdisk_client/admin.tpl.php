<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: admin.tpl.php 25 2014-01-10 03:13:43Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<div id="container">
<h1><?=__('phpdisk_client_title')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('phpdisk_client_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=plugins&menu=plugin&app=$app")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><b><?=__('open_phpdisk_client')?></b>: <br /><span class="txtgray"><?=__('open_phpdisk_client_tips')?></span></td>
	<td><input type="radio" name="setting[open_phpdisk_client]" value="1" {#ifchecked(1,$settings['open_phpdisk_client'])#}/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_phpdisk_client]" value="0" {#ifchecked(0,$settings['open_phpdisk_client'])#}/><?=__('no')?></td>
</tr>
<tr>
	<td><b><?=__('client_api_key')?></b>:<br /><span class="txtgray"><?=__('client_api_key_tips')?></span></td>
	<td><textarea name="setting[client_api_key]" id="client_api_key" cols="60" rows="10" style="width:500px;height:100px">{$settings[client_api_key]}</textarea>&nbsp;<input type="button" value="<?=__('truncate')?>" onclick="getId('client_api_key').value='';" class="btn" /><br />
	<a href="javascript:void(0);" onclick="resize_textarea('client_api_key','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('client_api_key','sub');">[-]</a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
