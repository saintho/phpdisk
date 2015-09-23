/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: events.js 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##
*/
function fileQueued(file) {
	if(this.getStats().files_queued >30){
		this.cancelUpload(file.id, false);
		document.getElementById('up_msg').innerHTML = '单次批量添加上传文件队列只允许最多30个';
		document.getElementById('up_msg_tips').style.display = '';
		setTimeout(function(){document.getElementById('up_msg_tips').style.display='none';},5000);
		return false;
	}else{
		var upload_btn = document.getElementById('upload_btn');
		try {
			if(this.getStats().files_queued >0){
				upload_btn.disabled = false;	
				document.getElementById('up_tips').style.display='none';
			}
			var progress = new FileProgress(file, this.customSettings.uploadprogressbar);
			progress.toggleCancelFile(true,this);
		}catch(ex){
			this.debug(ex);
		}
	}

}

function fileDialogComplete() {
	var upload_btn = document.getElementById('upload_btn');
	upload_btn.onclick = doSubmit;
	
}
function doSubmit(){
	if(upload_cate>0){
		var up_cate_id = document.getElementById('up_cate_id').value;	
	}
	if(upload_cate==2 && up_cate_id==0){
		alert('请设置文件分类');
		return false;
	}else{
		upl.startUpload();	
		document.getElementById('upload_btn').disabled = true;
	}
}

function uploadStart(file) {
	try {
		var up_folder_id = document.getElementById('up_folder_id').value;
		upl.addPostParam("up_folder_id", up_folder_id);
		var up_cate_id = document.getElementById('up_cate_id').value;		
		upl.addPostParam("up_cate_id", up_cate_id);
	}catch (ex) {
		this.debug(ex);
	}
	
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file, this.customSettings.uploadprogressbar);
		progress.setProgress(percent);
		progress.setStatus(lang['has_upload']+ percent +"%  "+lang['current_speed']+ SWFUpload.speed.formatBPS(file.currentSpeed));
		progress.toggleCancel(true, this);
	} catch (ex) {
		this.debug(ex);
	}
	
}

function uploadSuccess(file, serverData) {
	try {

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	var progress = new FileProgress(file, this.customSettings.uploadprogressbar);
	progress.setTimer(setTimeout(function(){
		progress.disappear();
	}, 2000));
	document.getElementById('upload_btn').disabled = true;
	if(this.getStats().files_queued ===0){
		document.getElementById('up_msg').innerHTML = lang['upload_complete'];
		document.getElementById('up_msg_tips').style.display = '';
		setTimeout(function(){	
			document.getElementById('up_tips').innerHTML = '上传成功，可选择文件再次上传';
			document.getElementById('up_tips').className = 'up_tips';
			top.document.location=up_go;
		},3000);
	}
}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert(lang['queue_too_many_files']);
			return;
		}

		var progress = new FileProgress(file, this.customSettings.uploadprogressbar);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus(lang['current_file_size']+SWFUpload.speed.formatBytes(file.size)+", "+lang['file_too_big']);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus(lang['zero_byte_file']);
			break;
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			progress.setStatus(lang['queue_too_many_files']);
			break;
		default:
			if (file !== null) {
				progress.setStatus(lang['unknown_error']+"\n Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + SWFUpload.speed.formatBytes(file.size) + ", Message: " + message);
			}
			break;
		}
		document.getElementById('up_tips').style.display='none';
	} catch (ex) {
        this.debug(ex);
    }
}
