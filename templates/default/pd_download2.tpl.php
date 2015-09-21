<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_download2.tpl.php 123 2014-03-04 12:40:37Z along $
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

<div>
	<div align="center"><!--#show_adv_data('adv_viewfile_download_top');#--></div>		
	<!--#if($auth[open_second_page] && get_plans(get_profile($file[userid],'plan_id'),'open_second_page')==2){#-->
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
	<div id="down_link" style="padding-left:35%">
	<!--#
	if($file[yun_fid]){
	#-->
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>电信下载</span></a>
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>网通下载</span></a>
	<!--#
	}else{

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
	</div>
	<!--#}else{#-->
		<div id="down_link" style="padding-left:35%">
		<a href="{$file['a_downfile']}" class="down_btn"><span><?=__('down_page_dx')?></span></a>
		<a href="{$file['a_downfile']}" class="down_btn"><span><?=__('down_page_wt')?></span></a>
		</div>
	<!--#}#-->
		
	<div align="center" class="clear"><!--#show_adv_data('adv_viewfile_download_bottom');#--></div>
</div>
<div class="clear"></div>
<br />
	<div align="center"></div>
		<div class="hr" style="margin:20px auto"></div>

<script type="text/javascript">
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
<br /><br />