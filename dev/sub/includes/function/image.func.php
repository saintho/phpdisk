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

function make_thumb($srcFile,$toFile="",$toW,$toH){
	$toW = $toW ? (int)$toW : 240;
	$toH = $toH ? (int)$toH : 180;
	if($toFile==""){ $toFile = $srcFile; }
	$info = "";
	$arr = getimagesize($srcFile,$info);
	switch ($arr[2]){
		case 1:
			if(!function_exists("imagecreatefromgif")){
				exit("function [imagecreatefromgif] not exists!");
			}
			$src_file = imagecreatefromgif($srcFile);
			break;
		case 2:
			if(!function_exists("imagecreatefromjpeg")){
				exit("function [imagecreatefromjpeg] not exists!");
			}
			$src_file = imagecreatefromjpeg($srcFile);
			break;
		case 3:
			if(!function_exists("imagecreatefrompng")){
				exit("function [imagecreatefrompng] not exists!");
			}
			$src_file = imagecreatefrompng($srcFile);
			break;
		case 6:
			if(!function_exists("imagecreatefromwbmp")){
				exit("function [imagecreatefromwbmp] not exists!");
			}
			$src_file = imagecreatefromwbmp($srcFile);
			break;
		default:

	}
	$srcW = imagesx($src_file);
	$srcH = imagesy($src_file);
	$toWH = $toW/$toH;
	$srcWH = $srcW/$srcH;
	if($toWH <= $srcWH){
		$ftoW = $toW;
		$ftoH = $ftoW*($srcH/$srcW);
	}else{
		$ftoH = $toH;
		$ftoW = $ftoH*($srcW/$srcH);
	}
	if($srcW>$toW || $srcH>$toH){
		if(function_exists("imagecreatetruecolor")){
			@$dest_file = imagecreatetruecolor($ftoW,$ftoH);
			if($dest_file){
				imagecopyresampled($dest_file,$src_file,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}else{
				$dest_file = imagecreate($ftoW,$ftoH);
				imagecopyresized($dest_file,$src_file,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
		}else{
			$dest_file = imagecreate($ftoW,$ftoH);
			imagecopyresized($dest_file,$src_file,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
		}
		switch ($arr[2]){
			case 1:
				if(!function_exists('imagegif')){
					exit("function [imagegif] not exists!");
				}
				imagegif($dest_file,$toFile);
				break;
			case 2:
				if(!function_exists('imagejpeg')){
					exit("function [imagejpeg] not exists!");
				}
				imagejpeg($dest_file,$toFile);
				break;
			case 3:
				if(!function_exists('imagepng')){
					exit("function [imagepng] not exists!");
				}
				imagepng($dest_file,$toFile);
				break;
			case 6:
				if(!function_exists('imagewbmp')){
					exit("function [imagewbmp] not exists!");
				}
				imagewbmp($dest_file,$toFile);
				break;
			default:
		}
		@imagedestroy($dest_file);
	}
	@imagedestroy($src_file);
}

?>