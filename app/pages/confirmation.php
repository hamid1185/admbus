<?php
include BASE_PATH . 'layouts/header.php';

// Generate invoice number
$invoice_number = generateInvoiceNumber();
$_SESSION['last_booking'] = [
    'invoice' => $invoice_number,
    'date' => date('Y-m-d H:i:s'),
    'amount' => 300
];
?>

<div class="confirmation-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <span class="text-gray-500">❶ যাত্রী তথ্য</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-500">❷ পেমেন্ট</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">❸ নিশ্চিতকরণ</span>
        </div>
    </div>

    <!-- Success Message -->
    <section class="confirmation-section py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Success Box -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
                <div class="text-6xl mb-6">✅</div>
                <h1 class="text-4xl font-bold text-green-600 mb-4">বুকিং সফল!</h1>
                <p class="text-xl text-gray-600 mb-8">আপনার টিকেট বুকিং সফলভাবে সম্পন্ন হয়েছে।</p>

                <!-- Invoice Details -->
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-8 text-left mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">বুকিং তথ্য</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">ইনভয়েস নম্বর</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $invoice_number; ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">বুকিং সময়</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo date('d-m-Y H:i'); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">মোট পরিমাণ</p>
                            <p class="text-2xl font-bold text-green-600">৳ 300</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm mb-1">পেমেন্ট স্ট্যাটাস</p>
                            <p class="text-2xl font-bold text-green-600">সফল</p>
                        </div>
                    </div>
                </div>

                <!-- Download Invoice Button -->
                <div class="flex gap-4 justify-center mb-8 flex-wrap">
                    <!-- Convert onclick buttons to use event listeners -->
                    <button id="printConfirmBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                        🖨️ প্রিন্ট করুন
                    </button>
                    <a href="?page=find-invoice" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-semibold transition inline-block">
                        📋 ইনভয়েস খুঁজুন
                    </a>
                    <a href="?page=home" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition inline-block">
                        🏠 হোমে ফিরুন
                    </a>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold mb-6 text-gray-900">পরবর্তী পদক্ষেপ</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="text-3xl">📧</div>
                        <div>
                            <h4 class="font-bold text-gray-900">ইমেইল নিশ্চিতকরণ</h4>
                            <p class="text-gray-600">আপনার ইমেইলে টিকেট বিবরণ পাঠানো হয়েছে। স্প্যাম ফোল্ডার দেখুন।</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-3xl">📱</div>
                        <div>
                            <h4 class="font-bold text-gray-900">এসএমএস নোটিফিকেশন</h4>
                            <p class="text-gray-600">আপনার মোবাইল নম্বরে টিকেট কোড এসএমএসের মাধ্যমে পাঠানো হবে।</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-3xl">🚌</div>
                        <div>
                            <h4 class="font-bold text-gray-900">যাত্রার জন্য প্রস্তুত থাকুন</h4>
                            <p class="text-gray-600">নির্ধারিত সময়ের ৩০ মিনিট আগে যাত্রা বিন্দুতে উপস্থিত থাকুন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('printConfirmBtn')?.addEventListener('click', function() {
        window.print();
    });
});
</script>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
