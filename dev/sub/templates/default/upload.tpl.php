<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: upload.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<script type="text/javascript">
var upload_cate ={$upload_cate};
</script>
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
var upl;
window.onload = function() {
	var settings = {
		flash_url : "includes/js/upload.swf",
		upload_url: '{$upload_url}',
		post_params: {"task": "{$action}"},
		file_size_limit : "{$max_user_file_size}B",
		file_types : "{$user_file_types}",
		button_image_url : "images/sel_file.png",
		button_placeholder_id : "spanPDButton",
		button_width: 88,
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
<div style="margin-left:8px;">
	<!--#if($cannot_upload){#-->
	<div class="up_msg_box">
	<div align="center"><img src="images/light.gif" border="0" align="absmiddle">&nbsp;<span class="txtgreen">{$hints_msg}</span></div>
	<br><br>
	</div>
	<!--#}else{#-->
	<div>
	<div class="upload_style">
		<span id="spanPDButton"></span> 
	</div>
<div class="upload_btn">
	<input type="button" value="" id="upload_btn" disabled="disabled"/>
</div>
	<div style="float:right">
	<div id="sel_box"><?=__('set_upload_folder')?>：<span id="cate_list"><img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...</span><a href="###" onclick="chg_cate();" title="<?=__('new_folder')?>">[+]</a>
	</div>
	<div id="add_box" style="display:none"><?=__('new_folder')?>：
	<input type="text" id="cate_name" value="" /><input type="button" value="<?=__('add')?>" class="btn" onclick="add_cate();" /><input type="button" value="<?=__('back')?>" class="btn" onclick="chg_cate();" />
	</div>
	</div>
	<!--#if($upload_cate){#-->
	<div class="clear">设置公共分类：
	<select name="up_cate_id" id="up_cate_id">
	<option value="0">- 请选择分类 -</option>
	{#get_cate_option();#}
	</select>
	</div>
	<!--#}#-->
	
	</div>
	<script type="text/javascript">
	function chg_cate(){
		if(getId('sel_box').style.display==''){
		getId('sel_box').style.display ='none';
		getId('add_box').style.display ='';
		}else{
		getId('sel_box').style.display ='';
		getId('add_box').style.display ='none';
		}
	}
	function add_cate(){
		var cate_name = getId('cate_name').value.strtrim();
		$.ajax({
			type : 'post',
			url : 'ajax.php',
			data : 'action=add_cate&cate_name='+cate_name+'&t='+Math.random(),
			dataType : 'text',
			success:function(msg){	
				var arr = msg.split('|');
				if(arr[0]=='true'){
					alert('<?=__('new_folder_add_success')?>');
					getId('sel_box').style.display ='';
					getId('add_box').style.display ='none';
					load_cate({$uid},arr[1]);
				}else{
					alert(msg);
				}
			},
			error:function(){
			}
	
		});
	}
	function load_cate(uid,id){
		$.ajax({
			type : 'post',
			url : 'ajax.php',
			data : 'action=load_cate&uid='+uid+'&sel_id='+id+'&t='+Math.random(),
			dataType : 'text',
			success:function(msg){	
				getId('cate_list').innerHTML = msg;
			},
			error:function(){
			}
	
		});
	}
	load_cate({$uid});
	</script>
	<div class="clear"></div>
	<div id="up_msg_tips" style="display:none"><img src="images/up_suc.gif" align="absmiddle" border="0" /> <span id="up_msg"><?=__('ok_upload_success')?></span> <a href="###" class="myBox_close" onclick="self.parent.document.location.reload();"><?=__('close')?></a></div>
	<div id="upload_box">
		<div id="uploadprogressbar"><div id="up_tips" class="up_tips"><?=__('pls_sel_upload_file')?></div></div>
	</div>
	<!--#}#-->
</div>
</div>
