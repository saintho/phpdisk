<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: files.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!--#if($action =='replace_file'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" enctype="multipart/form-data" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li class="txtgray">替换文件后，文件的内容将会变更，但是文件的链接不变。</li>
<li>&nbsp;</li>
<li>选择文件: <input type="file" name="filedata" size="35"/></li>
<li>&nbsp;</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.filedata.value.strtrim() == ''){
		alert('请选择需要替换的文件');
		return false;
	}
}
</script>
<!--#}elseif($action =='modify_file'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('file_name')?>(不包含扩展名):</li>
<li><input type="text" name="file_name" value="{$file['file_name']}" size="30" maxlength="50" /></li>
<li>文件分类:</li>
<li><input type="text" name="folder_name" id="folder_name" value="{$file['folder_name']}" size="12" maxlength="50" /> {$folder_str}</li>
<li>共享文件: <input type="radio" name="in_share" value="1" id="is1" {#ifchecked($file[in_share],1)#}><label for="is1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="in_share" value="0" id="is2" {#ifchecked($file[in_share],0)#}><label for="is2"><?=__('no')?></label></li>
<li>隐藏统计: <input type="radio" name="stat_hidden" value="1" id="sh1" {#ifchecked($file[stat_hidden],1)#}><label for="sh1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="stat_hidden" value="0" id="sh2" {#ifchecked($file[stat_hidden],0)#}><label for="sh2"><?=__('no')?></label></li>
<li>隐藏时间: <input type="radio" name="time_hidden" value="1" id="th1" {#ifchecked($file[time_hidden],1)#}><label for="th1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="time_hidden" value="0" id="th2" {#ifchecked($file[time_hidden],0)#}><label for="th2"><?=__('no')?></label></li>
<li>上传时间: {$file['file_time']}</li>
<li>文件大小: {$file['file_size']}</li>
<li>文件浏览: {$file['file_views']}&nbsp;&nbsp;&nbsp;&nbsp;文件下载: {$file['file_downs']}</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script type="text/javascript">
function sel_folder_id(){
	getId('folder_name').value = getId('folder_ids').options[getId('folder_ids').selectedIndex].text;
}
</script>
<!--#}elseif($action =='modify_folder'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="folder_id" value="{$folder_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li>分类名称:</li>
<li><input type="text" name="folder_name" value="{$fd['folder_name']}" size="30" maxlength="50" /></li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<!--#}#-->