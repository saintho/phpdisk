<?php
/**
 * Created by JetBrains PhpStorm.
 * User: coolfeel
 * Date: 12-8-17
 * Time: 下午5:34
 * To change this template use File | Settings | File Templates.
 */
/**
 * 定义 Install 类
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id:$
 * @author Administrator
 * @author $Author: $
 * $Date: 2012-07-10 09:46:31 +0800 (周二, 2012-07-10) $
 * @package Install
 */

define('M_IS_ACCESS', TRUE);

require(dirname(__FILE__) . '/Core/Access.php');
// 开始执行框架初始化
Access::start();

class Install extends Prepose implements IAction {

    private $_action = 'index';
    private $_base_dir;
    private $_template_dir;
    private $_view = array();

    public function __construct() {
        parent::__construct();
        $this->_action = $this->_context->get("act", 'index');
        $this->_base_dir = dirname(__FILE__);
        $this->_template_dir = $this->_base_dir . '/Template';
    }

    public function run() {
        $act = $this->_action . 'Action';
        $lock_file = $this->_base_dir . '/yuc.lock';
        if (!file_exists($lock_file) && method_exists($this, $act)) {
            $this->{$act}();
            $template = $this->_template_dir . '/' . $this->_action . '.php';
        } else {
            $this->defineAction();
            $template = $this->_template_dir . '/error.php';
        }
        if (file_exists($template)) {
            extract($this->_view);
            include_once($template);
        } else {
            die('Loss Template!!');
        }
    }

    public function indexAction() {
        $this->_view['_title'] = "插件安装首页";
    }

    public function configAction() {
        $file = $this->_base_dir . '/Config/conf.php';
        if ($this->_context->isPOST()) {
            $_POST['YUC_LOG_TYPE'] = implode(',', $_POST['YUC_LOG_TYPE']);
            unset($_POST['submit']);
            $cache_data = var_export($_POST, TRUE);
            file_put_contents($file, '<?php return ' . $cache_data . ';?>');
        }

        $config = require($file);
        $types = $config['YUC_LOG_TYPE'];
        $config['YUC_LOG_TYPE'] = explode(',', $types);
        $this->_view['_log_type'] = array(
            'EMERG',
            'NOTIC',
            'INFO',
            'DEBUG'
        );
        $write = is_writable($file);
        $this->_view['_write'] = $write;
        $this->_view['_config'] = $config;
        $this->_view['_title'] = "安装配置文件";
    }

    public function rightAction() {
        $specail = array(
            'Runtime/Cache',
            'Runtime/Data',
            'Runtime/Log'
        );
        $dirs = Files::getDirSafeScanRecyle(M_PRO_DIR);
        $this->_view['_specail'] = $specail;
        $this->_view["_dirs"] = $dirs;
        $this->_view['_title'] = "权限检测";
    }

    public function agreementAction() {
        $content = file_get_contents($this->_template_dir . '/common/agreement.html');
        $this->_view['_content'] = $content;
        $this->_view['_title'] = "使用协议";
    }

    public function stepAction() {
        $this->_view['_title'] = "安装步骤";
    }

    public function doAction() {
        $this->_view['_title'] = "更多功能";
    }

    public function helpAction() {
        $this->_view['_title'] = "帮助链接";
    }

    /**
     * 错误页面
     */
    public function errorAction() {
        $this->_view['_title'] = "错误页面";
    }

    public function defineAction() {
        die('Access Defined!!');
    }
}

Access::run('Install');
