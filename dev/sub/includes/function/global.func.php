<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: global.func.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

function template_echo($tpl,$tpl_dir,$app='',$is_admin_tpl=0){
	if($app){
		$tpl_cache_dir = PHPDISK_ROOT."system/plugins/$app/";
		$tpl_src_dir = PHPDISK_ROOT."plugins/$app/";
	}else{
		$tpl_cache_dir = $tpl_cache_dir_tmp = PHPDISK_ROOT.'system/'.$tpl_dir;
		$tpl_src_dir = PHPDISK_ROOT.$tpl_dir;
		$tpl_default_dir = PHPDISK_ROOT.'templates/default/';
		$admin_tpl_dir = PHPDISK_ROOT.'templates/admin/';
	}
	if(strpos($tpl,'/')!==false){
		$tpl_cache_dir_tmp = $tpl_cache_dir_tmp.substr($tpl,0,strlen($tpl)-strlen(strrchr($tpl,'/'))).'/';
	}
	make_dir($tpl_cache_dir_tmp);
	make_dir($tpl_cache_dir);

	$tpl_cache_file = $tpl_cache_dir.$tpl.'.tpl.php';
	$tpl_src_file = $tpl_src_dir.$tpl.'.tpl.php';
	if(!$app){
		if($is_admin_tpl && !file_exists($tpl_src_file)){
			$tpl_src_file = $admin_tpl_dir.$tpl.'.tpl.php';
		}elseif(!file_exists($tpl_src_file)){
			$tpl_src_file = $tpl_default_dir.$tpl.'.tpl.php';
		}
	}
	if(@filemtime($tpl_cache_file) < @filemtime($tpl_src_file)){
		write_file($tpl_cache_file,template_parse($tpl_src_file));
		return $tpl_cache_file;
	}
	if(file_exists($tpl_cache_file)){
		return $tpl_cache_file;
	}else{
		$str = strrchr($tpl_cache_file,'/');
		$str = substr($str,1,strlen($str));
		die("PHPDisk Template: <b>$tpl_dir$tpl_cache_file</b> not Exists!");
	}

}

function template_parse($tpl){
	global $user_tpl_dir;
	if(!file_exists($tpl)){
		exit('Template ['.$tpl.'] not exists!');
	}
	$str = read_file($tpl);
	$str = preg_replace("/\<\!\-\-\#include (.+?)\#\-\-\>/si","<?php require_once template_echo('\\1','$user_tpl_dir'); ?>", $str);
	$str = preg_replace("/\<\!\-\-\#(.+?)\#\-\-\>/si","<?php \\1 ?>", $str);
	$str = preg_replace("/\{([A-Z_]+)\}/","<?=\\1?>",$str);
	$str = preg_replace("/\{(\\\$[a-z0-9_\'\"\[\]]+)\}/si", "<?=\\1?>", $str);
	$str = preg_replace("/\{\<\?\=(\\\$[a-z0-9_\'\"\[\]]+)\?\>\}/si","{\\1}",$str);
	$str = preg_replace("/\{\#(.+?)\#\}/si","<?=\\1?>", $str);
	$str = preg_replace("/\{sql\[(.+)\]\[(.+)\]\}/si","<? foreach(get_sql(\"\\1\") as \\2){ ?>",$str);
	$str = str_replace("{/sql}","<? } ?>",$str);
	$str = str_replace('@@','{$tpf}',$str); // fix sql tag!

	$prefix = "<?php ".LF;
	$prefix .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF.LF;
	$prefix .= "// Cache Time:".date('Y-m-d H:i:s').LF.LF;
	$prefix .= "!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');".LF.LF;
	$prefix .= "?>".LF;

	return $prefix.$str;
}

function form_auth($p_formhash,$formhash){
	if($p_formhash != $formhash){
		exit(__('system_error'));
	}
}
function convert_str($in,$out,$str){
	global $db;
	if(function_exists("iconv")){
		$str = iconv($in,$out,$str);
	}elseif(function_exists("mb_convert_encoding")){
		$str = mb_convert_encoding($str,$out,$in);
	}
	return $db->escape($str);
}

function is_utf8(){
	global $charset;
	return (strtolower($charset) == 'utf-8') ? true : false;
}
function is_windows(){
	return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 1 : 0;
}

