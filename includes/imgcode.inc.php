<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: imgcode.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
session_start();
$verycode_type = (int)$_GET['verycode_type'];
$nosess = (int)$_GET['nosess'];

switch($verycode_type){
	case 2:
		$code_length = 4;
		$w = 58;
		$h = 22;
		$fontsize = 12;
		$seed_str = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$_verycode = "";

		$im = imagecreate($w, $h);

		$bgcolor = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $bgcolor);

		$bordercolor = imagecolorallocate($im, 150, 150, 150);
		imagerectangle($im, 0, 0, $w-1, $h-1, $bordercolor);
		
			$lineColor1 = imagecolorallocate($im, mt_rand(174,218),mt_rand(190,225),mt_rand(217,237));
			for($j=1;$j<=2;$j=$j+3){
				for($ii=0;$ii<10;$ii++){
					imageline($im,0,$j+mt_rand(1,30),80,$j+mt_rand(1,30),$lineColor1);
				}
			}
			
		for($i=0; $i<$code_length; $i++){
			$temp = mt_rand(0, strlen($seed_str)-1);
			$code = substr($seed_str, $temp, 1);
			$j = !$i ? 4 : $j+12;
			$color3 = imagecolorallocate($im, mt_rand(0,255),mt_rand(0,120),mt_rand(0,100));
			imagettftext($im, $fontsize, 0, $j, 15, $color3,'fonts/lsansdi.ttf',$code);
			$_verycode .= $code;
		}

		if(!$nosess){
			$_SESSION['_verycode'] = $_verycode;
		}
		ob_end_clean();
		header("Pragma:no-cache");
		header("Cache-Control:no-cache");
		header("Expires:0");

		if(function_exists("imagepng")){
			header("content-type:image/png");
			imagepng($im);
		}elseif(function_exists("imagegif")){
			header("content-type:image/gif");
			imagepng($im);
		}else{
			header("content-type:image/jpeg");
			imagejpeg($im);
		}
		imagedestroy($im);		
		break;
	case 1:	
	default:
		$code_length = 4;
		$w = 58;
		$h = 22;
		$fontsize = 12;
		$seed_str = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$_verycode = "";

		$im = imagecreate($w, $h);

		$bgcolor = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $bgcolor);

		$bordercolor = imagecolorallocate($im, 150, 150, 150);
		imagerectangle($im, 0, 0, $w-1, $h-1, $bordercolor);
		
		for($i=0; $i<$code_length; $i++){
			$temp = mt_rand(0, strlen($seed_str)-1);
			$code = substr($seed_str, $temp, 1);
			$j = !$i ? 4 : $j+12;
			$color3 = imagecolorallocate($im, mt_rand(0,125),mt_rand(0,100),mt_rand(0,100));
			imagettftext($im, $fontsize, 0, $j, 15, $color3,'fonts/consolas.ttf',$code);
			$_verycode .= $code;
		}

		for($i=0; $i<$code_length*40; $i++){
			$color2 = imagecolorallocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
			imagesetpixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2);
		}
		if(!$nosess){
			$_SESSION['_verycode'] = $_verycode;
		}
		ob_end_clean();
		header("Pragma:no-cache");
		header("Cache-Control:no-cache");
		header("Expires:0");

		if(function_exists("imagepng")){
			header("content-type:image/png");
			imagepng($im);
		}elseif(function_exists("imagegif")){
			header("content-type:image/gif");
			imagepng($im);
		}else{
			header("content-type:image/jpeg");
			imagejpeg($im);
		}
		imagedestroy($im);
}
?>