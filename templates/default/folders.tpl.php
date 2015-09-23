<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: folders.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='modify_folder' || $action=='add_folder'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('folder_name')?>:</li>
<li><input type="text" name="folder_name" value="{$fd['folder_name']}" style="width:200px" maxlength="50" /></li>
<li><?=__('parent_folder')?>：</li>
<li><select name="pid" style="width:200px">
	<option value="0"><?=__('root_folder_default')?></option>
	<!--#if($action=='add_folder'){#-->
	{#get_folder_option(0,$folder_id);#}
	<!--#}else{#-->
	{#get_folder_option(0,$fd[parent_id],0,$folder_id);#}
	<!--#}#-->
	</select>
</li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.folder_name.value.strtrim()==''){
		alert('<?=__('folder_name_error')?>');
		o.folder_name.focus();
		return false;
	}
}
</script>
<!--#
}elseif($action =='folder_delete'){
#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=folders")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<div class="cfm_info">
<li><img src="images/folder.gif" border="0" align="absmiddle" />&nbsp;<span class="txtgreen">{$folder_name}</span></li>
<li><?=__('delete_folder_confirm')?></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" />&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_cancel')?>" onclick="top.$.jBox.close(true);" /></li>
</div>
</form>
</div>
</div>
<!--#}#-->