function word_style($i,$type ='font'){
	switch($i){
		case 500:
			$f_px = "25px";
			$c_col = '#ff6600';
			break;
		case 300:
			$f_px = "20px";
			$c_col = '#ff5500';
			break;
		case 100:
			$f_px = "18px";
			$c_col = '#003366';
			break;
		case 50:
			$f_px = "14px";
			$c_col = '#003366';
			break;
		default:
			$f_px = "12px";
			$c_col = '#666666';
	}
	return ($type =='font') ? $f_px : $c_col;
}
function page_end_time(){
	global $ps_time,$db,$C;
	return 'Processed in '.get_runtime('start','end').' second(s), '.$db->querycount.' queries, Gzip '.$C['gz']['status'];
}

function replace_inject_str($str){
	$bad_chars = array("\\","'",'"','/','*',',','<','>',"\r","\t","\n",'$','(',')','%','?',';','^','#',':','&');
	return str_replace($bad_chars,'',$str);
}

function checklength($str,$min,$max){
	if(!$str || strlen($str) > $max || strlen($str) < $min){
		return true;
	}
}
function ifselected($int1,$int2,$type = 'int'){
	if($type == 'int'){
		if(intval($int1) == intval($int2)){
			return ' selected';
		}
	}elseif($type == 'str'){
		if(strval($int1) == strval($int2)){
			return ' selected';
		}
	}
}
function ifchecked($int1,$int2,$type = 'int'){
	if($type == 'int'){
		if(intval($int1) == intval($int2)){
			return ' checked';
		}
	}elseif($type == 'str'){
		if(strval($int1) == strval($int2)){
			return ' checked';
		}
	}
}
function multi_selected($id,$str){
	if(strpos($str,',')){
		$a2 = explode(',',$str);
		$rtn = in_array($id,$a2) ? ' selected' : '';
	}else{
		$rtn = $id==$str ? ' selected' : '';
	}
	return $rtn;
}

function replace_js($str){
	return preg_replace("'<script[^>]*?>(.*?)</script>'si","[script]\\1[/script]",$str);
}
function custom_time($format, $time){
	global $timestamp;
	$s = $timestamp - $time;
	if($s < 0){
		return __('custom_time_0');
	}
	if($s < 60){
		return $s.__('custom_time_1');
	}
	$m = $s / 60;
	if($m < 60){
		return floor($m).__('custom_time_2');
	}
	$h = $m / 60;
	if($h < 24){
		return floor($h).__('custom_time_3');
	}
	$d = $h / 24;
	if($d < 2){
		return __('custom_time_4').date("H:i", $time);
	}
	if($d <3){
		return __('custom_time_5').date("H:i", $time);
	}
	if($d <= 30){
		return floor($d).__('custom_time_6');
	}
	return date($format, $time);
}
function get_byte_value($v){
	$v = trim($v);
	$l = strtolower($v[strlen($v) - 1]);
	switch($l){
		case 'g':
			$v *= 1024;

		case 'm':
			$v *= 1024;

		case 'k':
			$v *= 1024;
	}
	return $v;
}

