<?php
include BASE_PATH . 'layouts/header.php';

$search_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice = Security::sanitize($_POST['invoice_number'] ?? '');
    // Here you would query the database to find the invoice
    // For now, showing mock data
    if (!empty($invoice)) {
        $search_result = [
            'invoice' => $invoice,
            'name' => 'মোহাম্মদ আহমেদ',
            'phone' => '01712345678',
            'destination' => 'ঢাকা বিশ্ববিদ্যালয়',
            'date' => '২৫-১১-২০২৫',
            'amount' => 300,
            'status' => 'সফল'
        ];
    }
}
?>

<div class="find-invoice-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">ইনভয়েস খুঁজুন</span>
        </div>
    </div>

    <!-- Search Section -->
    <section class="find-invoice-section py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold mb-6 text-gray-900">আপনার ইনভয়েস খুঁজুন</h1>
                <p class="text-gray-600 mb-8">আপনার ইনভয়েস নম্বর বা ফোন নম্বর ব্যবহার করে বুকিং অনুসন্ধান করুন।</p>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">ইনভয়েস নম্বর *</label>
                        <input type="text" name="invoice_number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="উদাহরণ: INV-20251125123456-1234">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold transition">
                        অনুসন্ধান করুন
                    </button>
                </form>

                <?php if ($search_result): ?>
                <div class="mt-8 bg-green-50 border-2 border-green-200 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-900">✅ ইনভয়েস পাওয়া গেছে</h2>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex justify-between"><span>ইনভয়েস:</span><strong><?php echo $search_result['invoice']; ?></strong></div>
                        <div class="flex justify-between"><span>নাম:</span><strong><?php echo $search_result['name']; ?></strong></div>
                        <div class="flex justify-between"><span>ফোন:</span><strong><?php echo $search_result['phone']; ?></strong></div>
                        <div class="flex justify-between"><span>গন্তব্য:</span><strong><?php echo $search_result['destination']; ?></strong></div>
                        <div class="flex justify-between"><span>তারিখ:</span><strong><?php echo $search_result['date']; ?></strong></div>
                        <div class="border-t pt-3 flex justify-between text-lg font-bold">
                            <span>মোট পরিমাণ:</span>
                            <span class="text-green-600"><?php echo formatBDT($search_result['amount']); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>স্ট্যাটাস:</span>
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full font-semibold"><?php echo $search_result['status']; ?></span>
                        </div>
                    </div>
                </div>
                <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <div class="mt-8 bg-red-50 border-2 border-red-200 rounded-lg p-6">
                    <p class="text-red-800 font-semibold">❌ কোনো ইনভয়েস পাওয়া যায়নি। অনুগ্রহ করে সঠিক তথ্য চেক করুন।</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
