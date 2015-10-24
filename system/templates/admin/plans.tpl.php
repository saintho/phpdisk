<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-27 16:53:14

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: plans.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action=='list'){ ?>
<div id="container">
<h1><?=__('earn_plans_manage')?><?php sitemap_tag(__('earn_plans')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('earn_plans_tips')?></span>
</div>
<form name="plans_form" action="<?=urr(ADMINCP,"item=plans&menu=user")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<?php if($auth[open_plan_active]){ ?>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('open_plan_active')?></span>: <br /><span class="txtgray"><?=__('open_plan_active_tips')?></span></td>
	<td><input type="radio" id="ot1" name="setting[open_plan_active]" value="1" <?=ifchecked(1,$settings['open_plan_active'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" id="ot0" name="setting[open_plan_active]" value="0" <?=ifchecked(0,$settings['open_plan_active'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('down_active_interval')?></span>: <br /><span class="txtgray"><?=__('down_active_interval_tips')?></span></td>
	<td><input type="radio" id="da1" name="setting[down_active_interval]" value="day" <?=ifchecked($settings[down_active_interval],'day','str')?> /> <label for="da1"><?=__('by_yesterday')?></label>&nbsp;&nbsp;<input type="radio" id="da0" name="setting[down_active_interval]" value="week" <?=ifchecked($settings[down_active_interval],'week','str')?>/> <label for="da0"><?=__('by_last_week')?></label></td>
</tr>
</table>
<br />
<?php } ?>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30" align="center" class="bold"><?=__('show_order')?></td>
	<td class="bold" width="15%"><?=__('plans_subject')?></td>
	<td class="bold" width="10%" align="center">扣量</td>
	<td class="bold" width="10%" align="center"><?=__('plans_user_count')?></td>
	<td class="bold" width="30%"><?=__('plans_content')?></td>
	<?php if($auth[open_plan_active]){ ?>
	<td class="bold"><?=__('plans_down_active_num')?></td>
	<?php } ?>
	<td class="bold" width="50" align="center"><?=__('status')?></td>
	<td class="bold" align="right"><?=__('operation')?></td>
</tr>
<?php 
if(count($plans)){
	foreach($plans as $k=>$v){
 ?>
<tr>
	<td>
	<input type="text" name="show_order[]" value="<?=$v['show_order']?>" style="width:20px; text-align:center" maxlength="2" />
	<input type="hidden" name="plan_ids[]" value="<?=$v['plan_id']?>" />
	</td>
	<td><a href="<?=$v['a_edit_plan']?>"><?=$v['subject']?></a></td>
	<td align="center"><?=$v[discount]?>%</td>
	<td align="center"><?=$v[user_count]?></td>
	<td><?=$v['content']?></td>
	<?php if($auth[open_plan_active]){ ?>
	<td><?=$v[down_active_num_min]?> <= <?=__('file_downs_num')?> < <?=$v[down_active_num_max]?></td>
	<?php } ?>
	<td align="center"><a href="<?=$v['a_change_status']?>"><?=$v['status_text']?></a></td>
	<td align="right">
	<?php if($auth[plan_set_default]){ ?><?=$v[is_default]?><?php } ?>
	<a href="<?=$v['a_edit_plan']?>" id="p_<?=$k?>"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>&nbsp;
	<div id="c_<?=$k?>" class="menu_box2 menu_common">
	<?php if($auth[plan_set_default]){ ?>
	<a href="<?=$v['a_set_plan']?>" class="txtgreen"><?=__('set_default')?></a>
	<?php } ?>
	<a href="<?=$v['a_edit_plan']?>"><?=__('modify')?></a>
	<a href="<?=$v['a_truncate_plan']?>" class="txtred" onclick="return confirm('<?=__('plan_truncate_confirm')?>');" target="_blank"><?=__('truncate')?></a>
	<a href="<?=$v['a_del_plan']?>" onclick="return confirm('<?=__('plan_delete_confirm')?>');"><?=__('delete')?></a>
	</div>
	</td>
</tr>
<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','-x','');</script>
<?php 
	}
	unset($plans);
}else{	
 ?>
<tr>
	<td align="center" colspan="7"><?=__('plans_not_found')?></td>
</tr>
<?php 
}
 ?>
<tr>
	<td align="center" colspan="7"><input type="button" class="btn" value="<?=__('add_plans')?>" onclick="go('<?=urr(ADMINCP,"item=plans&menu=user&action=add")?>');" /> <input type="submit" class="btn" value="<?=__('btn_submit')?>" />
	<?php if($auth[plan_set_default]){ ?>
	<input type="button" class="btn" value="<?=__('cancel_default')?>" onclick="go('<?=urr(ADMINCP,"item=plans&menu=user&action=cancel_default")?>');" />
	<?php } ?>
	</td>
</tr>
</table>
</form>
</div>
</div>
<?php }elseif($action=='add' || $action=='edit'){ ?>
<div id="container">
<?php if($action =='add'){ ?>
<h1><?=__('add_plans')?></h1>
<?php }else{ ?>
<h1><?=__('edit_plans')?></h1>
<?php } ?>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_edit_plans_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=plans&menu=user")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="plan_id" value="<?=$plan_id?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><b><?=__('plans_subject')?></b>:<br /><span class="txtgray"><?=__('plans_subject_tips')?></span></td>
	<td><input type="text" name="subject" value="<?=$pa[subject]?>" size="50" maxlength="100" /></td>
</tr>
<tr>
	<td><b><?=__('plans_content')?></b>:<br /><span class="txtgray"><?=__('plans_content_tips')?></span></td>
	<td><textarea name="content" id="content" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('content','expand');"><?=$pa[content]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('content','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('content','sub');">[-]</a></td>
</tr>
<?php if($auth[plan_discount]){ ?>
<tr>
	<td ><span class="bold">网赚计划扣量:</span><br /><span class="txtgray"><?=__('discount_rate_tips')?></span></td>
	<td><input type="text" name="discount" value="<?=$pa[discount]?>" maxlength="10" />%</td>
</tr>
<?php } ?>
<tr>
	<td><b><?=__('plans_space_code')?></b>:<br /><span class="txtgray"><?=__('plans_space_code_tips')?></span></td>
	<td><textarea name="space_code" id="space_code" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('space_code','expand');"><?=$pa[space_code]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('space_code','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('space_code','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('plans_viewfile_code')?></b>:<br /><span class="txtgray"><?=__('plans_viewfile_code_tips')?></span></td>
	<td><textarea name="viewfile_code" id="viewfile_code" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('viewfile_code','expand');"><?=$pa[viewfile_code]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('viewfile_code','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('viewfile_code','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('plans_download_code')?></b>:<br /><span class="txtgray"><?=__('plans_download_code_tips')?></span></td>
	<td><textarea name="download_code" id="download_code" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('download_code','expand');"><?=$pa[download_code]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('download_code','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('download_code','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('plans_download_code_top')?></b>:<br /><span class="txtgray"><?=__('plans_download_code_top_tips')?></span></td>
	<td><textarea name="download_code_top" id="download_code_top" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('download_code_top','expand');"><?=$pa[download_code_top]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('download_code_top','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('download_code_top','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('plans_download_code_left')?></b>:<br /><span class="txtgray"><?=__('plans_download_code_left_tips')?></span></td>
	<td><textarea name="download_code_left" id="download_code_left" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('download_code_left','expand');"><?=$pa[download_code_left]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('download_code_left','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('download_code_left','sub');">[-]</a></td>
</tr>
<tr>
	<td><b><?=__('plans_download_code_bottom')?></b>:<br /><span class="txtgray"><?=__('plans_download_code_bottom_tips')?></span></td>
	<td><textarea name="download_code_bottom" id="download_code_bottom" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('download_code_bottom','expand');"><?=$pa[download_code_bottom]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('download_code_bottom','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('download_code_bottom','sub');">[-]</a></td>
</tr>
<tr>
	<td ><b><?=__('plans_rate')?>:</b><br /><span class="txtgray"><?=__('plans_rate_tips')?></span></td>
	<td>
	<?=__('credit')?>：<input type="text" name="income_rate_credit" value="<?=$pa[income_rate_credit]?>" size="3" maxlength="6" />==
	<input type="text" name="income_rate_money" value="<?=$pa[income_rate_money]?>" size="3" maxlength="6" /><?=__('currency_unit')?><br />
	</td>
</tr>
<?php if($auth[open_plan_active]){ ?>
<tr>
	<td ><b><?=__('down_active')?>:</b><br /><span class="txtgray"><?=__('down_active_tips')?></span></td>
	<td>
	<input type="text" name="down_active_num_min" size="10" value="<?=$pa[down_active_num_min]?>" /> <= <?=__('file_downs_num')?> < <input type="text" name="down_active_num_max" size="10" value="<?=$pa[down_active_num_max]?>" />
	</td>
</tr>
<?php } ?>
<?php if($auth[open_second_page]){ ?>
<tr>
	<td><b>文件下载使用多少页</b>:<br /><span class="txtgray">默认下载使用三页</span></td>
	<td><input type="radio" name="open_second_page" value="1" <?=ifchecked($pa[open_second_page],1)?> />第一页
	<input type="radio" name="open_second_page" value="2" <?=ifchecked($pa[open_second_page],2)?> />第二页
	<input type="radio" name="open_second_page" value="3" <?=ifchecked($pa[open_second_page],3)?> />第三页
	</td>
</tr>
<?php } ?>
<tr>
	<td><b><?=__('plans_hidden')?></b>:<br /><span class="txtgray"><?=__('plans_hidden_tips')?></span></td>
	<td><input type="radio" name="is_hidden" value="1" <?=ifchecked($pa[is_hidden],1)?> /><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="is_hidden" value="0" <?=ifchecked($pa[is_hidden],0)?> /><?=__('no')?></td>
</tr>
<tr>
	<td><b><?=__('plans_ip_interval')?></b>:<br /><span class="txtgray">同一用户下载文件的IP间隔时间</span></td>
	<td><input type="text" name="ip_interval" value="<?=$pa[ip_interval]?>" />分钟</td>
</tr>
<tr>
	<td><b><?=__('plans_memo')?></b>:<br /><span class="txtgray"><?=__('plans_memo_tips')?></span></td>
	<td><textarea name="memo" id="memo" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('memo','expand');"><?=$pa[memo]?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('memo','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('memo','sub');">[-]</a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><span class="txtred"><?=__('plan_edit_tips')?></span><br />	
	<input type="submit" class="btn" value="<?=__('btn_submit')?>" <?php if(get_plan_users($plan_id)){ ?> onclick="return confirm('<?=__('plans_has_user')?>')" <?php } ?>/>&nbsp;
	<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(o.subject.value.strtrim().length <2){
		alert("<?=__('plans_subject_error')?>");
		o.subject.focus();
		return false;
	}
	if(o.content.value.strtrim().length <2){
		alert("<?=__('plans_content_error')?>");
		o.content.focus();
		return false;
	}
}
</script>
<?php } ?>
