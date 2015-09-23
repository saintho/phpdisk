<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: logger.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class logger {

	function logger() {

	}
	function read($f) {
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
	// $log_type ()
	function write($log_type,$str) {
		$log_arr = array('cache_log','db_log');
		if(in_array($log_type,$log_arr)){
			$log_dir = PHPDISK_ROOT."system/$log_type/";
			$log_file = $log_dir.date('Ymd').'.php';
			make_dir($log_dir);
			$str = '<?php exit; ?>'.$str.LF;			
			$fp = fopen($log_file,'ab');
			if (!$fp) {
				die("Logger: Can not open file <b>$log_type</b> .code:1");
			}
			if(is_writable($log_file)){
				if(!fwrite($fp,$str)){
					die("Logger: Can not write file <b>$log_type</b> .code:2");
				}
			}else{
				die("Logger: Can not write file <b>$log_type</b> .code:3");
			}
			fclose($fp);
		}else{
			die("Logger: Logger write error!");
		}

	}
}
?>