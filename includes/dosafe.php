<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: dosafe.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
function customError($errno, $errstr, $errfile, $errline)
{
	echo "<b>Error number:</b> [$errno],error on line $errline in $errfile<br />";
	die();
}
set_error_handler("customError",E_ERROR);
$getfilter="'|<[^>]*?>|^\\+\/v(8|9)|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="^\\+\/v(8|9)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){

	$StrFiltValue=arr_foreach($StrFiltValue);
	if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
		$str = "操作IP: ".$_SERVER["REMOTE_ADDR"]."\t操作时间: ".date('Y-m-d H:i:s')."\t操作页面:".$_SERVER["PHP_SELF"]."\t提交方式: ".$_SERVER["REQUEST_METHOD"]."\t提交参数: ".$StrFiltKey."\t提交数据: ".$StrFiltValue.LF;
		write_file(PHPDISK_ROOT.'system/defend_log.php',$str,'ab+');
		//print "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\"><br>您的提交带有不合法参数!<br><br></div>";
		exit();
	}
	if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
		$str = "操作IP: ".$_SERVER["REMOTE_ADDR"]."\t操作时间: ".date('Y-m-d H:i:s')."\t操作页面:".$_SERVER["PHP_SELF"]."\t提交方式: ".$_SERVER["REQUEST_METHOD"]."\t提交参数: ".$StrFiltKey."\t提交数据: ".$StrFiltValue.LF;
		write_file(PHPDISK_ROOT.'system/defend_log.php',$str,'ab+');
		//print "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:green;font-weight:bold;border-bottom:5px solid #999;\"><br>您的提交带有不合法参数!<br><br></div>";
		exit();
	}
}
//$ArrPGC=array_merge($_GET,$_POST,$_COOKIE);
foreach($_GET as $key=>$value){
	StopAttack($key,$value,$getfilter);
}
foreach($_POST as $key=>$value){
	StopAttack($key,$value,$postfilter);
}
foreach($_COOKIE as $key=>$value){
	StopAttack($key,$value,$cookiefilter);
}
foreach($referer as $key=>$value){
	StopAttack($key,$value,$getfilter);
}

function arr_foreach($arr) {
	static $str;
	if (!is_array($arr)) {
		return $arr;
	}
	foreach ($arr as $key => $val ) {

		if (is_array($val)) {

			arr_foreach($val);
		} else {

			$str[] = $val;
		}
	}
	return implode($str);
}
?>