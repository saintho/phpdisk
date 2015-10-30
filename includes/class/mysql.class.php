<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: mysql.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class cls_mysql{

	var $_l;

	var $querycount = 0;

	function connect($dbhost, $dbusr, $dbpwd, $dbname = '',$pconnect = 0){
		global $configs;
		$charset_arr = array('gbk' => 'gbk','utf-8' => 'utf8');
		$db_charset = $charset_arr[strtolower($configs['charset'])];
		$connmode = $pconnect == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->_l = @$connmode($dbhost, $dbusr, $dbpwd,$pconnect)){
			exit ($this->error ('Can not connect MySQL server!'));
		}

		if($this->version() > '4.1') {
			mysql_query("SET character_set_connection=$db_charset, character_set_results=$db_charset, character_set_client=binary;", $this->_l);
		}else{
			mysql_query("set names $db_charset;",$this->_l);
		}

		if($this->version() > '5.0') {
			mysql_query("SET sql_mode=''" , $this->_l);
		}

		if($dbname){
			if(!mysql_select_db($dbname , $this->_l)){
				exit ($this->error ('Cannot select database!'));
			}
		}
		return $this->_l;
	}

	function select_db($dbname){
		return mysql_select_db($dbname , $this->_l);
	}

	function list_tables($dbname){
		return mysql_list_tables($dbname,$this->_l);
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}

	function query($sql , $type = ''){
		$func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($s = $func($sql , $this->_l)) && $type != 'SILENT'){
			exit ($this->error ($sql));
		}
		//write_file(PHPDISK_ROOT.'system/run.sql',$_SERVER['REQUEST_URI'].'|'.$sql.LF,'ab');
		$this->querycount++;
		return $s;
	}

	function query_unbuffered($sql) {
		$s = $this->query($sql, 'UNBUFFERED');
		return $s;
	}

	function fetch_one_array($sql) {
		$result = $this->query($sql);
		$record = $this->fetch_array($result);
		return $record;
	}

	function fetch_array($s, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($s, $result_type);
	}

	function affected_rows() {
		return mysql_affected_rows($this->_l);
	}

	function num_rows($s) {
		return mysql_num_rows($s);
	}

	function num_fields($s)	{
		return mysql_num_fields($s);
	}

	function result($s, $row) {
		return mysql_result($s, $row);
	}

	function insert_id() {
		return mysql_insert_id($this->_l);
	}

	function fetch_row($s) {
		return mysql_fetch_row($s);
	}

	function escape($s){
		if(function_exists('mysql_real_escape_string')){
			return htmlspecialchars(mysql_real_escape_string($s, $this->_l));
		}
		return htmlspecialchars(addslashes($s));
	}

	function sql_array ($arr){
		$ins = array();
		reset($arr);
		while(list($c, $v) = each($arr)){
			$ins[] = ($v === NULL ? sprintf('`%s`=NULL', $c) : sprintf('`%s`=\'%s\'', $c, $v));
		}
		return implode(', ', $ins);
	}

	function ping(){
		global $configs;
		if(!mysql_ping($this->_l)){
			@mysql_close($this->_l);
			$this->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname']);
		}
	}

	function version() {
		return mysql_get_server_info($this->_l);
	}

	function free($q){
		return @mysql_free_result($q);
	}

	function close() {
		return @mysql_close($this->_l);
	}

	function get_error() {
		return mysql_error($this->_l);
	}

	function error ($s){
		global $configs;
		$onlineip = $_SERVER['REMOTE_ADDR'];
		$mysql_error = 'MySQL Info: ' . mysql_error ($this->_l);
		$mysql_errno = 'Error Code: ' . mysql_errno($this->_l);
		$access_str = '<?php exit(); ?>';
		$str = '';
		$str .= $mysql_error.LF;
		$str .= $mysql_errno.LF;
		$str .= 'Query: ' .$s.LF;
		$str .= 'Time: '.date("Y-m-d H:i:s").LF;
		$str .= 'IP: '.$onlineip.LF;
		$str .= $_SERVER['HTTP_HOST'].'|'.$_SERVER['REQUEST_URI'].LF;
		$str .= "-------------------------".LF;
		$log_file = PHPDISK_ROOT.'/system/db_log.php';

		if(file_exists($log_file)){
			$fp = @fopen($log_file,"a+");
			$fsize = @filesize($log_file);
			$content = @fread($fp, $fsize);
			@fclose($fp);
		}

		if(strpos($content,$access_str) ===false){
			$str = $access_str.LF.$str;
		}
		$fp = @fopen($log_file,'a+');
		if (!$fp) {
			exit("Can not open file <b>$log_file</b> .");
		}
		if(is_writable($log_file)){
			if(!fwrite($fp,$str)){
				exit("Can not write file <b>$log_file</b> .");
			}
		}else{
			exit("Can not write file <b>$log_file</b> .");
		}
		@fclose($fp);
		if($configs[debug]){
			$msg = $s;
		}else{
			$msg = PHPDISK_EDITION.'-'.PHPDISK_VERSION.'-db-error';
		}

		$rtn = '<div style="background:#F8F8F8;padding:3px;font-size:12px">';
		$rtn .= '<p><a href="http://faq.google.com/search?w='.$msg.'" target="_blank">[<span style="color:#FF0000;">PHPDisk DB Connect error!</span>]&nbsp;'.$msg.'</a><br><br>';
		$rtn .= '</p></div>';
		return $rtn;
	}
	// add for phpwind
	function get_one($sql, $result_type = MYSQL_ASSOC){
		$result = $this->query($sql);
		$record = $this->fetch_array($result, $result_type);
		return $record;
	}
	function get_value($sql, $result_type = MYSQL_NUM, $field = 0){
		$result_set = $this->query($sql);
		$rt =& $this->fetch_array($result_set, $result_type);
		return isset($rt[$field]) ? $rt[$field] : false;
	}
}

?>