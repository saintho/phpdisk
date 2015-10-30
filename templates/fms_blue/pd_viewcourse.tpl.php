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

<div class="div-breadcrumb">
	<ol class="breadcrumb">
		<li><a href="{#urr("index","")#}">首页</a></li>
		<!--#if(count($breadcrumb)){#-->
		<!--#foreach($breadcrumb as $item){#-->
		<!--#if(!empty($item['url'])){#-->
		<li><a href="{$item['url']}">{$item['name']}</a></li>
		<!--#}else{#-->
		<li class="active">{$item['name']}</li>
		<!--#}#-->
		<!--#}#-->
		<!--#}#-->
	</ol>
</div>

<div class="layout_box">
<!--#include sub/block_adv_middle#-->
<div class="md_l col-md-3">
<!--#show_adv_data('adv_right');#-->

<!--#include sub/block_cate_last_file#-->

<!--#include sub/block_yesterday_down_file#-->
</div>
<!--#if(!$action){#-->
<div class="md_r col-md-9">
<!--#if(false){#-->
<!--#}else{#-->
<div class="panel panel-default">
	<div class="col-md-6">
		<!--#show_adv_data('adv_viewfile_right');#-->
		<br/>
		<div class="jumbotron" style="width: 100%;height: 290px"></div>
	</div>
	<div class="col-md-6">
		<h3>{$course['course_name']}</h3>
		<table width="100%" cellpadding="4" cellspacing="0" align="center" class="td_line f14 table">
			<tr>
				<td colspan="2">课程分类: {$course['cate_name']}</td>
			</tr>
			<tr>
				<td width="50%">教师名称: {$course['username']}</td>
				<td>视频数: 3</td>
			</tr>
			<tr>
				<td>上传时间:<span id="file_upload_ip">{$course['update_date']}</span></td>
				<td>下载数: <span id="file_upload_time">{$course['download_num']}</span></td>
			</tr>
			<tr>
				<td colspan="2"><?=__('file_tag')?>: {$file['tags']}</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="op_btn">
					<!--#if($pd_uid){#-->
					<a href="javascript:;" onclick="abox('{$report_url}','<?=__('report')?>',500,350)"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>
					<!--#}else{#-->
					<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>
					<!--#}#-->
					<!--#if($pd_uid){#-->
					<a href="javascript:;" onclick="abox('{$comment_url}','<?=__('comment')?>',500,350)"><img src="images/cmt.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('comment')?></a>
					<!--#}else{#-->
					<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/cmt.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('comment')?></a>
					<!--#}#-->
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2"><!-- Baidu Button BEGIN -->
				<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
				<a class="bds_qzone"></a>
				<a class="bds_tsina"></a>
				<a class="bds_tqq"></a>
				<a class="bds_renren"></a>
				<a class="bds_t163"></a>
				<span class="bds_more"></span>
				<a class="shareCount"></a>
				</div>
				<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=68752" ></script>
				<script type="text/javascript" id="bdshell_js"></script>
				<script type="text/javascript">
				document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
				</script>
				<!-- Baidu Button END --></td>
			</tr>
		</table>
	</div>


<script type="text/javascript">
var lang = new Array();
lang['vote_just'] = "<?=__('vote_just')?>";
</script>
<script type="text/javascript" src="includes/js/digg.js"></script>
	<!--
<div class="digg">
<div id="digg0" onmouseover="this.style.backgroundPosition='0 0'" onmouseout="this.style.backgroundPosition='-189px 0'" onfocus="this.blur()" onClick="pdVote({$file['file_id']},1)">
	<div class="digg_bar"><div id="eimg1" style="width:{$file['g_px']}px"></div></div>
	<span id="barnum1"><span id="sp1">{$file['good_rate']}%</span> (<span id="s1">{$file['good_count']}</span>)</span>
</div>
<div style="margin-left:0;" id="digg1" onmouseover="this.style.backgroundPosition='-567px 0'" onmouseout="this.style.backgroundPosition='-378px 0'" onfocus="this.blur()" onclick="pdVote({$file['file_id']},2)">
	<div class="digg_bar"><div id="eimg2" style="width:{$file['b_px']}px"></div></div>
	<span id="barnum2"><span id="sp2">{$file['bad_rate']}%</span> (<span id="s2">{$file['bad_count']}</span>)</span>
</div>
</div>
-->

