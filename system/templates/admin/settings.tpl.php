<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-27 16:23:35

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: settings.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if($action =='base'){
 ?>
<div id="container">
<h1><?=__('base_setting')?><?php sitemap_tag(__('base_setting')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('setting_tips')?></span><br />
<span class="txtred"><?=$file_path_tips?></span>
</div>
<form action="<?=urr(ADMINCP,"item=settings&menu=base")?>" method="post" onsubmit="return chksettings();">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('site_title')?></span>: <br /><span class="txtgray"><?=__('site_title_tips')?></span></td>
	<td><input type="text" id="site_title" name="setting[site_title]" value="<?=$setting['site_title']?>" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('site_stat')?></span>: <br /><span class="txtgray"><?=__('site_stat_tips')?></span></td>
	<td>
	<textarea name="setting[site_stat]" id="site_stat" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('site_stat','expand');"><?=$settings['site_stat']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('site_stat','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('site_stat','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('miibeian')?></span>: <br /><span class="txtgray"><?=__('miibeian_tips')?></span></td>
	<td><input type="text" id="miibeian" name="setting[miibeian]" value="<?=$setting['miibeian']?>" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('contact_us')?></span>: <br /><span class="txtgray"><?=__('contact_us_tips')?></span></td>
	<td><input type="text" id="contact_us" name="setting[contact_us]" value="<?=$setting['contact_us']?>" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('phpdisk_url')?></span>: <br /><span class="txtgray"><?=__('phpdisk_url_tips')?></span></td>
	<td><input type="text" id="phpdisk_url" name="setting[phpdisk_url]" value="<?=$setting['phpdisk_url']?>" size="40" maxlength="150"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('encrypt_key')?></span>: <br /><span class="txtgray"><?=__('encrypt_key_tips')?></span></td>
	<td><input type="text" id="encrypt_key" name="setting[encrypt_key]" value="<?=$setting['encrypt_key']?>" maxlength="16"/>&nbsp;<input type="button" value="<?=__('make_random')?>" class="btn" onclick="make_code();" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('allow_access')?></span>: <br /><span class="txtgray"><?=__('allow_access_tips')?></span></td>
	<td><input type="radio" name="setting[allow_access]" value="1" <?=ifchecked(1,$setting['allow_access'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[allow_access]" value="0" <?=ifchecked(0,$setting['allow_access'])?>/> <?=__('no')?><br />
	<textarea name="setting[close_access_reason]" id="close_access_reason" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('close_access_reason','expand');"><?=$settings['close_access_reason']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('close_access_reason','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('close_access_reason','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('allow_register')?></span>: <br /><span class="txtgray"><?=__('allow_register_tips')?></span></td>
	<td><input type="radio" name="setting[allow_register]" value="1" <?=ifchecked(1,$setting['allow_register'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[allow_register]" value="0" <?=ifchecked(0,$setting['allow_register'])?>/> <?=__('no')?><br />
	<textarea name="setting[close_register_reason]" id="close_register_reason" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('close_register_reason','expand');"><?=$settings['close_register_reason']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('close_register_reason','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('close_register_reason','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/>&nbsp;
	<?php if($remote_server_url){ ?>
	<input type="button" class="btn" onclick="open_box('<?=$remote_server_url?>',400,200);" value="<?=__('update_remote_config')?>" />
	<?php } ?>
	&nbsp;<br /><span id="rm_tips" class="txtred"></span></td>
</tr>
</table>
</form>
<script language="javascript">
function chksettings(){
	if(getId('site_title').value.strtrim().length <1){
		alert("<?=__('js_site_title')?>");
		getId('site_title').focus();
		return false;
	}
	if(getId('phpdisk_url').value.strtrim().length <1){
		alert("<?=__('js_phpdisk_url')?>");
		getId('phpdisk_url').focus();
		return false;
	}
	if(getId('encrypt_key').value.strtrim().length <8){
		alert("<?=__('js_encrypt_key')?>");
		getId('encrypt_key').focus();
		return false;
	}
}
function make_code(){
   var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   var tmp = "";
   var code = "";
   for(var i=0;i<12;i++){
	   code += chars.charAt(Math.ceil(Math.random()*100000000)%chars.length);
   }
   getId('encrypt_key').value = code;
}
</script>
</div>
</div>
<?php }elseif($action =='advanced'){ ?>
<div id="container">
<h1><?=__('advanced_setting')?><?php sitemap_tag(__('advanced_setting')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('setting_tips')?></span><br />
<span class="txtred"><?=$file_path_tips?></span>
</div>
<form action="<?=urr(ADMINCP,"item=settings&menu=base")?>" method="post" onsubmit="return chksettings();">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('max_file_size')?></span>: <br /><span class="txtgray"><?=__('max_file_size_tips')?></span></td>
	<td><input type="text" id="max_file_size" name="setting[max_file_size]" value="<?=$setting['max_file_size']?>" maxlength="10"/> <?=__('current_file_size')?>: <b><?=$max_user_file_size?></b></td>
</tr>
<tr>
	<td><span class="bold"><?=__('file_path')?></span>: <br /><span class="txtgray"><?=__('file_path_tips')?></span></td>
	<td><input type="text" id="file_path" name="setting[file_path]" value="<?=$setting['file_path']?>" maxlength="30"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('invite_register_encode')?></span>: <br /><span class="txtgray"><?=__('invite_register_encode_tips')?></span></td>
	<td><input type="radio" name="setting[invite_register_encode]" value="1" <?=ifchecked(1,$settings['invite_register_encode'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[invite_register_encode]" value="0" <?=ifchecked(0,$settings['invite_register_encode'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('gzipcompress')?></span>: <br /><span class="txtgray"><?=__('gzipcompress_tips')?></span></td>
	<td><input type="radio" name="setting[gzipcompress]" value="1" <?=ifchecked(1,$setting['gzipcompress'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[gzipcompress]" value="0" <?=ifchecked(0,$setting['gzipcompress'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('site_notify')?></span>: <br /><span class="txtgray"><?=__('site_notify_tips')?></span></td>
	<td>
	<textarea name="setting[site_notify]" id="site_notify" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('site_notify','expand');"><?=$settings['site_notify']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('site_notify','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('site_notify','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td ><span class="bold"><?=__('deny_extension')?>:</span><br /><span class="txtgray"><?=__('deny_extension_tips')?></span></td>
	<td>
	<textarea name="setting[deny_extension]" id="deny_extension" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('deny_extension','expand');"><?=$settings['deny_extension']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('deny_extension','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('deny_extension','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td ><span class="bold">模板添加meta代码:</span><br /><span class="txtgray">添加meta代码可以用于域名验证，接口验证时添加的便捷，不需要手动修改模板</span></td>
	<td>
	<textarea name="setting[meta_ext]" id="meta_ext" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('meta_ext','expand');"><?=$settings['meta_ext']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_ext','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_ext','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td ><span class="bold"><?=__('min_to_income_set')?>:</span><br /><span class="txtgray"><?=__('min_to_income_set_tips')?></span></td>
	<td><input type="text" name="setting[min_to_income]" value="<?=$settings['min_to_income']?>" maxlength="10" /></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('downline_income')?>:</span><br /><span class="txtgray"><?=__('downline_income_tips')?></span></td>
	<td><input type="text" name="setting[downline_income]" value="<?=$settings['downline_income']?>" maxlength="10" />%</td>
</tr>
<?php if($auth[open_downline2]){ ?>
<tr>
	<td ><span class="bold">二级下线佣金:</span><br /><span class="txtgray">设定二级下线提成佣金，百分之x ，只需要填写x 即可。</span></td>
	<td><input type="text" name="setting[downline_income2]" value="<?=$settings['downline_income2']?>" maxlength="10" />%</td>
</tr>
<?php } ?>
<tr>
	<td ><span class="bold"><?=__('default_income_rate')?>:</span><br /><span class="txtgray"><?=__('default_income_rate_tips')?></span></td>
	<td>
	<?=__('credit')?>：<input type="text" name="setting[how_downs_credit]" value="<?=$settings['how_downs_credit']?>" size="3" maxlength="6" />==
	<input type="text" name="setting[how_money_credit]" value="<?=$settings['how_money_credit']?>" size="3" maxlength="6" /><?=__('currency_unit')?><br />
	</td>
</tr>
<?php if($auth[open_discount]){ ?>
<tr>
	<td ><span class="bold"><?=__('discount_rate')?>:</span><br /><span class="txtgray"><?=__('discount_rate_tips')?></span></td>
	<td><input type="text" name="setting[discount_rate]" value="<?=$settings['discount_rate']?>" maxlength="10" />%</td>
</tr>
<?php } ?>
<tr>
	<td ><span class="bold"><?=__('cookie_domain')?>:</span><br /><span class="txtgray"><?=__('cookie_domain_tips')?></span></td>
	<td><input type="text" name="setting[cookie_domain]" value="<?=$settings['cookie_domain']?>" maxlength="50" /></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('reg_interval')?>:</span><br /><span class="txtgray"><?=__('reg_interval_tips')?></span></td>
	<td><input type="text" name="setting[reg_interval]" value="<?=$settings['reg_interval']?>" maxlength="10" size="10" /></td>
</tr>
<?php if($auth[close_guest_upload]){ ?>
<tr>
	<td><span class="bold"><?=__('close_guest_upload')?></span>: <br /><span class="txtgray"><?=__('close_guest_upload_tips')?></span></td>
	<td><input type="radio" name="setting[close_guest_upload]" value="1" <?=ifchecked(1,$setting['close_guest_upload'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[close_guest_upload]" value="0" <?=ifchecked(0,$setting['close_guest_upload'])?>/> <?=__('no')?></td>
</tr>
<?php } ?>
<tr>
	<td><span class="bold"><?=__('global_open_custom_stats')?></span>: <br /><span class="txtgray"><?=__('global_open_custom_stats_tips')?></span></td>
	<td><input type="radio" name="setting[global_open_custom_stats]" value="1" <?=ifchecked(1,$setting['global_open_custom_stats'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[global_open_custom_stats]" value="0" <?=ifchecked(0,$setting['global_open_custom_stats'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td ><span class="bold"><?=__('global_sec_loading')?>:</span><br /><span class="txtgray"><?=__('global_sec_loading_tips')?></span></td>
	<td><input type="text" name="setting[global_sec_loading]" value="<?=$settings['global_sec_loading']?>" maxlength="10" size="10" /></td>
</tr>
<?php if($auth[open_xsendfile]){ ?>
<tr>
	<td><span class="bold"><?=__('open_xsendfile')?></span>: <br /><span class="txtgray"><?=__('open_xsendfile_tips')?></span></td>
	<td><input type="radio" name="setting[open_xsendfile]" value="0" <?=ifchecked(0,$setting['open_xsendfile'])?> /><?=__('php_flow')?>&nbsp;&nbsp;<input type="radio" name="setting[open_xsendfile]" value="1" <?=ifchecked(1,$setting['open_xsendfile'])?>/><?=__('apache_flow')?>&nbsp;&nbsp;<input type="radio" name="setting[open_xsendfile]" value="2" <?=ifchecked(2,$setting['open_xsendfile'])?>/><?=__('nginx_flow')?></td>
</tr>
<?php } ?>
<?php if($auth[pd_a]){ ?>
<tr>
	<td><span class="bold">关闭首页网站统计显示</span>: </td>
	<td><input type="radio" name="setting[close_index_stats]" value="1" <?=ifchecked(1,$setting['close_index_stats'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[close_index_stats]" value="0" <?=ifchecked(0,$setting['close_index_stats'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold">用户可修改二级域名次数</span>:<br /><span class="txtgray">设置为 0 则为不限制修改次数</span> </td>
	<td><input type="text" name="setting[mod_subdomain]" value="<?=$settings['mod_subdomain']?>" maxlength="10" size="10" /></td>
</tr>
<tr>
	<td><span class="bold">新注册用户所属组</span>: <br /><span class="txtgray"> 设置新注册的用户对应的用户组ID</span></td>
	<td>
	<select name="setting[default_reg_gid]">
	<?php if(count($gids)){
		foreach($gids as $v){
	 ?>
	<option value="<?=$v[gid]?>" <?=ifselected($v[gid],$settings[default_reg_gid])?>>(ID:<?=$v[gid]?>) <?=$v[group_name]?></option>
	<?php 
		}
	}
	 ?>
	</select>
	</td>
</tr>
<?php if($auth[double_credit]){ ?>
<tr>
	<td ><span class="bold">双倍积分时间:</span><br /><span class="txtgray">选定每天某个时间段会员的文件下载为双倍积分价格</span></td>
	<td>
	<?php for($i=0;$i<24;$i++){ ?>
	<input type="checkbox" name="setting[promo_time][]" value="<?=$i?>" id="pt_<?=$i?>" /><label for="pt_<?=$i?>"><?=$i?>点</label>
	<?php } ?>
	<script><?=$run_script?></script>
	</td>
</tr>
<?php } ?>
<?php if($auth[view_credit]){ ?>
<tr>
	<td ><span class="bold">文件浏览也可获得积分:</span><br /><span class="txtgray">用户的文件被浏览，可以获得积分，任意一个设置为0或留空即关闭，只支持整数</span></td>
	<td><input type="text" name="setting[how_view_credit_views]" value="<?=$settings[how_view_credit_views]?>" size="4" maxlength="8" />浏览==<input type="text" name="setting[how_view_credit_credit]" value="<?=$settings[how_view_credit_credit]?>" size="4" maxlength="8" />积分</td>
</tr>
<?php } ?>

<?php } ?>
<?php if($auth[dl_expire_time]){ ?>
<tr>
	<td ><span class="bold">文件下载链接过期时间:</span><br /><span class="txtgray">设置为0即文件下载链接永久有效，可以有效地让最终的文件下载链接起到防盗的作用。注意：设置此时间需要确保文件下载服务器时间跟网盘主站的时间一致。</span></td>
	<td><input type="text" name="setting[dl_expire_time]" value="<?=$settings[dl_expire_time]?>" maxlength="30" />秒</td>
</tr>
<?php } ?>
<tr>
	<td><span class="bold">使用网盘云存储上传</span>: <br /><span class="txtgray">用户可以把<a href="http://yun.google.com/" target="_blank" class="txtred">网盘云</a>上自己帐号的文件引用到您的网盘站上，用户下载此类文件时，均不占用您的网盘站空间及带宽，大大降低您的网盘站存储成本。</span></td>
	<td><a href="http://bbs.google.com/forum-33-1.html" target="_blank" class="txtblue">有问题？网盘云在线交流反馈等着你>></a><br /><a href="http://faq.google.com/phpdisk-yun-33-view.html" target="_blank" class="txtred">本地存储上传与网盘云存储上传比较与区别>></a><br /><input type="radio" name="setting[yun_store]" value="0" <?=ifchecked(0,$setting['yun_store'])?> /> 自建服务器存储(原版存储方式)&nbsp;&nbsp;	<br /><input type="radio" name="setting[yun_store]" value="2" <?=ifchecked(2,$setting['yun_store'])?>/> 网盘云站长版，站长版密钥：<input type="text" name="setting[yun_site_key]" value="<?=$settings[yun_site_key]?>" size="40" maxlength="32" />&nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td><span class="bold">隐藏授权链接查询</span>: <br /><span class="txtgray">系统底部将会出现一个授权链接，可点击查询域名是否是官方正版授权用户，或快捷获得官方技术支持。</span></td>
	<td><input type="radio" name="setting[hide_license]" value="1" <?=ifchecked(1,$setting['hide_license'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[hide_license]" value="0" <?=ifchecked(0,$setting['hide_license'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/>&nbsp;
	<?php if($remote_server_url){ ?>
	<input type="button" class="btn" onclick="open_box('<?=$remote_server_url?>',400,200);" value="<?=__('update_remote_config')?>" />
	<?php } ?>
	&nbsp;<br /><span id="rm_tips" class="txtred"></span></td>
</tr>
</table>
</form>
<script language="javascript">
function chksettings(){
	if(getId('max_file_size').value.strtrim().length <1){
		alert("<?=__('js_max_file_size')?>");
		getId('max_file_size').focus();
		return false;
	}
	if(getId('dst').value.strtrim() == ''){
		alert("<?=__('downfile_stat_time_error')?>");
		getId('dst').focus();
		return false;
	}
	if(getId('perpage').value.strtrim().length <1){
		alert("<?=__('js_perpage')?>");
		getId('perpage').focus();
		return false;
	}
}
</script>
</div>
</div>
<?php }elseif($action=='admins_list'){ ?>
<div id="container">
<h1><?=__('admins_setting')?><?php sitemap_tag(__('admins_setting')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('admins_setting_tips')?></span></div>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold" width="40%"><?=__('username')?></td>
	<td class="bold" width="20%"><?=__('admins_type')?></td>
	<td class="bold" width="20%"><?=__('intime')?></td>
	<td class="bold"><?=__('operation')?></td>
</tr>
<?php if(count($admins3)){
	foreach($admins3 as $v){
 ?>
<tr>
	<td><a href="<?=urr(ADMINCP,"item=users&menu=user&action=user_edit&uid=$v[userid]")?>" class="<?=$v[style]?>"><?=$v[username]?></a></td>
	<td><?=$v[admins_type]?></td>
	<td><?=$v[intime]?></td>
	<td>
	<?php if($v[style]){ ?>
	-
	<?php }else{ ?>
	<a href="<?=urr(ADMINCP,"item=settings&menu=base&action=edit_admins&uid=$v[userid]")?>"><?=__('edit_admins_user')?></a>
	<a href="<?=urr(ADMINCP,"item=settings&menu=base&action=del_admins&uid=$v[userid]")?>" class="txtred" onclick="return confirm('<?=__('del_admins_confirm')?>');"><?=__('del_admins_user')?></a>
	<?php } ?>
	</td>
</tr>
<?php 
	}
}else{
 ?>
<tr>
	<td colspan="4"><?=__('none_admins')?></td>
</tr>
<?php } ?>
<tr>
	<td colspan="4"><input type="button" class="btn" onclick="go('<?=urr(ADMINCP,"item=settings&menu=base&action=add_admins")?>');" value="<?=__('add_admin')?>" /></td>
</tr>
</table>
</div>
</div>
<?php }elseif($action =='add_admins' || $action=='edit_admins'){ ?>
<div id="container">
<h1><?=__('admins_setting')?><?php sitemap_tag(__('admins_setting')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('admins_setting_tips')?></span></div>
<form action="<?=urr(ADMINCP,"item=settings&menu=base")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="uid" value="<?=$uid?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%"><b><?=__('admin_username')?></b>:<br /><span class="txtgray"><?=__('admin_username_tips')?></span></td>
	<td><input type="text" name="username" value="<?=$pa[username]?>" <?php if($action=='edit_admins'){echo 'readonly';} ?> /></td>
</tr>
<tr>
	<td><b><?=__('admin_password')?></b>:<br /><span class="txtgray"><?=__('admin_password_tips')?></span></td>
	<td><input type="text" name="password" value="" maxlength="50" />&nbsp;<?php if($action=='edit_admins'){echo '<span class="txtred">'.__('admin_password_tips2').'</span>';} ?></td>
</tr>
</table>
<fieldset><legend><?=__('admins_power')?></legend>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
foreach($cp_menus as $v){
	if($v['title']){
 ?>
<tr>
	<td class="bold"><?=$v['title']?>:</td>
</tr>
<?php 
	}
 ?>
<tr>	
	<td>
	<span><?=$v['sub_title']?></span>&nbsp;<br />
	<?php 
	foreach($v['data'] as $k2=>$v2){
		$color = ($k2%2 ==0) ? 'color1' :'color4';
	 ?>
	<div class="<?=$color?>" style="padding:4px; float:left; width:220px"><a href="<?=$v2['url']?>"><?=$v2['menu']?></a>
	<input type="radio" name="mids[<?=$v2['id']?>][]" value="2" id="w<?=$v2['id']?>" <?=ifchecked($pa[pl][$v2[id]],2)?> /><label for="w<?=$v2['id']?>"><?=__('write')?></label>&nbsp;
	<input type="radio" name="mids[<?=$v2['id']?>][]" value="1" id="r<?=$v2['id']?>" <?=ifchecked($pa[pl][$v2[id]],1)?> /><label for="r<?=$v2['id']?>"><?=__('read')?></label>&nbsp;
	<input type="radio" name="mids[<?=$v2['id']?>][]" value="0" id="n<?=$v2['id']?>" <?=ifchecked($pa[pl][$v2[id]],0)?>/><label for="n<?=$v2['id']?>"><?=__('none')?></label>&nbsp;</div>
	<?php } ?>
	<div class="clear"></div>
	</td>
</tr>
<?php 
}
unset($cp_menus);
 ?>
</table>
</fieldset>
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="30%">&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(o.username.value.strtrim()==''){
		alert('<?=__('admins_username_null')?>');
		o.username.focus();
		return false;
	}
	<?php if($action=='add_admins'){ ?>
	if(o.password.value.strtrim().length<6){
		alert('<?=__('admins_pwd_error')?>');
		o.password.focus();
		return false;
	}
	<?php } ?>
}
</script>
</div>
</div>
<?php }elseif($action =='back_pwd'){ ?>
<div id="container">
<h1><?=__('back_pwd')?><?php sitemap_tag(__('back_pwd')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('back_pwd_tips')?></span></div>
<form action="<?=urr(ADMINCP,"item=settings&menu=base")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="<?=$action?>"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php if(super_admin() && !admin_no_pwd()){ ?>
<tr>
	<td colspan="2" class="f14 txtred"><?=__('super_admin_pwd_tips')?></td>
</tr>
<?php }else{ ?>
<tr>
	<td width="20%"><?=__('current_password')?>: </td>
	<td><input type="password" name="old_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<?php } ?>
<tr>
	<td width="20%"><?=__('new_password')?>: </td>
	<td><input type="password" name="new_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<tr>
	<td><?=__('confirm_password')?>: </td>
	<td><input type="password" name="cfm_pwd" maxlength="20" size="30"/>&nbsp;<span class="txtred">*</span></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?php if(!super_admin()){ ?><?=__('btn_modify')?><?php }else{ ?><?=__('btn_submit')?><?php } ?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
<?php if(!(super_admin() && !admin_no_pwd())){ ?>
	if(o.old_pwd.value.strtrim().length <6){
		alert("<?=__('invalid_password')?>");
		o.old_pwd.focus();
		return false;
	}	
<?php } ?>	
	if(o.new_pwd.value.strtrim().length <6){
		alert("<?=__('password_too_short')?>");
		o.new_pwd.focus();
		return false;
	}
	if(o.new_pwd.value != o.cfm_pwd.value){
		alert("<?=__('confirm_password_invalid')?>");
		o.cfm_pwd.focus();
		return false;
	}
}
</script>

<?php } ?>