function redirect($url,$str,$timeout = 2000,$target = ''){
	global $user_tpl_dir;

	if($timeout ==0){
		header("Location:$url");
		exit;
	}else{
		$msg = '';
		if(is_array($str)){
			for($i=0;$i<count($str);$i++){
				$msg .= "<li>·".$str[$i]."</li>".LF;
			}
		}else{
			$msg = $str;
		}
		$go_url = $url=='back' ? $url = 'javascript:history.back();' : $url;
		require_once template_echo('information',$user_tpl_dir);
		$rtn = "<script>".LF;
		$rtn .= "<!--".LF;
		$rtn .= "function redirect() {".LF;
		if($target =='top'){
			$rtn .= "	self.parent.location.href = '$url';".LF;
		}else{
			$rtn .= "	document.location.href = '$go_url';".LF;
		}
		$rtn .= "}".LF;
		$rtn .= "setTimeout('redirect();', $timeout);".LF;
		$rtn .= "-->".LF;
		$rtn .= "</script>".LF;
		echo $rtn;
	}
}
function tb_redirect($url,$str,$timeout=2000){
	if(is_array($str)){
		for($i=0;$i<count($str);$i++){
			$msg .= "<li>·".$str[$i]."</li>".LF;
		}
	}else{
		$msg = $str;
	}
	$go_url = $url=='back' ? $url='javascript:history.back();' : $url;
	$rtn .= '<div class="tb_box_msg" id="tb_box_msg"><img src="images/light.gif" border="0" align="absmiddle"><ul>'.$msg.'</ul></div>'.LF;
	$rtn .= "<script>".LF;
	$rtn .= "<!--".LF;
	$rtn .= "function redirect() {".LF;
	$rtn .= $url=='back' ? '' : '$("#tb_box_msg").myBox({timeout:2000});'.LF;
	if($url =='reload'){
		$rtn .= " top.document.location.reload();";
	}else{
		$rtn .= "	self.parent.document.location.href = '$go_url';".LF;
	}
	$rtn .= "}".LF;
	$rtn .= "setTimeout('redirect();', $timeout);".LF;
	$rtn .= "-->".LF;
	$rtn .= "</script>".LF;
	echo $rtn;
}
function is_bad_chars($str){
	$bad_chars = array("\\",' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'$','(',')','%','+','?',';','^','#',':','　','`','=','|','-','_','.');
	foreach($bad_chars as $value){
		if (strpos($str,$value) !== false){
			return true;
		}
	}
}
function get_extension($name){
	return strtolower(trim(strrchr($name, '.'), '.'));
}
function formhash(){
	global $pd_uid,$pd_pwd;
	return substr(md5(substr(time(), 0, -7).$pd_uid.$pd_pwd), 8, 8);
}
function encode_pwd($str){
	global $settings;
	$len = trim($str) ? strlen($str) : 6;
	if($settings['online_demo']){
		$rtn = str_repeat('*',$len);
	}else{
		if($len <=4){
			$rtn = str_repeat('*',$len);
		}elseif($len <=10){
			$rtn = str_repeat('*',$len-4);
			$rtn .= substr($str,-4);
		}else{
			$rtn = str_repeat('*',$len-6);
			$rtn .= substr($str,-6);
		}
	}
	return $rtn;
}
function random($length){
	$seed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	while(strlen($str) < $length){
		$str .= substr($seed,(mt_rand() % strlen($seed)),1);
	}
	return $str;
}

function addslashes_array(&$array) {
	if(is_array($array)){
		foreach($array as $k => $v) {
			$array[$k] = addslashes_array($v);
		}
	}elseif(is_string($array)){
		$array = addslashes($array);
	}
	return $array;
}

function get_size($s,$u='B',$p=2){
	$us = array('B'=>'K','K'=>'M','M'=>'G','G'=>'T');
	return (($u!=='B')&&(!isset($us[$u]))||($s<1024))?(number_format($s,$p)." $u"):(get_size($s/1024,$us[$u],$p));
}

function checkemail($email) {
	if((strlen($email) > 6) && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email)){
		return true;
	}else{
		return false;
	}
}

function defend_xss($val){
	return str_ireplace(array('<','>'),'',$val);
}

function gpc($name,$w = 'GPC',$default = '',$d_xss=1){
	$i = 0;
	for($i = 0; $i < strlen($w); $i++) {
		if($w[$i] == 'G' && isset($_GET[$name])) return $d_xss ? defend_xss($_GET[$name]) : $_GET[$name];
		if($w[$i] == 'P' && isset($_POST[$name])) return $d_xss ? defend_xss($_POST[$name]) : $_POST[$name];
		if($w[$i] == 'C' && isset($_COOKIE[$name])) return $d_xss ? defend_xss($_COOKIE[$name]) : $_COOKIE[$name];
	}
	return $default;
}
function get_ip(){
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	$onlineip = addslashes($onlineip);
	@preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
	$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	unset($onlineipmatches);
	return $onlineip;
}

