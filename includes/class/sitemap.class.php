<?php 
/**
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: sitemap.class.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
*/
!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

class sitemap {

	function sitemap() {

	}
	function build(){
		global $charset,$settings,$db,$tpf,$timestamp;
		$sitemap_file = PHPDISK_ROOT.'sitemap.xml';
		if(!file_exists($sitemap_file) || $timestamp-@filemtime($sitemap_file)>86400){

			$arr = array();
			$q = $db->query("select file_id,file_time from {$tpf}files where in_share=1 order by file_id desc limit 50");
			while ($rs = $db->fetch_array($q)) {
				$rs[loc] = $settings[phpdisk_url].urr("viewfile","file_id={$rs[file_id]}");
				$rs[lastmod] = date('Y-m-d H:i:s',$rs[file_time]);
				$rs[changefreq] = 'daily';
				$rs[priority] = '0.8';
				$arr[] = $rs;
			}
			$db->free($q);
			unset($rs);
			//	ob_end_clean();
			/*		header( "Content-type: application/xml; charset=\"".$charset . "\"", true );
			header( 'Pragma: no-cache' );*/
			$map = '<?xml version="1.0" encoding="'.$charset.'" ?>'.LF;
			$map .= '<!--  sitemap-generator-url="'.$settings[phpdisk_url].'" -->'.LF;
			$map .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.LF;
			$map .= '<url>'.LF;
			$map .= "\t<loc>{$settings[phpdisk_url]}</loc>".LF;
			$map .= "\t<lastmod>". date('Y-m-d H:i:s')."</lastmod>".LF;
			$map .= "\t<changefreq>daily</changefreq>".LF;
			$map .= "\t<priority>1.0</priority>".LF;
			$map .= '</url>'.LF;
			foreach($arr as $v){
				$map .= '<url>'.LF;
				$map .= "\t<loc>{$v[loc]}</loc>".LF;
				$map .= "\t<lastmod>{$v[lastmod]}</lastmod>".LF;
				$map .= "\t<changefreq>{$v[changefreq]}</changefreq>".LF;
				$map .= "\t<priority>{$v[priority]}</priority>".LF;
				$map .= '</url>'.LF;
			}
			$map .= '</urlset>'.LF;
			$map .= '<!--  generated-on="'.date('Y-m-d H:i:s').'" -->'.LF;			
			write_file(PHPDISK_ROOT.'sitemap.xml',$map,'wb+');
		}
	}
}

?>