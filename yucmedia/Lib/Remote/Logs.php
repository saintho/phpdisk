<?php

/**
 * 定义 Logs 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Logs.php 1872 2012-09-03 01:24:07Z masong $
 * @author Administrator
 * @author $Author: masong $
 * $Date: 2012-09-03 09:24:07 +0800 (星期一, 2012-09-03) $
 * @package Logs
 */
class Remote_Logs {
 
    public function ls() {
        return array(
            'result' => 1,
            'content' => Files::getLogs()
        );
    }

    public function show($name='') {
		// $name=self::$_string[' $name'];  
        $ret = array();
        //$name = isset($_POST['name']) ? $_POST['name'] : '';
		//$name ='20120831.log';
        $file = M_PRO_DIR . '/Runtime/Log/' . $name . '.php';
		Log::Write('file:' . $file , Log::DEBUG);
		
        $ret = file_get_contents($file);
        return array(
            'result' => 1,
            'content' => $ret
        );
    }

}

?>

