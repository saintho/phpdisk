<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: cache_file.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class super_cache {

	function super_cache() {

	}
	public static function cache_type(){
		return array('myinfo','public','file','tag','folder','announce','user','comment','extract','space','search','ads','link','gallery','navigation');
	}
	public static function _set($c_type,$c_key,$uid,$arr,$cache_func){
		global $db,$tpf;
		if(is_array($arr)){
			if($uid){
				$cache_dir = PHPDISK_ROOT.'system/cache/'.$uid.'/'.$c_type.'/'.self::store_path($c_key);
			}else{
				$cache_dir = PHPDISK_ROOT.'system/cache/common/'.$c_type.'/'.self::store_path($c_key);
			}
			$file = $cache_dir.$c_key.'.php';
			make_dir($cache_dir);

			$str = "<?php".LF.LF;
			$str .= "// This is PHPDISK auto-generated file. Do NOT modify me.".LF;
			$str .= "// Cache Time: ".date("Y-m-d H:i:s").LF;
			$str .= "// Function: $cache_func".LF.LF;
			$str .=	"if(!defined('IN_PHPDISK')){".LF;
			$str .= "\texit('[PHPDisk] Access Denied');".LF;
			$str .= "}".LF.LF;
			//$str .= "return '".serialize(self::addslashes_array($arr))."';".LF;
			$str .= "return '".str_replace("'","\'",serialize($arr))."';".LF;
			$str .= "?>".LF;

			write_file($file,$str);

		}else{
			$str = "Cache file _set($c_type,$c_key,$cache_func) data type error!";
			logger::write('cache_log',$str);
			die($str);
		}
	}
	public static function get($cache_func,$c_type='public',$uid=0,$life_time=300){
		global $db,$tpf,$settings;
		if(!in_array($c_type,self::cache_type())){
			$str = "Cache type <b>$c_type</b> is error!";
			logger::write('cache_log',$str);
			die($str);
		}

		if($settings[open_cache]){
			if(!$uid){
				$c_key = md5($c_type.$cache_func);
				$p_dir = 'common/'.$c_type.'/';
			}else{
				$c_key = md5($c_type.$cache_func.$uid);
				$p_dir = $uid.'/'.$c_type.'/';
			}
			make_dir(PHPDISK_ROOT.'system/cache/'.$p_dir);
			$file = PHPDISK_ROOT.'system/cache/'.$p_dir.self::store_path($c_key).$c_key.'.php';

			/*if(file_exists($file) && $life_time==0){
				return unserialize(include_once($file));
			}*/

			if(file_exists($file) && TS-@filemtime($file)<$life_time){
				return unserialize(include_once($file));
			}else{
				//echo $file.'|'.date('Y-m-d H:i:s',@filemtime($file));
				$cache_func2 = $cache_func;
				$param1 = $param2 = '';
				if(strpos($cache_func,'|')!==false){
					$arr = explode('|',$cache_func);
					$cache_func = $arr[0];
					$param1 = $arr[1];
					$param2 = $arr[2];
				}
				if(function_exists($cache_func)){
					if($param2){
						self::_set($c_type,$c_key,$uid,call_user_func($cache_func,$param1,$param2),$cache_func2);
						return call_user_func($cache_func,$param1,$param2);
					}else{
						self::_set($c_type,$c_key,$uid,call_user_func($cache_func,$param1),$cache_func2);
						return call_user_func($cache_func,$param1);
					}
				}else{
					$str = "public static function <b>$c_type,$cache_func2</b> not exists!";
					logger::write('cache_log',$str);
					die($str);
				}
			}
		}else{
			$param1 = $param2 = '';
			if(strpos($cache_func,'|')!==false){
				$arr = explode('|',$cache_func);
				$cache_func = $arr[0];
				$param1 = $arr[1];
				$param2 = $arr[2];
			}
			if($param2){
				return call_user_func($cache_func,$param1,$param2);
			}else{
				return call_user_func($cache_func,$param1);
			}
		}
	}
	public static function clear_all(){
		$cache_dir = PHPDISK_ROOT.'system/cache/';
		self::_get_cache_file($cache_dir);
	}
	public static function clear_by_key($cache_func,$c_type='public',$uid=0){
		if(!$c_uid){
			$c_key = md5($c_type.$cache_func);
			$p_dir = 'common/'.$c_type.'/';
		}else{
			$c_key = md5($c_type.$cache_func.(int)$c_uid);
			$p_dir = $uid.'/'.$c_type.'/';
		}
		$cache_dir = PHPDISK_ROOT.'system/cache/'.$p_dir.self::store_path($c_key);
		self::_get_cache_file($cache_dir,1,$c_key);
	}
	public static function clear_by_uid($c_uid){
		$cache_dir = PHPDISK_ROOT.'system/cache/'.$c_uid.'/';
		self::_get_cache_file($cache_dir);
	}
	public static function clear_by_cate($c_type){
		$cache_dir = PHPDISK_ROOT.'system/cache/common/'.$c_type.'/';
		self::_get_cache_file($cache_dir);
	}
	public static function clear_by_cu($c_uid,$c_type){
		$cache_dir = PHPDISK_ROOT.'system/cache/'.$c_uid.'/'.$c_type.'/';
		self::_get_cache_file($cache_dir);
	}
	public static function _get_cache_file($dir,$dir_flag=1,$key='') {
		static $FILE_COUNT = 1;
		$FILE_COUNT--;
		$dh = @opendir($dir);
		if($dh){
			while(false!==($filename=readdir($dh))){
				$flag = $dir_flag;
				if($filename!='.' && $filename!='..'){
					$FILE_COUNT++;
					if(is_dir($dir.$filename)){
						self::_get_cache_file($dir.$filename.'/',$dir_flag+1);

					}else{
						if(substr($filename,-4)=='.php'){
							if($key){
								@unlink($dir.$key.'.php');
							}else{
								@unlink($dir.$filename);
							}
						}
					}
				}
			}
			closedir($dh);
		}else{
			$str = "$dir not exists , [_get_cache_file]!";
			logger::write('cache_log',$str);
		}
	}
	public static function store_path($c_key){
		return $c_key{0}.$c_key{1}.'/'.$c_key{2}.$c_key{3}.'/';
	}
}
?>