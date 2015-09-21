<?php

/**
 * 定义 mLog 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Log.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package mBase
 */
class Log {
    // 日志级别 从上到下，由低到高

    const EMERG = 'EMERG'; // 严重错误: 导致系统崩溃无法使用
    const NOTICE = 'NOTIC'; // 通知: 程序可以运行但是还不够完美的错误
    const INFO = 'INFO'; // 信息: 程序输出信息
    const DEBUG = 'DEBUG'; // 调试: 调试信息

    //日志记录

    static public $_logs = array();
    protected static $_size = 0;

    public function __construct() {

    }

    /**
     * 直接记录日志
     * @param <type> $lvevel
     * @param string $level
     */
    static public function Write($msg, $level = self::DEBUG) {
        $arr_level = explode(',', App::getConfig('YUC_LOG_TYPE'));
        if (in_array($level, $arr_level)) {
            $record = date('Y-m-d H:m:s') . " >>> " . number_format(microtime(TRUE), 5, ".", "") . ' ' . " : " . $level . "\t" . $msg;
            $dest = self::getFile();
            file_put_contents($dest, $record . "\r\n", FILE_APPEND);
        }
    }

    /**
     * 获取日志文件路径
     * @param string $dest
     * @return string
     */
    private static function getFile($dest = "") {
        if ($dest == '') {
            $dest = M_PRO_DIR . '/Runtime/Log/' . str_replace("_", "", date('Y_m_d')) . '.log.php';
        }
        if (!file_exists($dest)) {
            file_put_contents($dest, "<?php die('Access Defined!');?>\r\n", FILE_APPEND);
        } else if (file_exists($dest)) {
            $size = filesize($dest);
            if ($size >= floor(App::getConfig('YUC_LOG_SIZE'))) {
                $new = dirname($dest) . '/' . time() . '-' . basename($dest);
                if (!file_exists($new))
                    rename($dest, $new);
            }
        }
        return $dest;
    }

}