function pd_setcookie($var, $value, $expires = 0,$cookiepath = '/') {
	global $timestamp,$settings;
	$cookie_domain = $settings['cookie_domain'] ? '.'.$settings['cookie_domain'] : '';
	setcookie($var, $value,$expires ? ($timestamp + $expires) : 0,$cookiepath,$cookie_domain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}


function pd_encode($txt, $operation = 'ENCODE',$key = 'PHPDisk=Rc9o'){
	global $settings;
	$key = $settings['encrypt_key'] ? $settings['encrypt_key'] : $key;
	if($operation == 'DECODE'){
		$txt = encrypt_key(base64_decode($txt), $key);
		$tmp = '';
		for ($i = 0; $i < strlen($txt); $i++) {
			$tmp .= $txt[$i] ^ $txt[++$i];
		}
		return $tmp;
	}else{
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++) {
			$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
			$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode(encrypt_key($tmp, $key));
	}
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

function cutstr($string, $length, $dot = '...',$charset='utf-8') {
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length - strlen($dot) - 1; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}

function multi($total, $perpage, $curpage, $mpurl) {
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if($total > $perpage) {
		$pg = 10;
		$offset = 5;
		$pgs = @ceil($total / $perpage);
		if($pg > $pgs) {
			$from = 1;
			$to = $pgs;
		} else {
			$from = $curpage - $offset;
			$to = $curpage + $pg - $offset - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$to = $pg;
				}
			} elseif($to > $pgs) {
				$from = $curpage - $pgs + $to;
				$to = $pgs;
				if(($to - $from) < $pg && ($to - $from) < $pgs) {
					$from = $pgs - $pg + 1;
				}
			}
		}

		$multipage = ($curpage - $offset > 1 && $pgs > $pg ? '<a href="'.$mpurl.'pg=1" class="p_redirect">&laquo;</a>' : '').($curpage > 1 ? '<a href="'.$mpurl.'pg='.($curpage - 1).'" class="p_redirect">&#8249;</a>' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<span class="p_curpage">'.$i.'</span>' : '<a href="'.$mpurl.'pg='.$i.'" class="p_num">'.$i.'</a>';
		}
		$multipage .= ($curpage < $pgs ? '<a href="'.$mpurl.'pg='.($curpage + 1).'" class="p_redirect">&#8250;</a>' : '').($to < $pgs ? '<a href="'.$mpurl.'pg='.$pgs.'" class="p_redirect">&raquo;</a>' : '');
		$multipage = $multipage ? '<div class="p_bar"><span class="p_info">Total:&nbsp;<b>'.$total.'</b>&nbsp;</span>'.$multipage.'</div>' : '';
	}
	return $multipage;
}
function is_today($time){
	return (date('Ymd') == date('Ymd',$time)) ? 1 : 0;
}
function get_ids_arr($arr,$msg,$str_in_db=0){
	global $db;
	$error = 0;
	if(!count($arr)){
		$error = 1;
		$strs = $msg;
	}else{
		for($i=0;$i<count($arr);$i++){
			$strs .= $str_in_db ? $db->escape($arr[$i])."," : "'".$db->escape($arr[$i])."',";
		}
		$strs = substr($strs,0,-1);
	}
	return array($error,$strs);
}

function syn_folder_size(){
	global $db,$tpf,$pd_uid;

	$q = $db->query("select * from {$tpf}folders where userid='$pd_uid'  order by folder_id asc");
	while($rs = $db->fetch_array($q)){
		if($rs['folder_id']){
			$total_size = @$db->result_first("select sum(file_size) from {$tpf}files where folder_id='{$rs['folder_id']}' and userid='$pd_uid'");
			$db->query_unbuffered("update {$tpf}folders set folder_size='$total_size' where folder_id='{$rs['folder_id']}' and  userid='$pd_uid'");
		}
	}
	$db->free($q);
	unset($rs);
}
function get_file_thumb($rs){
	global $db,$tpf,$settings;
	if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0) && $rs['server_oid'] >1){
		$rs2 = $db->fetch_one_array("select * from {$tpf}servers where server_oid='{$rs['server_oid']}' limit 1");
		if($rs2){
			if($rs['is_image']){
				$file_thumb = $rs2['server_host'].$rs2['server_store_path'].'/'.$rs['file_store_path'].$rs['file_real_name'].'_thumb.'.$rs['file_extension'];
			}
		}
		unset($rs2);
	}else{
		if($rs['is_image']){
			$file_thumb = $settings['file_path'].'/'.$username.$rs['file_store_path'].$rs['file_real_name'].'_thumb.'.$rs['file_extension'];

		}
	}
	return $file_thumb;
}
function short_date($str){
	return date($str);
}
function get_real_ext($file_extension){
	global $settings;
	if($file_extension){
		$exts = explode(',',$settings['filter_extension']);
		if(in_array($file_extension,$exts)){
			$file_ext = '.'.$file_extension.'.txt';
		}else{
			$file_ext = '.'.$file_extension;
		}
	}else{
		$file_ext = '.txt';
	}
	return $file_ext;
}
function get_file_name($file_name,$file_ext){
	$tmp_ext = $file_ext ? '.'.$file_ext: '';
	return $file_name.$tmp_ext;
}

function flashget_encode($t_url,$uid){
	$prefix = "Flashget://";
	$FlashgetURL = $prefix.base64_encode("[FLASHGET]".$t_url."[FLASHGET]")."&".$uid;
	return $FlashgetURL;
}

