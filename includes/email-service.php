<?php
class EmailService {
    
    private static $smtp_host = 'smtp.gmail.com';
    private static $smtp_port = 587;
    private static $smtp_user = '';
    private static $smtp_pass = '';
    private static $from_email = 'noreply@admissionbus.com';
    private static $from_name = 'এডমিশন বাস';

    /**
     * Send booking confirmation email
     */
    public static function sendBookingConfirmation($to_email, $booking_data) {
        $subject = 'বুকিং নিশ্চিতকরণ - ' . $booking_data['invoice_number'];
        
        $body = "
        <h2>বুকিং নিশ্চিতকরণ</h2>
        <p>আপনার বুকিং সফলভাবে নিশ্চিত হয়েছে।</p>
        
        <h3>বুকিং বিস্তারিত</h3>
        <ul>
            <li><strong>ইনভয়েস নম্বর:</strong> {$booking_data['invoice_number']}</li>
            <li><strong>গন্তব্য:</strong> {$booking_data['destination']}</li>
            <li><strong>তারিখ:</strong> {$booking_data['journey_date']}</li>
            <li><strong>আসন সংখ্যা:</strong> {$booking_data['num_seats']}</li>
            <li><strong>মোট পরিমাণ:</strong> {$booking_data['total_amount']} টাকা</li>
        </ul>
        
        <p>ধন্যবাদ, এডমিশন বাস টিম</p>
        ";

        return self::sendEmail($to_email, $subject, $body);
    }

    /**
     * Send payment confirmation email
     */
    public static function sendPaymentConfirmation($to_email, $payment_data) {
        $subject = 'পেমেন্ট সফল - ' . $payment_data['invoice_number'];
        
        $body = "
        <h2>পেমেন্ট সফল</h2>
        <p>আপনার পেমেন্ট সফলভাবে প্রক্রিয়া করা হয়েছে।</p>
        
        <h3>পেমেন্ট বিস্তারিত</h3>
        <ul>
            <li><strong>ইনভয়েস নম্বর:</strong> {$payment_data['invoice_number']}</li>
            <li><strong>পেমেন্ট পদ্ধতি:</strong> {$payment_data['method']}</li>
            <li><strong>লেনদেন আইডি:</strong> {$payment_data['transaction_id']}</li>
            <li><strong>পরিমাণ:</strong> {$payment_data['amount']} টাকা</li>
            <li><strong>তারিখ:</strong> " . date('d-m-Y H:i:s') . "</li>
        </ul>
        
        <p>আপনার টিকেট এখন বৈধ এবং ব্যবহারের জন্য প্রস্তুত।</p>
        ";

        return self::sendEmail($to_email, $subject, $body);
    }

    /**
     * Send password reset email
     */
    public static function sendPasswordReset($to_email, $reset_link) {
        $subject = 'পাসওয়ার্ড রিসেট - এডমিশন বাস';
        
        $body = "
        <h2>পাসওয়ার্ড রিসেট</h2>
        <p>আপনার পাসওয়ার্ড রিসেট করতে নিচের লিংকে ক্লিক করুন।</p>
        <p><a href='{$reset_link}'>পাসওয়ার্ড রিসেট করুন</a></p>
        <p>এই লিংকটি ২৪ ঘন্টা পর্যন্ত বৈধ।</p>
        ";

        return self::sendEmail($to_email, $subject, $body);
    }

    /**
     * Send admin notification
     */
    public static function sendAdminNotification($subject, $message, $admin_email) {
        return self::sendEmail($admin_email, 'এডমিশন বাস - ' . $subject, $message);
    }

    /**
     * Send email
     */
    private static function sendEmail($to_email, $subject, $body) {
        // Use PHP mail() function or mail library
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: " . self::$from_name . " <" . self::$from_email . ">" . "\r\n";

        $mail_result = mail($to_email, $subject, $body, $headers);

        return [
            'success' => $mail_result,
            'message' => $mail_result ? 'ইমেইল পাঠানো হয়েছে' : 'ইমেইল পাঠাতে ব্যর্থ'
        ];
    }
}
?>
