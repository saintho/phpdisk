<?php

/**
 * 定义 Server 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo Description
 * @version $Id: Server.php 2151 2012-09-17 09:19:11Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-17 17:19:11 +0800 (周一, 2012-09-17) $
 * @package Server
 */
class YucServer {

    /**
     *  访问域名
     * @return type
     */
    static public function getServerDomain() {
        $domain = YApp::getConfig('YUC_LOCAL_SERVER');
        if (trim($domain) == '') {
            return $_SERVER['HTTP_HOST'];
        } else {
            return $domain;
        }
    }

    /**
     *  访问端口
     * @return type
     */
    static public function getServerPort() {
        $port = YApp::getConfig('YUC_LOCAL_PORT');
        if (trim($port) == '') {
            return intval($_SERVER['SERVER_PORT']);
        } else {
            $port = intval($port);
            if ($port == 0) {
                return intval($_SERVER['SERVER_PORT']);
            } else {
                return $port;
            }
        }
    }

    /**
     *  获取访问地址
     * @return type
     */
    static public function getServerUrl() {
        $port = self::getServerPort();
        if ($port == 80) {
            return 'http://' . self::getServerDomain();
        } else {
            return 'http://' . self::getServerDomain() . ':' . $port;
        }
    }

}