function thunder_encode($url){
	$thunderPrefix = "AA";
	$thunderPosix = "ZZ";
	$thunderTitle = "thunder://";
	$thunderUrl = $thunderTitle.base64_encode($thunderPrefix.$url.$thunderPosix);
	return $thunderUrl;
}
function file_icon($ext,$fd = 'filetype',$align='absmiddle'){
	$icon = PHPDISK_ROOT."images/{$fd}/".$ext.".gif";
	if(file_exists($icon)){
		$img = "<img src='images/{$fd}/{$ext}.gif' align='{$align}' border='0' />";
	}else{
		$img = "<img src='images/{$fd}/file.gif' align='{$align}' border='0' />";
	}
	return $img;
}
function mime_type( $ext ){
	$mime = array(
	'avi'  => 'video/x-msvideo',
	'bmp'  => 'image/bmp',
	'css'  => 'text/css',
	'js'   => 'application/x-javascript js',
	'doc'  => 'application/msword',
	'gif'  => 'image/gif',
	'htm'  => 'text/html',
	'html' => 'text/html',
	'jpg'  => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'mov'  => 'video/quicktime',
	'mpeg' => 'video/mpeg',
	'mp3'  => 'audio/mpeg mpga mp2 mp3',
	'pdf'  => 'application/pdf',
	'php'  => 'text/html',
	'png'  => 'image/png',
	'qt'   => 'video/quicktime',
	'rar'  => 'application/x-rar',
	'swf'  => 'application/x-shockwave-flash swf',
	'txt'  => 'text/plain',
	'wmv'  => 'video/x-ms-wmv',
	'xml'  => 'text/xml',
	'xsl'  => 'text/xml',
	'xls'  => 'application/msexcel x-excel',
	'zip'  => 'application/zip x-zip',
	'torrent' => 'application/x-bittorrent',

	);
	return isset($mime[$ext]) ? $mime[$ext] : 'application/octet-stream';
}

