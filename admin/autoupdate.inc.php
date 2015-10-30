<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: autoupdate.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

require_once "../includes/commons.inc.php";

phpdisk_core::admin_login();

switch($action){
	case 'getnews':
		$url = $news_url;
		$arr = get_web_link($url);
		if($arr['http_code'] == 200){
			echo 'true';
		}else{
			$file = @fopen($url,"rb");
			echo $file ? 'true' : 'false';
			@fclose($file);
		}
		break;

	case 'upgrade':
	default:
		$url = $upgrade_url;
		$arr = get_web_link($url);
		if($arr['http_code'] == 200){
			echo trim($arr['content']);
		}else{
			$file = @fopen($url, "rb");
			if($file){
				while (!feof($file)) {
					$line = fgets($file);
				}
			}
			@fclose($file);
			echo trim($line);
		}
}
function get_web_link($url){
	if(function_exists('curl_init')){
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		///CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING       => "",
		CURLOPT_USERAGENT      => "spider",
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_CONNECTTIMEOUT => 120,
		CURLOPT_TIMEOUT        => 120,
		CURLOPT_MAXREDIRS      => 10,
		);
		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);

		$header['errno'] = $err;
		$header['errmsg'] = $errmsg;
		$header['content'] = $content;

		return $header;
	}
}

//include PHPDISK_ROOT."./includes/footer.inc.php";
?>