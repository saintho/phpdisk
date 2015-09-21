<?php

/**
 * 定义 CacheFile 类
 *
 * @link http://www.yucmedia.com/
 * @copyright Copyright (c) 2011-2012 宇初网络技术有限公司 {@link http://www.yucmedia.com/}
 * @version $Id: FileCache.php 1852 2012-08-31 02:57:50Z zhanghui $
 * @author $Author: zhanghui $
 * $Date: 2012-08-31 10:57:50 +0800 (星期五, 2012-08-31) $
 * @package Cache
 */
class FileCache {

    protected $_cachepath = null;
    protected $_safe_head = '<?php die();?>';
    protected $_safe_head_len = 0;
    protected $_default_config = array();
    protected $_prefix = 'File';

    /**
     * 构造函数
     * @param <type> $path
     * @param <type> $config
     */
    public function __construct($prefix = 'File') {
        $this->_prefix = $prefix;
        $this->_default_config = array_merge($this->_default_config, array('expire' => App::getConfig('YUC_CACHE_EXPIRE')));
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
     * @param <type> $id
     * @param <type> $data
     */
    public function set($id, $data) {
        try {
            if (trim($id) != '') {
                $cache_data['time'] = microtime(true);
                $cache_data['data'] = $data;
                file_put_contents($this->_getCacheFile($id), $this->_safe_head . serialize($cache_data));
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * 根据$id得到缓存文件 不判断有效性
     * @param <type> $id
     * @return <type>
     */
    private function getCache($id) {
        if ($this->isCache($id)) {
            $_content = file_get_contents($this->_getCacheFile($id), false, null, $this->_safe_head_len);
            $content = unserialize($_content);
            return $content;
        } else {
            return false;
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
            $diff = microtime(true) - $content['time'];
            if ($diff <= $this->_default_config['expire']) {
                return $content['data'];
            }
        }
        return false;
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
                return true;
            }
        }
        return false;
    }

}

