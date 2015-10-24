<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-04 18:13:41

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
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
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="layout_box">
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
<div class="l">
<?php show_adv_data('adv_right'); ?>
<?php require_once template_echo('sub/block_cate_last_file','templates/fms_blue/'); ?>
<br />
<?php require_once template_echo('sub/block_yesterday_down_file','templates/fms_blue/'); ?>
</div>
<?php if(!$action){ ?>
<div class="r">
<?php if($file['is_del']){ ?>
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/><?=__('file_is_delete')?><br /><br /><br /></div>
<?php }else{ ?>
<div class="file_box">
	<h3 class="file_tit"><?=file_icon($file['file_extension'],'filetype_32','absbottom')?><?=$file['file_name']?></h3>
	<div class="fb_l">
		<table width="100%" cellpadding="4" cellspacing="0" align="center" class="td_line f14">
		<tr>
			<td colspan="2"><?=__('file_category')?>: <?=get_cate_path($file[cate_id])?></td>
		</tr>
		<tr>
			<td width="50%"><?=__('upload_user')?>: <?=$file['username']?></td>
			<td><?=__('file_size')?>: <?=$file['file_size']?></td>
		</tr>
		<tr>
			<td><?=__('upload_ip')?>:<span id="file_upload_ip"><?=ip_encode($file['ip'])?></span></td>
			<td><?=__('upload_time')?>: <span id="file_upload_time"><?=$file['file_time']?></span></td>
		</tr>
		<tr>
			<td><?=__('file_downs')?>: <span id="file_downs"><?=$file['file_downs']?></span> </td>
			<td><?=__('file_views')?>: <span id="file_views"><?=$file['file_views']?></span> </td>
		</tr>
		<tr>
			<td colspan="2"><?=__('file_tag')?>: <?=$file['tags']?></td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="op_btn">
			<a href="<?=urr("shortcut","url=".$settings[phpdisk_url].urr("viewfile","file_id=".$file[file_id])."&name=".$file['file_name'])?>"><img src="images/valid.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('save_to_desktop')?></a>
		<?php if($pd_uid){ ?>
		<a href="javascript:;" onclick="save_as('<?=$file['file_id']?>');"><img src="images/save_disk.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('save_to_mydisk')?></a>
		<?php }else{ ?>
		<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/save_disk.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('save_to_mydisk')?></a>
		<?php } ?>
		<a href="<?=$_SERVER['REQUEST_URI']?>#down"><img src="images/down_file_icon.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('download_address')?></a>	
		</div>	
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="op_btn">
			<?php if($pd_uid){ ?>
			<a href="javascript:;" onclick="abox('<?=$report_url?>','<?=__('report')?>',500,350)"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>	
			<?php }else{ ?>
			<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/report.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('report')?></a>
			<?php } ?>
			<?php if($pd_uid){ ?>
			<a href="javascript:;" onclick="abox('<?=$comment_url?>','<?=__('comment')?>',500,350)"><img src="images/cmt.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('comment')?></a>	
			<?php }else{ ?>
			<a href="javascript:;" onclick="alert('<?=__('login_and_use_it')?>');"><img src="images/cmt.gif" width="17" height="17" align="absmiddle" border="0" /><?=__('comment')?></a>	
			<?php } ?>
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
	<div class="fb_r">
	<br />
	<?php show_adv_data('adv_viewfile_right'); ?>
	</div>

<script type="text/javascript">
var lang = new Array();
lang['vote_just'] = "<?=__('vote_just')?>";
</script>
<script type="text/javascript" src="includes/js/digg.js"></script>
<div class="digg">
<div id="digg0" onmouseover="this.style.backgroundPosition='0 0'" onmouseout="this.style.backgroundPosition='-189px 0'" onfocus="this.blur()" onClick="pdVote(<?=$file['file_id']?>,1)">
	<div class="digg_bar"><div id="eimg1" style="width:<?=$file['g_px']?>px"></div></div>
	<span id="barnum1"><span id="sp1"><?=$file['good_rate']?>%</span> (<span id="s1"><?=$file['good_count']?></span>)</span>
</div>
<div style="margin-left:0;" id="digg1" onmouseover="this.style.backgroundPosition='-567px 0'" onmouseout="this.style.backgroundPosition='-378px 0'" onfocus="this.blur()" onclick="pdVote(<?=$file['file_id']?>,2)">
	<div class="digg_bar"><div id="eimg2" style="width:<?=$file['b_px']?>px"></div></div>
	<span id="barnum2"><span id="sp2"><?=$file['bad_rate']?>%</span> (<span id="s2"><?=$file['bad_count']?></span>)</span>
</div>
</div>

<div style="color:#999999; font-size:12px; padding:10px;" class="clear">声明：<strong><?=$settings[site_title]?></strong>严禁上传包含淫秽色情、反动、侵权及其他违法内容的文件。<a href="###" onclick="window.external.addFavorite('<?=$settings[phpdisk_url]?>','<?=$settings[site_title]?>');return(false);" title="按 Ctrl+D 收藏本站">请点此收藏本站网址</a>,方便下次再下载所需文件！也可以百度一下<a href="http://www.baidu.com/s?wd=<?=rawurlencode($settings[site_title])?>" target="_blank"><?=$settings[site_title]?></a>进入本站。
</div>

<div class="file_link_box">
	<div align="center"><?php show_adv_data('adv_viewfile_hits_bottom'); ?></div>
	<div align="center"><?php show_adv_data('adv_viewfile_download_top'); ?></div>
	<div style="float:left; width:300px; margin-top:10px" id="down_link"></div><a name="down" id="down"></a>
	<div style="float:right; width:420px; background-color:#FFF7C8; border:#FDA918 1px dotted">
	<ul style="margin:0; padding:0">
	<li class="txtgray"><?=__('file_view_url')?>: <input type="text" class="txtgray" value="<?=$file['file_view_url']?>" id="f_view" size="38" onclick="getId('f_view').select();copy_text('f_view');" readonly/>&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_view').select();copy_text('f_view');" /></li>
	<li class="txtgray"><?=__('file_ubb_url')?>: <input type="text" class="txtgray" value="<?=$file['file_ubb_url']?>" id="f_ubb" size="38" onclick="getId('f_ubb').select();copy_text('f_ubb');" readonly />&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_ubb').select();copy_text('f_ubb');" /></li>
	<li class="txtgray"><?=__('file_html_url')?>: <input type="text" class="txtgray" value="<?=$file['file_html_url']?>" id="f_html" size="38" onclick="getId('f_html').select();copy_text('f_html');" readonly />&nbsp;<input type="button" class="btn" value="<?=__('copy_link')?>" onclick="getId('f_html').select();copy_text('f_html');" /></li>
	</ul>
	</div>
	<div class="clear"></div>
	<div align="center" class="clear"><?php show_adv_data('adv_viewfile_download_bottom'); ?></div>
</div>
<Br />
<script type="text/javascript">
var secs = <?=$loading_secs?>;
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
	<?php if(!$file[is_checked]){ ?>
	getId('down_link').innerHTML = "<?=__('file_checking')?>";
	<?php }else{ ?>
	
	<?php if(!get_plans(get_profile($file[userid],'plan_id'),'open_second_page')){ ?>
	load_file_addr('<?=$file['file_id']?>');
	<?php }else{ ?>
	getId('down_link').innerHTML = "<a id=\"down_a1\" href=\"###\" onmouseover=\"show_down_url('down_a1')\" onclick=\"down_process('<?=$file['file_id']?>');\" target=\"_blank\"><img src=\"<?=$user_tpl_dir?>images/btn_download.png\" align=\"absmiddle\" border=\"0\" /></a>";
	<?php } ?>
	
	<?php } ?>
	
}
function show_down_url(id){
	if(id=='down_a1'){
		$("#"+id).attr("href","<?=$file['a_downfile']?>");
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
				$('#down_link').html("<a id=\"down_a1\" href=\""+arr[1]+"\" onclick=\"down_process('<?=$file['file_id']?>');\" target=\"_blank\"><img src=\"<?=$user_tpl_dir?>images/btn_download.png\" align=\"absmiddle\" border=\"0\" /></a>");
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

</script>

<div class="file_item file_desc">
	<div class="tit"><?=__('file_description')?>:</div>
	<div class="ctn"><?=$file[file_description]?></div>
</div>

</div>
<Br />

<div>
<?php require_once template_echo('sub/block_viewfile_bottom','templates/fms_blue/'); ?>
<?php if($auth[is_fms]){ ?>
<br />
	<div class="cmt_u_box">
	<div class="cmt_title"><img src="images/ico_cmt.gif" align="absmiddle" border="0" /><?=__('user_cmts')?>:</div>
	<?php 
	if(count($cmts)){
		foreach($cmts as $v){
	 ?>
	<div class="cmt_cts">
		<div class="cmt_name"><a href="<?=$v['a_space']?>" target="_blank"><img src="images/ico_home.gif" align="absmiddle" border="0" /><?=$v['username']?></a> <span class="f11 txtgray">@ <?=$v['in_time']?></span></div>
		<div class="cmt_content"><?=$v['content']?></div>
	</div>
	<?php 
		}
		unset($cmts);
	 ?>
	<div align="right"><a href="<?=$a_comment?>"><?=__('view_all_cmts')?></a></div>
	<?php 
	}else{
	 ?>
	<div class="cmt_cts"><?=__('cmt_not_found')?></div>
	<?php 
	}
	 ?>
	</div>
<?php } ?>
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
<?php } ?>
</div>
<!-- end not action -->
<?php } ?>
<div class="clear"></div>
</div>
<?php if(!$pd_uid || !$settings['open_vip']){ ?>
<?=stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))?>
<?php }elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){ ?>
<?=stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))?>
<?php } ?>
<?php if(get_profile($file[userid],'open_custom_stats') && get_profile($file[userid],'check_custom_stats')){ ?>
<?=stripslashes(get_stat_code($file[userid]))?>
<?php } ?>
<br /><br />