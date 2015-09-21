<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-21 18:21:27

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admin.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php if($action =='uc'){ ?>
<div id="container">
<h1><?=__('api_manage')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('api_manage_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=plugins&app=$app")?>" method="post">
<input type="hidden" name="action" value="uc"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('connect_uc')?></span>: <br /><span class="txtgray"><?=__('connect_uc_tips')?></span></td>
	<td><input type="radio" name="setting[connect_uc]" value="1" <?=ifchecked(1,$setting['connect_uc'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[connect_uc]" value="0" <?=ifchecked(0,$setting['connect_uc'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('connect_uc_type')?></span>: <br /><span class="txtgray"><?=__('connect_uc_type_tips')?></span></td>
	<td><input type="radio" name="setting[connect_uc_type]" value="discuz" <?=ifchecked('discuz',$setting['connect_uc_type'],'str')?> /> <?=__('uc_type_discuz')?>&nbsp;&nbsp;<input type="radio" name="setting[connect_uc_type]" value="phpwind" <?=ifchecked('phpwind',$setting['connect_uc_type'],'str')?>/> <?=__('uc_type_phpwind')?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_charset')?></span>:<br /><span class="txtgray"><?=__('uc_charset_tips')?></span></td>
	<td><select name="setting[uc_charset]">
	<option value="utf-8" <?=ifselected('utf-8',$setting[uc_charset],'str')?>>UTF-8</option>
	</select></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_admin')?></span>:<br /><span class="txtgray"><?=__('uc_admin_tips')?></span></td>
	<td><input type="text" name="setting[uc_admin]" value="<?=$setting['uc_admin']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_dbhost')?></span>:<br /><span class="txtgray"><?=__('uc_dbhost_tips')?></span></td>
	<td><input type="text" name="setting[uc_dbhost]" value="<?=$setting['uc_dbhost']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_dbuser')?></span>:<br /><span class="txtgray"><?=__('uc_dbuser_tips')?></span></td>
	<td><input type="text" name="setting[uc_dbuser]" value="<?=$setting['uc_dbuser']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_dbpwd')?></span>:<br /><span class="txtgray"><?=__('uc_dbpwd_tips')?></span></td>
	<td><input type="text" name="setting[uc_dbpwd]" value="<?=$setting['uc_dbpwd']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_dbname')?></span>:<br /><span class="txtgray"><?=__('uc_dbname_tips')?></span></td>
	<td><input type="text" name="setting[uc_dbname]" value="<?=$setting['uc_dbname']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_dbtablepre')?></span>:<br /><span class="txtgray"><?=__('uc_dbtablepre_tips')?></span></td>
	<td><input type="text" name="setting[uc_dbtablepre]" value="<?=$setting['uc_dbtablepre']?>" maxlength="30"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_appid')?></span>:<br /><span class="txtgray"><?=__('uc_appid_tips')?></span></td>
	<td><input type="text" name="setting[uc_appid]" value="<?=$setting['uc_appid']?>" maxlength="30"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_key')?></span>:<br /><span class="txtgray"><?=__('uc_key_tips')?></span></td>
	<td><input type="text" name="setting[uc_key]" value="<?=$setting['uc_key']?>" size="50" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_api')?></span>:<br /><span class="txtgray"><?=__('uc_api_tips')?></span></td>
	<td><input type="text" name="setting[uc_api]" value="<?=$setting['uc_api']?>" size="50" maxlength="100"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_feed')?></span>: <br /><span class="txtgray"><?=__('uc_feed_tips')?></span></td>
	<td><input type="radio" name="setting[uc_feed]" value="1" <?=ifchecked(1,$setting['uc_feed'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[uc_feed]" value="0" <?=ifchecked(0,$setting['uc_feed'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('uc_credit_exchange')?></span>: <br /><span class="txtgray"><?=__('uc_credit_exchange_tips')?></span></td>
	<td><input type="radio" name="setting[uc_credit_exchange]" value="1" <?=ifchecked(1,$setting['uc_credit_exchange'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[uc_credit_exchange]" value="0" <?=ifchecked(0,$setting['uc_credit_exchange'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<?php } ?>
