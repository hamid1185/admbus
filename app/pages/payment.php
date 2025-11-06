<?php
include BASE_PATH . 'layouts/header.php';

// Get booking data from previous form
$booking_data = $_POST ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Security::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        die('CSRF Token সঠিক নয়');
    }
}
?>

<div class="payment-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <span class="text-gray-500">❶ যাত্রী তথ্য</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">❷ পেমেন্ট</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-500">❸ নিশ্চিতকরণ</span>
        </div>
    </div>

    <!-- Payment Section -->
    <section class="payment-section py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold mb-8 text-gray-900">পেমেন্ট পদ্ধতি নির্বাচন করুন</h1>

                <form method="POST" action="?page=confirmation" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">

                    <!-- Payment Methods -->
                    <div class="space-y-4">
                        <!-- bKash -->
                        <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-600 transition" onclick="selectPaymentMethod('bkash')">
                            <input type="radio" name="payment_method" value="bkash" required class="w-5 h-5 text-green-600">
                            <div class="ml-4 flex-1">
                                <div class="font-bold text-lg text-gray-900">bKash</div>
                                <div class="text-gray-600 text-sm">মোবাইল ব্যাংকিং - সবচেয়ে দ্রুত ও নিরাপদ</div>
                            </div>
                            <div class="text-3xl">📱</div>
                        </label>

                        <!-- Nagad -->
                        <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-600 transition" onclick="selectPaymentMethod('nagad')">
                            <input type="radio" name="payment_method" value="nagad" class="w-5 h-5 text-green-600">
                            <div class="ml-4 flex-1">
                                <div class="font-bold text-lg text-gray-900">Nagad</div>
                                <div class="text-gray-600 text-sm">মোবাইল ব্যাংকিং - দ্রুত এবং সহজ লেনদেন</div>
                            </div>
                            <div class="text-3xl">💳</div>
                        </label>

                        <!-- Rocket -->
                        <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-600 transition" onclick="selectPaymentMethod('rocket')">
                            <input type="radio" name="payment_method" value="rocket" class="w-5 h-5 text-green-600">
                            <div class="ml-4 flex-1">
                                <div class="font-bold text-lg text-gray-900">Rocket</div>
                                <div class="text-gray-600 text-sm">ডিজিটাল মানি - সর্বত্র গ্রহণযোগ্য</div>
                            </div>
                            <div class="text-3xl">🚀</div>
                        </label>

                        <!-- Card Payment -->
                        <label class="flex items-center p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-600 transition" onclick="selectPaymentMethod('card')">
                            <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-green-600">
                            <div class="ml-4 flex-1">
                                <div class="font-bold text-lg text-gray-900">ক্রেডিট/ডেবিট কার্ড</div>
                                <div class="text-gray-600 text-sm">ভিসা, মাস্টারকার্ড এবং অন্যান্য কার্ড</div>
                            </div>
                            <div class="text-3xl">💳</div>
                        </label>
                    </div>

                    <!-- Payment Amount Summary -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
                        <h3 class="text-lg font-bold mb-4 text-gray-900">পেমেন্ট বিবরণ</h3>
                        <div class="space-y-2 text-gray-700">
                            <div class="flex justify-between">
                                <span>মোট টিকেট মূল্য:</span>
                                <span class="font-semibold">৳ 250</span>
                            </div>
                            <div class="flex justify-between">
                                <span>প্রসেসিং ফি:</span>
                                <span class="font-semibold">৳ 50</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-xl font-bold text-green-600">
                                <span>মোট পেমেন্ট:</span>
                                <span>৳ 300</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div id="paymentInstructions" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6" style="display:none;">
                        <h3 class="text-lg font-bold mb-3 text-gray-900" id="instructionTitle"></h3>
                        <ul id="instructionList" class="space-y-2 text-gray-700 list-disc list-inside"></ul>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" id="paymentTerms" required class="w-4 h-4">
                        <label for="paymentTerms" class="text-gray-700">আমি বুঝেছি এবং পেমেন্ট শর্তাবলী মেনে নিচ্ছি *</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 mt-8">
                        <button type="submit" id="paymentBtn" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold text-lg transition">
                            পেমেন্ট করতে এগিয়ে যান
                        </button>
                        <button type="button" onclick="window.history.back()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 py-3 rounded-lg font-bold transition">
                            পূর্ববর্তী
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
const paymentInstructions = {
    bkash: {
        title: 'bKash দিয়ে পেমেন্ট করুন',
        steps: [
            'আপনার বিকাশ অ্যাপ খুলুন',
            '"Send Money" অপশন নির্বাচন করুন',
            'আমাদের bKash নম্বর: 01xxxxxxxxx লিখুন',
            'অঙ্ক ৳300 এন্টার করুন',
            'আপনার PIN দিয়ে লেনদেন সম্পন্ন করুন',
            'আমাদের কাছে রেফারেন্স নম্বর পাঠান'
        ]
    },
    nagad: {
        title: 'Nagad দিয়ে পেমেন্ট করুন',
        steps: [
            'Nagad অ্যাপ খুলুন',
            '"Pay" অপশন সিলেক্ট করুন',
            'মার্চেন্ট নম্বর: 01xxxxxxxxx লিখুন',
            'অঙ্ক ৳300 নির্ধারণ করুন',
            'আপনার PIN কনফার্ম করুন',
            'সফলতার বার্তা আমাদের কাছে পাঠান'
        ]
    },
    rocket: {
        title: 'Rocket দিয়ে পেমেন্ট করুন',
        steps: [
            'Rocket সেবা খুলুন',
            '"Send Money" নির্বাচন করুন',
            'আমাদের Rocket নম্বর: 01xxxxxxxxx লিখুন',
            'অঙ্ক ৳300 নিশ্চিত করুন',
            'আপনার পিন দিয়ে অনুমোদন করুন',
            'লেনদেন রেফারেন্স সংরক্ষণ করুন'
        ]
    },
    card: {
        title: 'কার্ড দিয়ে পেমেন্ট করুন',
        steps: [
            'আপনার কার্ড নম্বর প্রবেশ করুন',
            'এক্সপায়ারি ডেট এবং CVV লিখুন',
            'কার্ডহোল্ডার নাম নিশ্চিত করুন',
            'আপনার ব্যাংক থেকে OTP গ্রহণ করুন',
            'OTP যাচাই করুন',
            'পেমেন্ট সম্পন্ন করুন'
        ]
    }
};

function selectPaymentMethod(method) {
    const instructions = paymentInstructions[method];
    const instructionDiv = document.getElementById('paymentInstructions');
    const titleEl = document.getElementById('instructionTitle');
    const listEl = document.getElementById('instructionList');

    titleEl.textContent = instructions.title;
    listEl.innerHTML = instructions.steps.map(step => `<li>${step}</li>`).join('');
    instructionDiv.style.display = 'block';
}
</script>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
