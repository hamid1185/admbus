<?php
/**
 * Helper Functions for Admission Bus Platform
 * All function names in English, Bengali text only in UI
 */

if (defined('HELPERS_LOADED')) {
    return;
}
define('HELPERS_LOADED', true);

/**
 * Format amount in BDT currency
 */
function formatBDT($amount) {
    if ($amount === null || $amount === '') {
        return '৳ 0';
    }
    return '৳ ' . number_format((float)$amount, 0);
}

/**
 * Alias for formatBDT
 */
function format_currency($amount) {
    return formatBDT($amount);
}

/**
 * Format phone number to international format
 */
function formatPhoneNumber($phone) {
    if (empty($phone)) {
        return '';
    }
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) === 11 && substr($phone, 0, 1) === '0') {
        return '+880' . substr($phone, 1);
    } elseif (strlen($phone) === 10) {
        return '+880' . $phone;
    }
    return $phone;
}

/**
 * Alias for formatPhoneNumber
 */
function format_phone($phone) {
    return formatPhoneNumber($phone);
}

/**
 * Format date in custom format
 */
function formatDate($date, $format = 'd-m-Y') {
    if (empty($date)) {
        return '';
    }
    try {
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }
        return date($format, $timestamp);
    } catch (Exception $e) {
        error_log("Date formatting error: " . $e->getMessage());
        return $date;
    }
}

/**
 * Alias for formatDate
 */
function format_date($date, $format = 'd-m-Y') {
    return formatDate($date, $format);
}

/**
 * Generate unique invoice number
 */
function generateInvoiceNumber() {
    return 'INV-' . date('YmdHis') . '-' . rand(1000, 9999);
}

/**
 * Alias for generateInvoiceNumber
 */
function generate_invoice_number() {
    return generateInvoiceNumber();
}

/**
 * Redirect to URL
 */
function redirect($url) {
    if (headers_sent()) {
        echo "<script>window.location.href='$url';</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=$url'></noscript>";
    } else {
        header("Location: " . $url);
    }
    exit;
}

/**
 * Get logged in user (renamed to avoid PHP built-in conflict)
 */
function get_logged_user() {
    return $_SESSION['user'] ?? null;
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user']) && isset($_SESSION['user']['id']);
}

/**
 * Get formatted date with day and month names
 */
function get_formatted_date($date) {
    if (empty($date)) {
        return '';
    }
    
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 
               'July', 'August', 'September', 'October', 'November', 'December'];
    
    try {
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }
        
        $day = date('N', $timestamp) - 1;
        $d = date('d', $timestamp);
        $m = date('m', $timestamp) - 1;
        $y = date('Y', $timestamp);
        
        return $d . ' ' . $months[$m] . ' ' . $y . ', ' . $days[$day];
    } catch (Exception $e) {
        return $date;
    }
}

/**
 * Get all universities list
 */
function get_all_universities() {
    return [
        ['id' => 1, 'name_en' => 'Dhaka University', 'name_bn' => 'ঢাকা বিশ্ববিদ্যালয়', 'division' => 'ঢাকা'],
        ['id' => 2, 'name_en' => 'BUET', 'name_bn' => 'বুয়েট', 'division' => 'ঢাকা'],
        ['id' => 3, 'name_en' => 'Jahangirnagar University', 'name_bn' => 'জাহাঙ্গীরনগর বিশ্ববিদ্যালয়', 'division' => 'ঢাকা'],
        ['id' => 4, 'name_en' => 'Rajshahi University', 'name_bn' => 'রাজশাহী বিশ্ববিদ্যালয়', 'division' => 'রাজশাহী'],
        ['id' => 5, 'name_en' => 'Chittagong University', 'name_bn' => 'চট্টগ্রাম বিশ্ববিদ্যালয়', 'division' => 'চট্টগ্রাম'],
        ['id' => 6, 'name_en' => 'Khulna University', 'name_bn' => 'খুলনা বিশ্ববিদ্যালয়', 'division' => 'খুলনা'],
        ['id' => 7, 'name_en' => 'SUST', 'name_bn' => 'শাহজালাল বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 'division' => 'সিলেট'],
        ['id' => 8, 'name_en' => 'BSMRSTU', 'name_bn' => 'বঙ্গবন্ধু শেখ মুজিবুর রহমান বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 'division' => 'গোপালগঞ্জ'],
    ];
}

/**
 * Log user action
 */
function log_action($user_id, $action, $details = '') {
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] User $user_id: $action";
    if (!empty($details)) {
        $log_message .= " - $details";
    }
    error_log($log_message);
}

/**
 * Sanitize output for display
 */
function clean_output($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Get current page name
 */
function get_current_page() {
    return $_GET['page'] ?? 'home';
}

/**
 * Check if current page matches
 */
function is_current_page($page) {
    return get_current_page() === $page;
}

/**
 * Generate random string
 */
function generate_random_string($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Validate email
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (Bangladesh format)
 */
function is_valid_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return preg_match('/^(880|0)?1[3-9]\d{8}$/', $phone);
}

/**
 * Validate NID number
 */
function is_valid_nid($nid) {
    $nid = preg_replace('/[^0-9]/', '', $nid);
    return preg_match('/^\d{10}$|^\d{13}$|^\d{17}$/', $nid);
}

/**
 * Get time ago format
 */
function time_ago($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;
    
    if ($difference < 60) {
        return $difference . ' seconds ago';
    } elseif ($difference < 3600) {
        return floor($difference / 60) . ' minutes ago';
    } elseif ($difference < 86400) {
        return floor($difference / 3600) . ' hours ago';
    } elseif ($difference < 604800) {
        return floor($difference / 86400) . ' days ago';
    } else {
        return date('d M Y', $timestamp);
    }
}

/**
 * Truncate text
 */
function truncate_text($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Get site URL
 */
function get_site_url() {
    return defined('SITE_URL') ? SITE_URL : '';
}

/**
 * Build URL with parameters
 */
function build_url($page, $params = []) {
    $url = get_site_url() . '?page=' . $page;
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
        }
    }
    return $url;
}

/**
 * Get asset URL
 */
function asset_url($path) {
    return get_site_url() . '/' . ltrim($path, '/');
}

/**
 * Check if request is POST
 */
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check if request is GET
 */
function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Get IP address
 */
function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}

/**
 * Get user agent
 */
function get_user_agent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? '';
}