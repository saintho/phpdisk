<?php  !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied'); 
function check_auth_domain($post_action,$renew=0){ 
/*if($renew){ @unlink(PHPDISK_ROOT.'system/global/cache_settings.inc.php'); }
$system_dir = PHPDISK_ROOT.'system/';
$chk_system_dir = dir_writeable($system_dir) ? 1 : 0;
$script = '';
if(!$chk_system_dir){ 
$script = 'document.getElementById("sys_dir").style.display="";document.getElementById("s1").disabled=true;'; } 
$post_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$f = PHPDISK_ROOT.'system/global/cache_settings.inc.php';
$auth_endtime = false;
if(!file_exists($f) || $renew){ exit(auth_msg($auth_endtime,$renew,$post_action,$post_url,$script)); }
else{ 
$s = pd_encodex(str_replace(array('<?php exit;?>',"\r","\n"),'',file_get_contents($f)),'DECODE');
$arr_t = explode('@@',$s); 
if($arr_t[1] && time()>$arr_t[1]){ $auth_endtime = true; exit(auth_msg($auth_endtime,$renew,$post_action,$post_url,$script)); }
else{ 
$arr = explode('|',$arr_t[0]);
$flag = 0; 
$port = $_SERVER['SERVER_PORT']=='80' ? '' : ':'.$_SERVER['SERVER_PORT'];
$host = $port ? substr($_SERVER['HTTP_HOST'],0,'-'.strlen($port)) : $_SERVER['HTTP_HOST']; for ($i=0;$i<count($arr);$i++){ 
if($arr[$i] && strcasecmp(substr(strrev($host),0,strlen($arr[$i])),strrev($arr[$i]))==0){ $flag++; }
} 
!$flag && exit(auth_msg($auth_endtime,$renew,$post_action,$post_url,$script)); } } */} function check_auth_tpl($post_action,$tpl_name,$renew=0){ global $db,$tpf,$settings; $db->query_unbuffered("update {$tpf}templates set hash='' where tpl_name='$tpl_name' limit 1"); $auth_endtime = false; $port = $_SERVER['SERVER_PORT']=='80' ? '' : ':'.$_SERVER['SERVER_PORT']; $post_url = $settings[phpdisk_url]; exit(auth_msg($auth_endtime,$renew,$post_action,$post_url,'','tpl','dotpl')); } function auth_msg($auth_endtime,$renew,$post_action,$post_url,$script,$auth_type='domain',$go_action='doauth'){ global $charset,$tpl_name; $auth_type_arr = array('domain'=>'域名','tpl'=>'模板'); $msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'" />

'; if($auth_endtime){ $msg .='<title>您的'.$auth_type_arr[$auth_type].'授权使用期限已过，请续费开通</title>'.LF; }else{ if($renew){ $msg .='<title>更新'.$auth_type_arr[$auth_type].'授权</title>'.LF; }else{ $msg .='<title>您的'.$auth_type_arr[$auth_type].'未授权</title>'.LF; } } $msg .='<meta name="Copyright" content="Powered by PHPDisk Team, '.PHPDISK_VERSION .' '. PHPDISK_EDITION.'" />

<meta name="generator" content="PHPDisk Team" />

<style type="text/css">

body {

	margin: 20px;

	line-height: 140%;

	color: #000000;

	font: 14px "Georgia", "Verdana";

	background-color: #9eb6d8;

	text-align: center;

}

a {

	color: #333399; 

	text-decoration: none;

}

a:hover {

	color: #CC0000; 

}

.bold{font-weight:bold}

#main {

	background-color: #fff;

	text-align: left;

	padding: 20px;

	width: 850px;

	border: 1px solid #698cc3;

	margin: 20px auto;

}

.title {

	font-size: 18px;

	font-weight: bold;

}

form {

	margin: 0px;

	padding: 0px;

}

.input{width:200px;}

.formbutton {

	font: 14px "Georgia", "Verdana";

	font-weight: bold;

	padding: 3px;

}

