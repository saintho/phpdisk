<?php

/**
 * 定义 index 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id:$
 * @author Administrator
 * @author $Author: $
 * $Date: 2012-07-10 09:46:31 +0800 (周二, 2012-07-10) $
 * @package index
 */

define('P_IS_ACCESS', TRUE);

require('./_base.php');

class Index extends YPrepose implements YIAction {

    public function run() {
        $rndCodeStr = implode(',', YucMath::getCheckCode(5, 2));
        $code = urlencode(base64_encode(YucCrypt::encrypt($rndCodeStr, YucMath::erypt_key())));
        $c_id = YucMath::getMultiSerialId(2, 10);
        $plugin_path = dirname($this->_context->baseDir());
        $imgsrc = YucServer::getServerUrl() . "{$plugin_path}/image.php?I_S={$c_id}&mass={$code}";
        $renderid = $this->_context->get('renderid', '');
        echo "yuc_site_config.{$renderid}=" . json_encode(array(
            'imgsrc' => $imgsrc,
            'mass' => $code,
            "result" => array(
                "code" => 0,
                'details' => ''
            )
        ));
    }
}

YAccess::run('Index');