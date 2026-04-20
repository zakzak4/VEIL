<?php
error_reporting(0);
ini_set('display_errors', 0);
// HTTP
define('HTTP_SERVER', 'http://localhost/shop/admin/');
define('HTTP_CATALOG', 'http://localhost/shop/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/shop/admin/');
define('HTTPS_CATALOG', 'http://localhost/shop/');

// DIR
define('DIR_APPLICATION', 'C:/xampp/htdocs/shop/admin/');
define('DIR_SYSTEM', 'C:/xampp/htdocs/shop/system/');
define('DIR_IMAGE', 'C:/xampp/htdocs/shop/image/');
define('DIR_STORAGE', 'C:/xampp/htdocs/shop/storage/');
define('DIR_CATALOG', 'C:/xampp/htdocs/shop/catalog/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'shop');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