function get_my_nav($nav_arr=array()){
	global $db,$tpf,$pd_uid,$pd_gid,$group_settings;
	$rs = $db->fetch_one_array("select user_store_space from {$tpf}users where userid='$pd_uid'");
	if($rs['user_store_space'] ==0){
		$arr['max_storage'] = $group_settings[$pd_gid]['max_storage']==0 ? __('no_limit') : $group_settings[$pd_gid]['max_storage'];
	}else{
		$arr['max_storage'] = $rs['user_store_space'];
	}
	unset($rs);

	$file_size_total = $db->result_first("select sum(file_size) from {$tpf}files where userid='$pd_uid'");
	$arr['now_space'] = get_size($file_size_total);
	$file_size_total = ($file_size_total > get_byte_value($arr['max_storage'])) ? get_byte_value($arr['max_storage']) : $file_size_total;
	$arr['disk_fill'] = $arr['max_storage'] ? @round($file_size_total/get_byte_value($arr['max_storage']),1)*120 : 0;
	$arr['disk_percent'] = $arr['max_storage'] ? @round($file_size_total/get_byte_value($arr['max_storage']),3)*100 : 0;
	$arr['disk_remain'] = 100-$arr['disk_percent'];
	$arr['disk_space'] = $arr['max_storage'] ? get_size(get_byte_value($arr['max_storage'])-$file_size_total) : __('no_limit');
	if(is_array($nav_arr)){
		$arr = array_merge($arr,$nav_arr);
	}
	return $arr;
}
function get_rank($rank){
	if($rank){
		$sun = floor($rank/16);
		$moon = floor(($rank-16*$sun)/4);
		$star = $rank-16*$sun-4*$moon;
		$rtn = str_repeat('<img src="images/lv_sun.gif" align="absmiddle" border="0">',$sun);
		$rtn .= str_repeat('<img src="images/lv_moon.gif" align="absmiddle" border="0">',$moon);
		$rtn .= str_repeat('<img src="images/lv_star.gif" align="absmiddle" border="0">',$star);
	}else{
		$rtn = '<span class="f10">N/A</span>';
	}
	return $rtn;
}
function preview_file($file,$autostart = 0){
	global $settings;
	$v_width = 500;
	$v_height = 310;
	$a_width = 500;
	$a_height = 50;
	if(is_array($file) && $settings['open_file_preview'] && $file['is_checked']){

		if($file['file_extension'] =='swf'){
			$rtn = '<script type="text/javascript" reload="1">document.write(AC_FL_RunContent(\'width\', \''.$v_width.'\', \'height\', \''.$v_height.'\', \'allowNetworking\', \'internal\', \'allowScriptAccess\', \'never\', \'src\', \''.$file['preview_link'].'\', \'quality\', \'high\', \'bgcolor\', \'#ffffff\', \'wmode\', \'transparent\', \'allowfullscreen\', \'true\'));</script>';

		}elseif($file['is_image']){
			$rtn = '<img src="'.$file['file_thumb'].'" id="file_thumb" onload="resize_img(\'file_thumb\',400,300);" border="0">';

		}elseif($file['file_extension'] =='mp3'){
			$rtn = '<script type="text/javascript" src="includes/js/audio-player.js"></script>';
			$rtn .= '<script type="text/javascript">  ';
			$rtn .= '	AudioPlayer.setup("includes/js/audio-player.swf", {   ';
			$rtn .= '		width: '.$a_width.',';
			$rtn .= '		transparentpagebg: "yes"      ';
			$rtn .= '	});   ';
			$rtn .= '</script>  ';
			$rtn .= '<p id="audioplayer_1">audioplayer online</p>  ';
			$rtn .= '<script type="text/javascript">  ';
			$rtn .= 'AudioPlayer.embed("audioplayer_1", {soundFile: "'.$file['preview_link'].'",titles: "'.$file['file_name'].'"});';
			$rtn .= '</script>';

		}elseif(in_array($file['file_extension'],array('wma','mid','wav'))){
			$rtn = '<object classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" width="'.$a_width.'" height="64"><param name="invokeURLs" value="0"><param name="autostart" value="'.$autostart.'" /><param name="url" value="'.$file['preview_link'].'" /><embed src="'.$file['preview_link'].'" autostart="'.$autostart.'" type="application/x-mplayer2" width="'.$a_width.'" height="64"></embed></object>';

		}elseif(in_array($file['file_extension'],array('ra','rm','ram'))){
			$mediaid = 'media_'.random(3);
			$rtn = '<object classid="clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA" width="'.$a_width.'" height="32"><param name="autostart" value="'.$autostart.'" /><param name="src" value="'.$file['preview_link'].'" /><param name="controls" value="controlpanel" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$file['preview_link'].'" type="audio/x-pn-realaudio-plugin" controls="ControlPanel" console="'.$mediaid.'_" width="'.$a_width.'" height="32"></embed></object>';
		}elseif(in_array($file['file_extension'],array('asf','asx','wmv','mms','avi','mpg','mpeg'))){
			$rtn = '<object classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" width="'.$v_width.'" height="'.$v_height.'"><param name="invokeURLs" value="0"><param name="autostart" value="'.$autostart.'" /><param name="url" value="'.$file['preview_link'].'" /><embed src="'.$file['preview_link'].'" autostart="'.$autostart.'" type="application/x-mplayer2" width="'.$v_width.'" height="'.$v_height.'"></embed></object>';
		}elseif($file['file_extension'] =='mov'){
			$rtn = '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="'.$v_width.'" height="'.$v_height.'"><param name="autostart" value="'.($autostart ? '' : 'false').'" /><param name="src" value="'.$file['preview_link'].'" /><embed src="'.$file['preview_link'].'" autostart="'.($autostart ? 'true' : 'false').'" type="video/quicktime" controller="true" width="'.$v_width.'" height="'.$v_height.'"></embed></object>';
		}elseif(in_array($file['file_extension'],array('rm','rmvb','rtsp'))){
			$mediaid = 'media_'.random(3);
			$rtn = '<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="'.$v_width.'" height="'.$v_height.'"><param name="autostart" value="'.$autostart.'" /><param name="src" value="'.$file['preview_link'].'" /><param name="controls" value="imagewindow" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$file['preview_link'].'" type="audio/x-pn-realaudio-plugin" controls="imagewindow" console="'.$mediaid.'_" width="'.$v_width.'" height="'.$v_height.'"></embed></object><br /><object classid="clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA" width="'.$v_width.'" height="32"><param name="src" value="'.$file['preview_link'].'" /><param name="controls" value="controlpanel" /><param name="console" value="'.$mediaid.'_" /><embed src="'.$file['preview_link'].'" type="audio/x-pn-realaudio-plugin" controls="controlpanel" console="'.$mediaid.'_" width="'.$v_width.'" height="32"'.($autostart ? ' autostart="true"' : '').'></embed></object>';
		}
	}

	return 	$rtn ? '<div class="file_item">'.__('file_preview').':<br />'.$rtn.'</div><br />' : '';

}
function send_email($to,$subject,$body,$from='',$fromname='',$stmp = true, $sender='',$host='',$port='',$ssl='',$username='',$password=''){
	global $charset;
	$mail = new phpmailer;

	if (!$stmp) {
		$mail->IsMail();
	} else {
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->Host       = $host;
		if ($ssl) {
			$mail->SMTPSecure = "ssl";
		}
		if ($port!='') {
			$mail->Port       = $port;
		}

		$mail->Username   = $username;
		$mail->Password   = $password;

	}

	$mail->IsHTML(true);
	$mail->Sender       = $sender;
	$mail->FromEmail  = $from;
	$mail->FromName   = $fromname;

	$mail->Subject    = $subject;
	$mail->Body       = $body;
	$mail->CharSet		= $charset;
	$mail->WordWrap   = 50;

	if (is_array($to)) {
		foreach($to as $email) {
			$mail->AddAddress($email,"");
		}
	} else {
		$mail->AddAddress($to,"");
	}
	if ($fromname!='') $mail->AddReplyTo($from,$fromname);
	$mail->IsHTML(true);

	if(!$mail->Send()) {
		return "Mailer Error: " . $mail->ErrorInfo;
	} else {
		return true;
	}
}

