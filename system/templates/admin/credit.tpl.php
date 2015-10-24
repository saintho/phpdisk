<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 16:52:51

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: credit.tpl.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2012 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action=='stat_day' || $action=='stat_hour' || $action=='stat_user'){ ?>
<script type="text/javascript">
function dostat(act,dd,id){
	$('#'+id).html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$.ajax({
		type : 'post',
		url : 'adm_ajax.php',
		data : 'action=dostat&act='+act+'&dd='+dd+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#'+id).html(arr[1]);
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});

}
</script>
<div id="container">
<h1>收入统计</h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray">显示网盘收入统计</span>
</div>
<form action="<?=urr(ADMINCP,"")?>" method="get">
<input type="hidden" name="item" value="<?=$item?>" />
<input type="hidden" name="menu" value="user" />
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="search" />
<div class="search_box">
<img src="templates/admin/images/it_nav.gif" align="absbottom" />
<?php if($action=='stat_user'){ ?>
用户名：<input type="text" name="user" value="<?=$user?>" />
<?php } ?>
时间范围：<input type="text" name="s_time" value="<?=$s_time?>" /> <= 时间 <= <input type="text" name="e_time" value="<?=$e_time?>" />
 每页显示：<select name="pp">
 <option value="20" <?=ifselected($pp,20)?>>20条</option>
 <option value="50" <?=ifselected($pp,50)?>>50条</option>
 <option value="100" <?=ifselected($pp,100)?>>100条</option>
 <option value="200" <?=ifselected($pp,200)?>>200条</option>
 <option value="300" <?=ifselected($pp,300)?>>300条</option>
 </select>
 <input type="submit" class="btn" value="搜索" />
</div>
</form>
<div class="clear"></div>
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="9">
	<a href="<?=urr(ADMINCP,"item=credit&menu=user&action=stat_day")?>" id="n_stat_day">每日统计</a>
	<a href="<?=urr(ADMINCP,"item=credit&menu=user&action=stat_hour")?>" id="n_stat_hour">每小时统计</a>
	<a href="<?=urr(ADMINCP,"item=credit&menu=user&action=stat_user")?>" id="n_stat_user">用户统计</a>
	<script>$('#n_<?=$action?>').addClass('sel_a');</script>
	</td>
</tr>
<?php 
if(count($stat_log)){
 ?>
<tr>
	<td width="20%" class="bold">统计时间</td>
	<td class="bold"><a href="<?=$v_url?>">浏览数<?=$v_add?></a><?php if($action<>'stat_hour'){ ?>/扣量后<?php } ?></td>
	<td class="bold" width="20%"><a href="<?=$d_url?>">下载次数<?=$d_add?></a><?php if($action<>'stat_hour'){ ?>/扣量后<?php } ?></td>
	<td class="bold" width="20%">分成金额<?php if($action<>'stat_hour'){ ?>/扣量后<?php } ?></td>
	<?php if($action=='stat_user'){ ?>
	<td class="bold">用户名</td>
	<td class="bold">下载率</td>
	<td class="bold">网赚计划</td>
	<?php } ?>
</tr>
<?php 
	foreach($stat_log as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td><?=$v['stat_time']?></td>
	<td><?=$v['views']?>
	<?php if($action=='stat_user'){ ?>
	/<?=get_discount($v[userid],$v[views])?>
	<?php }elseif($action=='stat_day'){ ?>
	/<span id="sdv_<?=$k?>" onclick="dostat('views','<?=$v[dd]?>','sdv_<?=$k?>')" style="cursor:pointer"><u>查看</u></span>
	<?php } ?></td>
	<td><?=$v['downs']?>
	<?php if($action=='stat_user'){ ?>
	/<?=get_discount($v[userid],$v[downs])?>
	<?php }elseif($action=='stat_day'){ ?>
	/<span id="sdd_<?=$k?>" onclick="dostat('downs','<?=$v[dd]?>','sdd_<?=$k?>')" style="cursor:pointer"><u>查看</u></span>
	<?php } ?></td>
	<td><?=$v[money]?>
	<?php if($action=='stat_user'){ ?>
	/<?=get_discount($v[userid],$v[money])?>
	<?php }elseif($action=='stat_day'){ ?>
	/<span id="sdm_<?=$k?>" onclick="dostat('money','<?=$v[dd]?>','sdm_<?=$k?>')" style="cursor:pointer"><u>查看</u></span>
	<?php } ?></td>
	<?php if($action=='stat_user'){ ?>
	<td><a href="<?=urr(ADMINCP,"item=users&menu=user&action=user_edit&uid=$v[userid]")?>"><?=$v[username]?></a></td>
	<td><?php echo round($v['downs']/$v['views'],4) ?></td>
	<td><?=get_plans($v[plan_id],'subject')?></td>
	<?php } ?>
</tr>
<?php 		
	}
	unset($stat_log);
 ?>
<tr>
	<td colspan="9"><?=$page_nav?></td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td colspan="9" align="center">暂无收入统计</td>
</tr>
<?php 
}
 ?>
</table>
</div>
</div>
<?php } ?>