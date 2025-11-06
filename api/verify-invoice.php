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
    $invoice = Security::sanitize($_POST['invoice_number'] ?? '');

    if (empty($invoice)) {
        throw new Exception('ইনভয়েস নম্বর প্রবেশ করুন');
    }

    $db = Database::getInstance();
    $stmt = $db->query(
        "SELECT b.*, u.name, u.phone, r.destination, r.price 
         FROM bookings b 
         JOIN users u ON b.user_id = u.id 
         JOIN routes r ON b.route_id = r.id 
         WHERE b.invoice_number = ?",
        [$invoice]
    );

    $booking = $stmt->get_result()->fetch_assoc();

    if (!$booking) {
        throw new Exception('ইনভয়েস খুঁজে পাওয়া যায়নি');
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'invoice_number' => $booking['invoice_number'],
            'name' => $booking['name'],
            'phone' => $booking['phone'],
            'destination' => $booking['destination'],
            'journey_date' => $booking['journey_date'],
            'num_seats' => $booking['num_seats'],
            'total_amount' => $booking['total_amount'],
            'status' => $booking['status'],
            'payment_status' => $booking['payment_status'],
            'created_at' => $booking['created_at']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
