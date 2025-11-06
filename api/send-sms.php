<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH 'config/config.php';
require_once BASE_PATH . 'includes/security.php';

header('Content-Type: application/json');

class SMSService {
    private static $sms_gateway = 'https://api.sms-gateway.com/send';

    public static function sendTicketCode($phone, $ticket_code) {
        $message = "আপনার টিকেট কোড: $ticket_code। এডমিশন বাসে স্বাগতম।";
        
        return self::sendSMS($phone, $message);
    }

    public static function sendOTP($phone, $otp) {
        $message = "আপনার OTP: $otp। এটি কেউকে শেয়ার করবেন না।";
        
        return self::sendSMS($phone, $message);
    }

    private static function sendSMS($phone, $message) {
        try {
            // In production, use actual SMS gateway API
            // For now, return mock success
            return [
                'success' => true,
                'message' => 'SMS sent successfully'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'SMS failed: ' . $e->getMessage()
            ];
        }
    }
}

try {
    $phone = Security::sanitize($_POST['phone'] ?? '');
    $type = Security::sanitize($_POST['type'] ?? '');
    $data = Security::sanitize($_POST['data'] ?? '');

    if (empty($phone) || empty($type)) {
        throw new Exception('Invalid parameters');
    }

    if ($type === 'ticket_code') {
        $result = SMSService::sendTicketCode($phone, $data);
    } elseif ($type === 'otp') {
        $result = SMSService::sendOTP($phone, $data);
    } else {
        throw new Exception('Invalid SMS type');
    }

    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
