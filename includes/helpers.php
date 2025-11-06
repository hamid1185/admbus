<?php
if (defined('HELPERS_LOADED')) {
    return;
}
define('HELPERS_LOADED', true);

// Helper Functions - English function names and logic only

function format_currency($amount) {
    return '৳ ' . number_format($amount, 0);
}

function format_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) === 11 && substr($phone, 0, 1) === '0') {
        return '+880' . substr($phone, 1);
    }
    return $phone;
}

function format_date($date, $format = 'd-m-Y') {
    try {
        return date($format, strtotime($date));
    } catch (Exception $e) {
        error_log("Date formatting error: " . $e->getMessage());
        return $date;
    }
}

function generate_invoice_number() {
    return 'INV-' . date('YmdHis') . '-' . rand(10000, 99999);
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function get_logged_in_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user']) && isset($_SESSION['user']['id']);
}

function get_formatted_date($date) {
    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 
               'July', 'August', 'September', 'October', 'November', 'December'];
    
    $day = date('N', strtotime($date)) - 1;
    $d = date('d', strtotime($date));
    $m = date('m', strtotime($date)) - 1;
    $y = date('Y', strtotime($date));
    
    return $d . ' ' . $months[$m] . ' ' . $y . ', ' . $days[$day];
}

function get_all_universities() {
    return [
        ['id' => 1, 'name_en' => 'Dhaka University', 'name_bn' => 'ঢাকা বিশ্ববিদ্যালয়'],
        ['id' => 2, 'name_en' => 'BUET', 'name_bn' => 'বুয়েট'],
        ['id' => 3, 'name_en' => 'Jahangirnagar University', 'name_bn' => 'জাহাঙ্গীরনগর বিশ্ববিদ্যালয়'],
        ['id' => 4, 'name_en' => 'Rajshahi University', 'name_bn' => 'রাজশাহী বিশ্ববিদ্যালয়'],
        ['id' => 5, 'name_en' => 'Chittagong University', 'name_bn' => 'চট্টগ্রাম বিশ্ববিদ্যালয়'],
        ['id' => 6, 'name_en' => 'Khulna University', 'name_bn' => 'খুলনা বিশ্ববিদ্যালয়'],
    ];
}

function log_action($user_id, $action, $details = '') {
    error_log("User $user_id: $action - $details");
}
?>
