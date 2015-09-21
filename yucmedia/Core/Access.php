<?php

/**
 * 定义 Access 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Access.php 2187 2012-09-18 10:00:59Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-18 18:00:59 +0800 (星期二, 2012-09-18) $
 * @package Access
 */
//记录开始时间
define('M_START_TIME', microtime(TRUE));

if (!defined('M_IS_ACCESS'))
    define('M_IS_ACCESS', FALSE);


if (!M_IS_ACCESS)
    die('Access Defined');


class Access {

    public function __construct() {
        if (App::getConfig('YUC_IS_DEBUG')) {
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
        //捕获未定义的异常
        set_error_handler(array(
            'App',
            'comError'
        ));
        set_exception_handler(array(
            'App',
            'comException'
        ));
    }

    /**
     *  初始化系统
     */
    static public function start() {
        ob_start();
        define('M_PRO_DIR', dirname(dirname(__FILE__))); //定义项目目录
        require(M_PRO_DIR . '/Core/App.php');
        App::start();
        spl_autoload_register(array(
            'App',
            '_autoLoad'
        )); //开启自动注册加载类
    }

    /**
     *  执行Action
     */
    static public function run($class) {
        $instance = new $class();
        $instance->run();
        Log::Write('System Run Class<run>：' . $class, Log::DEBUG);
        ob_get_flush();
        return $instance;
    }

}

