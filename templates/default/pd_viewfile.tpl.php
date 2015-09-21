<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_viewfile.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if(!$file['is_del']){#-->
<div align="center" class="f18" style="padding-bottom:10px;">{#file_icon($file['file_extension'],'filetype_32','absbottom')#} {$file['file_name_min']}</div>
<!--#}#-->
<div id="fl_dir_box">
<!--#if(!$action){#-->
<div class="l">
<!--#if($file['is_del']){#-->
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/><?=__('file_is_delete')?>
<br /><br /><br />
<!-- ad -->
</div>
<!--#}else{#-->
<div class="file_box">
	<div class="fb_l f14 txtgray">
		<div class="file_item">
			<li><?=__('file_name')?>: {$file['file_name_min']}</li>
			<li id="file_uploader"><?=__('upload_user')?>: {$file['username']}</li>
			<li id="file_size"><?=__('file_size')?>: {$file['file_size']}&nbsp;&nbsp;
			</li>
			<!--#if($file['file_md5']){#-->
			<li><?=__('file_check')?>: <span class="txtgray">{$file['file_md5']}</span></li>
			<!--#}#-->
			<li><?=__('upload_time')?>: <span id="file_upload_time">{$file['file_time']}</span></li>
			<li><?=__('file_downs')?>: <span id="file_downs">{$file['file_downs']}</span></li>
			<li><?=__('file_views')?>: <span id="file_views">{$file['file_views']}</span></li>
			<li style="overflow:visible; margin-top:10px;"><?=__('file_share')?>: <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
        <a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <a class="bds_tieba"></a>
        <a class="bds_t163"></a>
        <a class="bds_copy"></a>
        <span class="bds_more">更多</span>
		<a class="shareCount"></a>
    </div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=68752" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>
<!-- Baidu Button END --></li>
		</div>
	</div>
	<div class="fb_r">
	<!--#show_adv_data('adv_viewfile_right');#-->
	</div>
</div>
<div class="clear"></div>

<div class="file_item" style=" margin-top:10px;margin-top:30px\9;">
</li>
	<div align="center"><!--#show_adv_data('adv_viewfile_hits_bottom');#--></div>
	<li class="txtgray"><?=__('file_view_url')?>: <input type="text" class="txtgray" value="{$file['file_view_url']}" id="f_view" size="60" onclick="getId('f_view').select();copy_text('f_view');" readonly/>&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_view').select();copy_text('f_view');" /></li>
	<li class="txtgray"><?=__('file_ubb_url')?>: <input type="text" class="txtgray" value="{$file['file_ubb_url']}" id="f_ubb" size="60" onclick="getId('f_ubb').select();copy_text('f_ubb');" readonly />&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_ubb').select();copy_text('f_ubb');" /></li>
	<li class="txtgray"><?=__('file_html_url')?>: <input type="text" class="txtgray" value="{$file['file_html_url']}" id="f_html" size="60" onclick="getId('f_html').select();copy_text('f_html');" readonly />&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_html').select();copy_text('f_html');" /></li>
</div>
<Br />
<!--#if($file[file_description]){#-->
<div class="file_item file_desc">
	<div class="tit"><?=__('file_description')?>:</div>
	<div class="ctn">{$file[file_description]}</div>
</div>
<!--#}#-->

<div>
	<div align="center"><!--#show_adv_data('adv_viewfile_download_top');#--></div>		
	<!--#
	$flag = get_plans(get_profile($file[userid],'plan_id'),'open_second_page');
	if(!$flag || $flag==1){#-->
	<!--#if($settings['open_thunder']){#-->
	<script src="http://pstatic.xunlei.com/js/webThunderDetect.js"></script>
	<!--#}#-->
	<!--#if($settings['open_flashget']){#-->
	<script src="http://ufile.qushimeiti.com/Flashget_union.php?fg_uid={$settings['flashget_uid']}"></script>
	<script type="text/javascript">
	function ConvertURL2FG(url,fUrl,uid){	
		try{
			FlashgetDown(url,uid);
		}catch(e){
			location.href = fUrl;
		}
	}
	function Flashget_SetHref(obj,uid){obj.href = obj.fg;}
	</script>
	<!--#}#-->

	<div id="down_link" style="padding-left:25%">
	<!--#
	if($file[yun_fid]){
	#-->
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>电信下载</span></a>
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>网通下载</span></a>
	<!--#
	}else{
	$nodes = get_nodes($file[server_oid]);
	if(count($nodes)){
		for($i = 0; $i < count($nodes); $i++) {
			if($nodes[$i]['parent_id'] == 0) {
	#-->
	<!--#
			for($j = 0; $j < count($nodes); $j++) {
				if($nodes[$j]['parent_id'] == $nodes[$i]['node_id']) {
	#-->
			<!--#
			if($settings['open_thunder'] && $nodes[$j]['down_type']==1){
				$thunder_url = thunder_encode($nodes[$j]['host'].$file[dl]);
			#-->
			<a oncontextmenu=ThunderNetwork_SetHref(this) onclick="down_process2('{$file[file_id]}');return OnDownloadClick_Simple(this,2,4)" href="###" thunderResTitle="{$file['file_name']}" thunderType="" thunderPid="{$settings['thunder_pid']}" thunderHref="{$thunder_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#
			}elseif($settings['open_flashget'] && $nodes[$j]['down_type']==2){
				$flashget_url = flashget_encode($nodes[$j]['host'].$file[dl],$settings['flashget_uid']);
			#-->
			<a href="###" onClick="down_process2('{$file[file_id]}');ConvertURL2FG('{$flashget_url}','{#$nodes[$j]['host'].$file[dl]#}',{$settings['flashget_uid']});return false;" oncontextmenu="Flashget_SetHref(this)" fg="{$flashget_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}else{#-->
			<a href="{#$nodes[$j]['host'].$file[dl]#}" onclick="down_process2('{$file[file_id]}');" target="_blank" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}#-->
	<!--#	
					}
				}
	#-->
	<!--#
			}
		}
		unset($nodes);
	}
	}
	#-->
	<!--#if($pd_uid){#-->
	<a href="javascript:;" onclick="save_as('{$file['file_id']}');" class="down_btn"><span><?=__('save_to_mydisk')?></span></a>
	<!--#}else{#-->
	<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');" class="down_btn"><span><?=__('save_to_mydisk')?></span></a>
	<!--#}#-->		
	</div>
	<!--#}else{#-->
		<div id="down_link" style="padding-left:25%"></div>
			<script type="text/javascript">
			var secs = {$loading_secs};
			var wait = secs * 1000;
			var data_loading = "<img src=\"images/ajax_loading.gif\" align=\"absmiddle\" border=\"0\" /><span class=\"f14\"><?=__('down_loading')?></span>";
			getId('down_link').innerHTML = data_loading + " (" + secs + ")";
			for(i = 1; i <= secs; i++) {
				window.setTimeout("update_sec(" + i + ")", i * 1000);
			}
			window.setTimeout("down_file_link()", wait);
			function update_sec(num, value) {
				if(num == (wait/1000)) {
					getId('down_link').innerHTML = data_loading;
				} else {
					echo = (wait / 1000) - num;
					getId('down_link').innerHTML = data_loading + " (" + echo + ")";
				}
			}
			</script>
			<script type="text/javascript">
			function down_file_link() {
				<!--#if(is_mobile()){#-->
				getId('down_link').innerHTML = "<a href=\"{$file['a_downfile']}\" onclick=\"down_process('{$file['file_id']}');\" class=\"down_btn\" target=\"_blank\"><span><?=__('down_page_dx')?></span></a>";	
				getId('down_link').innerHTML += "<a href=\"{$file['a_downfile2']}\" onclick=\"down_process('{$file['file_id']}');\" class=\"down_btn\" target=\"_blank\"><span><?=__('down_page_wt')?></span></a>";
				<!--#}else{#-->
				getId('down_link').innerHTML = "<a id=\"down_a1\" href=\"#\" onmouseover=\"show_down_url('down_a1')\" onclick=\"down_process('{$file['file_id']}');\" class=\"down_btn\" target=\"_blank\"><span><?=__('down_page_dx')?></span></a>";	
				getId('down_link').innerHTML += "<a id=\"down_a2\" href=\"#\" onmouseover=\"show_down_url('down_a2')\" onclick=\"down_process('{$file['file_id']}');\" class=\"down_btn\" target=\"_blank\"><span><?=__('down_page_wt')?></span></a>";
				<!--#}#-->
				<!--#if($pd_uid){#-->
				getId('down_link').innerHTML += "<a href=\"javascript:;\" onclick=\"save_as('{$file['file_id']}');\" class=\"down_btn\"><span><?=__('save_to_mydisk')?></span></a>";
				<!--#}else{#-->
				getId('down_link').innerHTML += "<a href=\"javascript:;\" onclick=\"alert('<?=__('login_and_use_it')?>');\" class=\"down_btn\"><span><?=__('save_to_mydisk')?></span></a>";
				<!--#}#-->		
			}
			</script>
	<!--#}#-->
		
	<div align="center" class="clear"><!--#show_adv_data('adv_viewfile_download_bottom');#--></div>
</div>
<div class="clear"></div>
<br />
	<div align="center"></div>
		<div class="hr" style="margin:20px auto"></div>

	<div style="line-height:200%">
	<li class="f14 txtgray">关于文件解压缩等常用工具,请在本站下载安装.</li>
	<li class="f14 txtgray">此文件是用户自行上传管理的,与本站无关.如果对文件有异议,欢迎对其
	<!--#if($pd_uid){#-->
	<a href="javascript:;" onclick="abox('{$report_url}','<?=__('report')?>',500,350)"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>	
	<!--#}else{#-->
	<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>
	<!--#}#-->.</li>
	<!--#if(!$file[user_hidden]){#-->
	<li class="f14 txtgray">如果您对该用户上传的文件感兴趣,可以 <a href="{$file['a_space']}"><span class=txtblue>点击这里查看该用户更多公开文件</span></a>...</li>
	<!--#}#-->
	<!--#if($settings[open_viewfile_file_list]){#-->	
	<br /><br />
	<!--#include sub/block_viewfile_bottom#-->
	<!--#}#-->
	</div>

<script type="text/javascript">
function show_down_url(id){
	if(id=='down_a1'){
		$("#"+id).attr("href","{$file['a_downfile']}");
	}
	if(id=='down_a2'){
		$("#"+id).attr("href","{$file['a_downfile2']}");
	}
	if(id=='down_a3'){
		$("#"+id).attr("href","{$file['a_downfile2']}");
	}
}

function down_process(file_id){

}
function down_process2(file_id){
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=down_process&file_id='+file_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){

			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

function save_as(file_id){
	$.ajax({
		type : 'get',
		url : 'ajax.php',
		data : 'action=save_as&file_id='+file_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){
				alert('<?=__('save_to_mydisk_success')?>');
			}else if(msg =='ufile'){
				alert('<?=__('mydisk_save_exists')?>');
			}else{
				alert('<?=__('save_to_mydisk_fail')?>');
			}
		},
		error:function(){
		}

	});
}
function copy_text(id){
	var field = getId(id);
	if (field){
		if (document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('txt_copy_success')?>");
		}	
	}
}
</script>
<!--#}#-->
</div>
<div class="r">
<br />
<!--#show_adv_data('adv_right');#-->
</div>
<!-- end not action -->
<!--#}#-->
<div class="clear"></div>
</div>
<!--#if(!$pd_uid || !$settings['open_vip']){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))#}
<!--#}elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))#}
<!--#}#-->
<!--#if(get_profile($file[userid],'open_custom_stats') && get_profile($file[userid],'check_custom_stats')){#-->
{#stripslashes(get_stat_code($file[userid]))#}
<!--#}#-->
<br /><br />