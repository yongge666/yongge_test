<?php
$host_url = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$root_path =  str_replace("\\","/", dirname(__file__));
$root_dir = basename(dirname(__FILE__));
//定义网站全局域名
define('ROOT_URL', 'http://'.$host_url.'/');
define('BASE_URL', 'http://'.$host_url.'/'.$root_dir);
//定义网站根目录全局物理路径
define('BASE_PATH', $root_path.'/');   //D:/WWW/sunupedu
$iweb = dirname(__FILE__)."/lib/iweb.php";
$config = dirname(__FILE__)."/config/config.php";
require($iweb);
IWeb::createWebApp($config)->run();
?>
