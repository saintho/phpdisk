<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: guest_upload.tpl.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
#-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
<title>phpdisk.com</title>
<link rel="shortcut icon" href="favicon.ico">
<meta name="generator" content="PHPDisk {PHPDISK_VERSION}" />
<script type="text/javascript" src="includes/js/jquery.js"></script>
<script type="text/javascript" src="includes/js/common.js"></script>
<script type="text/javascript">
var deny_extension = '{$settings['deny_extension']}';
<!--#if($settings['cookie_domain']){#-->
document.domain = "{$settings['cookie_domain']}";
<!--#}#-->
</script>
<link href="{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">
</head>

<body style="margin:0; padding:0">

<div class="index_box">
<script type=text/javascript src="includes/js/core.js"></script>
<script type="text/javascript">
var tmp_sess_id = '{$sess_id}';
</script>
<script type=text/javascript src="includes/js/guest_upload.js"></script>
<script type=text/javascript>
var swfu;

window.onload = function () {
swfu = new SWFUpload({
flash_url : "includes/js/upload.swf",
upload_url: '{$guest_upload_url}',
post_params: {"task": "guest_upload"},
file_size_limit : "{$max_user_file_size}B",
file_types : "*.*",	
file_types_description : "所有文件",
file_upload_limit : "0",
file_queue_limit : 1,

swfupload_loaded_handler : swfUploadLoaded,

file_dialog_start_handler: fileDialogStart,
file_queued_handler : fileQueued,
file_queue_error_handler : fileQueueError,
file_dialog_complete_handler : fileDialogComplete,

upload_progress_handler : uploadProgress,
upload_error_handler : uploadError,
upload_success_handler : uploadSuccess,
upload_complete_handler : uploadComplete,

button_image_url : "{$user_tpl_dir}images/upload_btn.jpg",
button_placeholder_id : "selectfile",
button_width: 70,
button_height: 34,

custom_settings : {
progress_target : "fsUploadProgress",
upload_successful : false
},

debug: false
});

};
</script>
<DIV class="gu_box">
<DIV style="Z-INDEX: 99; POSITION: absolute; TOP: 0px; LEFT: 0px">
<DIV class=upload_left>
<DIV id=fnbox1 class=filebase>您每次可以上传{$max_user_file_size}B以内的文件,总容量无限制...</DIV>
<INPUT id=txtFileName type=hidden name=txtFileName> 
<DIV class=selectfile><SPAN id=selectfile></SPAN></DIV>
</DIV>
</DIV>
<DIV style="Z-INDEX: 100; POSITION: absolute; TEXT-ALIGN: left; TOP: 0px; LEFT: 0px; opacity: 0.9" id=fsUploadProgress class=flash></DIV>
</DIV>

</div>
</body>
</html>