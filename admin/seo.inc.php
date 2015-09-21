<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: seo.inc.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_ADMINCP')) {
	exit('[PHPDisk] Access Denied');
}
admin_no_power($task,31,$pd_uid);
switch($action){

	default:

		if($task =='update_setting'){
			form_auth(gpc('formhash','P',''),formhash());

			$meta_title = trim(gpc('meta_title','P',''));
			$meta_keywords = trim(gpc('meta_keywords','P',''));
			$meta_description = trim(gpc('meta_description','P',''));
			$meta_title2 = trim(gpc('meta_title2','P',''));
			$meta_keywords2 = trim(gpc('meta_keywords2','P',''));
			$meta_description2 = trim(gpc('meta_description2','P',''));
			$meta_title3 = trim(gpc('meta_title3','P',''));
			$meta_keywords3 = trim(gpc('meta_keywords3','P',''));
			$meta_description3 = trim(gpc('meta_description3','P',''));
			$meta_title_s = trim(gpc('meta_title_s','P',''));
			$meta_keywords_s = trim(gpc('meta_keywords_s','P',''));
			$meta_description_s = trim(gpc('meta_description_s','P',''));
			$meta_title_v = trim(gpc('meta_title_v','P',''));
			$meta_keywords_v = trim(gpc('meta_keywords_v','P',''));
			$meta_description_v = trim(gpc('meta_description_v','P',''));
			$meta_title_d = trim(gpc('meta_title_d','P',''));
			$meta_keywords_d = trim(gpc('meta_keywords_d','P',''));
			$meta_description_d = trim(gpc('meta_description_d','P',''));

			$setting = array(
			'open_rewrite' => 0,
			);
			$settings = gpc('setting','P',$setting);

			if(!$error){

				update_seo('index',0,$meta_title,$meta_keywords,$meta_description);
				if($auth[pd_a]){
					update_seo('public',0,$meta_title2,$meta_keywords2,$meta_description2);
					update_seo('hotfile',0,$meta_title3,$meta_keywords3,$meta_description3);
					update_seo('space',0,$meta_title_s,$meta_keywords_s,$meta_description_s);
					update_seo('viewfile',0,$meta_title_v,$meta_keywords_v,$meta_description_v);
					update_seo('download',0,$meta_title_d,$meta_keywords_d,$meta_description_d);
				}

				settings_cache($settings);

				$sysmsg[] = __('seo_update_success');
				redirect(urr(ADMINCP,"item=$item&menu=$menu"),$sysmsg);

			}else{
				redirect('back',$sysmsg);
			}

		}else{
			$s = get_seo('index',0);
			if($auth[pd_a]){
				$s2 = get_seo('public',0);
				$s3 = get_seo('hotfile',0);
				$ss = get_seo('space',0);
				$sv = get_seo('viewfile',0);
				$sd = get_seo('download',0);
			}

			$setting = $settings;
			require_once template_echo($item,$admin_tpl_dir,'',1);
		}
}
?>