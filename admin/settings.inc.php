<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: settings.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
$remote_server_url = remote_server_url();

switch($action){
	case 'base':
		admin_no_power($task,1,$pd_uid);
		if($task =='base'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'site_title' => '',
			'miibeian' => '',
			'contact_us' => '',
			'site_stat' => '',
			'phpdisk_url' => '',
			'encrypt_key' => '',
			'allow_access' => '1',
			'close_access_reason' => '',
			'allow_register' => '1',
			'close_register_reason' => '',
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);
			$settings['filter_extension'] = 'asp,asa,aspx,ascx,dtd,xsd,xsl,xslt,as,wml,java,vtm,vtml,jst,asr,php,php3,php4,php5,vb,vbs,jsf,jsp,pl,cgi,js,html,htm,xhtml,xml,css,shtm,cfm,cfml,shtml,bat,sh';
			$settings['site_stat'] = base64_encode($settings['site_stat']);

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			if(checklength($settings['site_title'],2,100)){
				$error = true;
				$sysmsg[] = __('site_title_error');
			}
			if(substr($settings['phpdisk_url'],0,7) !='http://' && substr($settings['phpdisk_url'],0,8) !='https://'){
				$error = true;
				$sysmsg[] = __('phpdisk_url_error');
			}else{
				$settings['phpdisk_url'] = substr($settings['phpdisk_url'],-1) =='/' ? $settings['phpdisk_url'] : $settings['phpdisk_url'].'/';
			}
			if(checklength($settings['encrypt_key'],8,20) || preg_match("/[^a-z0-9]/i",$settings['encrypt_key'])){
				$error = true;
				$sysmsg[] = __('encrypt_key_error');
			}
			if(!checkemail($settings['contact_us'])){
				$error = true;
				$sysmsg[] = __('contact_us_error');
			}
			if(!$settings['allow_access']){
				if(checklength($settings['close_access_reason'],2,200)){
					$error = true;
					$sysmsg[] = __('close_access_reason_error');
				}
			}
			if(!$settings['allow_register']){
				if(checklength($settings['close_register_reason'],2,200)){
					$error = true;
					$sysmsg[] = __('close_register_reason_error');
				}
			}
			$settings['perpage'] = !is_numeric($settings['perpage']) ? 20 : (int)$settings['perpage'];

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('base_settings_update_success');
				redirect(urr(ADMINCP,"item=settings&menu=base&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$setting = $settings;
			$settings[site_stat] = stripslashes(base64_decode($setting[site_stat]));

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;

	case 'advanced':
		admin_no_power($task,2,$pd_uid);
		if($task =='advanced'){
			form_auth(gpc('formhash','P',''),formhash());

			$setting = array(
			'file_path' => '',
			'gzipcompress' => 0,
			'max_file_size' => '',
			'perpage' => 0,
			'invite_register_encode' => 0,
			'share_tool' => '',
			'site_notify' => '',
			'deny_extension' => '',
			'meta_ext' => '',
			'min_to_income' => '',
			'downline_income' => '',
			'how_downs_credit' => '',
			'how_money_credit' => '',
			'discount_rate' => 0,
			'cookie_domain' => '',
			'reg_interval' => 0,
			'close_guest_upload'=>0,
			'global_open_custom_stats'=>0,
			'open_xsendfile'=>0,
			'promo_time'=> array(),
			);
			$online_demo = $settings['online_demo'];
			$settings = gpc('setting','P',$setting);
			$settings['filter_extension'] = 'asp,asa,aspx,ascx,dtd,xsd,xsl,xslt,as,wml,java,vtm,vtml,jst,asr,php,php3,php4,php5,vb,vbs,jsf,jsp,pl,cgi,js,html,htm,xhtml,xml,css,shtm,cfm,cfml,shtml,bat,sh';
			//$settings['true_link_extension'] = str_replace(array("\r","\n",'，'),array('','',','),$settings['true_link_extension']);
			$settings['site_notify'] = base64_encode(stripslashes($settings['site_notify']));
			$settings['meta_ext'] = base64_encode(stripslashes($settings['meta_ext']));
			$settings[close_guest_upload] = $settings['close_guest_upload'] ? (int)$settings['close_guest_upload'] : 0;
			if(is_array($settings[promo_time])){
				$settings[promo_time] = implode(',',$settings[promo_time]);
			}else{
				$settings[promo_time] = '';
			}

			if($online_demo){
				$error = true;
				$sysmsg[] = __('online_demo_deny');
			}
			$bad_dirs = array('admin','docs','images','includes','install','languages','modules','system','templates','tools');
			if(in_array($settings['file_path'],$bad_dirs)){
				$error = true;
				$sysmsg[] = '"'.$settings['file_path'].'"'.__('system_reserve_folder');
			}
			if($settings['yun_store']==2 && $settings[yun_site_key]==''){
				$error = true;
				$sysmsg[] = '使用网盘云站长版时，需要填写站长版密钥';
			}
			if(checklength($settings['file_path'],2,20)){
				$error = true;
				$sysmsg[] = __('file_path_error');
			}

			if(!$error){

				settings_cache($settings);

				$sysmsg[] = __('advanced_settings_update_success');
				redirect(urr(ADMINCP,"item=settings&menu=base&action=$action"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$upload_max = get_byte_value(ini_get('upload_max_filesize'));
			$post_max = get_byte_value(ini_get('post_max_size'));
			$settings_max = $settings['max_file_size'] ? get_byte_value($settings['max_file_size']) : 0;
			$max_php_file_size = min($upload_max, $post_max);
			$max_file_size_byte = ($settings_max && $settings_max <= $max_php_file_size) ? $settings_max : $max_php_file_size;
			$max_user_file_size = get_size($max_file_size_byte,'B',0);
			$file_real_path = PHPDISK_ROOT.$settings['file_path'].'/';
			if(!is_dir($file_real_path)){
				$file_path_tips = __('file_path_not_exists');
			}
			$settings['site_notify'] = base64_decode($settings['site_notify']);
			$settings['meta_ext'] = base64_decode($settings['meta_ext']);

			$settings['convert_rate'] = $settings['convert_rate'] ? (int)$settings['convert_rate'] : 100;
			$settings[close_guest_upload] = $settings['close_guest_upload'] ? (int)$settings['close_guest_upload'] : 0;
			if($settings[promo_time]<>''){
				$arr = explode(',',$settings[promo_time]);
				$run_script = '';
				for($i=0;$i<count($arr);$i++){
					$run_script .= "getId('pt_{$arr[$i]}').checked=true;";
				}
			}
			$q = $db->query("select * from {$tpf}groups order by gid desc");
			$gids = array();
			while ($rs = $db->fetch_array($q)) {
				$gids[] = $rs;
			}
			$db->free($q);
			unset($rs);

			$setting = $settings;

			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'add_admins':
	case 'edit_admins':
		admin_no_power($task,0,$pd_uid);
		$cp_menus = array(

		'settings' => array(
		'title' => __('menu_site_setting'),
		'sub_title' => __('menu_site_setting'),
		'data' => array(
		array('id'=>'1','menu'=>__('menu_base_setting'),'url'=>urr(ADMINCP,"item=settings&menu=base&action=base")),
		array('id'=>'2','menu'=>__('menu_advanced_setting'),'url'=>urr(ADMINCP,"item=settings&menu=base&action=advanced")),
		array('id'=>'40','menu'=>__('menu_back_pwd'),'url'=>urr(ADMINCP,"item=settings&menu=base&action=back_pwd")),
		),
		),

		'users' => array(
		'title' => __('menu_user_setting'),
		'sub_title' => __('menu_user_setting'),
		'data' => array(
		array('id'=>'3','menu'=>__('menu_add_user'),'url'=>urr(ADMINCP,"item=users&menu=user&action=add_user")),
		array('id'=>'4','menu'=>__('menu_user_group'),'url'=>urr(ADMINCP,"item=groups&menu=user&action=index")),
		array('id'=>'5','menu'=>__('menu_user_fastlogin'),'url'=>urr(ADMINCP,"item=users&menu=user&action=fastlogin")),
		array('id'=>'6','menu'=>__('menu_user_manage'),'url'=>urr(ADMINCP,"item=users&menu=user&action=index")),
		array('id'=>'7','menu'=>__('menu_order_process'),'url'=>urr(ADMINCP,"item=users&menu=user&action=orders")),
		array('id'=>'8','menu'=>__('menu_earn_plans'),'url'=>urr(ADMINCP,"item=plans&menu=user&action=list")),
		),
		),
		'email' => array(
		'sub_title' => __('menu_email'),
		'data' => array(
		array('id'=>'11','menu'=>__('menu_email_setting'),'url'=>urr(ADMINCP,"item=email&menu=user&action=setting")),
		array('id'=>'12','menu'=>__('menu_email_test'),'url'=>urr(ADMINCP,"item=email&menu=user&action=mail_test")),
		),
		),
		'verycode' => array(
		'sub_title' => __('menu_other'),
		'data' => array(
		array('id'=>'13','menu'=>__('menu_verycode'),'url'=>urr(ADMINCP,"item=verycode&menu=user")),
		),
		),

		'files' => array(
		'title' => __('menu_files'),
		'sub_title' => __('menu_files'),
		'data' => array(
		array('id'=>'14','menu'=>__('menu_files_list'),'url'=>urr(ADMINCP,"item=files&menu=file&action=index")),
		array('id'=>'41','menu'=>__('menu_tag'),'url'=>urr(ADMINCP,"item=tag&menu=file")),
		array('id'=>'15','menu'=>__('menu_files_node'),'url'=>urr(ADMINCP,"item=nodes&menu=file&action=list")),
		),
		),

		'report' => array(
		'sub_title' => __('menu_report'),
		'data' => array(
		array('id'=>'20','menu'=>__('menu_report_setting'),'url'=>urr(ADMINCP,"item=report&menu=file")),
		array('id'=>'21','menu'=>__('menu_report_user'),'url'=>urr(ADMINCP,"item=report&menu=file&action=user")),
		array('id'=>'22','menu'=>__('menu_report_system'),'url'=>urr(ADMINCP,"item=report&menu=file&action=system")),
		array('id'=>'23','menu'=>__('menu_report_file_unlocked'),'url'=>urr(ADMINCP,"item=report&menu=file&action=file_unlocked")),
		),
		),

		'tpl' => array(
		'title' => __('menu_template_language'),
		'sub_title' => __('menu_template_language'),
		'data' => array(
		array('id'=>'26','menu'=>__('menu_lang_manage'),'url'=>urr(ADMINCP,"item=lang&menu=lang_tpl")),
		array('id'=>'27','menu'=>__('menu_template_manage'),'url'=>urr(ADMINCP,"item=templates&menu=lang_tpl")),
		),
		),

		'extend' => array(
		'title' => __('menu_extend_tools'),
		'sub_title' => __('menu_extend'),
		'data' => array(
		array('id'=>'28','menu'=>__('menu_adv_manage'),'url'=>urr(ADMINCP,"item=advertisement&menu=extend")),
		array('id'=>'29','menu'=>__('menu_announce_manage'),'url'=>urr(ADMINCP,"item=announce&menu=extend")),
		array('id'=>'30','menu'=>__('menu_navigation_manage'),'url'=>urr(ADMINCP,"item=navigation&menu=extend")),
		array('id'=>'31','menu'=>__('menu_seo_manage'),'url'=>urr(ADMINCP,"item=seo&menu=extend")),
		array('id'=>'32','menu'=>__('menu_union_manage'),'url'=>urr(ADMINCP,"item=union&menu=extend")),
		array('id'=>'33','menu'=>__('menu_comment_manage'),'url'=>urr(ADMINCP,"item=comment&menu=extend")),
		),
		),
		);
		$uid = (int)gpc('uid','GP',0);
		if($task=='add_admins' || $task=='edit_admins'){
			form_auth(gpc('formhash','P',''),formhash());
			$username = trim(gpc('username','P',''));
			$password = trim(gpc('password','P',''));
			$mids = gpc('mids','P',array());

			if($action=='edit_admins'){
				if($password){
					if(checklength($password,6,50)){
						$error = true;
						$sysmsg[] = __('admins_pwd_error');
					}else{
						$md5_pwd = md5($password);
					}
				}else{
					$md5_pwd = '';
				}
			}else{
				if($username){
					$userid = @$db->result_first("select userid from {$tpf}users where username='$username'");
					if(!$userid){
						$error = true;
						$sysmsg[] = __('username_not_exists');
					}else{
						$num = @$db->result_first("select count(*) from {$tpf}admins where userid='$userid'");
						if($num){
							$error = true;
							$sysmsg[] = __('admins_exists');
						}
					}
				}else{
					$error = true;
					$sysmsg[] = __('admins_username_null');
				}
				if(checklength($password,6,50)){
					$error = true;
					$sysmsg[] = __('admins_pwd_error');
				}else{
					$md5_pwd = md5($password);
				}
			}
			$arr = '';
			foreach ($mids as $k => $v){
				$arr[$k] = $v[0];
			}

			if(!$error){
				if($action=='edit_admins'){
					$ins = array(
					'power_list'=>serialize($arr),
					'intime'=>$timestamp,
					);
					$db->query_unbuffered("update {$tpf}admins set ".$db->sql_array($ins)." where userid='$uid'");
					if($md5_pwd){
						$db->query_unbuffered("update {$tpf}admins set password='$md5_pwd' where userid='$uid'");
					}
					$sysmsg[] = __('edit_admins_success');
				}else{
					$ins = array(
					'userid'=>$userid,
					'password'=>$md5_pwd,
					'power_list'=>serialize($arr),
					'intime'=>$timestamp,
					);
					$db->query_unbuffered("insert into {$tpf}admins set ".$db->sql_array($ins)."");
					$db->query_unbuffered("update {$tpf}users set gid=1 where userid='$userid'");
					$sysmsg[] = __('add_admins_success');
				}
				redirect(urr(ADMINCP,"item=settings&menu=base&action=admins_list"),$sysmsg);
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			if($uid){
				$pa = $db->fetch_one_array("select a.power_list,a.userid,u.username from {$tpf}admins a,{$tpf}users u where a.userid=u.userid");
				$pa[pl] = unserialize($pa[power_list]);
			}
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
	case 'del_admins':
		admin_no_power($task,0,$pd_uid);
		$uid = (int)gpc('uid','G',0);
		if($uid && super_admin()){
			$db->query_unbuffered("delete from {$tpf}admins where userid='$uid' limit 1");
			$db->query_unbuffered("update {$tpf}users set gid=4 where userid='$uid' limit 1");
			redirect('back',__('del_admins_success'));
		}
		break;

	case 'admins_list':
		admin_no_power($task,0,$pd_uid);
		$q = $db->query_unbuffered("select u.username,u.userid,a.intime from {$tpf}users u,{$tpf}admins a where u.userid=a.userid and u.userid='$uid'");
		$admins = array();
		while ($rs = $db->fetch_array($q)) {
			$rs[intime] = date('Y-m-d H:i:s',$rs[intime]);
			$rs[style] = '';
			$rs[admins_type] = __('common_admin');
			$admins[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$q = $db->query_unbuffered("select userid,username from {$tpf}users where userid in ({$adminset[super_adminid]})");
		$admins2 = array();
		while ($rs = $db->fetch_array($q)) {
			$rs[intime] = '-';
			$rs[style] = 'txtred';
			$rs[admins_type] = __('super_admin');
			$admins2[] = $rs;
		}
		$db->free($q);
		unset($rs);

		$admins3 = array_merge($admins2,$admins);

		require_once template_echo($item,$admin_tpl_dir,'',1);
		break;

	case 'back_pwd':
		admin_no_power($task,40,$pd_uid);
		if($task =='back_pwd'){
			form_auth(gpc('formhash','P',''),formhash());

			$old_pwd = trim(gpc('old_pwd','P',''));
			$new_pwd = trim(gpc('new_pwd','P',''));
			$cfm_pwd = trim(gpc('cfm_pwd','P',''));

			if(!(super_admin() && !admin_no_pwd())){
				$rs = $db->fetch_one_array("select userid from {$tpf}admins where password='".md5($old_pwd)."' and userid='$pd_uid'");
				if(!$rs){
					$error = true;
					$sysmsg[] = __('invalid_back_password');
				}
				unset($rs);
			}else{
				$num = @$db->result_first("select count(*) from {$tpf}admins where userid='$pd_uid'");
				if($num){
					$error = true;
					$sysmsg[] = __('admins_exists');
				}
			}
			if(checklength($new_pwd,6,20)){
				$error = true;
				$sysmsg[] = __('password_max_min');
			}elseif($new_pwd != $cfm_pwd){
				$error = true;
				$sysmsg[] = __('confirm_password_invalid');
			}else{
				$md5_pwd = md5($new_pwd);
			}

			if(!$error){
				if(!(super_admin() && !admin_no_pwd())){
					$db->query_unbuffered("update {$tpf}admins set password='$md5_pwd' where userid='$pd_uid'");
					$sysmsg[] = __('password_modify_success');
				}else{
					$ins = array(
					'userid'=>$pd_uid,
					'password'=>$md5_pwd,
					'intime'=>$timestamp,
					);
					$db->query_unbuffered("insert into {$tpf}admins set ".$db->sql_array($ins)."");
					$sysmsg[] = __('password_submit_success');
				}
				redirect(urr("account","action=adminlogin"),$sysmsg,2000,'top');
			}else{
				redirect('back',$sysmsg);
			}
		}else{
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
		break;
}
function admin_no_pwd(){
	global $db,$tpf,$pd_uid;
	return (int)@$db->result_first("select count(*) from {$tpf}admins where userid='$pd_uid'");
}
?>