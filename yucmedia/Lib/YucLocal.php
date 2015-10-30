<?php

/**
 * 定义 Local 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo 首次交互的数据处理
 * @version $Id: Local.php 2795 2012-10-29 05:58:13Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-10-29 13:58:13 +0800 (周一, 2012-10-29) $
 * @package Local
 */
class YucLocal {

    private $_possid = "";
    private $_positions;
    private $_context;
    private $_plugin_path;

    public function __construct() {
        $this->_context = new YucContext();
        $this->_plugin_path = dirname($this->_context->baseDir());
        $this->_possid = array_filter(explode(",", $this->_context->get("possid", "")));
        $this->_positions = require(M_PRO_DIR . '/Config/position.php'); //加载广告位信息
    }

    /**
     * PosiTeam
     * @return type
     */
    public function getPositionsIdTeam() {
        $positions_team = array();
        foreach ($this->_positions as $possid => $posiinfo) {
            $md5_val = (isset($posiinfo['md5']) ? $posiinfo['md5'] : md5(''));
            $positions_team[$possid] = $md5_val;
        }
        return $positions_team;
    }

    /**
     * 分析Js缓存状态
     * @return int
     */
    public function getJsCachedStatus() {
        $cached = $this->getCachedJsCode();
        if ($cached === FALSE) {
            $ret = 0;
        } else {
            $ret = 1;
        }
        return $ret;
    }

    /**
     *  获取缓存的js代码
     * @return type
     */
    public function getCachedJsCode() {
        $key = md5('_CLIENT_CACHED_JS_CODE_');
        return F($key);
    }

    /**
     *  设置缓存的Js代码
     * @param type $code
     */
    public function setCachedJsCode($code) {
        $key = md5('_CLIENT_CACHED_JS_CODE_');
        F($key, $code);
    }

    /**
     * 获取请求的POST值
     * @return type
     */
    public function getPostData() {
        return array(
            'site_key' => YApp::getConfig('YUC_SITE_KEY'),
            'cached' => $this->getJsCachedStatus(),
            'yuc_version' => json_encode(YApp::getVersions()),
            'posi_team' => json_encode($this->getPositionsIdTeam()),
            'posi_request' => json_encode($this->_possid),
            'client_ip' => getClientIp(),
            'charset' => YApp::getConfig('YUC_RESPONSE_CHARSET'),
            'plugin_path' => $this->_plugin_path,
            'adl' => YApp::getConfig('YUC_DEV_LANGUAGE'),
            'upper_plus' => YApp::getConfig("YUC_UPPER_PLUS"),
            'plus_request_version' => YApp::getVersions('YUC_PLUS_REQUEST_VESION'),
        );
    }

    /**
     *  生成验证码展示类型
     * @return type
     */
    public function getShowType() {
        $ret = array();
        foreach ($this->_positions as $posiid => $posiinfo) {
            $ret[$posiid] = $posiinfo['showtype'];
        }
        return $ret;
    }

    /**
     *  创建本地ssid
     * @return type
     */
    public function getCreatedSsid() {
        $ret = array();
        $seckeymd5 = md5(YApp::getConfig('YUC_SITE_KEY'));
        foreach ($this->_positions as $posi_id => $posi_one) {
            $ret[$posi_id] = YucMath::createdRandSsidSerial() . ',' . $seckeymd5;
        }
        return $ret;
    }

    /**
     * 验证码posiid关系
     * @return array
     */
    public function getPosiIdTeam() {
        $ret = array();
        foreach ($this->_positions as $posiid => $posiinfo) {
            $ret[$posiid] = $posiinfo['fieldid'];
        }
        return $ret;
    }


    /**
     *  本地的公共参数
     * @return type
     */
    public function getComParams() {
        $ret = array();
        $ret['localserver'] = YucServer::getServerDomain();
        $ret['localport'] = YucServer::getServerPort();
        $ret['installdir'] = $this->_plugin_path;
        $ret['charset'] = YApp::getConfig('YUC_RESPONSE_CHARSET');
        return $ret;
    }

}


