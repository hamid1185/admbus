<?php
include BASE_PATH . 'layouts/header.php';

$contact_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = Security::sanitize($_POST['name'] ?? '');
    $email = Security::sanitize($_POST['email'] ?? '');
    $message = Security::sanitize($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        // In production, save to database or send email
        $contact_success = true;
    }
}
?>

<div class="contact-page">
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">যোগাযোগ</span>
        </div>
    </div>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-4xl font-bold mb-4 text-gray-900 text-center">আমাদের সাথে যোগাযোগ করুন</h1>
            <p class="text-center text-gray-600 mb-12">যেকোনো প্রশ্ন বা পরামর্শের জন্য আমাদের সাথে যোগাযোগ করুন।</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <?php if ($contact_success): ?>
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                        বার্তা সফলভাবে পাঠানো হয়েছে। শীঘ্রই আমরা যোগাযোগ করব।
                    </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">নাম</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ইমেইল</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">বার্তা</label>
                            <textarea name="message" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-bold transition">পাঠান</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <div class="bg-green-50 border-l-4 border-green-600 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">ফোন</h3>
                        <p class="text-gray-700">+৮৮ ০১৭০০-০০০০০০</p>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">ইমেইল</h3>
                        <p class="text-gray-700">support@admissionbus.com</p>
                    </div>
                    <div class="bg-purple-50 border-l-4 border-purple-600 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">অফিস</h3>
                        <p class="text-gray-700">ঢাকা, বাংলাদেশ</p>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-yellow-600 p-6 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">কর্মসময়</h3>
                        <p class="text-gray-700">সোমবার - শুক্রবার: ৯:০০ - ১৮:০০<br>শনিবার - রবিবার: ১০:০০ - ১৬:০০</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
