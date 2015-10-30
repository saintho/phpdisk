<?php

/**
 * 系统上下文
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: Context.php 2186 2012-09-18 09:48:05Z zhanghui $
 * @author $Author: zhanghui $
 * $Date: 2012-09-18 17:48:05 +0800 (周二, 2012-09-18) $
 * @package
 */
class YucContext {

    protected $_coll = array();

    /**
     * 构造函数
     */
    public function __construct() {
        $this->_coll = array_merge($_GET, $_POST);
    }

    /**
     * POST 值的获取
     * @param type $key
     * @param type $value
     * @return type
     */
    public function _post($key, $value = NULL) {
        if ($value === NULL) {
            return isset($_POST[$key]) ? $_POST[$key] : '';
        } else {
            $_POST[$key] = $value;
            return $value;
        }
    }

    /**
     * GET 值的获取
     * @param type $key
     * @param type $value
     * @return type
     */
    public function _get($key, $value = NULL) {
        if ($value === NULL) {
            return isset($_GET[$key]) ? $_GET[$key] : '';
        } else {
            $_GET[$key] = $value;
            return $value;
        }
    }

    /**
     *
     * @param type $key
     * @param string|\type $default
     * @return type
     */
    public function get($key, $default = '') {
        if (isset($this->_coll[$key])) {
            return $this->_coll[$key];
        } else {
            return $default;
        }
    }

    /**
     * 返回请求使用的方法
     *
     * @return string
     */
    function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 返回 HTTP 请求头中的指定信息，如果没有指定参数则返回 false
     *
     * @param string $header 要查询的请求头参数
     *
     * @return string 参数值
     */
    function header($header) {
        $temp = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
        if (!empty($_SERVER[$temp]))
            return $_SERVER[$temp];

        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (!empty($headers[$header]))
                return $headers[$header];
        }

        return FALSE;
    }

    /**
     * 是否是 GET 请求
     *
     * @return boolean
     */
    function isGET() {
        return $this->getRequestMethod() == 'GET';
    }

    /**
     * 是否是 POST 请求
     *
     * @return boolean
     */
    function isPOST() {
        return $this->getRequestMethod() == 'POST';
    }

    /**
     * 是否是 PUT 请求
     *
     * @return boolean
     */
    function isPUT() {
        return $this->getRequestMethod() == 'PUT';
    }

    /**
     * 是否是 DELETE 请求
     *
     * @return boolean
     */
    function isDELETE() {
        return $this->getRequestMethod() == 'DELETE';
    }

    /**
     * 是否是 HEAD 请求
     *
     * @return boolean
     */
    function isHEAD() {
        return $this->getRequestMethod() == 'HEAD';
    }

    /**
     * 是否是 OPTIONS 请求
     *
     * @return boolean
     */
    function isOPTIONS() {
        return $this->getRequestMethod() == 'OPTIONS';
    }

    /**
     * 判断 HTTP 请求是否是通过 XMLHttp 发起的
     *
     * @return boolean
     */
    function isAJAX() {
        return strtolower($this->header('X_REQUESTED_WITH')) == 'xmlhttprequest';
    }

    /**
     * 确定请求的完整 URL
     *
     * 此方法参考 Zend Framework 实现。
     *
     * @return string 请求的完整 URL
     */
    public function requestUri() {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
            $uri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
            $uri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            $uri = '';
        }
        return $uri;
    }

    /**
     * 基础路径
     * @return string
     */
    public function baseUri() {
        $filename = basename($_SERVER['SCRIPT_FILENAME']);
        if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
            $url = $_SERVER['SCRIPT_NAME'];
        } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
            $url = $_SERVER['PHP_SELF'];
        } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
            $url = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
        } else {
            $path = $_SERVER['PHP_SELF'];
            $segs = explode('/', trim($_SERVER['SCRIPT_FILENAME'], '/'));
            $segs = array_reverse($segs);
            $index = 0;
            $last = count($segs);
            $url = '';
            do {
                $seg = $segs[$index];
                $url = '/' . $seg . $url;
                ++$index;
            } while (($last > $index) && (FALSE !== ($pos = strpos($path, $url))) && (0 != $pos));
        }

        // Does the baseUrl have anything in common with the request_uri?
        $request_uri = $this->requestUri();

        if (0 === stripos($request_uri, $url)) {
            return $url;
        }

        if (0 === stripos($request_uri, dirname($url))) {
            return rtrim(dirname($url), '/') . '/';
        }

        if (!stripos($request_uri, basename($url))) {
            return '';
        }

        if ((strlen($request_uri) >= strlen($url)) && ((FALSE !== ($pos = stripos($request_uri, $url))) && ($pos !== 0))) {
            $url = substr($request_uri, 0, $pos + strlen($url));
        }

        return rtrim($url, '/') . '/';
    }

    /**
     * 返回请求 URL 中的基础路径（不包含脚本名称）
     *
     * @return string 请求 URL 中的基础路径
     */
    public function baseDir() {
        $base_uri = $this->baseUri();
        if (substr($base_uri, -1, 1) == '/') {
            $base_dir = $base_uri;
        } else {
            $base_dir = dirname($base_uri);
        }
        $base_dir = rtrim($base_dir, '/\\');
        $base_dir = str_replace("//", "/", $base_dir);
        return $base_dir;
    }

    //**************************************************************************
    //魔法函数

    public function __get($key) {
        if (isset($this->_coll[$key])) {
            return $this->_coll[$key];
        }
        return NULL;
    }

    public function __set($key, $value) {
        $this->_coll[$key] = $value;
        return $this->_coll[$key];
    }

    /*
     * 输出字符创
     */

    public function __toString() {
        $ret = '';
        foreach ($this->_coll as $key => $value) {
            $ret .= "{$key}：{$value}；";
        }
        return $ret;
    }

    /**
     * 单子模式实例化
     * @return Context|object
     */
    static public function getInstance() {
        static $instance_context;
        if (!is_object($instance_context)) {
            $instance_context = new YucContext();
        }
        return $instance_context;
    }

}