<!--
<div style="color:#999999; font-size:12px; padding:10px;" class="clear">声明：<strong>{$settings[site_title]}</strong>严禁上传包含淫秽色情、反动、侵权及其他违法内容的文件。<a href="###" onclick="window.external.addFavorite('{$settings[phpdisk_url]}','{$settings[site_title]}');return(false);" title="按 Ctrl+D 收藏本站">请点此收藏本站网址</a>,方便下次再下载所需文件！也可以百度一下<a href="http://www.baidu.com/s?wd={#rawurlencode($settings[site_title])#}" target="_blank">{$settings[site_title]}</a>进入本站。
</div>
-->
<div class="clearfix"></div>
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
function down_file_link() {
	<!--#if(!$file[is_checked]){#-->
	getId('down_link').innerHTML = "<?=__('file_checking')?>";
	<!--#}else{#-->

	<!--#if(!get_plans(get_profile($file[userid],'plan_id'),'open_second_page')){#-->
	load_file_addr('{$file['file_id']}');
	<!--#}else{#-->
	getId('down_link').innerHTML = "<a id=\"down_a1\" href=\"###\" onmouseover=\"show_down_url('down_a1')\" onclick=\"down_process('{$file['file_id']}');\" target=\"_blank\"><img src=\"{$user_tpl_dir}images/btn_download.png\" align=\"absmiddle\" border=\"0\" /></a>";
	<!--#}#-->

	<!--#}#-->

}
function show_down_url(id){
	if(id=='down_a1'){
		$("#"+id).attr("href","{$file['a_downfile']}");
	}
}
function load_file_addr(id){
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=load_file_addr&file_id='+id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#down_link').html("<a id=\"down_a1\" href=\""+arr[1]+"\" onclick=\"down_process('{$file['file_id']}');\" target=\"_blank\"><img src=\"{$user_tpl_dir}images/btn_download.png\" align=\"absmiddle\" border=\"0\" /></a>");
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

</script>

</div>

<div class="panel panel-default">
	<div class="panel-heading">课程下载</div>
	<div class="panel-body">
		<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="front_course_t">
			<!--#if(count($chapter_section_array)){#-->

			<!--#
}
if(count($chapter_section_array)){
    foreach($chapter_section_array as $k => $v){
        $color = ($k%2 ==0) ? 'color1' :'color4';
#-->
			<!--#if($v['is_cs']){ #-->
			<tr class="">
				<td>
					<!--# echo str_repeat('&nbsp;',$v['level']*2)#-->
					<img src="images/disk.gif" align="absmiddle" border="0" />
					{$v['cs_name']}
				</td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<!--<td align="center">
                    <a href="javascript:;" onclick="abox('{$v[a_edit]}','修改章节',350,250);"><img src="images/ico_write.png" align="absbottom" border="0" /></a>
                    <a href="javascript:;" onclick="abox('{$v[a_del]}','删除章节',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
                </td>-->
			</tr>
			<!--#} #-->
			<!--#if($v['is_file']){ #-->
			<tr class="">
				<td>
					<!--# echo str_repeat('&nbsp;',$v['level']*2)#-->
					<img src="images/tree/cd.gif" align="absmiddle" border="0" />
					{$v['file_name']}
				</td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray"></td>
				<td align="center" class="txtgray">下载</td>
				<!--<td align="center">
                    <a href="javascript:;" onclick="abox('{$v[a_del]}','删除文件',400,250)"><img src="images/delete_icon.gif" align="absmiddle" border="0" /></a>
                </td>-->
			</tr>
			<!--#} #-->
			<!--#
                }#-->

			<!--#}#-->
			<!--#
            if(!count($chapter_section_array) ){
            #-->
			<tr>
				<td colspan="6" align="center">内容为空，还没添加章节</td>
			</tr>
			<!--#
            }
            #-->
		</table>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">课程描述</div>
	<div class="panel-body">
		{$course[description]}
	</div>
</div>

<div>
<!--#include sub/block_viewfile_bottom#-->

<!--#if($auth[is_fms]){#-->
<br />
	<div class="cmt_u_box">
	<div class="cmt_title"><img src="images/ico_cmt.gif" align="absmiddle" border="0" /><?=__('user_cmts')?>:</div>
	<!--#
	if(count($cmts)){
		foreach($cmts as $v){
	#-->
	<div class="cmt_cts">
		<div class="cmt_name"><a href="{$v['a_space']}" target="_blank"><img src="images/ico_home.gif" align="absmiddle" border="0" />{$v['username']}</a> <span class="f11 txtgray">@ {$v['in_time']}</span></div>
		<div class="cmt_content">{$v['content']}</div>
	</div>
	<!--#
		}
		unset($cmts);
	#-->
	<div align="right"><a href="{$a_comment}"><?=__('view_all_cmts')?></a></div>
	<!--#
	}else{
	#-->
	<div class="cmt_cts"><?=__('cmt_not_found')?></div>
	<!--#
	}
	#-->
	</div>
<!--#}#-->
</div>

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
		}else{
			alert("<?=__('not_ie_copy_tips')?>");
		}
	}
}
</script>
<!--#}#-->
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