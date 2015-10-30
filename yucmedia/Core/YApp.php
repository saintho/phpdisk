<?php

/**
 * 定义 YApp 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id:$
 * @author Administrator
 * @author $Author:$
 * $Date:$
 * @package App
 */
class YApp {

    private static $_cache = array();

    public function __construct() {
        $this->init();
    }

    /**
     *  初始化
     */
    private function init() {
        $conf = require(M_PRO_DIR . '/Config/conf.php');
        $server = require(M_PRO_DIR . '/Config/server.php');
        self::$_cache['config'] = array_merge($conf, $server); //加载配置文件
        if (YApp::getConfig('YUC_SESSION_AUTO_START')) {
            session_start(); //启动会话
        }
        self::$_cache['version'] = require(M_PRO_DIR . '/Config/version.php'); //加载版本配置信息
        require(M_PRO_DIR . '/Core/YLog.php'); //加载日志类
        YLog::Write('System Start：' . date('Y-m-d h:i:s'), YLog::DEBUG);
        require(M_PRO_DIR . '/Core/YIAction.php'); //加载Action的接口文件
        require(M_PRO_DIR . '/Core/YFileCache.php'); //加载文件缓存
        require(M_PRO_DIR . '/Core/YPrepose.php'); //加载前置控制器
        require(M_PRO_DIR . '/Core/Function.php'); //加载函数集合
    }

    /**
     *  启动服务
     * @return \App
     */
    static public function start() {
        return new YApp();
    }

    /**
     *  异常 错误处理
     */
    static public function _catch() {
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
     *  获取版本信息
     * @param null $key
     * @return type
     */
    static public function getVersions($key = NULL) {
        if ($key === NULL) {
            return self::$_cache['version'];
        } else {
            return self::$_cache['version'][$key];
        }
    }

    /**
     *  获取配置信息
     * @param type $key
     * @return string
     */
    static public function getConfig($key) {
        if (isset(self::$_cache['config'][$key])) {
            return self::$_cache['config'][$key];
        } else {
            return NULL;
        }
    }

    /**
     *  设置配置信息
     * @param type $key
     * @param type $value
     * @return string
     */
    static public function setConfig($key, $value) {
        self::$_cache['config'][$key] = $value;
        return $value;
    }

    /**
     * 自动注册函数
     * @static
     * @param $className
     * @throws Exception
     */
    static public function _autoLoad($className) {
        try {
            $class_file = M_PRO_DIR . '/Lib/' . str_replace('_', '/', $className) . '.php';
            if (file_exists($class_file)) {
                require_once($class_file);
                YLog::Write('Load Class : ' . $className, YLog::INFO);
            } else {
                throw new Exception('_not_get_class_ : ' . $className);
            }
        } catch (Exception $e) {
            YLog::Write('Error Message:' . $e->getMessage(), YLog::EMERG);
        }
    }

    /**
     * 异常处理
     * @param Exception $e
     * @internal param $ <type> $e
     */
    static public function comException(Exception $e) {
        $errors = array();
        $errors['Message'] = $e->getMessage();
        $errors['Code'] = $e->getCode();
        $errors['Line'] = $e->getLine();
        $errors['File'] = $e->getFile();
        foreach ($errors as $key => $value) {
            YLog::Write("Exception：{$key}:$value", Log::EMERG);
        }

    }

    /**
     * 错误处理
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     * @internal param $ <type> $e
     */
    static public function comError($code, $message, $file, $line) {
        $errors['Message'] = $message;
        $errors['Code'] = $code;
        $errors['Line'] = $line;
        $errors['File'] = $file;
        foreach ($errors as $key => $value) {
            YLog::Write("Error：{$key}:$value", Log::EMERG);
        }
    }
}

