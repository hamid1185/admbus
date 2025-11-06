<?php
class PaymentGateway {
    
    /**
     * Process bKash Payment
     */
    public static function processBKash($amount, $invoice_number, $phone, $user_email) {
        try {
            // bKash API Integration
            $bkash_data = [
                'amount' => $amount,
                'invoiceNumber' => $invoice_number,
                'phoneNumber' => $phone,
                'userEmail' => $user_email,
                'timestamp' => date('Y-m-d H:i:s'),
                'reference' => generateInvoiceNumber()
            ];

            // Send to bKash API (mock implementation)
            $response = [
                'status' => 'success',
                'transactionId' => 'BKT' . time() . rand(1000, 9999),
                'amount' => $amount,
                'method' => 'bKash',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            return [
                'success' => true,
                'transaction_id' => $response['transactionId'],
                'message' => 'bKash payment initiated successfully',
                'redirect_url' => 'https://bkash.app/payment?txn=' . $response['transactionId']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'bKash payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process Nagad Payment
     */
    public static function processNagad($amount, $invoice_number, $phone, $user_email) {
        try {
            $nagad_data = [
                'amount' => $amount,
                'invoiceNumber' => $invoice_number,
                'phoneNumber' => $phone,
                'userEmail' => $user_email,
                'reference' => generateInvoiceNumber()
            ];

            // Nagad API Integration
            $response = [
                'status' => 'success',
                'transactionId' => 'NGD' . time() . rand(1000, 9999),
                'amount' => $amount,
                'method' => 'Nagad'
            ];

            return [
                'success' => true,
                'transaction_id' => $response['transactionId'],
                'message' => 'Nagad payment initiated successfully',
                'redirect_url' => 'https://nagad.com.bd/payment?txn=' . $response['transactionId']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Nagad payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process Rocket Payment
     */
    public static function processRocket($amount, $invoice_number, $phone, $user_email) {
        try {
            $rocket_data = [
                'amount' => $amount,
                'invoice' => $invoice_number,
                'phone' => $phone,
                'email' => $user_email,
                'reference' => generateInvoiceNumber()
            ];

            $response = [
                'status' => 'success',
                'transactionId' => 'RKT' . time() . rand(1000, 9999),
                'amount' => $amount,
                'method' => 'Rocket'
            ];

            return [
                'success' => true,
                'transaction_id' => $response['transactionId'],
                'message' => 'Rocket payment initiated successfully',
                'redirect_url' => 'https://rocket.app/payment?txn=' . $response['transactionId']
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Rocket payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process Card Payment
     */
    public static function processCard($amount, $invoice_number, $card_data, $user_email) {
        try {
            // SSL Commerz or similar gateway
            $card_payment_data = [
                'total_amount' => $amount,
                'tran_id' => $invoice_number,
                'card_number' => self::maskCardNumber($card_data['card_number']),
                'email' => $user_email,
                'currency' => 'BDT'
            ];

            $response = [
                'status' => 'success',
                'transactionId' => 'CRD' . time() . rand(1000, 9999),
                'amount' => $amount,
                'method' => 'Card'
            ];

            return [
                'success' => true,
                'transaction_id' => $response['transactionId'],
                'message' => 'Card payment initiated successfully'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Card payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify Payment
     */
    public static function verifyPayment($transaction_id, $amount, $method) {
        try {
            // Verify with payment gateway (mock implementation)
            $is_valid = self::validateWithGateway($transaction_id, $amount, $method);

            return [
                'success' => $is_valid,
                'verified' => $is_valid,
                'transaction_id' => $transaction_id,
                'message' => $is_valid ? 'Payment verified successfully' : 'Payment verification failed'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Verification error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate with gateway
     */
    private static function validateWithGateway($txn_id, $amount, $method) {
        // In production, make actual API call to payment gateway
        // For now, return true if transaction ID format is valid
        return preg_match('/^(BKT|NGD|RKT|CRD)\d+/', $txn_id);
    }

    /**
     * Mask card number for security
     */
    private static function maskCardNumber($card_number) {
        $card_number = preg_replace('/\D/', '', $card_number);
        return substr_replace($card_number, '****', 4, 8);
    }

    /**
     * Refund payment
     */
    public static function refundPayment($transaction_id, $amount, $method) {
        try {
            $refund_data = [
                'transaction_id' => $transaction_id,
                'refund_amount' => $amount,
                'method' => $method,
                'refund_id' => 'REFUND-' . time() . '-' . rand(1000, 9999)
            ];

            return [
                'success' => true,
                'refund_id' => $refund_data['refund_id'],
                'message' => 'Refund processed successfully'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage()
            ];
        }
    }
}
?>
