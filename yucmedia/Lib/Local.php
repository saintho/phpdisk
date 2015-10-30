<?php

/**
 * 定义 Local 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @todo 首次交互的数据处理
 * @version $Id: Local.php 1905 2012-09-05 10:40:33Z zhanghui $
 * @author Administrator
 * @author $Author: zhanghui $
 * $Date: 2012-09-05 18:40:33 +0800 (星期三, 2012-09-05) $
 * @package Local
 */
class Local {

    private $_default_posi_id = 'POSIE1-983856-002526-E7B600-078A26-E8E4E8';
    private $_posi_id;
    private $_render_id;
    private $_posi_team = array();
    private $_posi;
    private $_mode = FALSE;
    private $_js_code;
    private $_context;

    public function __construct() {
        $this->_context = new Context();
        $this->_posi_id = $this->_context->get('posiid', $this->_default_posi_id);
        $this->_render_id = $this->_context->get('renderid', 'yucmedia_Captcha');
        $this->_mode = $this->_context->get('mode', $this->_mode);
        $this->_posi = require(M_PRO_DIR . '/Config/position.php'); //加载广告位信息
    }

    /**
     *  默认的广告ID
     * @return type
     */
    public function getDefaultPosiId() {
        return $this->_default_posi_id;
    }

    /**
     * PosiId
     * @return type
     */
    public function getPosiId() {
        return $this->_posi_id;
    }

    /**
     * PosiTeam
     * @return type
     */
    public function getPosIdTeam() {
        $team = explode(',', $this->_posi_id);
        foreach ($team as $id) {
            $posi = $this->getPosiInfoById($id);
            $temp_md5 = (isset($posi['md5']) ? $posi['md5'] : md5(''));
            $this->_posi_team[$id] = $temp_md5;
        }
        return $this->_posi_team;
    }

    /**
     *  获取广告位信息
     * @param type $id
     * @return array
     */
    public function getPosiInfoById($id) {
        if (isset($this->_posi[$id])) {
            if (isset($this->_posi[$id])) {
                return $this->_posi[$id];
            } else {
                return "yucmedia";
            }
        } else {
            return array(
                $this->_default_posi_id => array(
                    'top' => '0',
                    'left' => '0',
                    'fieldid' => 'input1,input2,input3',
                    'showtype' => '0',
                    'md5' => '24e030ab9b4dab72e4cb94a492bb0814',
                )
            );
        }
    }

    /**
     * 分析Js缓存状态
     * @return int
     */
    public function getJsCachedStatus() {
        $ret = 0;
        $cached = $this->getCachedJsCode();
        if ($cached === FALSE) {
            $ret = 0;
        } else {
            $this->_js_code = $cached;
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
            'site_key' => App::getConfig('YUC_SITE_KEY'),
            'cached' => $this->getJsCachedStatus(),
            'yuc_version' => json_encode(App::getVersions()),
            'posi_team' => json_encode($this->getPosIdTeam()),
            'client_ip' => getClientIp(),
            'charset' => App::getConfig('YUC_RESPONSE_CHARSET'),
            'adl' => 'php',
            'plus_request_version' => App::getVersions('YUC_PLUS_REQUEST_VESION'),
        );
    }

    /**
     *  生成验证码展示类型
     * @return type
     */
    public function getShowType() {
        $ret = array();
        $team = explode(',', $this->_posi_id);
        foreach ($team as $id) {
            $posi = $this->getPosiInfoById($id);
            $ret[$id] = $posi['showtype'];
        }
        return $ret;
    }

    /**
     *  创建本地ssid
     * @return type
     */
    public function getCreatedSsid() {
        $ret = array();
        $seckeymd5 = md5(App::getConfig('YUC_SITE_KEY'));
        foreach ($this->getPosIdTeam() as $posi_id => $posi_one) {
            $ret[$posi_id] = Math::createdRandSsidSerial() . ',' . $seckeymd5;
        }
        return $ret;
    }

    /**
     * 验证码posiid关系
     * @return array
     */
    public function getPosiIdTeam() {
        $ret = array();
        $team = explode(',', $this->_posi_id);
        foreach ($team as $id) {
            $posi = $this->getPosiInfoById($id);
            $ret[$id] = $posi['fieldid'];
        }
        return $ret;
    }


    /**
     *  本地的公共参数
     * @return type
     */
    public function getComParams() {
        $ret = array();
        $ret['localserver'] = Server::getServerDomain();
        $ret['localport'] = Server::getServerPort();
        $ret['installdir'] = App::getConfig('YUC_INSTALL_DIR');
        $ret['charset'] = App::getConfig('YUC_RESPONSE_CHARSET');
        return $ret;
    }

}


