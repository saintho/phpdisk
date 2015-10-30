<?php

/**
 * 定义 YucRequest 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id:$
 * @author Administrator
 * @author $Author: $
 * $Date: 2012-07-10 09:46:31 +0800 (周二, 2012-07-10) $
 * @package YucRequest
 */
class YucRequest {

    private $_host;
    private $_port;
    private $_timeout = 3;
    private $_status = 200;
    private $_content = '';

    public function __construct($host, $port) {
        $this->_host = $host;
        $this->_port = $port;
    }

    /**
     * 设置超时时间
     * @param $timeout
     */
    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }

    /**
     * 批量判断函数存在性
     * @return bool
     */
    private function functionIsExists() {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!function_exists($arg)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * 处理post请求的方式 多种方式自动切换
     * @param $path
     * @param $data
     * @return mixed
     */
    public function post($path, $data) {
        if ($this->functionIsExists('curl_init', 'curl_setopt', 'curl_exec', 'curl_close')) {
            $ret = $this->postByCurl($path, $data);
        } elseif ($this->functionIsExists('fsockopen') || $this->functionIsExists('pfsockopen')) {
            $ret = $this->postBySocket($path, $data);
        } elseif ($this->functionIsExists('stream_socket_client')) {
            $ret = $this->postBySsc($path, $data);
        } elseif ($this->functionIsExists("file_get_contents", "stream_context_create")) {
            $ret = $this->postByFile($path, $data);
        }
        return $ret;
    }

    /**
     * Sockey 版本
     * @param $path
     * @param $data
     * @return array
     */
    private function postBySocket($path, $data) {
        $content = "";
        $post_string = http_build_query($data);
        if (function_exists('fsockopen')) {
            $fp = @fsockopen($this->_host, $this->_port, $errno, $err, $this->_timeout);
        } elseif (function_exists('pfsockopen')) {
            $fp = @pfsockopen($this->_host, $this->_port, $errno, $err, $this->_timeout);
        }

        if ($fp) {
            fwrite($fp, "POST {$path} HTTP/1.0\r\n");
            fwrite($fp, "Host: {$this->_host}:{$this->_port}\r\n");
            fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fwrite($fp, "Content-length: " . strlen($post_string) . "\r\n");
            fwrite($fp, "User-Agent : Yuc Media Agent" . "\r\n");
            fwrite($fp, "Accept:*/*\r\n");
            fwrite($fp, "Connection: close\r\n\r\n");
            fwrite($fp, $post_string);
            $atStart = TRUE;
            while (!feof($fp)) {
                $line = fgets($fp, 1028);
                if ($atStart) {
                    $atStart = FALSE;
                    if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
                        return FALSE;
                    }
                    $this->_status = $m[2];
                    continue;
                }
                $content .= $line;
            }
            fclose($fp);
        }
        $content = preg_replace("/^.*\r\n\r\n/Us", '', $content);
        $this->_content = trim($content);
        return $content;
    }

    /**
     * stream_socket_client版本
     * @param $path
     * @param $data
     * @return bool
     */
    private function postBySsc($path, $data) {
        $content = "";
        $remote_server = "{$this->_host}:{$this->_port}{$path}";
        $post_string = http_build_query($data);
        $fp = @stream_socket_client($remote_server, $errno, $err, $this->_timeout);
        if ($fp) {
            fwrite($fp, "POST {$path} HTTP/1.0\r\n");
            fwrite($fp, "Host: {$this->_host}:{$this->_port}\r\n");
            fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fwrite($fp, "Content-length: " . strlen($post_string) . "\r\n");
            fwrite($fp, "User-Agent : Yuc Media Agent" . "\r\n");
            fwrite($fp, "Accept:*/*\r\n");
            fwrite($fp, "Connection: close\r\n\r\n");
            fwrite($fp, $post_string);
            $atStart = TRUE;
            while (!feof($fp)) {
                $line = fgets($fp, 1028);
                if ($atStart) {
                    $atStart = FALSE;
                    if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
                        return FALSE;
                    }
                    $this->_status = $m[2];
                    continue;
                }
                $content .= $line;
            }
            fclose($fp);
            $content = preg_replace("/^.*\r\n\r\n/Us", '', $content);
        }
        $this->_content = $content;
    }

    /**
     * Curl版本
     * @param $path
     * @param $data
     * @return mixed
     */
    private function postByCurl($path, $data) {
        $remote_server = "http://{$this->_host}:{$this->_port}{$path}";
        $post_string = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, "Yuc Media Post Agent");
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        $content = curl_exec($ch);
        curl_close($ch);
        if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $content, $m)) {
            return FALSE;
        }
        $this->_status = $m[2];
        $content = preg_replace("/^.*\r\n\r\n/Us", '', $content);
        $this->_content = $content;
        return $content;
    }

    /**
     * file_get_contents 版本
     * @param $path
     * @param $data
     * @return string
     */
    private function postByFile($path, $data) {
        $remote_server = "http://{$this->_host}:{$this->_port}{$path}";
        $post_string = http_build_query($data);
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "User-Agent : Yuc Media Agent\r\n" . "Content-length:" . strlen($post_string) . "\r\n" . "Accept:*/*\r\n" . "Connection: close\r\n\r\n",
                'content' => $post_string,
                'protocol_version' => 1.0,
                'timeout' => $this->_timeout,
            )
        );
        $stream_context = stream_context_create($context);
        $content = file_get_contents($remote_server, FALSE, $stream_context);
        if (is_array($http_response_header)) {
            $headers = implode("\r\n", $http_response_header);
            if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $headers, $m)) {
                return FALSE;
            }
            $this->_status = $m[2];
        }
        $this->_content = $content;
        return $content;
    }


    public function getContent() {
        return $this->_content;
    }


    public function getStatus() {
        return $this->_status;
    }

}