<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: plugin_upload.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<script type="text/javascript" src="includes/js/core.js"></script>
<script type="text/javascript" src="includes/js/queue.js"></script>
<script type="text/javascript" src="includes/js/progress.js"></script>
<script type="text/javascript" src="includes/js/speed.js"></script>
<script type="text/javascript" src="includes/js/events.js"></script>
<script type="text/javascript">
var lang = new Array();
lang['has_upload'] = "<?=__('has_upload')?>";
lang['current_speed'] = "<?=__('current_speed')?>";
lang['queue_too_many_files'] = "<?=__('queue_too_many_files')?>";
lang['current_file_size'] = "<?=__('current_file_size')?>";
lang['file_too_big'] = "<?=__('file_too_big')?>";
lang['zero_byte_file'] = "<?=__('zero_byte_file')?>";
lang['unknown_error'] = "<?=__('unknown_error')?>";
lang['upload_complete'] = "<?=__('upload_complete')?>";
lang['js_tag'] = "<?=__('js_tag')?>";
lang['js_tag_tips'] = "<?=__('js_tag_tips')?>";
lang['js_content'] = "<?=__('js_content')?>";
lang['js_expand'] = "<?=__('js_expand')?>";
lang['replace_file_tips'] = "<?=__('replace_file_tips')?>";
var plugin_upload = true;
var upload_cate = 0;
var upl;
window.onload = function() {
	var settings = {
		flash_url : "includes/js/upload.swf",
		upload_url: '{$upload_url}',
		post_params: {"task": "{$action}","sign":"{$sign}"},
		file_size_limit : "{$max_user_file_size}B",
		file_types : "{$user_file_types}",
		button_image_url : "images/up_btn.png",
		button_placeholder_id : "spanPDButton",
		button_width: 93,
		button_height: 22,
		button_text : "",
		file_queued_handler : fileQueued,
		file_dialog_complete_handler: fileDialogComplete,
		file_queue_error_handler : fileQueueError,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		custom_settings : {
			uploadprogressbar : "uploadprogressbar"
		}
	};
	upl = new SWFUpload(settings);
 };
</script>
<div id="container">
<div style="height:328px; margin-left:8px; overflow-y:auto;">
	<!--#if($cannot_upload){#-->
	<div class="up_msg_box">
	<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen">{$hints_msg}</span></div>
	<br><br>
	<!--#}else{#-->
	<div class="upload_style">
		<span id="spanPDButton"></span><span class="txtgray">（文件上传完成之后打开文件列表即可获得上传的文件连接）</span>
	</div>
<div class="upload_btn">
	<input type="button" value="" id="upload_btn" disabled="disabled"/>
</div>
	<div class="clear"></div>
	<div id="up_msg_tips" style="display:none"><img src="images/up_suc.gif" align="absmiddle" border="0" /> <span id="up_msg"></span> <a href="###" onclick="self.parent.document.location.reload();" class="myBox_close">关闭</a></div>
	<div id="upload_box_p">
		<div id="uploadprogressbar"><div id="up_tips" class="up_tips">请选择要上传的文件</div></div>
	</div>
	<!--#}#-->
</div>
</div>


