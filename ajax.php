<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: ajax.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

include "includes/commons.inc.php";

switch($action){
	case 'digg':
		$file_id = (int)gpc('file_id','G',0);
		$dig_type = (int)gpc('dig_type','G',0);
		$digg_cookie = gpc("phpdisk_digg_{$file_id}",'C','');
		if(!$digg_cookie){
			$rs = $db->fetch_one_array("select good_count,bad_count,userid from {$tpf}files where file_id='$file_id' limit 1");
			if($rs){
				$good_count = (int)$rs['good_count']+1;
				$bad_count = (int)$rs['bad_count']+1;
				$userid = (int)$rs['userid'];
			}
			unset($rs);
			if($dig_type ==1){
				$db->query_unbuffered("update {$tpf}files set good_count=good_count+1 where file_id='$file_id'");
			}elseif($dig_type ==2){
				$db->query_unbuffered("update {$tpf}files set bad_count=bad_count+1 where file_id='$file_id'");
			}
			pd_setcookie("phpdisk_digg_{$file_id}", $file_id, $timestamp+3600);
			echo "var re=new Array();re[0]=".$file_id.";re[1]=".$dig_type.";re[2]=\"success\";re[3]=\"".__('vote_success')."\";";
		}else{
			echo "var re=new Array();re[0]=".$file_id.";re[1]=".$dig_type.";re[2]=\"fail\";re[3]=\"".__('cannot_same_vote')."\";";
		}
		break;
	case 'down_process':

		$file_id = (int)gpc('file_id','P',0);
		$ref_fail =false;
		$arr = explode('/',$_SERVER['HTTP_REFERER']);
		$arr2 = explode('/',$settings[phpdisk_url]);
		if($_SERVER['HTTP_HOST']!='localhost'){
			if(!$_SERVER['HTTP_REFERER'] || $arr[2]!=$arr2[2]){
				$ref_fail =true;
			}
		}
		if($ref_fail || !is_numeric($file_id)){
			echo 'Bad View!';
			exit;
		}
		cal_downs($file_id);
		break;
	case 'save_as':
		$file_id = (int)gpc('file_id','G',0);
		if($pd_uid){
			$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id' limit 1");
			if($rs){
				$has_file = @$db->result_first("select count(*) from {$tpf}files where file_name='{$rs[file_name]}' and file_extension='{$rs[file_extension]}' and file_size='{$rs[file_size]}' and userid='$pd_uid' limit 1");
				if(($rs['userid'] ==$pd_uid) || $has_file){
					$rtn ='ufile';
				}else{
					$ins = array(
					'file_name' => '[转]'.$rs['file_name'],
					'file_key' => random(8),
					'file_extension' => $rs['file_extension'],
					'is_image' => $rs['is_image'],
					'file_mime' => $rs['file_mime'],
					'file_description' => $rs['file_description'],
					'file_store_path' => $rs['file_store_path'],
					'file_real_name' => $rs['file_real_name'],
					'file_md5' => $rs['file_md5'],
					'server_oid' => $rs['server_oid'],
					'file_size' => $rs['file_size'],
					'file_time' => $timestamp,
					'in_share' => 1,
					'is_checked' => $rs['is_checked'],
					'userid' => $pd_uid,
					'ip' => get_ip(),
					);
					$db->query_unbuffered("insert into {$tpf}files set ".$db->sql_array($ins)."");
					$rtn = 'true';
				}
			}
			unset($rs);
		}else{
			$rtn = 'false';
		}
		echo $rtn;
		break;
	case 'conv_credit':
		if($pd_uid){
			$credit_type = gpc('credit_type','P','');
			switch($credit_type){
				case 'credit':
					if(!$myinfo[credit] && !$myinfo[dl_credit]){
						echo '积分为零，无法兑换金钱，请努力推广赚钱吧。';
					}else{
						if(conv_credit($pd_uid)){
							echo 'true';
						}else{
							echo __('conv_credit_error');
						}
					}
					break;
				default:
					echo 'Invalid Action';
			}
		}else{
			echo 'Invalid User!';
		}
		break;

	case 'check_code':
		$code = trim(gpc('code','P',''));
		//$_SESSION[my_imgcode][code];
		if(strtolower($code)==strtolower($_SESSION[my_imgcode][code])){
			echo 'true';
		}else{
			echo 'false';
		}
		break;
	case 'check_yuc':
		require_once PHPDISK_ROOT.'yucmedia/YucCaptcha.php';
		$code = trim(gpc('code','P',''));
		if ($code) {
			$result = YucCaptcha::getVerifyResult();
			if($result){
				echo 'true';
			}else{
				echo YucCaptcha::getDetails() . '::' . $result;
			}
		}
		break;
	case 'check_yxm':
		$settings[yxm_public_key] = $settings[yxm_public_key] ? $settings[yxm_public_key] : '82393b3baca49c60e4f0ea9f7f4f5960';
		require_once 'yxm/YinXiangMaLib.php';
		$YinXiangMa_response=YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
		if($YinXiangMa_response == "true") {
			echo 'true';
		}else{
			echo 'Error!';
		}
		break;
	case 'chk_username':
		$r_username = trim(gpc('r_username','P',''));
		if(checklength($r_username,2,60)){
			echo __('username_length_error');
		}elseif(is_bad_chars($r_username)){
			echo __('username_has_bad_chars');
		}else{
			$num = @$db->result_first("select count(*) from {$tpf}users where username='$r_username'");
			if($num){
				echo __('username_already_exists');
			}else{
				echo 'true|'.__('username_can_reg');
			}
		}
		break;
	case 'chk_email':
		$r_email = trim(gpc('r_email','P',''));

		if(!checkemail($r_email)){
			echo __('invalid_email');
		}else{
			$num = @$db->result_first("select count(*) from {$tpf}users where email='$r_email'");
			if($num){
				echo __('email_already_exists');
			}else{
				echo 'true|'.__('email_can_reg');
			}
		}
		break;
	case 'fd_stat':
		$folder_id = (int)gpc('folder_id','P',0);
		if($folder_id){
			$file_size = (int)@$db->result_first("select sum(file_size) from {$tpf}files where folder_id='$folder_id'");
			$db->query_unbuffered("update {$tpf}folders set folder_size='$file_size' where folder_id='$folder_id'");
			echo 'true|'.get_size($file_size);
		}
		break;

	case 'space_pwd':
		$code = gpc('code','P','');
		$userid = (int)gpc('uid','P',0);
		if($code){
			$num = (int)@$db->result_first("select count(*) from {$tpf}users where space_pwd='$code' and userid='$userid'");
			if($num){
				pd_setcookie('c_space_pwd',$code);
				echo 'true|'.__('space_pwd_ok');
			}else{
				echo __('space_pwd_fail');
			}
		}else{
			echo __('space_pwd_fail');
		}
		break;
	case 'admin_space_pwd':
		$userid = (int)gpc('uid','P',0);
		if($pd_gid==1 && $userid){
			$space_pwd = (int)@$db->result_first("select space_pwd from {$tpf}users where userid='$userid'");
			if($space_pwd){
				pd_setcookie('c_space_pwd',$space_pwd);
				echo 'true|'.__('space_pwd_ok');
			}else{
				echo __('space_pwd_fail');
			}
		}else{
			echo __('space_pwd_error');
		}
		break;
	case 'bind_user':
		$flid = gpc('flid','P','');
		$username = gpc('username','P','');
		$password = gpc('password','P','');

		if($username && $password){
			$md5_pwd = md5($password);
			$userid = @$db->result_first("select userid from {$tpf}users where username='$username' and password='$md5_pwd'");
			if($userid){
				$db->query_unbuffered("update {$tpf}fastlogin set userid='$userid' where flid='$flid' ");
				$rs = $db->fetch_one_array("select userid,gid,username,password,email from {$tpf}users where userid='$userid'");
				if($rs){
					pd_setcookie('phpdisk_zcore_info',pd_encode("{$rs[userid]}\t{$rs[gid]}\t{$rs[username]}\t{$rs[password]}\t{$rs[email]}"));
				}
				echo 'true|'.__('fastlogin_ok');
			}else{
				echo __('username_password_error');
			}
		}else{
			echo __('username_password_is_null');
		}
		break;
	case 'guest_visit':
		$flid = gpc('flid','P','');
		$rs = $db->fetch_one_array("select auth_type,nickname from {$tpf}fastlogin where flid='$flid'");
		if($rs[nickname]){
			$nickname = addslashes(trim($rs[nickname]));
			$num = @$db->result_first("select count(*) from {$tpf}users where username='$nickname'");
		}
		unset($rs);
		if($num){
			$reg_name = $nickname.'_'.random(2);
		}else{
			$tmp_uid = (int)@$db->result_first("select userid from {$tpf}users order by userid desc limit 1");
			$reg_name = $nickname ? addslashes($nickname) : 'guest-'.($tmp_uid+1);
		}
		$ins = array(
		'username' => $reg_name,
		'password' => md5($timestamp),
		'email' => $timestamp.'@guest.tmp',
		'gid' => 4,
		'reg_time' => $timestamp,
		'reg_ip' => $onlineip,
		'space_name' => $reg_name.'的文件',
		'can_edit'=>1,
		);
		$db->query_unbuffered("insert into {$tpf}users set ".$db->sql_array($ins)."");
		$uid = $db->insert_id();
		$db->query_unbuffered("update {$tpf}fastlogin set userid='$uid' where flid='$flid' ");
		$rs = $db->fetch_one_array("select userid,gid,username,password,email from {$tpf}users where userid='$uid'");
		if($rs){
			pd_setcookie('phpdisk_zcore_info',pd_encode("{$rs[userid]}\t{$rs[gid]}\t{$rs[username]}\t{$rs[password]}\t{$rs[email]}"));
		}
		echo 'true|'.__('fastlogin_ok');
		break;

	case 'load_file_addr':
		$file_id = (int)gpc('file_id','P',0);
		if($file_id){
			$rs = $db->fetch_one_array("select * from {$tpf}files where file_id='$file_id'");
			if($rs[yun_fid]){
				$a_down = 'http://d.yun.google.com/down-'.$rs[yun_fid];
			}else{
				if(display_plugin('multi_server','open_multi_server_plugin',$settings['open_multi_server'],0)){
					$rs2 = $db->fetch_one_array("select server_host,server_dl_host from {$tpf}servers where server_oid='{$rs[server_oid]}' limit 1");
					if($rs2){
						$a_down = $rs2['server_host'].create_down_url($rs);
						if($rs['file_time'] && $timestamp-$rs['file_time']>600){
							if($rs2[server_dl_host]){
								$arr = explode(LF,$rs2[server_dl_host]);
								$a_down = $arr[0].create_down_url($rs);
							}
						}

					}
					unset($rs2);
				}
				unset($rs);				
			}
			echo 'true|<a href="'.$a_down.'" target="_blank">[下载]</a>';
		}else{
			echo 'NO file_id';
		}
		break;
	case 'cp_index':
		$setting = array(
		'open_index_fast_upload_box' => 0,
		'open_index_site_desc' => 0,
		'open_index_file_list' => 0,
		);
		$settings = gpc('setting','P',$setting);
		$settings[open_index_fast_upload_box] = $settings[open_index_fast_upload_box] ? 1 : 0;
		$settings[open_index_site_desc] = $settings[open_index_site_desc] ? 1 : 0;
		$settings[open_index_file_list] = $settings[open_index_file_list] ? 1 : 0;
		if(!$error && $pd_gid==1){
			settings_cache($settings);
			echo __('diy_update_success');
		}else{
			echo __('diy_update_fail');
		}
		break;

	case 'cp_viewfile':
		$setting = array(
		'open_viewfile_file_list' => 0,
		);
		$settings = gpc('setting','P',$setting);
		$settings[open_viewfile_file_list] = $settings[open_viewfile_file_list] ? 1 : 0;

		if(!$error && $pd_gid==1){
			settings_cache($settings);
			echo __('diy_update_success');
		}else{
			echo __('diy_update_fail');
		}
		break;
	case 'uploadCloud':
		$folder_id = (int)gpc('folder_id','P',0);
		$data = trim(gpc('data','P',''));

		if($data){
			$file_key = random(8);
			if(strpos($data,',')!==false){
				$add_sql = $msg = '';
				$arr = explode(',',$data);
				for($i=0;$i<count($arr)-1;$i++){
					$file = unserialize(base64_decode($arr[$i]));
					//print_r($file);
					//exit;
					$report_status =0;
					$report_arr = explode(',',$settings['report_word']);
					if(count($report_arr)){
						foreach($report_arr as $value){
							if (strpos($file['file_name'],$value) !== false){
								$report_status = 2;
							}
						}
					}
					$num = @$db->result_first("select count(*) from {$tpf}files where yun_fid='{$file[file_id]}' and userid='$pd_uid'");
					if($num && $file[file_id]){
						$tmp_ext = $file[file_extension] ? '.'.$file[file_extension] : '';
						$msg .=	$file[file_name].$tmp_ext.',';
					}else{
						$add_sql .= "($file[file_id],'$file[file_name]','$file_key','$file[file_extension]','application/octet-stream','$file[file_description]','$file[file_size]','$timestamp','$is_checked','$in_share','$report_status','$pd_uid','$folder_id','$onlineip'),";
					}
				}
				if($add_sql){
					$add_sql = is_utf8() ? $add_sql : iconv('utf-8','gbk',$add_sql);
					$add_sql = substr($add_sql,0,-1);
					$db->query_unbuffered("insert into {$tpf}files(yun_fid,file_name,file_key,file_extension,file_mime,file_description,file_size,file_time,is_checked,in_share,report_status,userid,folder_id,ip) values $add_sql ;");
				}
			}else{
				$file = unserialize(base64_decode($data));
				//write_file(PHPDISK_ROOT.'system/ax.txt',var_export($file,true),'ab');
				//print_r($file);
				//exit;
				$num = @$db->result_first("select count(*) from {$tpf}files where yun_fid='{$file[file_id]}' and userid='$pd_uid'");
				if($num && $file[file_id]){
					$tmp_ext = $file[file_extension] ? '.'.$file[file_extension] : '';
					$msg = $file[file_name].$tmp_ext;
				}else{
					$report_status =0;
					$report_arr = explode(',',$settings['report_word']);
					if(count($report_arr)){
						foreach($report_arr as $value){
							if (strpos($file['file_name'],$value) !== false){
								$report_status = 2;
							}
						}
					}
					$ins = array(
					'yun_fid' => $file[file_id],
					'file_name' => $file[file_name],
					'file_key' => $file_key,
					'file_extension' => $file[file_extension],
					'file_mime' => 'application/octet-stream',
					'file_description' => $file[file_description],
					'file_size' => $file['file_size'],
					'file_time' => $timestamp,
					'is_checked' => 1,
					'in_share' => 1,
					'report_status' => $report_status,
					'userid' => $pd_uid,
					'folder_id' => $folder_id,
					'ip' => $onlineip,
					);
					$sql = "insert into {$tpf}files set ".$db->sql_array($ins).";";
					$db->query_unbuffered(is_utf8() ? $sql : iconv('utf-8','gbk',$sql));
				}
			}
			$msg = $msg ? '文件已存在：'.substr($msg,0,-1).',不能重复添加' : '';
			echo 'true|'.$msg;
		}else{
			echo 'false';
		}
		break;
}

