<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: uc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

define('IN_DISCUZ', TRUE);
define('IN_PHPDISK',TRUE);
define('UC_CLIENT_VERSION', '1.5.0');
define('UC_CLIENT_RELEASE', '20090121');

define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_GETTAG', 1);
define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_GETCREDIT', 1);
define('API_UPDATECREDITSETTINGS', 1);

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');


define('PHPDISK_ROOT', substr(dirname(__FILE__), 0, -3));
define('CURR_PLUGIN_DIR', substr(dirname(__FILE__), 0, -3).'plugins/api/');

if(!defined('IN_UC')) {

	error_reporting(0);
	set_magic_quotes_runtime(0);

	defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	require_once PHPDISK_ROOT.'./system/configs.inc.php';
	require_once CURR_PLUGIN_DIR.'./uc_configs.inc.php';
	require_once PHPDISK_ROOT.'./system/settings.inc.php';
	require_once PHPDISK_ROOT.'./includes/class/mysql.class.php';

	$_DCACHE = $get = $post = array();

	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
	if(MAGIC_QUOTES_GPC) {
		$get = _stripslashes($get);
	}

	$timestamp = time();
	if(empty($get)) {
		exit('Invalid Request');
	} elseif($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	}
	$action = $get['action'];

	require_once CURR_PLUGIN_DIR.'./uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings'))) {
	
		$GLOBALS['db'] = new cls_mysql;
		$GLOBALS['db']->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
		$GLOBALS['tpf'] = $configs['tpf'];	
		unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
		$uc_note = new uc_note();
		exit($uc_note->$get['action']($get, $post));
	} else {
		exit(API_RETURN_FAILED);
	}

} else {

	define('PHPDISK_ROOT', $app['extra']['apppath']);
	require_once PHPDISK_ROOT.'./system/configs.inc.php';
	require_once CURR_PLUGIN_DIR.'./uc_configs.inc.php';
	require_once PHPDISK_ROOT.'./system/settings.inc.php';
	require_once PHPDISK_ROOT.'./includes/class/mysql.class.php';
	$GLOBALS['db'] = new cls_mysql;
	$GLOBALS['db']->connect($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['dbname'],$configs['pconnect']);
	$GLOBALS['tpf'] = $configs['tpf'];	
	unset($configs['dbhost'],$configs['dbuser'],$configs['dbpasswd'],$configs['pconnect']);
}

class uc_note {

