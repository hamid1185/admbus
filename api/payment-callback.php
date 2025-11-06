<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/security.php';
require_once BASE_PATH . 'includes/helpers.php';
require_once BASE_PATH . 'includes/payment-gateway.php';
require_once BASE_PATH . 'includes/email-service.php';

header('Content-Type: application/json');

try {
    $method = Security::sanitize($_GET['method'] ?? '');
    $transaction_id = Security::sanitize($_GET['txn_id'] ?? '');
    $status = Security::sanitize($_GET['status'] ?? '');
    $reference = Security::sanitize($_GET['ref'] ?? '');

    if (empty($transaction_id) || empty($status)) {
        throw new Exception('Invalid callback data');
    }

    $db = Database::getInstance();

    // Find payment record
    $payment_stmt = $db->query(
        "SELECT p.*, b.id as booking_id, b.user_id, b.total_amount, b.invoice_number, u.email 
         FROM payments p 
         JOIN bookings b ON p.booking_id = b.id 
         JOIN users u ON b.user_id = u.id 
         WHERE p.transaction_id = ?",
        [$transaction_id]
    );

    $payment = $payment_stmt->get_result()->fetch_assoc();

    if (!$payment) {
        throw new Exception('Payment record not found');
    }

    if ($status === 'success') {
        // Update payment status
        $db->query(
            "UPDATE payments SET status = 'success', reference_number = ? WHERE transaction_id = ?",
            [$reference, $transaction_id]
        );

        // Update booking status
        $db->query(
            "UPDATE bookings SET status = 'confirmed', payment_status = 'success' WHERE id = ?",
            [$payment['booking_id']]
        );

        // Send confirmation emails
        EmailService::sendPaymentConfirmation($payment['email'], [
            'invoice_number' => $payment['invoice_number'],
            'transaction_id' => $transaction_id,
            'amount' => $payment['total_amount'],
            'method' => $method
        ]);

        $_SESSION['payment_success'] = true;
        $_SESSION['booking_id'] = $payment['booking_id'];
        
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Payment confirmed']);
    } else {
        // Update payment status to failed
        $db->query(
            "UPDATE payments SET status = 'failed' WHERE transaction_id = ?",
            [$transaction_id]
        );

        throw new Exception('Payment was not successful');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
