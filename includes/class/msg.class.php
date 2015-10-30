<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: msg.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class msg {

	function msg() {

	}
	function fmsg($str,$param){
		return sprintf($str,$param);
	}
	function umsg($str,$code,$timeout=5000){
		global $settings;
		$rtn = '<html>'.LF;
		$rtn .= '<head>'.LF;
		$rtn .= '<title>PHPDisk 403</title>'.LF;
		$rtn .= '</head>'.LF;
		$rtn .= '<body>'.LF;
		$rtn .= '<div style="background:#F8F8F8;padding:3px;font-size:12px">';
		$rtn .= '<p><a href="http://faq.google.com/search?w='.rawurlencode($code).'" target="_blank">[<span style="color:#FF0000;">PHPDisk error!</span>]&nbsp;'.$str.':'.$code.'</a><br><br>';
		$rtn .= '</div>';
		$rtn .= '<script>setTimeout(function(){document.location="'.$settings[phpdisk_url].'";},'.$timeout.');</script>';
		$rtn .= '</body></html>'.LF;
		return $rtn;
	}
}
?>