	var $db = '';
	var $tpf = '';
	var $appdir = '';

	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once CURR_PLUGIN_DIR.'./uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function uc_note() {
		$this->appdir = CURR_PLUGIN_DIR;
		$this->db = $GLOBALS['db'];
		$this->tpf = $GLOBALS['tpf'];
	}

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}

	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
		$query = $this->db->query("DELETE FROM ".$this->tpf."users WHERE userid IN ($uids)");
		return API_RETURN_SUCCEED;
	}
	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}
		$this->db->query("UPDATE ".$this->tpf."users SET username='$usernamenew' WHERE username='$usernameold' and userid='$uid'");
		return API_RETURN_SUCCEED;
	}
	function gettag($get, $post) {
		return API_RETURN_FORBIDDEN;
	}
	function synlogin($get, $post) {
		$uid = (int)$get['uid'];
		$username = trim($get['username']);
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		$cookietime = 2592000;
		$timestamp = time();
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

		$query = $this->db->query("SELECT userid,gid,username,password,email FROM ".$this->tpf."users WHERE username='$username'");
		if($member = $this->db->fetch_array($query)) {
			$userid = (int)$member['userid'];
			$gid = (int)$member['gid'];
			$username = trim($member['username']);
			$password = trim($member['password']);
			$email = trim($member['email']);
			pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"),$cookietime);
		} else {
			require_once CURR_PLUGIN_DIR.'./uc_client/client.php';
			$data = uc_get_user($username);
			list($uid, $username, $email) = $data;
			$password = md5($data[1]);
			$gid = 4;
			$ip = addslashes($_SERVER['REMOTE_ADDR']);
			$this->db->query("insert into ".$this->tpf."users SET userid='{$data[0]}',username='{$data[1]}',password='{$password}',email='{$data[2]}',gid='$gid',is_activated='1',reg_time='$timestamp',reg_ip='$ip'");
			pd_setcookie('phpdisk_zcore_info',pd_encode("$data[0]\t$gid\t$data[1]\t$password\t$data[2]"),$cookietime);
		}
	}
	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		pd_setcookie('phpdisk_zcore_info', '', -86400 * 365);
	}

	function updatepw($get, $post) {
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		$username = $get['username'];
		$password = md5($get['password']);
		$this->db->query("UPDATE ".$this->tpf."users SET password='$password' WHERE username='$username'");
		return API_RETURN_SUCCEED;
	}

	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/badwords.php';
		$fp = fopen($cachefile, 'w');
		$data = array();
		if(is_array($post)) {
			foreach($post as $k => $v) {
				$data['findpattern'][$k] = $v['findpattern'];
				$data['replace'][$k] = $v['replacement'];
			}
		}
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'badwords\'] = '.var_export($data, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
		global $_DCACHE;
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];

		if(empty($post) || empty($UC_API)) {
			return API_RETURN_SUCCEED;
		}

		$cachefile = $this->appdir.'./uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		if(is_writeable($this->appdir.'./config.inc.php')) {
			$configfile = trim(file_get_contents($this->appdir.'./config.inc.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if($fp = @fopen($this->appdir.'./config.inc.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			}
		}

		global $_DCACHE;
		require_once $this->appdir.'./forumdata/cache/cache_settings.php';
		require_once $this->appdir.'./include/cache.func.php';
		foreach($post as $appid => $app) {
			$_DCACHE['settings']['ucapp'][$appid]['viewprourl'] = $app['url'].$app['viewprourl'];
		}
		updatesettings();

		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		$this->db->query("update ".$this->tpf."users set credit=credit+'$amount' where userid='$uid'");
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}

		$uid = intval($get['uid']);
		$credit = intval($get['credit']);
		return (int)$this->db->result_first("SELECT credit FROM ".$this->tpf."users WHERE userid='$uid'");
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
        $credits = array();
        $credits[] = array('积分', '');
		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
		
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
	
		$outextcredits = array();
	
		foreach($get['credit'] as $appid => $credititems) {
			if($appid == UC_APPID) {
				foreach($credititems as $value) {
					$outextcredits[$value['appiddesc'].'|'.$value['creditdesc']] = array(
						'creditsrc' => $value['creditsrc'],
						'title' => $value['title'],
						'unit' => $value['unit'],
						'ratio' => $value['ratio']
					);
				}
			}
		}
	
		$cachefile = CURR_PLUGIN_DIR.'./creditsettings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n\r\n";
		$s .= "// This is PHPDISK auto-generated file. Do NOT modify me.\r\n";
		$s .= "// Cache Time: ".date("Y-m-d H:i:s")."\r\n\r\n";
		$s .= '$_CACHE[\'creditsettings\'] = '.var_export($outextcredits, TRUE).";\r\n";
		$s .= "\r\n?>";
		fwrite($fp, $s);
		fclose($fp);
	
		return API_RETURN_SUCCEED;
	}
}
function pd_setcookie($var, $value, $expires = 0,$cookiepath = '/', $cookiedomain = '') {
	global $timestamp, $_SERVER;
	setcookie($var, $value,$expires ? ($timestamp + $expires) : 0,$cookiepath,$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function pd_encode($txt, $operation = 'ENCODE',$key = 'PHPDisk=Rc9o'){
	global $settings;
	$key = $settings['encrypt_key'] ? $settings['encrypt_key'] : $key;
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
function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}
function _setcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
?>