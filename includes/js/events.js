/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: events.js 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/
function fileQueued(file) {
	var arr = new Array(); 
	var arr = deny_extension.split(',');
	for(var i=0;i<arr.length;i++){
		if(get_extension(file.type.toLowerCase()) == arr[i]){
			alert(file.name +' , '+ arr[i].toUpperCase()+ '文件类型禁止上传');
			this.cancelUpload(file.id, false);
			return;
		}
	}
	var upload_btn = document.getElementById('upload_btn');
	if(upload_replace() && this.getStats().files_queued >1){
		upload_btn.disabled = false;
		this.cancelUpload(file.id, false);
		alert(lang['replace_file_tips']);
		return;
	}
	try {
		if(this.getStats().files_queued >0){
			upload_btn.disabled = false;	
		}
		var progress = new FileProgress(file, this.customSettings.uploadprogressbar);
		progress.toggleCancelFile(true,this);
	}catch(ex){
		this.debug(ex);
	}

}

function fileDialogComplete() {
	var upload_btn = document.getElementById('upload_btn');
	upload_btn.onclick = doSubmit;
	
}
function doSubmit(){
	upl.startUpload();	
	document.getElementById('upload_btn').disabled = true;
}

function uploadStart(file) {
	try {
		var desc = document.getElementById('desc'+file.id).value;
		upl.addPostParam("desc["+file.id+"]", desc);
		if(open_tag()){
			var tag = document.getElementById('tag'+file.id).value;
			upl.addPostParam("tag["+file.id+"]", tag);
		}
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
	upl.removePostParam("desc["+file.id+"]");
	if(open_tag()){
		upl.removePostParam("tag["+file.id+"]");
	}
	if(this.getStats().files_queued ==0){
		document.getElementById('up_msg').innerHTML = lang['upload_complete'];
		document.getElementById('up_msg_tips').style.display = '';
		//setTimeout(function(){self.parent.hs.close();self.parent.document.location.reload();},1000);
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
	} catch (ex) {
        this.debug(ex);
    }
}
