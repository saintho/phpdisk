<?php

!defined('P_W') && exit('Forbidden');
//api mode 1

define('API_USER_USERNAME_NOT_UNIQUE', 100);

class User {

	var $base;
	var $db;

	function User($base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function getInfo($uids, $fields = array()) {
		if (!$uids) {
			return new ApiResponse(false);
		}
		require_once(R_P.'require/showimg.php');

		$uids = is_numeric($uids) ? array($uids) : explode(",",$uids);

		if (!$fields) $fields = array('uid', 'username', 'icon', 'gender', 'location', 'bday');
		
		$userService = L::loadClass('UserService', 'user'); /* @var $userService PW_UserService */
		$users = array();
		foreach ($userService->getByUserIds($uids) as $rt) {
			list($rt['icon']) = showfacedesign($rt['icon'], 1, 'm');
			$rt_a = array();
			foreach ($fields as $field) {
				if (isset($rt[$field])) {
					$rt_a[$field] = $rt[$field];
				}
			}
			$users[$rt['uid']] = $rt_a;
		}
		return new ApiResponse($users);
	}

	function alterName($uid, $newname) {
		$userService = L::loadClass('UserService', 'user'); /* @var $userService PW_UserService */
		$userName = $userService->getUserNameByUserId($uid);
		if (!$userName || $userName == $newname) {
			return new ApiResponse(1);
		}
		$existUserId = $userService->getUserIdByUserName($newname);
		if ($existUserId) {
			return new ApiResponse(API_USER_USERNAME_NOT_UNIQUE);
		}
		$userService->update($uid, array('username' => $newname));

		$user = L::loadClass('ucuser', 'user');
		$user->alterName($uid, $userName, $newname);

		return new ApiResponse(1);
	}

	function deluser($uids) {
		$user = L::loadClass('ucuser', 'user');
		$user->delUserByIds($uids);

		return new ApiResponse(1);
	}

	function synlogin($user) {
		global $timestamp,$onlineip,$tpf,$db;
		list($winduid, $windid, $windpwd) = explode("\t", $this->base->strcode($user, false));
		$cookietime = 86400*7;
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$windid = trim($windid);
		$member = $db->fetch_one_array("SELECT userid,gid,username,password,email FROM {$tpf}users WHERE username='$windid'");
		if($member) {
			$userid = (int)$member['userid'];
			$gid = (int)$member['gid'];
			$username = trim($member['username']);
			$password = trim($member['password']);
			$email = trim($member['email']);
			pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$username\t$password\t$email"),$cookietime);
		}else{
			$email = $timestamp.'@phpwind.net';
			$gid = 4;
			$db->query_unbuffered("insert into {$tpf}users SET username='$windid',password='$windpwd',email='$email',reg_ip='$onlineip',gid='4'");
			$userid = $db->insert_id();
			pd_setcookie('phpdisk_zcore_info',pd_encode("$userid\t$gid\t$windid\t$windpwd\t$email"),$cookietime);
		}	
	}

	function synlogout() {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		pd_setcookie('phpdisk_zcore_info', '', -86400 * 365);
	}
    function getusergroup() {
        $usergroup = array();
        $query = $this->db->query("SELECT gid,gptype,grouptitle FROM ".UC_DBTABLEPRE."usergroups ");
        while($rt= $this->db->fetch_array($query)) {
            $usergroup[$rt['gid']] = $rt;
        }
        return new ApiResponse($usergroup);
    }
}

?>