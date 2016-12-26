<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-14
 * Time: 오후 12:18
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'jerry');
define('DB_PASS', 'Wlsnrl0805*');
define('DB_NAME', 'surl');
define('SITE_URL', 'http://localhost/');
define('SITE_SHORT_URL', 'http://localhost/api/v1/createShortURL.php');
define('SITE_TITLE', 'ShortURL');
define('VERSION', '1.0.0');

define('URL_PROTOCOLS', 'http|https|ftp|ftps|mailto|news|mms|rtmp|rtmpt|e2dk');

define('KEY', 'itemmania');

error_reporting(E_ALL);

session_start();