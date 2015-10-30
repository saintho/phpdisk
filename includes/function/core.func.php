<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: core.func.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##

if(!defined('IN_PHPDISK')) {
	exit('[PHPDisk] Access Denied');
}

if(!function_exists('get_discount')){
	function get_discount($uid,$src,$op='asc'){
		return $src;
	}
}
if(!function_exists('show_ext_menu')){
	function show_ext_menu($menu){
		return '';
	}
}
if(!function_exists('auth_task')){
	function auth_task($task){
		echo msg::umsg('Task Error!','err-core-auth_task');
	}
}
if(!function_exists('auth_action')){
	function auth_action($action){
		echo msg::umsg('Read Error!','err-core-auth_action');
	}
}
if(!function_exists('auth_task_domain')){
	function auth_task_domain(){
		echo msg::umsg('Task Error!','err-core-auth_task_domain');
	}
}
if(!function_exists('auth_task_mod_domain')){
	function auth_task_mod_domain(){
		echo msg::umsg('Task Error!','err-core-auth_task_mod_domain');
	}
}
if(!function_exists('auth_task_guest')){
	function auth_task_guest(){
		echo msg::umsg('Task Error!','err-core-auth_task_guest');
	}
}
if(!function_exists('auth_task_space_pwd')){
	function auth_task_space_pwd(){
		echo msg::umsg('Task Error!','err-core-auth_task_space_pwd');
	}
}
if(!function_exists('menu_guest_reg')){
	function menu_guest_reg(){
		return '';
	}
}
if(!function_exists('menu_buy_vip')){
	function menu_buy_vip(){
		return '';
	}
}


?>