function urr($str,$vars){
	global $settings;
	if($settings['open_rewrite']){
		switch($str){
			case 'viewfile':
				parse_str($vars);
				return "file-{$file_id}.html";
				break;

			case 'downfile':
				$arr = explode('&',trim($vars));
				parse_str($vars);

				if(count($arr) ==2){
					return "downfile-{$file_id}-{$file_key}.html";
				}else{
					return "viewfile-{$file_id}-{$file_key}.html";
				}
				break;

			case 'space':
				$arr = explode('&',trim($vars));
				parse_str($vars);
				if(count($arr)==2){
					return 'space_'.rawurlencode($username).'_'.$folder_id.'.html';
				}else{
					return 'space_'.rawurlencode($username).'.html';
				}
				break;

			default:
				return $vars ? $str.'.php?'.$vars : $str.'.php';
		}

	}else{
		return $vars ? $str.'.php?'.$vars : $str.'.php';
	}
}
function make_dir($path,$write_file=1){
	if(!is_dir($path)){
		$str = dirname($path);
		if($str){
			make_dir($str.'/');
			@mkdir($path,0777);
			chmod($path,0777);
			if($write_file){
				write_file($path.'index.htm','PHPDisk');
			}
		}
	}
}
function get_order_number(){
	$arr = explode(' ',microtime());
	return date('YmdHis',$arr[1]).substr($arr[0],2,6);
}
function get_income_status($str){
	if($str =='pendding'){
		$rtn = '<span class="txtblue">'.__('income_pendding').'</span>';
	}elseif($str =='success'){
		$rtn = '<span class="txtgreen">'.__('income_success').'</span>';
	}elseif($str =='fail'){
		$rtn = '<span class="txtred">'.__('income_fail').'</span>';
	}
	return $rtn;
}
function filter_name($name){
	$srh = array('！','＠','@',' ','#','￥','%','…','&','*','（','）','：','；','‘','’','“','”','|','\\','/','丶','^','？','?','!',';','+');
	return str_replace($srh,'_',$name);
}
function get_profile($uid,$col='*'){
	global $db,$tpf,$pd_uid;
	$uid = $uid ? (int)$uid : $pd_uid;
	if($col=='*'){
		$rs = $db->fetch_one_array("select * from {$tpf}users where userid='$uid' limit 1");
		if($rs[credit_rate]){
			$arr = explode(',',$rs[credit_rate]);
			$rs[credit_a] = $arr[0];
			$rs[credit_b] = $arr[1];
		}
		return $rs;
	}else{
		return @$db->result_first("select $col from {$tpf}users where userid='$uid' limit 1");
	}
}
function get_plans($plan_id,$col='*'){
	global $db,$tpf;
	if($col=='*'){
		return $db->fetch_one_array("select * from {$tpf}plans where plan_id='$plan_id' limit 1");
	}else{
		return @$db->result_first("select $col from {$tpf}plans where plan_id='$plan_id' limit 1");
	}
}
function get_stat_code($uid){
	global $db,$tpf;
	$stat_code = @$db->result_first("select stat_code from {$tpf}users where userid='$uid' limit 1");
	return $stat_code ? '<div style="display:none">'.base64_decode($stat_code).'</div>' : '';
}
function nav_path($folder_id,$uid){
	global $db,$tpf;
	$username = $db->result_first("select username from {$tpf}users where userid='$uid' limit 1");
	$rs = $db->fetch_one_array("select parent_id,folder_name,folder_id from {$tpf}folders where folder_id='$folder_id' and userid='$uid'");
	$str = '';
	if($rs['parent_id']!=0){
		$str .= nav_path($rs['parent_id'],$uid);
	}
	$str .= $rs['folder_name'] ? '<a href="'.urr("space","username={$username}&folder_id={$rs['folder_id']}").'">'.$rs['folder_name'].'</a>&raquo; ' : '';
	unset($rs);
	return $str;
}

function read_file($f) {
	if (file_exists($f)) {
		if (PHP_VERSION >= "4.3.0") return file_get_contents($f);
		$fp = fopen($f,"rb");
		$fsize = filesize($f);
		$c = fread($fp, $fsize);
		fclose($fp);
		return $c;
	} else{
		exit("<b>$f</b> does not exist!");
	}
}

