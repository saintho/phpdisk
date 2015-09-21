<?php
//session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
	$ms  = $c->home_timeline(); // done
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
	$nickname = $user_message['screen_name'];
	$abs_path = '../../';
	$flid = @$db->result_first("select flid from {$tpf}fastlogin where auth_type='weibo' and auth_name='{$_SESSION['token'][uid]}'");
	if($flid){
		$userid = @$db->result_first("select userid from {$tpf}fastlogin where flid='$flid'");
		if($userid){
			$rs = $db->fetch_one_array("select userid,gid,username,password,email from {$tpf}users where userid='$userid'");
			if($rs){
				pd_setcookie('phpdisk_zcore_info',pd_encode("{$rs[userid]}\t{$rs[gid]}\t{$rs[username]}\t{$rs[password]}\t{$rs[email]}"));
				//login
				$ins = array(
				'last_login_time'=>$timestamp,
				'last_login_ip'=>$onlineip,
				);
				$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$userid'");
				$db->query_unbuffered("update {$tpf}fastlogin set ".$db->sql_array($ins)." where flid='$flid'");
				//echo 'Login Success';
				redirect($settings[phpdisk_url].urr("mydisk",""),'',0);
			}
			unset($rs);
		}else{
			// to bind username
			$title = __('bind_disk_name');
			require_once template_echo('pd_fastlogin',$user_tpl_dir);
		}
	}else{
		$ins = array(
		'nickname'=>$nickname,
		'auth_type'=>'weibo',
		'auth_name'=>$_SESSION['token'][uid],
		'last_login_time'=>$timestamp,
		'last_login_ip'=>$onlineip,
		);
		$db->query_unbuffered("insert into {$tpf}fastlogin set ".$db->sql_array($ins)."");
		$flid = $db->insert_id();
		//echo 'Login Success';
		$title = __('bind_disk_name');
		require_once template_echo('pd_fastlogin',$user_tpl_dir);

	}
} else {
	exit('Weibo Login Error');
}
?>
