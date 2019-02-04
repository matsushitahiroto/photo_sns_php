<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:host=localhost;dbname=photo_sns_php');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'xj54bivpjn7hr');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('MAX_FILE_SIZE', 1 * 1024 * 1024);
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/../public_html/postimage');
define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs');

require_once(__DIR__ . '/../lib/function.php');
require_once(__DIR__ . '/autoload.php');

session_start();

// ini_set('display_errors', 1);
//
// define('DSN', 'mysql:host=localhost;dbname=photo_sns_php');
// define('DB_USERNAME', 'dbuser');
// define('DB_PASSWORD', 'xj54bivpjn7hr');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/photo_sns_php/public_html');
// define('MAX_FILE_SIZE', 1 * 1024 * 1024);
// define('THUMBNAIL_WIDTH', 400);
// define('IMAGES_DIR', __DIR__ . '/../public_html/postimage');
// define('THUMBNAIL_DIR', __DIR__ . '/../public_html/thumbs');
//
// require_once(__DIR__ . '/../lib/function.php');
// require_once(__DIR__ . '/autoload.php');
//
// session_start();
