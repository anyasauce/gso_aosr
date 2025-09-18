<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!defined('ROOT_PATH')){
    define('ROOT_PATH', dirname(__DIR__) . '/');
}

require_once ROOT_PATH . 'vendor/autoload.php';

require_once ROOT_PATH . 'config/db.php';
require_once ROOT_PATH . 'config/session.php';

require_once ROOT_PATH . 'controllers/PHPMailerController.php';
require_once ROOT_PATH . 'controllers/PaymongoController.php';
