<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: admin.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
phpdisk_core::admin_login();

switch($action){

	case 'uc':

		require PHPDISK_ROOT.'system/configs.inc.php';
		if($task =='update'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'connect_uc' => 0,
			'uc_charset' => '',
			'uc_dbcharset' => '',
			'uc_admin' => '',
			'uc_dbhost' => '',
			'uc_dbuser' => '',
			'uc_dbpwd' => '',
			'uc_dbname' => '',
			'uc_dbtablepre' => '',
			'uc_key' => '',
			'uc_api' => '',
			'uc_appid' => 0,
			);
			$tmp_uc_dbpwd = $settings['uc_dbpwd'];
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(!trim($settings['uc_dbhost'])){
				$error = true;
				$sysmsg[] = __('uc_dbhost_error');
			}
			if(!trim($settings['uc_dbuser'])){
				$error = true;
				$sysmsg[] = __('uc_dbuser_error');
			}
			if(strpos($settings['uc_dbpwd'],'*') ===false){
				if(!$settings['uc_dbpwd']){
					$error = true;
					$sysmsg[] = __('uc_dbpwd_error');
				}
			}else{
				$settings['uc_dbpwd'] = $tmp_uc_dbpwd;
			}
			if(!trim($settings['uc_dbname'])){
				$error = true;
				$sysmsg[] = __('uc_dbname_error');
			}
			if(!trim($settings['uc_dbtablepre'])){
				$error = true;
				$sysmsg[] = __('uc_dbtablepre_error');
			}
			if(!trim($settings['uc_key'])){
				$error = true;
				$sysmsg[] = __('uc_key_error');
			}
			if(!trim($settings['uc_api'])){
				$error = true;
				$sysmsg[] = __('uc_api_error');
			}
			if(!$settings['uc_appid']){
				$error = true;
				$sysmsg[] = __('uc_appid_error');
			}

			if($settings['connect_uc'] && !$error){
				$dbuc = new cls_mysql;
				$dbuc->connect($settings['uc_dbhost'],$settings['uc_dbuser'],$settings['uc_dbpwd'],$settings['uc_dbname'],$settings['uc_pconnect']);

				$username = @$dbuc->result_first("select username from `{$settings['uc_dbname']}`.{$settings['uc_dbtablepre']}members where username='{$settings['uc_admin']}' limit 1");
				if($q){
					$dbuc->free($q);
				}
				$dbuc->close();

				if(!$username){
					$error = true;
					$sysmsg[] = __('uc_admin_error');
				}
			}

			if(!$error){

				$charset_arr = array('gbk' => 'gbk','utf-8' => 'utf8');
				$settings['uc_dbcharset'] = $charset_arr[strtolower($settings['uc_charset'])];

				settings_cache($settings);

				$str = "<?php".LF.LF;
				$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
				$str .= "// Cache Time: ".date("Y-m-d H:i:s",$timestamp).LF.LF;
				$str .= "define('UC_CONNECT', 'mysql');".LF;
				$str .= "define('UC_DBHOST', '{$settings['uc_dbhost']}');".LF;
				$str .= "define('UC_DBUSER', '{$settings['uc_dbuser']}');".LF;
				$str .= "define('UC_DBPW', '{$settings['uc_dbpwd']}');".LF;
				$str .= "define('UC_DBNAME', '{$settings['uc_dbname']}');".LF;
				$str .= "define('UC_DBCHARSET', '{$settings['uc_dbcharset']}');".LF;
				$str .= "define('UC_DBTABLEPRE', '`{$settings['uc_dbname']}`.{$settings['uc_dbtablepre']}');".LF;
				$str .= "define('UC_DBCONNECT', '0');".LF;
				$str .= "define('UC_KEY', '{$settings['uc_key']}');".LF;
				$str .= "define('UC_API', '{$settings['uc_api']}');".LF;
				$str .= "define('UC_CHARSET', '{$settings['uc_charset']}');".LF;
				$str .= "define('UC_IP', '');".LF;
				$str .= "define('UC_APPID', '{$settings['uc_appid']}');".LF;
				$str .= "define('UC_PPP', '20');".LF.LF;
				$str .= "?>".LF;

				write_file(PD_PLUGINS_DIR.'api/uc_configs.inc.php',$str);

				if($settings['connect_uc'] && $username){
					$db->query_unbuffered("update `{$configs['dbname']}`.{$tpf}users set username='$username' where userid=1 and gid=1;");
				}

				$sysmsg[] = __('uc_update_success');
				redirect(urr(ADMINCP,"item=plugins&app=$app&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			$setting['connect_uc'] = $settings['connect_uc'] ? 1 : 0;
			$setting['connect_uc_type'] = $settings['connect_uc_type'] ? $settings['connect_uc_type'] : 'discuz';
			$setting['uc_charset'] = $settings['uc_charset'] ? $settings['uc_charset'] : $configs['charset'];
			$setting['uc_admin'] = $settings['uc_admin'] ? $settings['uc_admin'] : '';
			$setting['uc_dbhost'] = $settings['uc_dbhost'] ? $settings['uc_dbhost'] : '';
			$setting['uc_dbuser'] = $settings['uc_dbuser'] ? $settings['uc_dbuser'] : '';
			$setting['uc_dbpwd'] = $settings['uc_dbpwd'] ? encode_pwd($settings['uc_dbpwd']) : '';
			$setting['uc_dbname'] = $settings['uc_dbname'] ? $settings['uc_dbname'] : '';
			$setting['uc_dbtablepre'] = $settings['uc_dbtablepre'] ? $settings['uc_dbtablepre'] : "uc_";
			$setting['uc_key'] = $settings['uc_key'] ? $settings['uc_key'] : random(16);
			$setting['uc_api'] = $settings['uc_api'] ? $settings['uc_api'] : 'http://';
			$setting['uc_appid'] = $settings['uc_appid'] ? $settings['uc_appid'] : 0;
			$setting['uc_feed'] = $settings['uc_feed'] ? 1 : 0;
			$setting['uc_credit_exchange'] = $settings['uc_credit_exchange'] ? 1 : 0;

			require_once template_echo('admin','',$app);
		}
		break;
	default:
		redirect(urr(ADMINCP,"item=plugins&app=$app&action=uc"),'',0);
}
update_action_time($app);
?>