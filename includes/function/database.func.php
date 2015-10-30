<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: database.func.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

if(!function_exists('file_put_contents')){
	function file_put_contents($file, $string, $append = ''){
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}

function cache_read($file, $mode = 'i'){
	$cachefile = PHPDISK_ROOT.'system/data/'.$file;
	if(!file_exists($cachefile)) return array();
	return $mode == 'i' ? include $cachefile : file_get_contents($cachefile);
}

function cache_write($file, $string, $type = 'array'){
	if(is_array($string)){
		$type = strtolower($type);
		if($type == 'array'){
			$string = "<?php\n return ".var_export($string,TRUE).";\n?>";
		}elseif($type == 'constant'){
			$data='';
			foreach($string as $key => $value) $data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			$string = "<?php\n".$data."\n?>";
		}
	}
	file_put_contents(PHPDISK_ROOT.'system/data/'.$file, $string);
}

function cache_delete($file){
	return @unlink(PHPDISK_ROOT.'system/data/'.$file);
}

function sql_dumptable($table, $startfrom = 0, $currsize = 0){
	global $db, $sizelimit, $startrow;

	if(!isset($tabledump)) $tabledump = '';
	$offset = 100;
	if(!$startfrom){
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_row($createtable);
		$tabledump .= $create[1].";\n\n";
	}

	$tabledumped = 0;
	$numrows = $offset;
	while($currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset){
		$tabledumped = 1;
		$rows = $db->query("SELECT * FROM $table LIMIT $startfrom, $offset");
		$numfields = $db->num_fields($rows);
		$numrows = $db->num_rows($rows);
		while ($row = $db->fetch_row($rows)){
			$comma = "";
			$tabledump .= "INSERT INTO $table VALUES(";
			for($i = 0; $i < $numfields; $i++){
				$tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
				$comma = ",";
			}
			$tabledump .= ");\n";
		}
		$startfrom += $offset;
	}
	$startrow = $startfrom;
	$tabledump .= "\n";
	return $tabledump;
}

function sql_execute($sql){
	global $db;
    $sqls = sql_split($sql);
	if(is_array($sqls)){
		foreach($sqls as $sql){
			if(trim($sql) != ''){
				$db->query($sql);
			}
		}
	}else{
		$db->query($sqls);
	}
	return true;
}

function sql_split($sql){
	global $db;
	if($db->version() > '4.1'){
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=utf8",$sql);
	}
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	
	foreach($queriesarray as $query){
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		
		foreach($queries as $query){
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return($ret);
}

?>