.txtblue{ color:#0000FF}

.txtgreen{color:#008800}

.txtred{color:#FF0000}

</style>

</head>



<body>

<div id="main">

  

  <form method="post" name="myform" action="'.$post_action.'" onsubmit="return dosubmit(this);">

  <input type="hidden" name="action" value="'.$go_action.'" />

  <input type="hidden" name="renew" value="'.$renew.'" />'; if($tpl_name){ $msg .=' <input type="hidden" name="tpl_name" value="'.$tpl_name.'" />'; $set_default_tpl = '&nbsp;&nbsp;【<a href="'.$settings[phpdisk_url].'?action=set_default_tpl" onclick="return confirm(\'恢复默认模板,确认操作？\');" class="txtblue">恢复默认模板</a>】'; } $msg .=' <input type="hidden" name="posturl" value="'.$post_url.'" />'; if($auth_endtime){ $msg .='<p class="title">亲爱的PHPDisk站长用户，您的<u>'.$auth_type_arr[$auth_type].'</u>授权使用已过期 </p>

	<hr noshade="noshade" />

	<p>1) 抱歉，您的'.$auth_type_arr[$auth_type].'授权使用已过期，请续费开通，否则将无法正常安装/使用此系统。</p>

	<p>2) 可能原因：您当前使用的系统未授权或为盗版产品。</p>

	<p>3) 请从【PHPDisk网盘系统】官方网站(<a href="http://www.google.com" target="_blank" title="访问PHPDisk网盘系统官方网站">http://www.google.com</a>)购买正版授权系统，享受正版授权服务。</p>

	<p>4) 如果您已经是授权用户，可以在下面的快捷授权框填写信息进行授权检测，检测通过即可激活系统。</p>'; }else{ if($renew){ $msg .='<p class="title">亲爱的PHPDisk站长用户，请更新<u>'.$auth_type_arr[$auth_type].'</u>授权</p>

    <hr noshade="noshade" />

    <p></p>'; }else{ $msg .='<p class="title">亲爱的PHPDisk站长用户，您的<u>'.$auth_type_arr[$auth_type].'</u>未授权'.$set_default_tpl.'</p>

    <hr noshade="noshade" />

	<p>1) 抱歉，您的'.$auth_type_arr[$auth_type].'未授权，无法正常安装/使用此系统。</p>

	<p>2) 可能原因：您当前使用的系统未授权或为盗版产品。</p>

	<p>3) 请从【PHPDisk网盘系统】官方网站(<a href="http://www.google.com" target="_blank" title="访问PHPDisk网盘系统官方网站">http://www.google.com</a>)购买正版授权系统，享受正版授权服务。</p>

	<p>4) 如果您已经是授权用户，可以在下面的快捷授权框填写信息进行授权检测，检测通过即可激活系统。</p>'; } } $msg .='<p></p>

	<div style="border:#efefef 4px solid; padding:20px 10px; margin:20px 0">

<table width="100%" align="center" cellpadding="8" cellspacing="0" border="0">

<tbody id="sys_dir" style="display:none">

<tr>

	<td colspan="2" class="txtred">警告：网盘目录 system/ 权限不足，此目录以及其下所有文件和子目录，需要拥有修改写入权限\Linux系统需要 0777 权限。</td>

</tr>

</tbody>

<tr>

	<td width="35%" align="right">授权邮箱：</td>

	<td><input type="text" name="email" value="" class="input" /><br><span class="txtred">接收授权邮件及授权信息的邮箱，官方网站的登录帐号。</span></td>

</tr>

<tr>

	<td align="right">授 权 码：</td>

	<td><input type="password" name="auth_code" value="" class="input" /><br><span class="txtred">请勿将授权邮箱及授权码透露给别人，防止授权被盗！</span></td>

</tr>

<tr>

	<td>&nbsp;</td>'; if($auth_endtime){ $msg .= '<td><input class="formbutton" id="s1" type="submit" value="续费'.$auth_type_arr[$auth_type].'授权" /></td>'; }else{ if($renew){ $msg .= '<td><input class="formbutton" id="s1" type="submit" value="更新'.$auth_type_arr[$auth_type].'授权" /></td>'; }else{ $msg .= '<td><input class="formbutton" id="s1" type="submit" value="获取授权并激活" /></td>'; } } $msg .= '</tr>

</table>

</div>

<p class="f14" style="sty"><span class="f14">友情提示：</span><br />

