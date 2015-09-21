<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: account.php 125 2014-03-05 13:10:19Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

$in_front = true;

$tit_arr = array(
'relogin'=>__('account_login'),
'login'=>__('account_login'),
'adminlogin'=>__('account_adminlogin'),
'register'=>__('account_register'),
'forget_pwd'=>__('account_forget_pwd'),
'reset_pwd'=>__('account_reset_pwd'),
'logout'=>__('account_logout'),
'demologin'=>__('account_demologin'),
);

$title = $tit_arr[$action].' - '.$settings[site_title];

include PHPDISK_ROOT.'includes/header.inc.php';

switch($action){
	case 'relogin':
	case 'login':
	case 'fastlogin':
		if($task =='login'){

			form_auth(gpc('formhash','P',''),formhash());

			$username = $username_pd = gpc('username','P','');
			$password = $password_pd = gpc('password','P','');
			$md5_pwd = md5($password);
			$remember = (int)gpc('remember','P',0);
			$verycode = trim(gpc('verycode','P',''));
			$ref = trim(gpc('ref','P',''));

			if(checklength($username,2,60)){
				$error = true;
				$sysmsg[] = __('invalid_username');
			}
			if(checklength($password,6,20)){
				$error = true;
				$sysmsg[] = __('invalid_password');
			}
			if($action<>'fastlogin' && $settings['login_verycode'] && $settings['open_verycode']){
				if (!$verycode || strtolower($verycode) != strtolower($_SESSION['_verycode'])) {
					unset($_SESSION['_verycode']);
					$error = true;
					$sysmsg[] = __('invalid_verycode');
				}
			}

			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					$user_login = uc_user_login($username,$md5_pwd,0);
					$ucsynlogin = $user_login['synlogin'];
				}else{
					list($uid, $username, $password, $email) = uc_user_login($username, $password);
					if($uid > 0){
						$ucsynlogin = uc_user_synlogin($uid);
						if(trim($username)){
							$rs = $db->fetch_one_array("select username from {$tpf}users where username='$username' limit 1");
							if(!$rs){
								$gid = 4;
								$ins = array(
								'username' => $username,
								'password' => $md5_pwd,
								'email' => $email,
								'gid' => $gid,
								'reg_time' => $timestamp,
								'reg_ip' => $onlineip,
								);
								$db->query("insert into {$tpf}users set ".$db->sql_array($ins).";");
								$userid = $db->insert_id();
							}
							unset($rs);
						}
						if(!@$db->result_first("select count(*) from {$tpf}users where username='$username' and password='$md5_pwd' limit 1")){
							$db->query_unbuffered("update {$tpf}users set password='$md5_pwd',email='$email' where username='$username' limit 1");
						}
					}elseif($uid ==-1){
						$email = @$db->result_first("select email from {$tpf}users where username='$username_pd' limit 1");
						if($email){
							$uid = uc_user_register($username_pd , $password_pd , $email);
							if($uid<=0){
								$error = true;
								$sysmsg[] = 'UC:'.__('invalid_username');
							}
						}else{
							$error = true;
							$sysmsg[] = 'UC:'.__('user_already_delete');
						}
					}elseif($uid ==-2){
						$error = true;
						$sysmsg[] = __('password_is_error');
					}
				}
			}

			$rs = $db->fetch_one_array("select userid,gid,username,password,email,is_locked from {$tpf}users where username='$username' limit 1");
			if(!$rs){
				$error = true;
				$sysmsg[] = __('user_not_exists');
			}else{
				if($md5_pwd != $rs['password']){
					$error = true;
					$sysmsg[] = __('user_password_false');
				}elseif($rs['is_locked']){
					$error = true;
					$sysmsg[] = __('user_is_locked');
				}else{
					$userid = (int)$rs['userid'];
					$gid = (int)$rs['gid'];
					$username = trim($rs['username']);
					$password = trim($rs['password']);
					$email = trim($rs['email']);
				}
			}
			if(!$settings['allow_access'] && $gid !=1){
				$error = true;
				$sysmsg[] = __('admin_not_valid');
			}
			if(!$error){

				$credit = $settings['credit_open'] ? (int)$settings['credit_login'] : 0;
				$sql_do = $credit ? ", credit=credit+{$credit}" : "";
				$exp_login = (int)$settings['exp_login'];
				$db->query_unbuffered("update {$tpf}users set last_login_ip='$onlineip',last_login_time='$timestamp',exp=exp+$exp_login {$sql_do} where userid='$userid'");
				if($settings['create_default_folder']){
					$num = @$db->result_first("select count(*) from {$tpf}folders where userid='$userid'");
					if(!$num){
						$ins = array(
						'folder_node' => 1,
						'folder_name' => trim($settings['create_default_folder']),
						'userid' => $userid,
						'in_time' => $timestamp,
						);
						$db->query_unbuffered("insert into {$tpf}folders set ".$db->sql_array($ins).";");
					}
				}
				if(!get_profile($userid,'plan_id')){
					$plan_id = (int)@$db->result_first("select plan_id from {$tpf}plans where is_default=1 limit 1");
					if($plan_id){
						$db->query_unbuffered("update {$tpf}users set plan_id='$plan_id' where userid='$userid' limit 1");
					}
				}
				if($remember){
					pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"),86400*30);
				}else{
					pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"));
				}
				if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
					echo $ucsynlogin;
				}
				$login_success = 1;
				$sysmsg[] = __('login_success');
				redirect($ref ? $ref : urr("mydisk",""),$sysmsg,3000,'top');
			}
		}else{
			if(!$settings['allow_access']){
				$sysmsg[] = __('close_access');
			}
			$user_title = __('user_login');
			$ref = trim(gpc('ref','G',''));
			$ref = $ref ? $ref : $_SERVER['HTTP_REFERER'];
		}
		require_once template_echo('pd_account',$user_tpl_dir);

		break;

	case 'adminlogin':

		$username = $pd_username;
		if($task =='adminlogin'){

			form_auth(gpc('formhash','P',''),formhash());

			$username = gpc('username','P','');
			$password = gpc('password','P','');
			$verycode = trim(gpc('verycode','P',''));
			$md5_pwd = md5($password);

			if(checklength($username,2,60)){
				$error = true;
				$sysmsg[] = __('invalid_username');
			}
			if(checklength($password,6,50)){
				$error = true;
				$sysmsg[] = __('invalid_password');
			}
			if (!$verycode || strtolower($verycode) != strtolower($_SESSION['_verycode'])) {
				unset($_SESSION['_verycode']);
				$error = true;
				$sysmsg[] = __('invalid_verycode');
			}
			$rs = $db->fetch_one_array("select userid,gid,username,password,email from {$tpf}users where username='$username' limit 1");
			if(!$rs){
				$error = true;
				$sysmsg[] = __('user_not_exists');
			}else{
				$userid = (int)$rs['userid'];
				$admins_pwd = @$db->result_first("select password from {$tpf}admins where userid='$userid'");
				if($admins_pwd){
					if($admins_pwd!=$md5_pwd){
						$error = true;
						$sysmsg[] = __('admins_pwd_valid_error');
					}else{
						$gid = (int)$rs['gid'];
						$username = trim($rs['username']);
						$password = trim($rs['password']);
						$email = trim($rs['email']);
					}
				}else{
					// is super admin
					if(super_admin()){
						$gid = (int)$rs['gid'];
						$username = trim($rs['username']);
						$password = trim($rs['password']);
						$email = trim($rs['email']);
					}else{
						$error = true;
						$sysmsg[] = __('not_admin_error');
					}
				}
			}
			if($gid==1){
				if($adminset[admin_login_ip]){
					$arr = explode(',',$adminset[admin_login_ip]);
					if(!in_array($onlineip,$arr)){
						$error = true;
						$sysmsg[] = __('not_site_master');
					}
				}
			}
			if(!$error && $gid ==1 && $pd_uid){
				$pd_sid = random(8);
				$_SESSION['pd_sid'] = $pd_sid;
				$ins = array(
				'userid' => $pd_uid,
				'login_time' => $timestamp,
				'hashcode' => $pd_sid,
				'ip' => $onlineip,
				);
				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}adminsession where userid='$pd_uid'");
				if($rs['total'] ==0){
					$db->query("replace into {$tpf}adminsession set ".$db->sql_array($ins).";");
				}else{
					$db->query("update {$tpf}adminsession set ".$db->sql_array($ins)." where userid='$pd_uid' and $timestamp-login_time >10");
				}
				unset($rs);

				redirect(urr(ADMINCP,""),'',0);
			}else{
				if(!count($sysmsg)){
					$sysmsg[] = __('admin_not_valid');
				}
			}
		}
		$user_title = __('admin_login');
		require_once template_echo('pd_account',$user_tpl_dir);
		break;

	case 'register':
		if($task == 'register'){

			form_auth(gpc('formhash','P',''),formhash());

			$username = trim(gpc('username','P',''));
			$password = trim(gpc('password','P',''));
			$confirm_password = trim(gpc('confirm_password','P',''));
			$email = trim(gpc('email','P',''));
			$qq = trim(gpc('qq','P',''));
			$buddy_name = trim(gpc('buddy_name','P',''));
			$verycode = trim(gpc('verycode','P',''));
			$invite_uid = (int)gpc('invite_uid','P',0);

			if($buddy_name){
				$tmp_uid = (int)$db->result_first("select userid from {$tpf}users where username='$buddy_name' limit 1");
				$invite_uid = $tmp_uid ? $tmp_uid : $invite_uid;
			}
			if($pd_uid){
				$error = true;
				$sysmsg[] = __('user_already_register');
			}
			if(checklength($username,2,60)){
				$error = true;
				$sysmsg[] = __('username_length_error');
			}elseif(is_bad_chars($username)){
				$error = true;
				$sysmsg[] = __('username_has_bad_chars');
			}else{
				$rs = $db->fetch_one_array("select username from {$tpf}users where username='$username' limit 1");
				if($rs){
					if(strcasecmp($username,$rs['username']) ==0){
						$error = true;
						$sysmsg[] = __('username_already_exists');
					}
				}
				unset($rs);
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					$checkuser = uc_check_username($username);
					if($checkuser<>1){
						$error = true;
						$sysmsg[] = 'UC:'.__('invalid_username');
					}
				}else{
					$ucresult = uc_user_checkname($username);
					if($ucresult <0) {
						$error = true;
						$sysmsg[] = 'UC:'.__('username_already_exists');
					}
				}
			}
			if(checklength($password,6,20)){
				$error = true;
				$sysmsg[] = __('invalid_password');
			}else{
				if($password == $confirm_password){
					$md5_pwd = md5($password);
				}else{
					$error = true;
					$sysmsg[] = __('confirm_password_invalid');
				}
			}
			if(!checkemail($email)){
				$error = true;
				$sysmsg[] = __('invalid_email');
			}else{
				$rs = $db->fetch_one_array("select email from {$tpf}users where email='$email' limit 1");
				if($rs){
					if(strcasecmp($email,$rs['email']) ==0){
						$error = true;
						$sysmsg[] = __('email_already_exists');
					}
					unset($rs);
				}
			}
			if($qq && !is_numeric($qq)){
				$error = true;
				$sysmsg[] = '联系QQ号码格式错误';
			}

			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					$ucresult = uc_check_email($email);
					if($ucresult <>1){
						$error = true;
						$sysmsg[] = 'UC:'.__('email_already_exists');
					}
				}else{
					$ucresult = uc_user_checkemail($email);
					if($ucresult <0){
						$error = true;
						$sysmsg[] = 'UC:'.__('email_already_exists');
					}
				}
			}
			if($settings['register_verycode'] && $settings['open_verycode']){
				if (!$verycode || strtolower($verycode) != strtolower($_SESSION['_verycode'])) {
					unset($_SESSION['_verycode']);
					$error = true;
					$sysmsg[] = __('invalid_verycode');
				}
			}
			if(!$error && display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				if($settings['connect_uc_type']=='phpwind'){
					uc_user_register($username,$md5_pwd,$email);
				}else{
					$uid = uc_user_register($username , $password , $email);
					if($uid <= 0){
						$error = true;
						$sysmsg[] = 'UC: '.__('reg_user_error');
					}
				}
			}
			$gid = $settings[default_reg_gid] ? (int)$settings[default_reg_gid] : (int)$db->result_first("select gid from {$tpf}groups order by gid desc limit 1");
			if(!$error){
				$credit = $settings['credit_open'] ? (int)$settings['credit_reg'] : 0;
				$ins = array(
				'username' => $username,
				'password' => $md5_pwd,
				'email' => $email,
				'qq' => $qq,
				'gid' => $gid,
				'credit' => $credit,
				'exp' => (int)$settings['exp_reg'],
				'reg_time' => $timestamp,
				'reg_ip' => $onlineip,
				'space_name' => $username.' '.__('file'),
				'income_pwd'=>$md5_pwd,
				);
				$db->query("insert into {$tpf}users set ".$db->sql_array($ins).";");
				$userid = $db->insert_id();

				if($invite_uid){
					$ins2 = array(
					'userid' => $invite_uid,
					'touserid' => $userid,
					'in_time' => $timestamp,
					);
					$num = @$db->result_first("select count(*) from {$tpf}buddys where userid='$invite_uid' and touserid='$userid'");
					if(!$num){
						$db->query_unbuffered("insert into {$tpf}buddys set ".$db->sql_array($ins2).";");
					}
					$num = @$db->result_first("select count(*) from {$tpf}invitelog where userid='$invite_uid' and touserid='$userid'");
					if(!$num){
						$db->query_unbuffered("insert into {$tpf}invitelog set ".$db->sql_array($ins2).";");
					}
					/*$credit_invite = $settings['credit_open'] ? (int)$settings['credit_invite'] : 0;
					$exp_invite = (int)$settings['exp_invite'];
					$db->query_unbuffered("update {$tpf}users set credit=credit+$credit_invite,exp=exp+$exp_invite where userid='$invite_uid'");*/
				}

				$rs = $db->fetch_one_array("select count(*) as total from {$tpf}users ");
				if($rs){
					$stats['users_count'] = (int)$rs['total'];
					stats_cache($stats);
				}
				unset($rs);
				pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$md5_pwd\t$email"));

				if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
					if($settings['connect_uc_type']=='phpwind'){
						$user_login = uc_user_login($username,$md5_pwd,0);
						$ucsynlogin = $user_login['synlogin'];
					}else{
						list($uid, $username, $password, $email) = uc_user_login($username, $password);
						if($uid > 0) {
							$ucsynlogin = uc_user_synlogin($uid);
						}
					}
					echo $ucsynlogin;
				}
				$sysmsg[] = __('register_success');
				redirect("./",$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}
		}else{
			if(!$settings['allow_register']){
				$sysmsg[] = __('close_register');
				if($settings['close_register_reason']){
					$sysmsg[] = 'Tips: '.$settings['close_register_reason'];
				}
			}
			$register_too_busy =false;
			if($settings[reg_interval]){
				$num = @$db->result_first("select count(*) from {$tpf}users where reg_ip='$onlineip' and $timestamp-reg_time<{$settings[reg_interval]} limit 1");
				if($num){
					$register_too_busy =true;
					$sysmsg[] = __('register_too_busy');
				}
			}
			if($settings['invite_register_encode']){
				$str = $_SERVER['QUERY_STRING'];
				$arr = explode('&',$str);
				parse_str(pd_encode($arr[1],'DECODE'));
			}else{
				$uid = gpc('uid','G',0);
			}
			$invite_uid = (int)$uid;
			if($invite_uid){
				$rs = $db->fetch_one_array("select userid,username from {$tpf}users where userid='$invite_uid' limit 1");
				if($rs){
					$invite_name = $rs['username'];
					$a_space = urr("space","username=".rawurlencode($rs['username']));
				}
				unset($rs);
			}
			$user_title = __('user_register');
			require_once template_echo('pd_account',$user_tpl_dir);
		}

		break;

	case 'forget_pwd':
		if($task =='forget_pwd'){
			form_auth(gpc('formhash','P',''),formhash());

			$username = trim(gpc('username','P',''));
			$verycode = trim(gpc('verycode','P',''));

			if($settings['forget_verycode'] && $settings['open_verycode']){
				if (!$verycode || strtolower($verycode) != strtolower($_SESSION['_verycode'])) {
					unset($_SESSION['_verycode']);
					$error = true;
					$sysmsg[] = __('invalid_verycode');
				}
			}

			if(!$error){
				$rs = $db->fetch_one_array("select * from {$tpf}users where username='$username' limit 1");
				if($rs['userid']){
					if($settings['open_email']){
						$code = pd_encode($rs['userid'].$settings[encrypt_key]);
						$reset_url = $settings['phpdisk_url'].urr("account","action=reset_pwd&code=$code");
						$to = $rs['email'];
						$subject = __('reset_pwd_email');
						$body = __('reset_mail_conent')."<br><br><a href=\"{$reset_url}\">$reset_url</a><br><br><br>".$settings['phpdisk_url']."<br>".$settings['email_user'];
						$from = $sender = $username1 = $settings['email_address'];
						$fromname = $settings['email_user'];
						$host = $settings['email_smtp'];
						$port = (int)$settings['email_port'];
						$ssl = (int)$settings['email_ssl'];
						$password = $settings['email_pwd'];

						send_email($to,$subject,$body,$from,$fromname,$stmp = true, $sender,$host,$port,$ssl,$username1,$password);
						$code = strlen($code)>32 ? substr($code,0,32) : $code;
						$db->query_unbuffered("update {$tpf}users set reset_code='$code' where userid='{$rs['userid']}' limit 1");

						$sysmsg[] = __('confirm_mail_success');

					}else{
						$sysmsg[] = __('confirm_mail_success');
					}

				}else{
					$sysmsg[] = __('user_not_exists');
				}
				unset($rs);
			}else{
				redirect("javascript:history.back()",$sysmsg);
			}
		}
		require_once template_echo('pd_account',$user_tpl_dir);
		break;

	case 'reset_pwd':
		$code = trim(gpc('code','GP',''));
		$code = strlen($code)>32 ? substr($code,0,32) : $code;
		if($task =='reset_pwd'){
			form_auth(gpc('formhash','P',''),formhash());

			$pwd = trim(gpc('pwd','P',''));
			$pwd2 = trim(gpc('pwd2','P',''));
			$userid = (int)gpc('userid','P',0);

			if(checklength($pwd,6,20)){
				$error = true;
				$sysmsg[] = __('user_password_false');
			}
			if($pwd !=$pwd2){
				$error = true;
				$sysmsg[] = __('confirm_pwd_not_same');
			}else{
				$md5_pwd = md5($pwd);
			}
			if(!$userid || !$code){
				$error = true;
				$sysmsg[] = '参数错误';
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}users where reset_code='$code' and userid='$userid'");
				if(!$num){
					$error = true;
					$sysmsg[] = '较验参数不正确';
				}
			}
			if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
				$ucresult = uc_user_edit($pd_username, $pwd, $pwd,'',1);
				if($ucresult < 0) {
					$error = true;
					$sysmsg[] = 'UC:'.__('user_password_false');
				}
			}

			if(!$error){
				$db->query_unbuffered("update {$tpf}users set password='$md5_pwd',reset_code='' where userid='$userid' limit 1");
				$sysmsg[] = __('reset_pwd_success');
				echo "<script>setTimeout(function(){document.location='".urr("account","action=login")."'},3000);</script>";
			}
		}else{

			if($code){
				$rs = $db->fetch_one_array("select * from {$tpf}users where reset_code='$code' limit 1");
				if($rs['userid']){
					$userid = $rs['userid'];
				}else{
					$sysmsg[] = __('user_not_exists');
					$disabled = 'disabled';
				}
			}else{
				$sysmsg[] = __('confirm_mail_error');
				$disabled = 'disabled';
			}
		}
		require_once template_echo('pd_account',$user_tpl_dir);
		break;

	case 'logout':
		pd_setcookie('phpdisk_zcore_info','');
		if(display_plugin('api','open_uc_plugin',$settings['connect_uc'],0)){
			$synlogout = uc_user_synlogout();
			echo $synlogout;
		}
		$sysmsg[] = __('logout_success');
		redirect('./',$sysmsg);
		break;

	case 'demologin':
		if(!$settings['open_demo_login']){
			$sysmsg[] = __('demo_login_not_open');
			require_once template_echo('pd_account',$user_tpl_dir);
		}else{
			$gid = 4;
			$username = 'phpdisk_demo';
			$password = 'fcf41657f02f88137a1bcf068a32c0a3';
			$email = 'demo@google.com';

			$rs = $db->fetch_one_array("select * from {$tpf}users where username='$username'");
			if(!$rs){
				$ins = array(
				'gid' => $gid,
				'username' => $username,
				'password' => $password,
				'email' => $email,
				'reg_ip' => $onlineip,
				'reg_time' => $timestamp,
				);
				$db->query("insert into {$tpf}users set ".$db->sql_array($ins).";");

			}else{
				$db->query_unbuffered("update {$tpf}users set last_login_ip='$onlineip',last_login_time='$timestamp' where userid='{$rs['userid']}'");
			}
			unset($rs);

			$rs = $db->fetch_one_array("select * from {$tpf}users where username='$username'");
			if($rs){
				$userid = $rs['userid'];
				$gid = $rs['gid'];
				$username = $rs['username'];
				$password = $rs['password'];
				$email = $rs['email'];
			}
			unset($rs);

			pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"));

			redirect(urr("space",""),'',0);
		}
		break;

	default:
		redirect(urr("account","action=login"),'',0);
}

include PHPDISK_ROOT."./includes/footer.inc.php";


?>

