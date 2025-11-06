<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/security.php';
require_once BASE_PATH . 'includes/helpers.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Validate CSRF token
    $token = $_POST['csrf_token'] ?? '';
    if (!Security::verifyCSRFToken($token)) {
        throw new Exception('Invalid CSRF token');
    }

    // Sanitize input
    $name = Security::sanitize($_POST['full_name'] ?? '');
    $phone = Security::sanitize($_POST['phone'] ?? '');
    $email = Security::sanitize($_POST['email'] ?? '');
    $nid = Security::sanitize($_POST['nid'] ?? '');
    $destination = Security::sanitize($_POST['destination'] ?? '');
    $journey_date = $_POST['journey_date'] ?? '';
    $num_seats = (int)($_POST['num_seats'] ?? 1);
    $payment_method = Security::sanitize($_POST['payment_method'] ?? '');

    // Validate inputs
    if (empty($name) || empty($phone) || empty($email) || empty($nid)) {
        throw new Exception('সমস্ত প্রয়োজনীয় ক্ষেত্র পূরণ করুন');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('বৈধ ইমেইল ঠিকানা নির্দিষ্ট করুন');
    }

    if (!preg_match('/^(\+880|0)[1-9]\d{9}$/', formatPhoneNumber($phone))) {
        throw new Exception('বৈধ ফোন নম্বর নির্দিষ্ট করুন');
    }

    // Get or create user
    $db = Database::getInstance();
    $user_stmt = $db->query("SELECT id FROM users WHERE email = ? OR phone = ?", [$email, $phone]);
    $user_result = $user_stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];
    } else {
        // Create new user
        $db->query(
            "INSERT INTO users (name, email, phone, nid) VALUES (?, ?, ?, ?)",
            [$name, $email, formatPhoneNumber($phone), $nid]
        );
        $user_id = $db->getConnection()->insert_id;
    }

    // Get route and check availability
    $route_stmt = $db->query("SELECT id, price, available_seats FROM routes WHERE destination = ?", [$destination]);
    $route_result = $route_stmt->get_result();

    if ($route_result->num_rows === 0) {
        throw new Exception('নির্বাচিত রুট পাওয়া যায়নি');
    }

    $route = $route_result->fetch_assoc();
    if ($route['available_seats'] < $num_seats) {
        throw new Exception('পর্যাপ্ত সিট উপলব্ধ নেই');
    }

    // Calculate amount
    $ticket_price = $route['price'] * $num_seats;
    $processing_fee = 50;
    $total_amount = $ticket_price + $processing_fee;

    // Generate invoice number
    $invoice_number = generateInvoiceNumber();

    // Create booking
    $db->query(
        "INSERT INTO bookings (invoice_number, user_id, route_id, num_seats, journey_date, total_amount, payment_method, status) 
         VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')",
        [$invoice_number, $user_id, $route['id'], $num_seats, $journey_date, $total_amount, $payment_method]
    );

    $booking_id = $db->getConnection()->insert_id;

    // Update available seats
    $new_available = $route['available_seats'] - $num_seats;
    $db->query("UPDATE routes SET available_seats = ? WHERE id = ?", [$new_available, $route['id']]);

    // Store in session for next step
    $_SESSION['booking'] = [
        'id' => $booking_id,
        'invoice_number' => $invoice_number,
        'total_amount' => $total_amount,
        'user_id' => $user_id,
        'payment_method' => $payment_method
    ];

    echo json_encode([
        'success' => true,
        'message' => 'বুকিং সফলভাবে তৈরি হয়েছে',
        'booking_id' => $booking_id,
        'invoice_number' => $invoice_number,
        'total_amount' => $total_amount
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