<span class="txtred" style="line-height: 180%;height:180%">请从官方网站(<a href="http://www.google.com" target="_blank" title="访问PHPDisk网盘系统官方网站">http://www.google.com</a>)购买正版授权系统，请勿相信，购买其他网站或个人提供所谓授权、破解版本，不法分子可能会改动源码，添加程序后门、木马等，防止上当受骗。</span></p>

  </form>

  <hr noshade="noshade" />

  <div align="center" class="bold" style="padding:15px 0;">Powered by <a href="http://www.google.com/" target="_blank">PHPDisk Team</a> '.PHPDISK_VERSION .' '. PHPDISK_EDITION.' (C) 2008-'.NOW_YEAR.' All Rights Reserved.</div>

</div>

<script type="text/javascript">

'.$script.'

function dosubmit(o){

	var s1 = document.getElementById("s1");

	if(o.email.value=="" || o.email.value.indexOf("@")==-1){

		o.email.focus();

		alert("请填写购买时的授权邮箱。");

		return false;

	}

	if(o.auth_code.value==""){

		o.auth_code.focus();

		alert("请填写您的授权码。");

		return false;

	}

	s1.disabled=true;

	s1.value="检测中...";

}

</script>

</body>

</html>

'; return $msg; } function get_auth_time(){ $f = PHPDISK_ROOT.'system/global/cache_settings.inc.php'; $s = pd_encodex(str_replace(array('<?php exit;?>',"\r","\n"),'',file_get_contents($f)),'DECODE'); $arr_t = explode('@@',$s); if($arr_t[1]){ return date('Y-m-d',$arr_t[1]); }else{ return '永久不限'; } } function pd_encodex($txt, $operation = 'ENCODE',$key = '&*PHPD=Rt'){ if($operation == 'DECODE'){ $txt = encrypt_key(base64_decode($txt), $key); $tmp = ''; for ($i = 0; $i < strlen($txt); $i++) { $tmp .= $txt[$i] ^ $txt[++$i]; } return $tmp; }else{ srand((double)microtime() * 1000000); $encrypt_key = md5(rand(0, 32000)); $ctr = 0; $tmp = ''; for($i = 0; $i < strlen($txt); $i++) { $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr; $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]); } return base64_encode(encrypt_key($tmp, $key)); } } if(!function_exists('encrypt_key')){ function encrypt_key($txt, $key) { $md5_key = md5($key); $ctr = 0; $tmp = ''; for($i = 0; $i < strlen($txt); $i++) { $ctr = $ctr == strlen($md5_key) ? 0 : $ctr; $tmp .= $txt[$i] ^ $md5_key[$ctr++]; } return $tmp; } } function get_template_info($tpl_name){ global $db,$tpf; $file = PHPDISK_ROOT."templates/$tpl_name/template_info.php"; if(file_exists($file)){ $_data = read_file($file); preg_match("/Template Name:(.*)/i",$_data,$tpl_title); preg_match("/Template URL:(.*)/i",$_data,$tpl_url); preg_match("/Description:(.*)/i",$_data,$tpl_desc); preg_match("/Author:(.*)/i",$_data,$tpl_author); preg_match("/Author Site:(.*)/i",$_data,$tpl_site); preg_match("/Version:(.*)/i",$_data,$tpl_version); preg_match("/Template Type:(.*)/i",$_data,$tpl_type); preg_match("/PHPDISK Core:(.*)/i",$_data,$phpdisk_core); preg_match("/Template Core:(.*)/i",$_data,$template_core); } $actived = (int)@$db->result_first("select actived from {$tpf}templates where tpl_name='$tpl_name' limit 1"); $arr = array( 'tpl_title' => trim($tpl_title[1]), 'tpl_url' => trim($tpl_url[1]), 'tpl_desc' => htmlspecialchars(trim($tpl_desc[1])), 'tpl_author' => trim($tpl_author[1]), 'tpl_site' => trim($tpl_site[1]), 'tpl_version' => trim($tpl_version[1]), 'tpl_type' => trim(strtolower($tpl_type[1])), 'tpl_dir' => trim($tpl_name), 'phpdisk_core' => trim($phpdisk_core[1]), 'template_core' => trim($template_core[1]), 'actived' => $actived, ); if(file_exists(PHPDISK_ROOT.'templates/'.$tpl_name.'/core.tpl.php')){ $hash = @$db->result_first("select hash from {$tpf}templates where tpl_name='$tpl_name' limit 1"); if($hash){ $s = pd_encodex(str_replace(array("\r","\n"),'',$hash),'DECODE'); $arr_t = explode('@@',$s); if($arr_t[1] && time()>$arr_t[1]){ $arr[authed_tpl]=1; }else{ $arrb = explode('|',$arr_t[0]); $flag = 0; for ($i=0;$i<count($arrb);$i++){ if($arrb[$i] && strcasecmp(substr(strrev($_SERVER['HTTP_HOST']),0,strlen($arrb[$i])),strrev($arrb[$i]))==0){ $flag++; } } $arr[authed_tpl] = $flag ? 2 : 1; } }else{ $arr[authed_tpl] = 1; } }else{ $arr[authed_tpl] = 0; } return $arr; } ?>