include PHPDISK_ROOT."./includes/footer.inc.php";

function cal_downs($file_id){
	global $db,$tpf,$timestamp,$onlineip,$my_sid,$auth,$settings;
	$down_file = gpc('down_file_log','C',0);
	$rs = $db->fetch_one_array("select userid,file_size from {$tpf}files where file_id='$file_id'");
	if($rs){
		$userid = $rs[userid];
		$file_size = $rs[file_size];
	}
	unset($rs);
	$ip_interval = get_plans(get_profile($userid,'plan_id'),'ip_interval');
	$ip_interval = $ip_interval ? (int)$ip_interval : 24;

	$db->query_unbuffered("update {$tpf}files set file_last_view='$timestamp' where file_id='$file_id'");

	if(!$down_file && check_download_ok($my_sid,$ip_interval * 60)){
		//if(1){
		pd_setcookie('down_file_log',1,$ip_interval * 60);

		$id = (int)@$db->result_first("select id from ".get_table_day_down()." where file_id='$file_id' and d_day='".date('Ymd')."'");
		if(!$id){
			$ins = array(
			'd_year'=>date('Y'),
			'd_month'=>date('Ym'),
			'd_day'=>date('Ymd'),
			'd_week'=>date('YW'),
			'file_id'=>$file_id,
			'down_count'=>1,
			'userid'=>$userid,
			);
			$db->query_unbuffered("insert into ".get_table_day_down()." set ".$db->sql_array($ins)."");
			if($auth[open_plan_active] && $settings[open_plan_active]){
				$dday = date('Ymd',strtotime('-1 day'));
				$dweek = date('YW',strtotime('-1 week'));

				if($settings[down_active_interval]=='week'){
					$sql_do = " and d_week='$dweek'";
				}else{
					$sql_do = " and d_day='$dday'";
				}
				$mydowns = (int)@$db->result_first("select sum(down_count) from ".get_table_day_down()." where userid='$userid' $sql_do");
				//echo $mydowns.',';
				$mydowns = $mydowns ? get_discount($userid,$mydowns) : 1;
				$to_plan_id = @$db->result_first("select plan_id from {$tpf}plans where $mydowns>=down_active_num_min and $mydowns<down_active_num_max and is_hidden=0");
				//echo $to_plan_id;
				if($to_plan_id && date('Ymd',get_profile($userid,'plan_conv_time'))<>date('Ymd')){
					conv_credit($userid);
					$ins = array(
					'open_plan'=>1,
					'plan_id'=>$to_plan_id,
					'credit_rate'=>get_plans($to_plan_id,'income_rate'),
					'plan_conv_time'=>$timestamp,
					);
					$db->query_unbuffered("update {$tpf}users set ".$db->sql_array($ins)." where userid='$userid'");
				}
			}
		}else{
			$db->query_unbuffered("update ".get_table_day_down()." set down_count=down_count+1 where id='$id'");
		}

		$add_credit = 1;
		if($settings[promo_time]<>''){
			$hour = date('G');
			$arr = explode(',',$settings[promo_time]);
			if(in_array($hour,$arr)){
				$add_credit = 2;
			}
		}
		add_credit_log($file_id,$add_credit,'download',$userid);
		$db->query_unbuffered("update {$tpf}users set credit=credit+$add_credit where userid='$userid'");
		$db->query_unbuffered("update {$tpf}files set file_downs=file_downs+1 where file_id='$file_id'");
		$db->query_unbuffered("update {$tpf}users set dl_credit=dl_credit+1 where userid=(select userid from {$tpf}buddys where touserid='$userid')");
		$upline_userid = (int)@$db->result_first("select userid from {$tpf}buddys where touserid='$userid'");
		$db->query_unbuffered("update {$tpf}users set dl_credit2=dl_credit2+1 where userid=(select userid from {$tpf}buddys where touserid='$upline_userid')");
	}

	echo 'true';
}

?>