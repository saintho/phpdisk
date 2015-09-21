<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: files.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='modify_file'){#-->
<script charset="utf-8" src="editor/kindeditor-min.js"></script>
<script charset="utf-8" src="editor/lang/zh_CN.js"></script>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('textarea[name="file_description"]', {
			resizeType : 1,
			allowPreviewEmoticons : false,
			allowImageUpload : false,
			items : [
				'fullscreen','|','fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link']
		});
	});
</script>
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('file_name')?><?=__('not_include_extension')?>:</li>
<li><input type="text" name="file_name" value="{$file['file_name']}" size="30" maxlength="50" /></li>
<li><?=__('folder_name')?>:</li>
<li>
<select name="folder_id" id="folder_ids" style="width:100px;" onchange="sel_folder_id();">
<option value=0>- 根目录 -</option>
{#get_folder_option(0,$file['folder_id']);#}</select></li>
<!--#if($auth[is_fms]){#-->
<li><?=__('file_tag')?>[<?=__('file_tag_tips')?>](<?=__('optional')?>):</li>
<li><input type="text" name="file_tag" value="{$file['file_tag']}" size="50" maxlength="50" /></li>
<!--#}#-->
<li><?=__('file_description')?>：</li>
<li style="width:auto; height:auto"><textarea name="file_description" style="width:500px; height:150px;">{$file['file_description']}</textarea></li>
<li><?=__('in_share')?>: <input type="radio" name="in_share" value="1" id="is1" {#ifchecked($file[in_share],1)#}><label for="is1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="in_share" value="0" id="is2" {#ifchecked($file[in_share],0)#}><label for="is2"><?=__('no')?></label></li>
<li><?=__('stat_hidden')?>: <input type="radio" name="stat_hidden" value="1" id="sh1" {#ifchecked($file[stat_hidden],1)#}><label for="sh1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="stat_hidden" value="0" id="sh2" {#ifchecked($file[stat_hidden],0)#}><label for="sh2"><?=__('no')?></label></li>
<li><?=__('time_hidden')?>: <input type="radio" name="time_hidden" value="1" id="th1" {#ifchecked($file[time_hidden],1)#}><label for="th1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="time_hidden" value="0" id="th2" {#ifchecked($file[time_hidden],0)#}><label for="th2"><?=__('no')?></label></li>
<!--#if($auth[open_user_hidden]){#-->
<li><?=__('user_hidden')?>: <input type="radio" name="user_hidden" value="1" id="uh1" {#ifchecked($file[user_hidden],1)#}><label for="uh1"><?=__('yes')?></label>&nbsp;&nbsp;<input type="radio" name="user_hidden" value="0" id="uh2" {#ifchecked($file[user_hidden],0)#}><label for="uh2"><?=__('no')?></label></li>
<!--#}#-->
<li><?=__('file_time')?>: {$file['file_time']}</li>
<li><?=__('file_size')?>: {$file['file_size']}</li>
<li><?=__('file_views')?>: {#get_discount($file[userid],$file['file_views'])#}&nbsp;&nbsp;&nbsp;&nbsp;<?=__('file_downs')?>: {#get_discount($file[userid],$file['file_downs'])#}</li>
<li><input type="submit" class="btn" value="<?=__('btn_submit')?>" /></li>
</form>
</div>
</div>
<script type="text/javascript">
function sel_folder_id(){
	getId('folder_name').value = getId('folder_ids').options[getId('folder_ids').selectedIndex].text;
}
</script>
<!--#}elseif($action =='post_report'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('report_tips')?></li>
<li>&nbsp;</li>
<!--#if($msg){#-->
<li class="txtred">{$msg}</li>
<!--#}else{#-->
<li><?=__('report_content')?>:</li>
<li style="width:auto; height:auto"><textarea name="content" style="width:450px; height:150px;"></textarea></li>
<li>&nbsp;</li>
<!--#}#-->
<li><input type="submit" class="btn" value="<?=__('btn_report')?>" />&nbsp;<span id="rp_tips" class="txtred"></span></li>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.content.value.strtrim()==''){
		$('#rp_tips').html('<?=__('report_content_error')?>');
		o.content.focus();
		setTimeout(function(){$('#rp_tips').hide();},3000);
		return false;
	}
}
</script>
<!--#}elseif($action =='post_comment'){#-->
<div id="container">
<div class="box_style">
<form action="{#urr("mydisk","item=$item")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="{$action}" />
<input type="hidden" name="file_id" value="{$file_id}" />
<input type="hidden" name="ref" value="{$ref}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<li><?=__('comment_tips')?></li>
<li>&nbsp;</li>
<!--#if($msg){#-->
<li class="txtred">{$msg}</li>
<!--#}else{#-->
<li><?=__('comment_content')?>:</li>
<li style="width:auto; height:auto"><textarea name="content" style="width:450px; height:150px;"></textarea></li>
<li>&nbsp;</li>
<!--#}#-->
<li><input type="submit" class="btn" value="<?=__('btn_comment')?>" />&nbsp;<span id="cmt_tips" class="txtred"></span></li>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.content.value.strtrim()==''){
		$('#cmt_tips').html('<?=__('cmt_content_error')?>');
		o.content.focus();
		setTimeout(function(){$('#cmt_tips').hide();},3000);
		return false;
	}
}
</script>
<!--#}#-->