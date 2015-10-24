<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-01 10:13:01

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: verycode.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('verycode_title')?><?php sitemap_tag(__('verycode_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('verycode_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=$item&menu=user")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_verycode')?></span>: <br /><span class="txtgray"><?=__('open_verycode_tips')?></span></td>
	<td><input type="radio" name="setting[open_verycode]" value="1" <?=ifchecked(1,$setting['open_verycode'])?>/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_verycode]" value="0" <?=ifchecked(0,$setting['open_verycode'])?>/><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('op_verycode')?></span>: <br /><span class="txtgray"><?=__('verycode_tips')?></span></td>
	<td><input type="checkbox" name="setting[register_verycode]" id="reg" value="1" <?=ifchecked(1,$setting['register_verycode'])?> /><label for="reg"><?=__('register_verycode')?></label>&nbsp;
	<input type="checkbox" name="setting[login_verycode]" id="login" value="1" <?=ifchecked(1,$setting['login_verycode'])?>/><label for="login"><?=__('login_verycode')?></label>&nbsp;
	<input type="checkbox" name="setting[forget_verycode]" id="forget" value="1" <?=ifchecked(1,$setting['forget_verycode'])?>/><label for="forget"><?=__('forget_verycode')?></label>&nbsp;
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('verycode_type')?></span>: <br /><span class="txtgray"><?=__('verycode_type_tips')?></span></td>
	<td>
	<?php for($i=1;$i<=2;$i++){ ?>
	<input type="radio" name="setting[verycode_type]" id="vt_<?=$i?>" value="<?=$i?>" <?=ifchecked($i,$settings['verycode_type'])?> /><img src="includes/imgcode.inc.php?verycode_type=<?=$i?>&nosess=1&t=<?=$timestamp?>" align="absbottom" style="cursor:pointer"/>&nbsp;&nbsp;
	<?php } ?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<br /><br />
<form action="<?=urr(ADMINCP,"item=$item&menu=user")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="down_code"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 bold"><?=__('download_file_code')?> :</td>
</tr>
<tr>
	<td width="40%" rowspan="4"><span class="bold"><?=__('down_auth_code')?></span>:<br /><span class="txtgray"><?=__('down_auth_code_tips')?></span></td>
	<td><input type="radio" name="setting[down_auth_code]" value="0" <?=ifchecked(0,$settings['down_auth_code'])?>/><?=__('close')?>
	</td>
</tr>
<tr>
	<td>
	<img style="cursor:pointer" id="imgcode" alt="<?=__('refresh')?>" border="0" onclick="chg_imgcode();"/><br />
	<input type="radio" name="setting[down_auth_code]" value="2" <?=ifchecked(2,$settings['down_auth_code'])?>/><?=__('system_auth_code')?>
	</td>
</tr>
<tr>
	<td>
	   <script type='text/javascript' charset='gbk'>
		var YXM_PUBLIC_KEY = '<?=$settings[yxm_public_key]?>';
		var YXM_localsec_url = 'http://127.0.0.1/YinXiangMa_PHP_SDK_Demo/localsec/';
		function YXM_local_check()
		{
		if(typeof(YinXiangMaDataString)!='undefined')return;
		YXM_oldtag = document.getElementById('YXM_script');
		var YXM_local=document.createElement('script');
		YXM_local.setAttribute("type","text/javascript");
		YXM_local.setAttribute("id","YXM_script");
		YXM_local.setAttribute("src",YXM_localsec_url+'yinxiangma.js?pk='+YXM_PUBLIC_KEY+'&m=live&v=YinXiangMa_PHPSDK_3.0');
		YXM_oldtag.parentNode.replaceChild(YXM_local,YXM_oldtag);  
		}
		setTimeout("YXM_local_check()",2000);
		document.write("<input type='hidden' id='YXM_here' /><script type='text/javascript' charset='gbk' id='YXM_script' async src='http://api.yinxiangma.com/api2/yzm.yinxiangma.php?pk="+YXM_PUBLIC_KEY+"&m=live&v=YinXiangMaPHPSDK_3.0'><"+"/script>");
		</script> 
<br />
	印象码 PRIVATE_KEY :&nbsp;&nbsp;<input type="text" name="setting[yxm_private_key]" size="50" value="<?=$settings[yxm_private_key]?>" /><br />
	印象码 PUBLIC_KEY :&nbsp;&nbsp;<input type="text" name="setting[yxm_public_key]" size="50" value="<?=$settings[yxm_public_key]?>" /><br />
	<input type="radio" name="setting[down_auth_code]" value="3" <?=ifchecked(3,$settings['down_auth_code'])?>/>印象码&nbsp;&nbsp;<a href="http://www.yinxiangma.com/server/register.php?refer=m7an0c" target="_blank">[免费注册链接]</a>&nbsp;&nbsp;<a href="http://bbs.google.com/thread-4999-1-1.html" target="_blank">[配置教程]</a>
	<br /><br />
	</td>
</tr>
<tr>
	<td>
	<div><script type="text/javascript" src="yucmedia/Action/load.php"></script>
	<input name="<?=$settings[yuc_ads_id]?>" style="display:inline" type="text" id="<?=$settings[yuc_ads_id]?>" /></div>
	宇初输入框ID :&nbsp;&nbsp;<input type="text" name="setting[yuc_ads_id]" size="50" value="<?=$settings[yuc_ads_id]?>" /><br />
	<input type="radio" name="setting[down_auth_code]" value="1" <?=ifchecked(1,$settings['down_auth_code'])?>/><?=__('yuccode')?>&nbsp;&nbsp;<a href="http://site.yucmedia.com/?from=phpdisk" target="_blank">[免费注册链接]</a>&nbsp;&nbsp;<a href="http://bbs.google.com/thread-4999-1-1.html" target="_blank">[配置教程]</a>
	<br /><br />
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('download_file_downs')?></span>:<br /><span class="txtgray"><?=__('download_file_downs_tips')?></span></td>
	<td><input type="text" name="setting[file_downs]" size="5" maxlength="10" value="<?=$settings[file_downs]?>" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
  <script type="text/javascript">
  getId('imgcode').src = 'imagecode.php';
  function chg_imgcode(){
  	getId('imgcode').src = 'imagecode.php?t='+Math.random();
  }
</script>
</div>
</div>
