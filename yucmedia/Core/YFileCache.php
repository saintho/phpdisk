<?php

/**
 * 定义 YFileCache 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: FileCache.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (周五, 2012-08-31) $
 * @package Cache
 */
class YFileCache {

    protected $_cachepath = NULL;
    protected $_safe_head = '<?php die();?>';
    protected $_safe_head_len = 0;
    protected $_default_config = array();
    protected $_prefix = 'File';

    /**
     * 构造函数
     * @param string $prefix
     * @internal param $ <type> $path
     * @internal param $ <type> $config
     */
    public function __construct($prefix = 'File') {
        $this->_prefix = $prefix;
        $this->_default_config = array_merge($this->_default_config, array('expire' => YApp::getConfig('YUC_CACHE_EXPIRE')));
        $this->_safe_head_len = strlen($this->_safe_head);
    }

    /**
     *  设置缓存时间
     * @param type $t
     */
    public function setExpire($t) {
        $this->_default_config['expire'] = $t;
    }

    /**
     * 根据$id得到缓存文件
     * @param <type> $id
     * @return string
     */
    private function _getCacheFile($id) {
        $dest = M_PRO_DIR . '/Runtime/Cache/' . $this->_prefix . '_' . md5($id) . '_cache' . '.php';
        return $dest;
    }

    /**
     * 设置保存缓存
     * @param $id
     * @param $data
     * @return bool
     */
    public function set($id, $data) {
        try {
            if (trim($id) != '') {
                $cache_data['time'] = microtime(TRUE);
                $cache_data['data'] = $data;
                $file = $this->_getCacheFile($id);
                if (is_writable($file)) {
                    @file_put_contents($file, $this->_safe_head . serialize($cache_data));
                } else {
                    YucMonitor::report("REPORT_0010");
                }
                return TRUE;
            }
        } catch (Exception $exc) {
            return FALSE;
        }
    }

    /**
     * 根据$id得到缓存文件 不判断有效性
     * @param <type> $id
     * @return <type>
     */
    private function getCache($id) {
        if ($this->isCache($id)) {
            $_content = file_get_contents($this->_getCacheFile($id), FALSE, NULL, $this->_safe_head_len);
            $content = unserialize($_content);
            return $content;
        } else {
            return FALSE;
        }
    }

    /**
     * 根据$id得到缓存文件 判断有效性
     * @param <type> $id
     * @return <type>
     */
    public function get($id) {
        $content = $this->getCache($id);
        if ($content) {
            $diff = microtime(TRUE) - $content['time'];
            if ($diff <= $this->_default_config['expire']) {
                return $content['data'];
            }
        }
        return FALSE;
    }

    /**
     * 根据删除缓存文件
     * @param <type> $id
     */
    public function remove($id) {
        if (empty($id)) {
            throw new Exception("File Delete Error! ID Not empty!! ");
        } else {
            if ($this->isCache($id)) {
                unlink($this->_getCacheFile($id));
            }
        }
    }

    /**
     * 判断缓存文件是否存在
     * @param <type> $id
     * @return <type>
     */
    private function isCache($id) {
        if (file_exists($this->_getCacheFile($id))) {
            if (is_readable($this->_getCacheFile($id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

