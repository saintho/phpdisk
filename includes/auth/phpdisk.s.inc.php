<?php  if(!defined('IN_PHPDISK')) { exit('[PHPDisk] Access Denied'); } $auth['is_commercial_edition'] = 1; $auth['com_news_url'] = 'http://www.google.com/m_news/zcore_idx_v2.php'; $auth['com_upgrade_url'] = 'http://www.google.com/autoupdate/zcore_last_version_v2.php'; define('PHPDISK_EDITION','Z-Core Standard Edition'); $auth[pd_s] = true; $auth[close_guest_upload] = true; ?>