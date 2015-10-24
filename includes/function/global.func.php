<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: global.func.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
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

	if(file_exists(PHPDISK_ROOT.$user_tpl_dir.'core.tpl.php') && substr(strrchr($tpl,'/'),1)=='pd_header.tpl.php'){
		return $str;
	}else{
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
			$rtn .= "	self.parent.location.href = '$go_url';".LF;
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
	$go_url = $url=='back' ? 'javascript:history.back();' : $url;
	$rtn .= '<div class="tb_box_msg"><img src="images/light.gif" border="0" align="absmiddle"><ul>'.$msg.'</ul></div>'.LF;
	$rtn .= "<script>".LF;
	$rtn .= "<!--".LF;
	$rtn .= "function redirect() {".LF;
	//$rtn .= $url=='back' ? 'javascript:history.back();'.LF : $url;
	if($url =='reload'){
		$rtn .= " top.document.location.reload();";
	}else{
		$rtn .= "	top.document.location = '$go_url';".LF;
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
	return is_array($val) ? $val : htmlspecialchars($val);
}

function gpc($name,$w = 'GPC',$default = '',$d_xss=1){
	global $curr_script;
	if($curr_script==ADMINCP){
		$d_xss = 0;
	}
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
if(!function_exists('encrypt_key')){
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
	$error = 0;
	if(!count($arr)){
		$error = 1;
		$strs = $msg;
	}else{
		for($i=0;$i<count($arr);$i++){
			if(is_numeric($arr[$i])){
				$strs .= $str_in_db ? (int)$arr[$i]."," : "'".(int)$arr[$i]."',";
			}
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
	global $db,$tpf,$settings;
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
			case 'public':
				$arr = explode('&',trim($vars));
				parse_str($vars);
				if($cate_id){
					return "cate_{$cate_id}.html";
				}else{
					return "share.html";
				}
				break;
			case 'tag':
				$arr = explode('&',trim($vars));
				parse_str($vars);
				if($tag){
					return "tag_{$tag}.html";
				}else{
					return "tag.html";
				}
				break;
			case 'hotfile':
				$arr = explode('&',trim($vars));
				parse_str($vars);

				if(count($arr) ==2){
					return "hotfile_{$o_type}_{$cate_id}.html";
				}elseif($o_type){
					return "hotfile_{$o_type}.html";
				}else{
					return 'hotfile.html';
				}
				break;
			case 'download':
				parse_str($vars);
				return "down-{$file_id}.html";
				break;
			case 'ann_list':
				parse_str($vars);
				if($aid){
					return "announce-{$aid}.html";
				}else{
					return "announce.html";
				}
				break;

			case 'space':
				$arr = explode('&',trim($vars));
				parse_str($vars);
				if($settings[open_domain]){
					$domain = $db->result_first("select domain from {$tpf}users where username='$username' limit 1");
					if($domain){
						$domain = $domain ? $domain : $username;
						if(count($arr)==2){
							if($settings['open_rewrite']==1){
								return 'http://'.$domain.$settings[suffix_domain].'/'.$username.'_folder_'.$folder_id.'.html';
							}else{
								return 'http://'.$domain.$settings[suffix_domain].'/folder_'.$folder_id.'.html';
							}
						}else{
							return 'http://'.$domain.$settings[suffix_domain];
						}
					}else{
						if(count($arr)==2){
							return 'space_'.rawurlencode($username).'_'.$folder_id.'.html';
						}else{
							return $username ? 'space_'.rawurlencode($username).'.html' : './';
						}
					}
				}else{
					if(count($arr)==2){
						return 'space_'.rawurlencode($username).'_'.$folder_id.'.html';
					}else{
						return $username ? 'space_'.rawurlencode($username).'.html' : './';
					}
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
function get_pay_status($str){
	if($str =='success'){
		$rtn = '<span class="txtgreen">'.__('pay_success').'</span>';
	}elseif($str =='fail'){
		$rtn = '<span class="txtred">'.__('pay_fail').'</span>';
	}elseif($str =='pendding'){
		$rtn = '<span class="txtblue">'.__('pay_pendding').'</span>';
	}
	return $rtn;
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
function get_vip($vip_id,$col='*'){
	global $db,$tpf,$pd_uid;
	$uid = $uid ? (int)$uid : $pd_uid;
	if($col=='*'){
		return $db->fetch_one_array("select * from {$tpf}vips where vip_id='$vip_id' limit 1");
	}else{
		return @$db->result_first("select $col from {$tpf}vips where vip_id='$vip_id' limit 1");
	}
}
function get_vip_icon(){
	global $db,$tpf,$pd_uid,$timestamp,$settings,$auth;
	if($settings[open_vip] && $pd_uid && ($auth[buy_vip_a] || $auth[buy_vip_p])){
		$num = @$db->result_first("select count(*) from {$tpf}users where userid='$pd_uid' and vip_end_time>$timestamp");
		if($num){
			return '<a href='.urr("vip","").' title="'.__('vip').'"><img src="images/vip.gif" align="absmiddle" border="0" class="vip_icon" /></a>';
		}else{
			return '<a href='.urr("vip","").' title="'.__('no_vip').'"><img src="images/no_vip.gif" align="absmiddle" border="0" class="vip_icon" /></a>';
		}
	}else{
		return '';
	}
}
function get_plans($plan_id,$col='*',$default=1){
	global $db,$tpf;
	if($plan_id){
		if($col=='*'){
			return $db->fetch_one_array("select * from {$tpf}plans where plan_id='$plan_id' limit 1");
		}else{
			return @$db->result_first("select $col from {$tpf}plans where plan_id='$plan_id' limit 1");
		}
	}else{
		$num = (int)@$db->result_first("select count(*) from {$tpf}plans where is_default=1");
		if(!$num){
			return $default;
		}else{
			if($col=='*'){
				return $db->fetch_one_array("select * from {$tpf}plans where is_default=1 limit 1");
			}else{
				return @$db->result_first("select $col from {$tpf}plans where is_default=1 limit 1");
			}
		}
	}
}
function get_stat_code($uid){
	global $db,$tpf,$settings;
	$stat_code = '';
	if($settings[global_open_custom_stats]){
		$stat_code = @$db->result_first("select stat_code from {$tpf}users where userid='$uid' and open_custom_stats>0 limit 1");
	}
	return $stat_code ? '<div style="display:none">'.base64_decode($stat_code).'</div>' : '';
}
function nav_path($folder_id,$uid,$only_txt=0){
	global $db,$tpf;
	$username = $db->result_first("select username from {$tpf}users where userid='$uid' limit 1");
	$rs = $db->fetch_one_array("select parent_id,folder_name,folder_id from {$tpf}folders where folder_id='$folder_id' and userid='$uid'");
	$str = '';
	if($rs['parent_id']!=0){
		$str .= nav_path($rs['parent_id'],$uid,$only_txt);
	}
	if($only_txt){
		$str .= $rs['folder_name'] ? $rs['folder_name'].'>' : '';
	}else{
		$str .= $rs['folder_name'] ? '<a href="'.urr("space","username={$username}&folder_id={$rs['folder_id']}").'">'.$rs['folder_name'].'</a>&raquo; ' : '';
	}
	unset($rs);
	return $str;
}
function nav_path_course($course_id,$uid,$only_txt=0){
    global $db,$tpf;
    $username = $db->result_first("select username from {$tpf}users where userid='$uid' limit 1");
    $rs = $db->fetch_one_array("select * from {$tpf}course where courseid='$course_id' ");
    $str = '';
    if($rs['parent_id']!=0){
        $str .= nav_path_course($rs['parent_id'],$uid,$only_txt);
    }
    if($only_txt){
        $str .= $rs['course_name'] ? $rs['course_name'].'>' : '';
    }else{
        $str .= $rs['course_name'] ? '<a href="'.urr("space","username={$username}&cs_id={$rs['courseid']}").'">'.$rs['course_name'].'</a>&raquo; ' : '';
    }
    unset($rs);
    return $str;
}

function read_file($f) {
	if (file_exists($f)) {
		if (PHP_VERSION >= "4.3.0") return file_get_contents($f);
		$fp = @fopen($f,"rb");
		$fsize = @filesize($f);
		$c = @fread($fp, $fsize);
		@fclose($fp);
		return $c;
	} else{
		exit("<b>$f</b> does not exist!");
	}
}

function write_file($f,$str,$mode = 'wb') {
	$fp = @fopen($f,$mode);
	if (!$fp) {
		exit("Can not open file <b>$f</b> .code:1");
	}
	if(is_writable($f)){
		if(!@fwrite($fp,$str)){
			exit("Can not write file <b>$f</b> .code:2");
		}
	}else{
		exit("Can not write file <b>$f</b> .code:3");
	}
	@fclose($fp);
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
function get_income_rate($uid,$is_downline=0){
	global $settings;
	$credit_rate = get_profile($uid,'credit_rate');
	$downline_income = get_profile($uid,'downline_income');
	$rate = 0;
	if($credit_rate){
		$arr = explode(',',$credit_rate);
		$rate = $arr[1]/$arr[0];
	}elseif($settings['how_money_credit'] && $settings['how_downs_credit']){
		$rate = $settings['how_money_credit']/$settings['how_downs_credit'];
	}
	$downline_income = $downline_income ? $downline_income : $settings['downline_income'];
	return $rate ? ($is_downline ? $rate*($downline_income/100) : $rate) : '';
}
function conv_credit($uid){
	global $db,$tpf;
	$myinfo[credit] = get_profile($uid,'credit');
	$myinfo[dl_credit] = get_profile($uid,'dl_credit');

	if(get_income_rate($uid)){
		$money = get_discount($uid,$myinfo[credit]) * get_income_rate($uid);
		$dl_money = get_discount($uid,$myinfo['dl_credit']) * get_income_rate($uid,1);
		$add_wealth = round($money+$dl_money,4);
		$db->query_unbuffered("update {$tpf}users set credit=0,dl_credit=0,wealth=wealth+$add_wealth where userid='$uid' limit 1");
		//echo $add_wealth;
		return true;
	}
}
function ip_encode($ip){
	global $pd_gid;
	if($pd_gid==1){
		return $ip;
	}else{
		$arr = explode('.',$ip);
		for($i=0;$i<count($arr)-1;$i++){
			return $arr[0].'.*.*.*';
		}
	}
}
function clear_html($str,$len=50){
	return str_replace("\r\n",' ',cutstr(preg_replace("/<.+?>/i","",$str),$len));
}
function get_chapter_section_option($courseId,$pid=0,$selID=0,$lv=0){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}course_chapter_section where course_id = {$courseId}");
	while ($rs = $db->fetch_array($q)) {
		$data[] = $rs;
	}
	$db->free($q);
	unset($rs);
	if(count($data)){
		$html = '';
		foreach($data as $v){
			if($v['parent_id'] == $pid){
				$html .= '<option value="'.$v[csid].'"';
				$html .= $selID ? ifselected($selID,$v[csid]) : '';
				$html .= '>'.str_repeat('&nbsp;',$lv*2).$v[cs_name].'</option>'.LF;
				$lv++;
				$html .= get_chapter_section_option($courseId, $v['csid'],$selID,$lv);
				$lv--;
			}
		}
		return $html;
	}else{
		return '';
	}
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
function get_cate_list($pid=0){
	global $db,$tpf,$o_type;
	$pid = (int)$pid;
	$pid_sql = $pid ? " and pid='$pid'" : '';
	$q = $db->query("select cate_id,cate_name from {$tpf}categories where cate_list=1 $pid_sql order by show_order asc,cate_id desc");
	$cate_list = array();
	while ($rs = $db->fetch_array($q)) {
		$rs[a_public] = urr("public","cate_id={$rs[cate_id]}");
		$rs[a_hotfile] = urr("hotfile","o_type=$o_type&cate_id={$rs[cate_id]}");
		$cate_list[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $cate_list;
}
//获取该分类下全部子分类
function get_allsubcate_form_cateid($cate_id){

}

function get_cate_path($cate_id){
	global $db,$tpf;
	$rs = $db->fetch_one_array("select pid,cate_id,cate_name from {$tpf}categories where cate_id='$cate_id'");
	$str = '';
	if($rs['pid']!=0){
		$str .= get_cate_path($rs['pid']);
	}
	$str .= $rs['cate_name'] ? '<a href="'.urr("public","cate_id=".$rs[cate_id]).'" target="_blank">'.$rs['cate_name'].'</a>&raquo;' : '';
	unset($rs);
	return $str ? $str : '&nbsp;';
}
function filter_tag($str){
	return str_replace(array('"',"'",'/','(',')','*'),'',$str);
}
function make_tags($tags,$tag_arr,$file_id){
	global $db,$tpf,$timestamp,$pd_uid;
	if($tags){
		$tags = filter_tag($tags);
		$tags_str = '';
		for($i=0;$i<count($tag_arr);$i++){
			if($tag_arr[$i]){
				$tags_str .= "'".filter_tag($tag_arr[$i])."',";
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}file2tag where tag_name='{$tag_arr[$i]}' and file_id='{$file_id}'");
				if(!$rs['total']){
					$ins = array(
					'tag_name' => $tag_arr[$i],
					'file_id' => $file_id,
					);
					$db->query_unbuffered("insert into {$tpf}file2tag set ".$db->sql_array($ins).";");
				}
				unset($rs);
			}
		}
		$tags_str = (substr($tags_str,-1) ==',') ? substr($tags_str,0,-1) : $tags_str;
		$db->query_unbuffered("update {$tpf}tags set tag_count=tag_count-1 where tag_name in (select tag_name from {$tpf}file2tag where file_id='$file_id')");
		$db->query_unbuffered("delete from {$tpf}file2tag where file_id='$file_id' and tag_name not in ($tags_str)");

		$tagdb = explode(',',$tags);
		for($i=0; $i<count($tagdb); $i++){
			$tagdb[$i] = trim($tagdb[$i]);
			if($tagdb[$i]){
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}tags where tag_name='{$tagdb[$i]}'");
				if(!$rs['total']){
					$ins = array(
					'tag_name' => $tagdb[$i],
					'tag_count' => 1,
					);
					$db->query_unbuffered("insert into {$tpf}tags set ".$db->sql_array($ins).";");
				}
				unset($rs);
				$db->query_unbuffered("update {$tpf}tags set tag_count=(select count(*) from {$tpf}file2tag where tag_name='{$tagdb[$i]}') where tag_name='{$tagdb[$i]}'");
			}
		}

	}else{
		$q = $db->query("select * from {$tpf}file2tag where file_id='$file_id'");
		while($rs = $db->fetch_array($q)){
			$tags_str .= "'{$rs['tag_name']}',";
		}
		$db->free($q);
		unset($rs);
		$tags_str = (substr($tags_str,-1) ==',') ? substr($tags_str,0,-1) : $tags_str;
		$tags_str = filter_tag($tags_str);
		if($tags_str){
			$db->query_unbuffered("update {$tpf}tags set tag_count=tag_count-1 where tag_name in ($tags_str)");
			$db->query_unbuffered("delete from {$tpf}file2tag where file_id='$file_id'");
		}
	}
	$db->query_unbuffered("delete from {$tpf}tags where tag_count<0");
}
function select_tpl(){
	global $db,$tpf,$settings;
	$q = $db->query("select * from {$tpf}templates where tpl_type='user'");
	$tpl_sw = array();
	while($rs = $db->fetch_array($q)){
		$arr = get_template_info($rs[tpl_name]);
		$rs[tpl_title] = $arr[tpl_title];
		$rs['tpl_href'] = $settings[phpdisk_url].'?tpl='.$rs['tpl_name'].'&ref='.base64_encode($_SERVER['REQUEST_URI']);
		if($arr[authed_tpl]==2 ||!$arr[authed_tpl]){
			$tpl_sw[] = $rs;
		}
	}
	$db->free($q);
	unset($rs);
	return $tpl_sw;
}
function select_lang(){
	global $db,$tpf,$settings;
	$q = $db->query("select * from {$tpf}langs");
	$langs_sw = array();
	while($rs = $db->fetch_array($q)){
		$arr = get_lang_info($rs[lang_name]);
		$rs[lang_txt] = $arr[lang_title];
		$rs['lang_href'] = $settings[phpdisk_url].'?lang='.$rs['lang_name'].'&ref='.base64_encode($_SERVER['REQUEST_URI']);
		$langs_sw[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $langs_sw;
}
function check_template($tpl_name){
	$dir = PHPDISK_ROOT."templates/{$tpl_name}/";
	if(file_exists($dir.'template_info.php') && $tpl_name !='.' && $tpl_name !='..'){
		$rtn = 1;
	}else{
		$rtn = 0;
	}
	return $rtn;
}
function check_lang($lang_name){
	$dir = PHPDISK_ROOT."languages/{$lang_name}/";
	if(file_exists($dir.'./lang_info.php') && $lang_name !='.' && $lang_name !='..'){
		$rtn = 1;
	}else{
		$rtn = 0;
	}
	return $rtn;
}
function get_lang_info($lang_name){
	global $db,$tpf;
	$file = PHPDISK_ROOT."languages/$lang_name/lang_info.php";
	if(file_exists($file)){
		$_data = read_file($file);
		preg_match("/Language Name:(.*)/i",$_data,$lang_title);
		preg_match("/Language URL:(.*)/i",$_data,$lang_url);
		preg_match("/Description:(.*)/i",$_data,$lang_desc);
		preg_match("/Author:(.*)/i",$_data,$lang_author);
		preg_match("/Author Site:(.*)/i",$_data,$lang_site);
		preg_match("/Version:(.*)/i",$_data,$lang_version);
		preg_match("/PHPDISK Core:(.*)/i",$_data,$phpdisk_core);
	}
	$actived = (int)@$db->result_first("select actived from {$tpf}langs where lang_name='$lang_name' limit 1");
	$arr = array(
	'lang_title' => trim($lang_title[1]),
	'lang_url' => trim($lang_url[1]),
	'lang_desc' => htmlspecialchars(trim($lang_desc[1])),
	'lang_author' => trim($lang_author[1]),
	'lang_site' => trim($lang_site[1]),
	'lang_version' => trim($lang_version[1]),
	'lang_dir' => trim($lang_name),
	'phpdisk_core' => trim($phpdisk_core[1]),
	'actived' => $actived,
	);
	return $arr;
}
function get_table_credit_log(){
	global $db,$tpf,$db_charset;
	$q = $db->query("show tables;");
	if($q){
		$tbl_list = array();
		while($rs = $db->fetch_array($q)){
			$tbl_list[] = $rs;
		}
		$db->free($q);
		unset($rs);
	}
	//print_r($tbl_list);
	for($i=0;$i<count($tbl_list)-1;$i++){
		foreach($tbl_list[$i] as $v){
			$arr[] = $v;
		}
	}
	$now_table = "{$tpf}credit_log".date('Ym');
	if(!in_array($now_table,$arr)){
		$sql = "CREATE TABLE IF NOT EXISTS `$now_table` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `credit` float unsigned NOT NULL DEFAULT '0',
  `action` varchar(20) NOT NULL,
  `in_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `ref` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `intime` (`in_time`),
  KEY `userid` (`userid`),
  KEY `action` (`action`),
  KEY `file_id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET={$db_charset} AUTO_INCREMENT=1 ;
";
		$db->query_unbuffered($sql);
	}
	return $now_table;
}
function get_table_day_down(){
	global $db,$tpf,$db_charset;
	$q = $db->query("show tables;");
	if($q){
		$tbl_list = array();
		while($rs = $db->fetch_array($q)){
			$tbl_list[] = $rs;
		}
		$db->free($q);
		unset($rs);
	}
	//print_r($tbl_list);
	for($i=0;$i<count($tbl_list)-1;$i++){
		foreach($tbl_list[$i] as $v){
			$arr[] = $v;
		}
	}
	$now_table = "{$tpf}day_down".date('Y');
	if(!in_array($now_table,$arr)){
		$sql = "CREATE TABLE IF NOT EXISTS `$now_table` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `d_year` char(4) NOT NULL,
  `d_month` char(6) NOT NULL,
  `d_day` char(8) NOT NULL,
  `d_week` char(6) NOT NULL,
  `file_id` int(10) unsigned NOT NULL default '0',
  `down_count` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `d_year` (`d_year`),
  KEY `d_month` (`d_month`),
  KEY `d_day` (`d_day`),
  KEY `d_week` (`d_week`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET={$db_charset} AUTO_INCREMENT=1 ;
";
		$db->query_unbuffered($sql);
	}
	return $now_table;
}
function filter_name($str){
	return str_ireplace(array(' ','&amp;','・','%'),'_',$str);
}
function get_nodes($server_oid){
	global $db,$tpf;
	$q = $db->query("select * from {$tpf}nodes where server_oid='$server_oid' and is_hidden=0 order by show_order asc,node_id asc");
	$nodes = array();
	while ($rs = $db->fetch_array($q)) {
		$rs[icon] = $rs[icon] ? '<img src="'.$rs[icon].'" align="absmiddle" border="0" />' : '&nbsp;';
		$rs[host] = $rs[host] ? $rs[host] : 'http://www.google.com/';
		$nodes[] = $rs;
	}
	$db->free($q);
	unset($rs);
	return $nodes;
}
function super_admin(){
	global $adminset,$pd_uid;
	$arr = explode(',',$adminset[super_adminid]);
	if(in_array($pd_uid,$arr)){
		return true;
	}else{
		return false;
	}
}
function get_admins_power($uid){
	global $db,$tpf;
	$rs = $db->fetch_one_array("select * from {$tpf}admins where userid='$uid' limit 1");
	if($rs){
		return unserialize($rs[power_list]);
	}
	unset($rs);
}
function admin_no_power($task,$menuid,$uid){
	$error = false;
	if(!super_admin()){
		$arr = get_admins_power($uid);
		if($task){
			if($arr[$menuid]<>2){
				$error = true;
				$sysmsg[] = __('admin_no_write');

			}
		}else{
			if(!in_array($arr[$menuid],array(1,2))){
				$error = true;
				$sysmsg[] = __('admin_no_visit');
			}
		}
		if($error){
			redirect(urr(ADMINCP,""),$sysmsg,60000);
			exit;
		}
	}
}
function is_mobile(){
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') || strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'applewebkit')){
		return true;
	}else{
		return false;
	}
}
function check_download_ok($my_sid,$interval_time){
	global $db,$tpf,$onlineip,$timestamp;
	$rtn = false;
	$db->query_unbuffered("delete from {$tpf}downlog where $timestamp-intime>86400");
	$rs = $db->fetch_one_array("select * from {$tpf}downlog where hash='$my_sid' or ip='$onlineip'");
	if(!$rs[intime]){
		$ins = array(
		'hash'=>$my_sid,
		'ip'=>$onlineip,
		'intime'=>$timestamp,
		);
		$db->query_unbuffered("insert into {$tpf}downlog set ".$db->sql_array($ins)."");
		$rtn = true;
	}else{
		$interval_time = $interval_time ? $interval_time : 600;
		if($timestamp-$rs[intime]>$interval_time){
			$db->query_unbuffered("update {$tpf}downlog set intime='$timestamp' where id='{$rs[id]}'");
			$rtn = true;
		}
		$db->query_unbuffered("update {$tpf}downlog set downcount=downcount+1 where id='{$rs[id]}'");
	}
	return $rtn;
}
function filter_word($str){
	global $settings;
	if(!empty($settings['filter_word'])){
		$arr = explode(',', $settings['filter_word']);
		foreach($arr as $k=>$v){
			$str = str_ireplace($v, '*', $str);
		}
	}
	return $str;
}
function is_vip($uid){
	global $timestamp;
	$vip_id = get_profile($uid,'vip_id');
	$vip_end_time = 0;
	if($vip_id){
		$vip_end_time = get_profile($uid,'vip_end_time');
	}
	return $vip_end_time>$timestamp ? true : false;
}
function dir_writeable($dir) {
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/phpdisk.test", 'w')) {
			@fclose($fp);
			@unlink("$dir/phpdisk.test");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}
function seo_filter($str){
	return str_replace('"','',$str);
}
function get_seo($seo_type,$type_id){
	global $db,$tpf,$seo_settings;
	if($seo_settings){
		return $seo_settings[$seo_type.'_'.$type_id];
	}else{
		$rs = $db->fetch_one_array("select * from {$tpf}seo where seo_type='$seo_type' and type_id='$type_id'");
		return $rs ? $rs : '';
	}
}
function add_credit_log($file_id,$credit,$action,$userid,$ref=''){
	global $db,$tpf,$timestamp,$onlineip,$settings;
	if(!$settings['close_credit_log']){
		switch ($action){
			case 'download':
				$id = @$db->result_first("select id from ".get_table_credit_log()." where file_id='$file_id' and userid='$userid' and action='$action' order by id desc limit  1");
				if($id){
					$db->query_unbuffered("update ".get_table_credit_log()." set credit=credit+$credit,in_time='$timestamp',ip='$onlineip' where id='$id'");
				}else{
					$ins = array(
					'file_id'=>$file_id,
					'credit'=>$credit,
					'action'=>$action,
					'in_time'=>$timestamp,
					'ip'=>$onlineip,
					'userid'=>$userid,
					);
					$db->query_unbuffered("insert into ".get_table_credit_log()." set ".$db->sql_array($ins)."");
				}
				break;
			case 'view':
				$id = @$db->result_first("select id from ".get_table_credit_log()." where file_id='$file_id' and userid='$userid' and action='$action' order by id desc limit  1");
				if($id){
					$db->query_unbuffered("update ".get_table_credit_log()." set credit=credit+$credit,in_time='$timestamp',ip='$onlineip' where id='$id'");
				}else{
					$ins = array(
					'file_id'=>$file_id,
					'credit'=>$credit,
					'action'=>$action,
					'in_time'=>$timestamp,
					'ip'=>$onlineip,
					'userid'=>$userid,
					);
					$db->query_unbuffered("insert into ".get_table_credit_log()." set ".$db->sql_array($ins)."");
				}
				break;
			case 'ref':
				if($ref){
					$ins = array(
					'file_id'=>$file_id,
					'action'=>$action,
					'in_time'=>$timestamp,
					'ip'=>$onlineip,
					'userid'=>$userid,
					'ref'=>$ref,
					);
					$db->query_unbuffered("insert into ".get_table_credit_log()." set ".$db->sql_array($ins)."");
				}
				break;
		}
	}
}
function exp_credit_rate($credit_rate){
	if(strpos($credit_rate,',')!==false){
		$arr = explode(',',$credit_rate);
		return $arr[0].'==￥'.$arr[1];
	}
}
function create_down_url($file){
	global $settings,$timestamp;
	$pp = $file['file_store_path'].$file['file_real_name'].get_real_ext($file['file_extension']);
	$fs = $file['file_size'];
	$hash = strtoupper(md5($file['file_id'].'_'.$file['file_size'].'_'.$file['file_store_path'].$file['file_real_name']));
	$tmp_ext = $file['file_extension'] ? '.'.$file['file_extension'] : "";
	$p_filename = filter_name($file['file_name'].$tmp_ext);
	$expire_time = $settings[dl_expire_time] ? ($settings[dl_expire_time]+$timestamp) : 0;
	return urr("dl",pd_encode("file_name=$p_filename&file_id={$file['file_id']}&fs=$fs&pp=$pp&hash=$hash&expire_time=$expire_time"));
}

//获取用户提交过教师申请的状态
function get_application_teacher_status(){
	global $db,$tpf,$pd_uid;
	$user_id = $pd_uid;
	$sql = "SELECT status FROM {$tpf}application_teacher WHERE user_id = {$user_id}";
	$application_one = $db->fetch_one_array($sql);
	return $application_one;
}

//获取视频列表数据
function get_course_list($condition = null){
	global $db,$tpf,$pd_uid,$pg,$defineCouser;
	$perpage = 20;
	$start_num = ($pg-1) * $perpage;
    $sql = "SELECT distinct c.*, cg.cate_name,u.username, count(*) as file_num
            FROM {$tpf}file_cs_relation fcr
            LEFT JOIN {$tpf}course c ON c.courseid = fcr.course_id
            LEFT JOIN {$tpf}categories cg ON c.cate_id = cg.cate_id
            LEFT JOIN {$tpf}users u ON u.userid = c.user_id
            WHERE user_id = {$pd_uid} {$condition} limit {$start_num},{$perpage}";
	$q = $db->query($sql);
	$course_array = array();
	while($rs = $db->fetch_array($q)) {
        if(!empty($rs['courseid'])){
            $rs['create_date'] = date('Y-m-d H:i:s',$rs[create_date]);
            $rs['update_date'] = date('Y-m-d H:i:s',$rs[update_date]);
            $rs['status_num'] = $rs['status'];
            $rs['status'] = $defineCouser[$rs['status']]?$defineCouser[$rs['status']]:'未定义状态';
            $rs['a_course_view'] = urr("mydisk","item=profile&action=chapter_section_manage&course_id={$rs['courseid']}");
            $rs['a_course_view_admin'] = urr("admincp","item=course&menu=file&action=course_view&course_id={$rs['courseid']}");
            $rs['a_edit'] = urr("mydisk","item=course&action=modify_course&course_id={$rs['courseid']}");
            $rs['a_del'] = urr("mydisk","item=course&action=course_delete&course_id={$rs['courseid']}");
            $rs['a_course_review'] = urr("mydisk", "item=course&action=course_review&course_id={$rs['courseid']}");
            $rs['a_course_review_cancel'] = urr("mydisk", "item=course&action=course_review_cancel&course_id={$rs['courseid']}");
            $course_array[] = $rs;
        }
	}
	$db->free($q);
	unset($rs);
	return $course_array;
}

//获取课程的章节列表
function get_chapter_section_list($course_id){
	global $tpf, $db, $defineChaptersSections, $defineFileChaptersSections;
	//获取章节
	require(PHPDISK_ROOT.'includes/class/phptree.class.php');
	$sql = "SELECT * FROM {$tpf}course_chapter_section WHERE course_id = {$course_id}";
	$q = $db->query($sql);
	$chapter_section_array = array();
	while($rs = $db->fetch_array($q)) {
		$rs['ff_id'] = $rs['csid'];
		$rs['create_date'] = date('Y-m-d H:i:s',$rs[create_date]);
		$rs['update_date'] = date('Y-m-d H:i:s',$rs[update_date]);
		$rs['status'] = $defineChaptersSections[$rs['status']]?$defineChaptersSections[$rs['status']]:'未定义状态';
		$rs['a_edit'] = urr("mydisk","item=course&action=modify_chapter_section&cs_id={$rs['csid']}&course_id={$course_id}");
		$rs['a_del'] = urr("mydisk","item=course&action=chapter_section_delete&cs_id={$rs['csid']}&course_id={$course_id}");
		$rs['a_add_file'] = urr("mydisk","item=course&action=add_file_cs_relation&cs_id={$rs['csid']}&course_id={$course_id}");
		$rs['is_cs'] = 1;
		$chapter_section_array[] = $rs;
	}
	unset($rs);
	//获取章节下的文件
	$sql = "SELECT * FROM {$tpf}file_cs_relation fcr LEFT JOIN {$tpf}files f ON fcr.file_id = f.file_id WHERE course_id = {$course_id} AND is_del =0";
	$q = $db->query($sql);
	$file_array = array();
	$ff_id = 10000000;
	while($rs = $db->fetch_array($q)) {
		$rs['ff_id'] = $ff_id;
		$ff_id ++;
		$rs['parent_id'] = $rs['cs_id'];
		$rs['file_time'] = date('Y-m-d H:i:s',$rs[file_time]);
		$rs['status'] = $defineFileChaptersSections[$rs['status']]?$defineFileChaptersSections[$rs['status']]:'未定义状态';
		$rs['a_del'] = urr("mydisk","item=course&action=file_cs_relation_delete&cs_id={$rs['cs_id']}&file_id={$rs['file_id']}&course_id={$rs['course_id']}");
		$rs['is_file'] = 1;
		$file_array[] = $rs;
	}
	unset($rs);
	//合并数组
	$cs_file = array_merge($chapter_section_array,$file_array);
	PHPTree::$config['primary_key'] = 'ff_id';
	PHPTree::$config['parent_key'] = 'parent_id';
	$chapter_section_array = PHPTree::makeTreeForHtml($cs_file);
	return $chapter_section_array;
}

//获取分类下的课程
function get_course_from_cate($cate=0){

}
?>