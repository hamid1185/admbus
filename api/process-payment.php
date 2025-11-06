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
    $booking_id = (int)($_POST['booking_id'] ?? 0);
    $payment_method = Security::sanitize($_POST['payment_method'] ?? '');
    $transaction_id = Security::sanitize($_POST['transaction_id'] ?? '');
    $reference = Security::sanitize($_POST['reference'] ?? '');

    if (!$booking_id || empty($payment_method)) {
        throw new Exception('Invalid booking or payment method');
    }

    $db = Database::getInstance();

    // Get booking
    $booking_stmt = $db->query("SELECT * FROM bookings WHERE id = ?", [$booking_id]);
    $booking = $booking_stmt->get_result()->fetch_assoc();

    if (!$booking) {
        throw new Exception('বুকিং খুঁজে পাওয়া যায়নি');
    }

    // Simulate payment verification
    $payment_success = true; // In production, verify with payment gateway

    if ($payment_success) {
        // Create payment record
        $db->query(
            "INSERT INTO payments (booking_id, transaction_id, amount, method, reference_number, status) 
             VALUES (?, ?, ?, ?, ?, 'success')",
            [$booking_id, $transaction_id, $booking['total_amount'], $payment_method, $reference]
        );

        // Update booking status
        $db->query(
            "UPDATE bookings SET status = 'confirmed', payment_status = 'success' WHERE id = ?",
            [$booking_id]
        );

        echo json_encode([
            'success' => true,
            'message' => 'পেমেন্ট সফল',
            'invoice_number' => $booking['invoice_number'],
            'booking_id' => $booking_id
        ]);
    } else {
        throw new Exception('পেমেন্ট ব্যর্থ হয়েছে');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
