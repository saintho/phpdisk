<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: dl.php 33 2013-08-10 05:40:30Z along $
#
#	Copyright (C) 2008-2012 PHPDisk Team. All Rights Reserved.
#
*/

if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('OS_WIN',true);
	define('LF',"\r\n");
}else{
	define('OS_WIN',false);
	define('LF',"\n");
}
$timestamp = time();
define('PHPDISK_ROOT', dirname(__FILE__).'/');
require_once(PHPDISK_ROOT.'system/settings.inc.php');
define('SERVER_KEY',$settings[encrypt_key]);
define('FILE_PATH',$settings[file_path]);
define('IN_PHPDISK',TRUE);

@set_time_limit(0);
@ignore_user_abort(true);
@set_magic_quotes_runtime(0);

function check_ref(){
	global $settings;
	$arr = explode('/',$_SERVER['HTTP_REFERER']);
	$arr2 = explode('/',$settings[phpdisk_url]);
	if($_SERVER['HTTP_HOST']!='localhost'){
		if(!$_SERVER['HTTP_REFERER'] || $arr[2]!=$arr2[2]){
			header('Location: '.$settings[phpdisk_url]);
			exit;
		}
	}
}
//check_ref();

function pd_decode($txt, $key = 'wpwo09oq'){
	$key = SERVER_KEY ? SERVER_KEY : $key;
	$txt = encrypt_key(base64_decode($txt), $key);
	$tmp = '';
	for ($i = 0; $i < strlen($txt); $i++) {
		$tmp .= $txt[$i] ^ $txt[++$i];
	}
	return $tmp;
}
function encrypt_key($txt, $key) {
	$md5_key = md5($key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($md5_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $md5_key[$ctr++];
	}
	return $tmp;
}
function filter_name($str){
	return str_ireplace(array(' ','&amp;','・'),'_',$str);
}
function get_real_ext($file_extension){
	if($file_extension){
		$exts = explode(',','asp,asa,aspx,ascx,dtd,xsd,xsl,xslt,as,wml,java,vtm,vtml,jst,asr,php,php3,php4,php5,vb,vbs,jsf,jsp,pl,cgi,js,html,htm,xhtml,xml,css,shtm,cfm,cfml,shtml,bat,sh');
		if(in_array($file_extension,$exts)){
			$file_ext = '.txt';
		}
	}else{
		$file_ext = '.txt';
	}
	return $file_ext;
}
function get_extension($name){
	return strtolower(trim(strrchr($name, '.'), '.'));
}

$str = $_SERVER['QUERY_STRING'];

parse_str(pd_decode($str));
if($expire_time && $expire_time<$timestamp){
	header("Content-Type: text/html; charset=utf-8");
	$src_url = $settings[phpdisk_url]."viewfile.php?file_id=$file_id";
	echo '<p>请登录原地址重新获取： <a href="'.$src_url.'" target="_blank">'.$src_url.'<a></p>';
	echo '<p style="color:#ff0000">温馨提示：此文件链接已失效，请勿非法盗链。</p>';
	exit;
}
$pp = $pp.get_real_ext(get_extension($pp));
if(!file_exists(PHPDISK_ROOT.FILE_PATH.'/'.$pp)){
	header("Content-Type: text/html; charset=utf-8");
	echo '<p style="padding:10px; font-size:12px;">文件ID： '.$file_id.'<br>';
	echo '['.$file_name.'] 文件不存在，请联系网站管理员处理。<br><br>';
	echo '联系方式：'.$settings[contact_us].'</p>';
}else{
	$file_name = filter_name(str_replace("+", "%20",$file_name));

	ob_end_clean();
	$ua = $_SERVER["HTTP_USER_AGENT"];
	if(preg_match("/MSIE/i", $ua)){
		header('Content-disposition: attachment;filename="'.iconv('utf-8','gbk',$file_name).'"');
	}else{
		header('Content-disposition: attachment;filename="'.$file_name.'"');
	}
	header('Content-type: application/octet-stream');
	if($settings[open_xsendfile]==2){
		header('X-Accel-Redirect: /'.FILE_PATH.'/'.$pp);
	}elseif($settings[open_xsendfile]==1){
		header('X-sendfile: ./'.FILE_PATH.'/'.$pp);
	}else{
		header('Content-Encoding: none');
		header('Content-Transfer-Encoding: binary');
		header('Content-length: '.$fs);
		@readfile('./'.FILE_PATH.'/'.$pp);
	}
}

exit;
?>