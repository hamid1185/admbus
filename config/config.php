<?php
if (defined('CONFIG_LOADED')) {
    return;
}
define('CONFIG_LOADED', true);

// Production Admission Bus Ticketing Platform
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Development mode - set to false in production
define('DEVELOPMENT_MODE', true);

// define('BASE_PATH', __DIR__ . '/../');
define('LOGS_PATH', BASE_PATH . 'logs/');

// Create logs directory if it doesn't exist
// if (!is_dir(LOGS_PATH)) {
//     mkdir(LOGS_PATH, 0755, true);
// }

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'admission_bus');

// Site Configuration - English in code, Bengali only in UI
define('SITE_NAME', 'Admission Bus');
define('SITE_URL', getenv('SITE_URL') ?: 'http://localhost/admission-bus');
define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'admin@admissionbus.com');
define('SUPPORT_PHONE', '01700000000');

// Payment Gateway Configuration
define('BKASH_API_KEY', getenv('BKASH_API_KEY') ?: '');
define('BKASH_SECRET', getenv('BKASH_SECRET') ?: '');
define('NAGAD_MERCHANT_ID', getenv('NAGAD_MERCHANT_ID') ?: '');
define('NAGAD_API_KEY', getenv('NAGAD_API_KEY') ?: '');

// Security
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'change-this-key-in-production-12345');
define('CSRF_TOKEN_LENGTH', 32);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_WINDOW', 900); // 15 minutes

// Session Configuration
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);

// Timezone
date_default_timezone_set('Asia/Dhaka');
?>