function write_file($f,$str,$mode = 'wb') {
	$fp = fopen($f,$mode);
	if (!$fp) {
		exit("Can not open file <b>$f</b> .code:1");
	}
	if(is_writable($f)){
		if(!fwrite($fp,$str)){
			exit("Can not write file <b>$f</b> .code:2");
		}
	}else{
		exit("Can not write file <b>$f</b> .code:3");
	}
	fclose($fp);
}
function upload_file($source, $target) {
	if (function_exists('move_uploaded_file') && @move_uploaded_file($source, $target)) {
		@chmod($target, 0666);
		return $target;
	} elseif (@copy($source, $target)) {
		@chmod($target, 0666);
		return $target;
	} elseif (@is_readable($source)) {
		if ($fp = @fopen($source,'rb')) {
			@flock($fp,2);
			$filedata = @fread($fp,@filesize($source));
			@fclose($fp);
		}
		if ($fp = @fopen($target, 'wb')) {
			@flock($fp, 2);
			@fwrite($fp, $filedata);
			@fclose($fp);
			@chmod ($target, 0666);
			return $target;
		} else {
			return false;
		}
	}
}
function get_user_file_size($gid){
	global $db,$tpf,$settings;
	if($gid){
		$group_set = $db->fetch_one_array("select * from {$tpf}groups where gid='$gid'");
		$upload_max = get_byte_value(ini_get('upload_max_filesize'));
		$post_max = get_byte_value(ini_get('post_max_size'));
		$settings_max = $settings['max_file_size'] ? get_byte_value($settings['max_file_size']) : 0;
		$max_php_file_size = min($upload_max, $post_max);
		$max_file_size_byte = ($settings_max && $settings_max <= $max_php_file_size) ? $settings_max : $max_php_file_size;
		if($group_set['max_filesize']){
			$group_set_max_file_size = get_byte_value($group_set['max_filesize']);
			$max_file_size_byte = ($group_set_max_file_size >=$max_file_size_byte) ? $max_file_size_byte : $group_set_max_file_size;
		}
		return get_size($max_file_size_byte,'B',0);
	}else{
		return '80 M';
	}
}
function chk_deny_extension($ext){
	global $settings;
	if($settings[deny_extension]){
		$arr = explode(',',$settings[deny_extension]);
		if(in_array($ext,$arr)){
			return true;
		}
	}
	return false;
}
function get_folder_option($pid=0,$selID=0,$lv=0,$folder_id=0){
	global $db,$tpf,$pd_uid;
	$q = $db->query("select * from {$tpf}folders where userid='$pd_uid' and folder_id<>'$folder_id' order by folder_order asc,folder_id desc");
	while ($rs = $db->fetch_array($q)) {
		$data[] = $rs;
	}
	$db->free($q);
	unset($rs);
	if(count($data)){
		$html = '';
		foreach($data as $v){
			if($v['parent_id'] == $pid){
				$html .= '<option value="'.$v[folder_id].'"';
				$html .= $selID ? ifselected($selID,$v[folder_id]) : '';
				$html .= '>'.str_repeat('&nbsp;',$lv*2).$v[folder_name].'</option>'.LF;
				$lv++;
				$html .= get_folder_option($v['folder_id'],$selID,$lv,$folder_id);
				$lv--;
			}
		}
		return $html;
	}else{
		return '';
	}
}

function get_server_oid(){
	global $db,$tpf,$configs;
	//$server_oid = @$db->result_first("select server_oid from {$tpf}servers where server_id>1 order by is_default desc limit 1");
	
	$server_oid2 = @$db->result_first("select server_oid from {$tpf}servers where server_key='{$configs[server_key]}' limit 1");
	/*if($server_oid && $server_oid<>$server_oid2){
		exit('<p>Unknown Upload Server.</p>'.$server_oid.'|'.$server_oid2);
	}else{
		return $server_oid;
	}*/
	return $server_oid2;
}
function get_cate_option($pid=0,$selID=0,$lv=0){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}categories order by show_order asc");
	while ($rs = $db->fetch_array($q)) {
		$data[] = $rs;
	}
	$db->free($q);
	unset($rs);
	if(count($data)){
		$html = '';
		foreach($data as $v){
			if($v['pid'] == $pid){
				$html .= '<option value="'.$v[cate_id].'"';
				$html .= $selID ? ifselected($selID,$v[cate_id]) : '';
				$html .= '>'.str_repeat('&nbsp;',$lv*2).$v[cate_name].'</option>'.LF;
				$lv++;
				$html .= get_cate_option($v['cate_id'],$selID,$lv);
				$lv--;
			}
		}
		return $html;
	}else{
		return '';
	}
}

?>