<?php

/**
 * 定义 Access 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Access.php 2820 2012-10-31 00:58:55Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-10-31 08:58:55 +0800 (周三, 2012-10-31) $
 * @package Access
 */
//记录开始时间
define('M_START_TIME', microtime(TRUE));

if (!defined('P_IS_ACCESS'))
    define('P_IS_ACCESS', FALSE);

if (!P_IS_ACCESS)
    die('Access Defined');


class YAccess {

    public function __construct() {
        if (YApp::getConfig('YUC_IS_DEBUG')) {
            if (version_compare(PHP_VERSION, '5.0', '>=')) {
                error_reporting(E_ALL & ~E_STRICT);
            } else {
                error_reporting(E_ALL);
            }
            @ini_set('display_errors', 1);
        } else {
            error_reporting(0); //? E_ERROR | E_WARNING | E_PARSE
            @ini_set('display_errors', 0);
        }
        //扑捉 错误 异常
        App::_catch();
    }

    /**
     *  初始化系统
     */
    static public function start() {
        ob_start();
        define('M_PRO_DIR', dirname(dirname(__FILE__))); //定义项目目录
        require(M_PRO_DIR . '/Core/YApp.php');
        YApp::start();
        spl_autoload_register(array(
            'YApp',
            '_autoLoad'
        )); //开启自动注册加载类
    }

    /**
     *  执行Action
     */
    static public function run($class) {
        $instance = new $class();
        $instance->run();
        YLog::Write('System Run Class<run>：' . $class, YLog::DEBUG);
        ob_get_flush();
        return $instance;
    }

}

