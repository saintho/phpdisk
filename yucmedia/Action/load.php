<?php

/**
 * 定义 Load 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: load.php 3325 2012-11-22 06:14:45Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-11-22 14:14:45 +0800 (周四, 2012-11-22) $
 * @package Load
 */
define('P_IS_ACCESS', TRUE);

require('./_base.php');

class Load extends YPrepose implements YIAction {

    private $_comparam;
    private $_local;

    public function __construct() {
        parent::__construct();
    }

    /**
     *  入口执行函数
     */
    public function run() {
        @header('Content-type: text/javascript');
        @header("Pragma:no-cache\r\n");
        @header("Cache-Control:no-cache\r\n");
        @header("Expires:0\r\n");

        $this->_local = new YucLocal();
        $this->_comparam = new YucComParam();

        $this->_comparam->createdFromArray($this->_local->getComParams());
        echo $this->getCreatedJs();
    }

    /**
     *  返回组装的特殊变量
     * @return string
     */
    private function getCreatedJs() {
        //远程数据接收
        return $this->request();
    }

    /**
     *  请求 POST
     * @return type
     */
    private function request() {
        $ret = '';
        $ispost = FALSE;
        if (!YApp::getConfig('YUC_CODE_IS_LOCAL')) {
            $ispost = TRUE;
            $client_back = $this->doPost();
            $cfg = $client_back['content'];
            $c_status = $client_back['status'];
            YLog::Write(var_export($cfg, TRUE), YLog::DEBUG);
        } else {
            YucMonitor::report("REPORT_0001");
            $cfg['result']['code'] = 'O_CODELOCAL_001';
            $cfg['result']['details'] = '强制被本地化处理!';
            YLog::Write('强制本地化验证码', YLog::DEBUG);
        }
        if (!YApp::getConfig('YUC_CODE_IS_LOCAL') && $c_status == 200 && is_array($cfg) && isset($cfg['service']['type']) && $cfg['service']['type'] == 1) {
            YLog::Write('远程响应正常，开始处理远程服务！', YLog::DEBUG);
            $this->_comparam->createdFromArray($cfg['config']);
            $this->_comparam->createdFromArray($cfg['picserver']);
            $this->_comparam->createdFromArray($cfg['session']);
            $this->_comparam->createdFromArray($cfg['position']);
            $this->_comparam->set('request_type', 1);
            $this->_comparam->set('result', returnJSON($cfg['result']));
            if (isset($cfg["reject"])) {
                $ret .= $this->_comparam->createdJsVar(json_decode($cfg["reject"]));
            }
            $ret .= $cfg["js"]["extra"];
            //远程和本地通信缓存交互
            if ($cfg['js']['cached'] === 1) {
                YLog::Write('加载本地缓存 JS Code', YLog::DEBUG);
                $ret .= $this->_local->getCachedJsCode();
            } else {
                YLog::Write('加载远程 JS Code', YLog::DEBUG);
                $ret .= $cfg['js']['jscode'];
                $this->_local->setCachedJsCode($cfg['js']['jscode']);
            }
            posi_update($cfg['update_posi']); //更新广告位信息
        } else {
            if ($ispost && $c_status != 200) {
                YucMonitor::report("REPORT_0002");
                YLog::Write('远程响应出现异常，开始本地服务！', YLog::DEBUG);
            } else if (isset($cfg['service']['type']) && $cfg['service']['type'] == 1) {
                YLog::Write('远程切换服务，开始本地服务！', YLog::DEBUG);
            } else {
                YucMonitor::report("REPORT_0003");
                YLog::Write('其它原因导致，开始本地服务！', YLog::DEBUG);
            }
            $this->_comparam->set('imgsrc', '');
            $this->_comparam->set('request_type', 0);
            $this->_comparam->set('ssid', returnJSON($this->_local->getCreatedSsid()));
            $this->_comparam->set('posiid', returnJSON($this->_local->getPosiIdTeam()));
            $this->_comparam->set('show_type', returnJSON($this->_local->getShowType()));
            $this->_comparam->set('result', returnJSON($cfg['result']));
            $ret .= $this->loadJs('server.js');
            $ret .= $this->_comparam->createdJsVar(array(
                'ssid',
                'show_type',
                'posiid',
                'result',
            ));
            $ret .= $this->loadJs('loadImg.js');
        }
        return $ret;
    }

    /**
     *  POST发送请求数据
     * @return array
     */
    private function doPost() {
        $client = new YucRequest(YApp::getConfig('YUC_SERVICE_NAME'), YApp::getConfig('YUC_SERVICE_PORT'));
        $client->setTimeout(YApp::getConfig('YUC_CLIENT_TIMEOUT')); //设置超时
        $client->post(YApp::getConfig('YUC_REQUEST_PATH'), $this->_local->getPostData());
        YLog::Write('请求：' . YApp::getConfig('YUC_SERVICE_NAME') . YApp::getConfig('YUC_REQUEST_PATH') . ';返回状态 ：' . $client->getStatus() . ';POST请求返回的数据：' . $client->getContent(), YLog::DEBUG);
        $ret_back = json_decode($client->getContent(), TRUE);
        if (!is_array($ret_back)) {
            YucMonitor::report("REPORT_0004", $client->getContent());
        }
        return array(
            'status' => $client->getStatus(),
            'content' => $ret_back,
        );
    }

    /**
     * 加载 Js文件
     * @param $js
     * @return string|type
     */
    private function loadJs($js) {
        $js_code_temp = '';
        $key = md5('__compress_js__' . $js);
        $js_cache_code = F($key);
        if ($js_cache_code === FALSE) {
            $js_arr = explode('|', $js);
            foreach ($js_arr as $js) {
                $file = M_PRO_DIR . '/Media/Js/' . str_replace("_", "/", $js);
                $js_code_temp .= file_get_contents($file);
            }
            $js_cache_code = $js_code_temp;
            F($key, $js_cache_code);
        }
        return $js_cache_code;
    }
}

YAccess::run('Load');

