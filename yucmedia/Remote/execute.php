<?php

/**
 * 定义 Index 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: execute.php 1871 2012-09-03 00:41:11Z masong $
 * @author Administrator
 * @author $Author: masong $
 * $Date: 2012-09-03 08:41:11 +0800 (星期一, 2012-09-03) $
 * @package Index
 */
define('M_IS_ACCESS', TRUE);

require('./_base.php');

class Execute extends Prepose implements IAction {

    public function run() {
		
        $data = $this->_context->get("data", '');
       // Log::Write('【加密数据】Remote Accept:' . $data, Log::DEBUG);
        if ($this->_context->isPOST()) {
            $de_data = Crypt::decrypt($data, App::getConfig('YUC_SECURE_KEY'));
          //  Log::Write('解析的加密数据:' . $de_data, Log::DEBUG);
            $post = json_decode($de_data, TRUE);
            if ($post != '' && is_array($post) && $post['site_key'] == md5(App::getConfig('YUC_SITE_KEY'))) {
                $mod = $post['mod'];
                $act = $post['act'];
                $class = 'Remote_' . $mod;
				if($act=='show'&&$mod=='Logs'){
                 $name=$post['name'];
				  $obj = new $class();
				 //self::$_string[' $name']=$name;
				  $ret = $obj->{$act}($name);
				}else{
                $obj = new $class();
                $ret = $obj->{$act}();
				
				}
				
                Log::Write('Remote Run:' . $mod . ',' . $act.','.$ret, Log::DEBUG);
                _returnCryptAjax($ret);
            } else {
                Log::Write('安全认证错误!', Log::DEBUG);
                _returnCryptAjax(array(
                    'result' => 0,
                    'content' => '安全认证比对错误错误!'
                ));
            }
        } else {
            Log::Write('远程控制错误！数据并非POST交互!', Log::DEBUG);
            _returnCryptAjax(array(
                'result' => 0,
                'content' => '远程控制错误！数据并非POST交互!'
            ));
        }
    }

}

Access::run('Execute');
?>
