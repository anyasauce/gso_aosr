<?php
// --- 1. Enable errors for debugging ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- 2. Define project root path ---
<<<<<<< HEAD
if(!defined('ROOT_PATH')){
    define('ROOT_PATH', dirname(__DIR__) . '/');
}
=======
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/../');
}

>>>>>>> 6e36b8a6090a57e4f5adbd68bd94a6dc9374ecaf

// --- 3. Composer autoload ---
require_once ROOT_PATH . 'vendor/autoload.php';

// --- 4. Include database & session ---
require_once ROOT_PATH . 'config/db.php';
require_once ROOT_PATH . 'config/session.php';

// --- 5. Include controllers ---
require_once ROOT_PATH . 'controllers/PHPMailerController.php';
require_once ROOT_PATH . 'controllers/PaymongoController.php';
