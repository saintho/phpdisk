<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: rss.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
error_reporting(0);
define('PHPDISK_ROOT', dirname(__FILE__).'/');
define('IN_PHPDISK',TRUE);
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('OS_WIN',true);
	define('LF',"\r\n");
}else{
	define('OS_WIN',false);
	define('LF',"\n");
}
$arr = array('global');
for ($i=0;$i<count($arr);$i++){
	require(PHPDISK_ROOT.'includes/function/'.$arr[$i].'.func.php');
}
$arr = array('core','mysql');
for ($i=0;$i<count($arr);$i++){
	require(PHPDISK_ROOT.'includes/class/'.$arr[$i].'.class.php');
}
require_once(PHPDISK_ROOT.'system/configs.inc.php');
require_once(PHPDISK_ROOT.'system/settings.inc.php');

phpdisk_core::init_core();
$db = phpdisk_core::init_db_connect();
$charset = $configs['charset'];
$tpf = $configs[tpf];

$arr = array();
$q = $db->query("select file_id,file_name,file_extension,file_time,file_description,folder_id,u.username from {$tpf}files f,{$tpf}users u where f.userid=u.userid and in_share=1 order by file_id desc limit 30");
while ($rs = $db->fetch_array($q)) {
	$tmp_ext = $rs['file_extension'] ? '.'.$rs['file_extension'] : "";
	$rs[title] = $rs['file_name'].$tmp_ext;
	$rs[link] = $settings[phpdisk_url].urr("viewfile","file_id={$rs[file_id]}");
	$rs[file_description] = $rs[file_description] ? cutstr($rs[file_description],150) : $rs[title];
	$rs[pubDate] = date('Y-m-d H:i:s',$rs[file_time]);
	if($rs[folder_id]){
		$rs[folder_name] = @$db->result_first("select folder_name from {$tpf}folders where folder_id='{$rs[folder_id]}' limit 1");
	}else{
		$rs[folder_name] = '';
	}
	$arr[] = $rs;
}
$db->free($q);
unset($rs);
//	ob_end_clean();
/*		header( "Content-type: application/xml; charset=\"".$charset . "\"", true );
header( 'Pragma: no-cache' );*/
@ob_end_clean();
header("Content-type:application/xml");

$str = '<?xml version="1.0" encoding="'.$charset.'" ?>'.LF;
$str .= '<rss version="2.0">'.LF;
$str .= '<channel>'.LF;
$str .= "\t<title><![CDATA[最近30个更新的文件]]></title>".LF;
$str .= "\t<link>{$settings[phpdisk_url]}</link>".LF;
$str .= "\t<description><![CDATA[last 30's file of {$settings[site_title]}]]></description>".LF;
$str .= "\t<pubDate>". date('Y-m-d H:i:s')."</pubDate>".LF;
$str .= '<copyright>'.$settings[phpdisk_url].' (C)'.date('Y').'. All rights reserved.</copyright>';
$str .= '<generator>'.$settings[phpdisk_url].' RSS Source</generator>'.LF;
$str .= '<ttl>60</ttl>'.LF;
foreach($arr as $v){
	$str .= "\t<item>".LF;
	$str .= "\t\t<title><![CDATA[{$v[title]}]]></title>".LF;
	$str .= "\t\t<author>{$v[username]}</author>".LF;
	$str .= "\t\t<link>{$v[link]}</link>".LF;
	$str .= "\t\t<category>{$v[folder_name]}</category>".LF;
	$str .= "\t\t<description><![CDATA[{$v[file_description]}]]></description>".LF;
	$str .= "\t\t<pubDate>". $v[pubDate]."</pubDate>".LF;
	$str .= "\t</item>".LF;
}
$str .= '</channel>'.LF;
$str .= '</rss>'.LF;
//write_file($rss_file,$str,'wb+');
echo $str;


?>
