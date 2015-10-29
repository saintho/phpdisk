<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: folders.inc.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/

if(!defined('IN_PHPDISK') || !defined('IN_MYDISK')) {
	exit('[PHPDisk] Access Denied');
}

$course_id = (int)gpc('course_id','GP',0);
$userid = 0;
//if($pd_gid==1){
//	$userid = @$db->result_first("select userid from {$tpf}files where file_id='$file_id' limit 1");
//}
//$userid = $userid ? (int)$userid : $pd_uid;

switch ($action){

	case 'add_course':
		if($task=='add_course'){
			form_auth(gpc('formhash','P',''),formhash());
			$course_name = trim(gpc('course_name','P',''));
			$cate_id = (int)gpc('cate_id','P','');
			$description = gpc('description','P','');

			if(checklength($course_name,1,150)){
				$error = true;
				$sysmsg[] = "课程名称长度非法，增加失败";
			}elseif(strpos($course_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}
			$num = @$db->result_first("select count(*) from {$tpf}course where user_id='$pd_uid' and course_name='$course_name'");
			if($num){
				$error = true;
				$sysmsg[] = "你开设的课程中，已经存在相同名称的课程";
			}
			if(!$error){
				$ins = array(
				'course_name' => $course_name,
				'cate_id' => $cate_id,
				'user_id' => $pd_uid,
				'description' => $description,
				'view_num' => 0,
				'download_num' => 0,
				'status' => 1,
				'create_date' => time(),
				'update_date' => time(),
				);
				$db->query_unbuffered("insert into {$tpf}course set ".$db->sql_array($ins));
				$sysmsg[] = "增加课程成功";
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$upload_cate = (int)$settings[upload_cate];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
    case 'course_review':
        $course_id = (int)gpc('course_id','GP',0);
        if($task=='course_review'){
            form_auth(gpc('formhash','P',''),formhash());
            $ref = gpc('ref','P','');
            //课程改审核状态
            $sql = "UPDATE {$tpf}course SET status = 2 WHERE courseid = {$course_id}";
            $db->query_unbuffered($sql);
            //章节改审核状态
            $sql = "UPDATE {$tpf}course_chapter_section SET status = 2 WHERE course_id = {$course_id}";
            $db->query_unbuffered($sql);
            //文件改审核状态
            $sql = "UPDATE {$tpf}file_cs_relation SET status = 2 WHERE course_id = {$course_id}";
            $db->query_unbuffered($sql);
            $sysmsg[] = "提交审核成功";
            tb_redirect('reload',$sysmsg);
        }else{
            $ref = $_SERVER['HTTP_REFERER'];
            $course_name = @$db->result_first("select course_name from {$tpf}course where courseid='$course_id' and user_id='$pd_uid'");
            require_once template_echo($item,$user_tpl_dir);
        }
        break;
    case 'course_review_cancel':
        $course_id = (int)gpc('course_id','GP',0);
        if($task=='course_review_cancel'){
            form_auth(gpc('formhash','P',''),formhash());
            $ref = gpc('ref','P','');
            //课程改审核状态
            $sql = "UPDATE {$tpf}course SET status = 1 WHERE courseid = {$course_id}";
            $db->query_unbuffered($sql);
            //章节改审核状态
            $sql = "UPDATE {$tpf}course_chapter_section SET status = 1 WHERE course_id = {$course_id}";
            $db->query_unbuffered($sql);
            //文件改审核状态
            $sql = "UPDATE {$tpf}file_cs_relation SET status = 1 WHERE course_id = {$course_id}";
            $db->query_unbuffered($sql);
            $sysmsg[] = "取消提交审核成功";
            tb_redirect('reload',$sysmsg);
        }else{
            $ref = $_SERVER['HTTP_REFERER'];
            $course_name = @$db->result_first("select course_name from {$tpf}course where courseid='$course_id' and user_id='$pd_uid'");
            require_once template_echo($item,$user_tpl_dir);
        }
        break;
	case 'course_delete':
		$course_id = (int)gpc('course_id','GP',0);
		if($task=='course_delete'){
			form_auth(gpc('formhash','P',''),formhash());
			$ref = gpc('ref','P','');
			$num = @$db->result_first("select count(*) from {$tpf}course_chapter_section where course_id='$course_id'");
			if($num>0){
				$sysmsg[] = "该课程下面存在章节，需要删除章节后才能删除该课程";
				tb_redirect('reload',$sysmsg);
			}else{
				$db->query_unbuffered("delete from {$tpf}course where courseid='$course_id' and user_id='$pd_uid'");
				$sysmsg[] = "删除课程成功";
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$course_name = @$db->result_first("select course_name from {$tpf}course where courseid='$course_id' and user_id='$pd_uid'");
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'modify_course':
		$course_id = (int)gpc('course_id','GP',0);
		$error = $course_id?false:true;
		if($task =='modify_course'){
			form_auth(gpc('formhash','P',''),formhash());
			$course_name = trim(gpc('course_name','P',''));
			$cate_id = (int)gpc('cate_id','P',0);
			$description = gpc('description','P','');

			if(checklength($course_name,1,150)){
				$error = true;
				$sysmsg[] = "课程名称长度非法，增加失败";
			}elseif(strpos($course_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}

			$num = @$db->result_first("select count(*) from {$tpf}course where user_id='$pd_uid' and course_name='$course_name' and courseid<>{$course_id}");
			if($num){
				$error = true;
				$sysmsg[] = "已经存在相同名称的课程";
			}

			if(!$error){
				$ins = array(
					'course_name' => $course_name,
					'cate_id' => $cate_id,
					'description' => $description,
					'update_date' => time(),
				);
				$db->query_unbuffered("update {$tpf}course set ".$db->sql_array($ins)." where courseid='$course_id' and user_id='$pd_uid'");
				tb_redirect('reload',"修改课程成功",0);
			}else{
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$upload_cate = (int)$settings[upload_cate];
			$course_edit = $db->fetch_one_array("select * from {$tpf}course where courseid='{$course_id}' limit 1");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'add_chapter_section':
		$course_id = (int)gpc('course_id','GP',0);
		$error = $course_id?false:true;
		if($task=='add_chapter_section'){
			form_auth(gpc('formhash','P',''),formhash());
			$cs_name = trim(gpc('cs_name','P',''));
			$pid = (int)gpc('pid','P','');
			$description = gpc('description','P','');

			if(checklength($cs_name,1,150)){
				$error = true;
				$sysmsg[] = "章节名称长度非法，增加失败";
			}elseif(strpos($cs_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}
			$num = @$db->result_first("select count(*) from {$tpf}course_chapter_section where course_id<>'$course_id' and cs_name='$cs_name'");
			if($num){
				$error = true;
				$sysmsg[] = "你开设的章节中，已经存在相同名称的章节";
			}
			if(!$error){
				$ins = array(
					'cs_name' => $cs_name,
					'description' => $description,
					'course_id' => $course_id,
					'parent_id' => $pid,
					'view_num' => 0,
					'download_num' => 0,
					'type' => 0,
					'status' => 1,
					'create_date' => time(),
					'update_date' => time(),
				);
				$db->query_unbuffered("insert into {$tpf}course_chapter_section set ".$db->sql_array($ins));
				$sysmsg[] = "增加章节成功";
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'chapter_section_delete':
		$course_id = (int)gpc('course_id','GP',0);
		$cs_id = (int)gpc('cs_id','GP',0);
		if($task=='chapter_section_delete'){
			form_auth(gpc('formhash','P',''),formhash());
			$ref = gpc('ref','P','');
			$num = @$db->result_first("select count(*) from {$tpf}file_cs_relation where cs_id='$cs_id'");
			if($num>0){
				$sysmsg[] = "该章节下面存在文件，需要删除文件后才能删除该章节";
				tb_redirect('reload',$sysmsg);
			}else{
				$db->query_unbuffered("delete from {$tpf}course_chapter_section where csid='$cs_id'");
				$sysmsg[] = "删除课程成功";
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$cs_name = @$db->result_first("select cs_name from {$tpf}course_chapter_section where csid='$cs_id' ");
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'modify_chapter_section':
		$cs_id = (int)gpc('cs_id','GP',0);
		$course_id = (int)gpc('course_id','GP',0);
		$error = ($cs_id && $course_id)?false:true;
		if($task =='modify_chapter_section'){
			form_auth(gpc('formhash','P',''),formhash());
			$cs_name = trim(gpc('cs_name','P',''));
			$pid = (int)gpc('pid','P','');
			$description = gpc('description','P','');

			if(checklength($cs_name,1,150)){
				$error = true;
				$sysmsg[] = "章节名称长度非法，增加失败";
			}elseif(strpos($cs_name,"'")!==false){
				$error = true;
				$sysmsg[] = "不能含有单引号等特殊字符";
			}
			$num = @$db->result_first("select count(*) from {$tpf}course_chapter_section where course_id<>'$course_id' and cs_name='$cs_name'");
			if($num){
				$error = true;
				$sysmsg[] = "你开设的章节中，已经存在相同名称的章节";
			}
			if(!$error){
				$ins = array(
					'cs_name' => $cs_name,
					'description' => $description,
					'course_id' => $course_id,
					'parent_id' => $pid,
					'update_date' => time(),
				);
				$db->query_unbuffered("update {$tpf}course_chapter_section set ".$db->sql_array($ins)." where csid='$cs_id'");
				$sysmsg[] = "修改章节成功";
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('reload',$sysmsg);
			}
		}else{
			$cs_edit = $db->fetch_one_array("select * from {$tpf}course_chapter_section where csid='{$cs_id}' limit 1");
			$ref = $_SERVER['HTTP_REFERER'];
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
	case 'add_file_cs_relation':
		$cs_id = (int)gpc('cs_id','GP',0);
		$course_id = (int)gpc('course_id','GP',0);
		$error = $cs_id?false:true;
		if($task=='add_file_cs_relation') {
			form_auth(gpc('formhash','P',''),formhash());
			$file_ids = gpc('file_ids','P','');
			if(!$error){
                //清除原来的数据
                $db->query_unbuffered("DELETE FROM {$tpf}file_cs_relation WHERE course_id={$course_id} AND cs_id={$cs_id}");
                $courseInfo = $db->get_one("SELECT status FROM {$tpf}course WHERE courseid={$course_id}");
                $statusCourse = $courseInfo['status'];
                foreach($file_ids as $file_id){
					$ins = array(
						'file_id' => $file_id,
						'cs_id' => $cs_id,
						'course_id' => $course_id,
						'status' => $statusCourse,
					);
					$db->query_unbuffered("insert into {$tpf}file_cs_relation set ".$db->sql_array($ins));
				}
				$sysmsg[] = "增加视频成功";
				tb_redirect('reload',$sysmsg);
			}else{
				tb_redirect('reload',$sysmsg);
			}
		}else{
			if(!$error) {
				require(PHPDISK_ROOT . 'includes/class/phptree.class.php');
				//获取用户文件夹
				$sql = "SELECT * FROM {$tpf}folders WHERE userid={$pd_uid} AND in_recycle=0";
				$q = $db->query($sql);
				$user_folder = array();
				while ($rs = $db->fetch_array($q)) {
					$rs['ff_id'] = $rs['folder_id'];
					$rs['in_time'] = date('Y-m-d H:i:s', $rs['in_time']);
					$rs['is_folder'] = 1;
					$user_folder[] = $rs;
				}
				unset($rs);
				//获取用户文件
				$sql = "SELECT * FROM {$tpf}files WHERE userid={$pd_uid} AND is_del=0";
				$q = $db->query($sql);
				$user_file = array();
				$ff_id = 10000000;
				while ($rs = $db->fetch_array($q)) {
					$rs['ff_id'] = $ff_id;
					$ff_id++;
					$rs['file_time'] = date('Y-m-d H:i:s', $rs['file_time']);
					$rs['parent_id'] = $rs['folder_id'];
					$rs['is_file'] = 1;
					$user_file[] = $rs;
				}
				unset($rs);
				//混合文件
				$user_folder_file = array_merge($user_folder, $user_file);
				PHPTree::$config['primary_key'] = 'ff_id';
				PHPTree::$config['parent_key'] = 'parent_id';
				$user_folder_file = PHPTree::makeTreeForHtml($user_folder_file);

				//获取用户已经选取的视频
				$sql = "SELECT file_id FROM {$tpf}file_cs_relation fcr LEFT JOIN {$tpf}course c ON c.courseid = fcr.course_id WHERE user_id={$pd_uid} AND fcr.course_id = {$course_id} AND fcr.cs_id = {$cs_id}";
				$q = $db->query($sql);
				$user_select_file = array();
				while ($rs = $db->fetch_array($q)) {
					$user_select_file[] = $rs['file_id'];
				}
				unset($rs);
				$ref = $_SERVER['HTTP_REFERER'];
				require_once template_echo($item, $user_tpl_dir);
			}else{
				$sysmsg[] = "缺失courseid或csid，非法操作";
				tb_redirect('reload',$sysmsg);
			}
		}
		break;
	case 'file_cs_relation_delete':
		$course_id = (int)gpc('course_id','GP',0);
		$cs_id = (int)gpc('cs_id','GP',0);
		$file_id = (int)gpc('file_id','GP',0);
		if($task=='file_cs_relation_delete'){
			form_auth(gpc('formhash','P',''),formhash());
			$ref = gpc('ref','P','');
			$db->query_unbuffered("delete from {$tpf}file_cs_relation where cs_id='$cs_id' AND file_id = '$file_id'");
			$sysmsg[] = "删除文件成功";
			tb_redirect('reload',$sysmsg);
		}else{
			$ref = $_SERVER['HTTP_REFERER'];
			$file_name = @$db->result_first("select file_name from {$tpf}files where file_id='$file_id' ");
			require_once template_echo($item,$user_tpl_dir);
		}
		break;
}

?>