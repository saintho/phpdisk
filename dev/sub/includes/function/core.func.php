<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.phpdisk.com
#
#	$Id: image.func.php 14 2013-03-18 03:02:57Z along $
#
#	Copyright (C) 2008-2013 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}
function pd_encodex($txt, $operation = 'ENCODE',$key = '&*PHPD=Rt'){
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
function get_oss_info($act){
	global $settings;
	if($settings[flow_setting]){
		$s = pd_encodex($settings[flow_setting],'DECODE');
		if($s){
			$arr = explode('|',$s);
		}
		switch ($act){
			case 'id':
				return $arr[0];
				break;
			case 'username':
				return $arr[1];
				break;
			case 'access_id':
				return $arr[2];
				break;
			case 'access_key':
				return $arr[3];
				break;
			case 'oss_host':
				return $arr[4];
				break;
			case 'oss_bucket':
				return $arr[5];
				break;
			case 'oss_money':
				return $arr[6];
				break;
		}
	}else{
		return 'no_flow!!!';
	}
}
function oss_upload($src,$object,$dir){
	include_once PHPDISK_ROOT.'includes/oss/sdk.class.php';
	$obj = new ALIOSS();
	$obj->set_debug_mode(false);
	$bucket = get_oss_info('oss_bucket');

	//$object = 'netbeans-7.1.2-ml-cpp-linux.sh';
	//$file_path = "D:\\TDDOWNLOAD\\netbeans-7.1.2-ml-cpp-linux.sh";

	$response = $obj->upload_file_by_file($bucket,get_oss_info('id').'/'.$dir.$object,$src);
	//_format($response);
	return $response->status==200 ? true : false;
}
function oss_make_dir($obj_dir){
	include_once PHPDISK_ROOT.'includes/oss/sdk.class.php';
	$obj = new ALIOSS();
	$obj->set_debug_mode(false);
	$bucket = get_oss_info('oss_bucket');

	$response = $obj->create_object_dir($bucket,get_oss_info('id').'/'.$obj_dir);
	//_format($response);
	return $response->status==200 ? true : false;
}
function _format($response) {
	$str = '|-----------------------Start---------------------------------------------------------------------------------------------------'."\n";
	$str .= '|-Status:' . $response->status . "\n";
	$str .= '|-Body:' ."\n";
	$str .= $response->body . "\n";
	$str .= "|-Header:\n";
	$str .= var_export ( $response->header,true );
	$str .= '-----------------------End-----------------------------------------------------------------------------------------------------'."\n\n";
	write_file(PHPDISK_ROOT.'system/upload.log',$str,'ab+');
}

?>