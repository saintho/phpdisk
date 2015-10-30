<?php

/**
 * 定义 Files 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Files.php 1988 2012-09-11 09:49:11Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-11 17:49:11 +0800 (星期二, 2012-09-11) $
 * @package Files
 */
class Files {

    static function getFileSafeScanRecyle($base = "./", $code = 'file') {
        static $tree;
        $base = rtrim($base, "/");
        foreach (scandir($base) as $single) {
            if ($single != "." && $single != "..") {
                if (is_file($base . '/' . $single)) {
                    $key = md5_file($base . '/' . $single);
                    $rel = ltrim($base . '/' . $single, M_PRO_DIR);
                    $tree[$rel] = $key;
                } else if ($single != 'Runtime' && is_dir($base . '/' . $single)) {
                    self::getFileSafeScanRecyle($base . '/' . $single, $code);
                }
            }
        }
        return $tree;
    }

    static function getDirSafeScanRecyle($base = "./", $code = 'file') {
        static $tree;
        $base = rtrim($base, "/");
        foreach (scandir($base) as $single) {
            if ($single != "." && $single != "..") {
                if (is_dir($base . '/' . $single)) {
                    $dir = $base . '/' . $single;
                    $key = ltrim($dir, M_PRO_DIR);
                    $tree[$key] = self::dir_writeable($dir);
                    self::getDirSafeScanRecyle($base . '/' . $single, $code);
                }
            }
        }
        return $tree;
    }

    /**
     * 
     * @param type $dir
     * @return int
     */
    static function dir_writeable($dir) {
        $writeable = 0;
        if (!is_dir($dir)) {
            @mkdir($dir, 0777);
        }
        if (is_dir($dir)) {
            $fp = @fopen("$dir/test.tes", 'w');
            if ($fp) {
                @fclose($fp);
                @unlink("$dir/test.tes");
                $writeable = TRUE;
            } else {
                $writeable = FALSE;
            }
        }
        return $writeable;
    }

    /**
     *  获取日志列表
     * @staticvar type $tree
     * @param string|\type $code
     * @return type
     */
    static function getLogs($code = 'logs') {
        static $tree;
        $base = M_PRO_DIR . '/Runtime/Log';
        foreach (scandir($base) as $single) {
            if ($single != "." && $single != "..") {
                if (is_file($base . '/' . $single)) {
                    $file = $base . '/' . $single;
                    $tree[rtrim(basename($file), '.php')] = filesize($file);
                }
            }
        }
        return $tree;
    }

}

