<?php
include BASE_PATH . 'layouts/header.php';
?>

<div class="booking-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <span class="text-gray-900 font-semibold">❶ যাত্রী তথ্য</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-500">❷ পেমেন্ট</span>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-500">❸ নিশ্চিতকরণ</span>
        </div>
    </div>

    <!-- Booking Form Section -->
    <section class="booking-section py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold mb-8 text-gray-900">টিকেট বুকিং ফর্ম</h1>

                <form id="bookingForm" method="POST" action="?page=payment" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">

                    <!-- Passenger Information -->
                    <div class="border-b pb-6">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900">যাত্রী তথ্য</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">সম্পূর্ণ নাম *</label>
                                <input type="text" name="full_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="আপনার নাম লিখুন">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">ফোন নম্বর *</label>
                                <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="01XXXXXXXXX">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">ইমেইল *</label>
                                <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="your@email.com">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">জাতীয়তা নম্বর *</label>
                                <input type="text" name="nid" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="১৩ ডিজিট NID">
                            </div>
                        </div>
                    </div>

                    <!-- Journey Details -->
                    <div class="border-b pb-6">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900">যাত্রার বিবরণ</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">গন্তব্য বিশ্ববিদ্যালয় *</label>
                                <select name="destination" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                                    <option value="">বেছে নিন</option>
                                    <option value="dhaka-university">ঢাকা বিশ্ববিদ্যালয়</option>
                                    <option value="buet">BUET</option>
                                    <option value="jnu">জাহাঙ্গীরনগর বিশ্ববিদ্যালয়</option>
                                    <option value="cu">চট্টগ্রাম বিশ্ববিদ্যালয়</option>
                                    <option value="ku">খুলনা বিশ্ববিদ্যালয়</option>
                                    <option value="ru">রাজশাহী বিশ্ববিদ্যালয়</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">যাত্রার তারিখ *</label>
                                <input type="date" name="journey_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-2">আসন সংখ্যা *</label>
                            <select name="num_seats" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="">বেছে নিন</option>
                                <option value="1">১ জন</option>
                                <option value="2">২ জন</option>
                                <option value="3">৩ জন</option>
                                <option value="4">৪ জন</option>
                                <option value="5">৫ জন</option>
                            </select>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="terms" name="terms" required class="w-4 h-4">
                        <label for="terms" class="text-gray-700">আমি শর্তাবলী এবং বুকিং নীতি মেনে নিচ্ছি *</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold text-lg transition">
                            পরবর্তী: পেমেন্ট তথ্য
                        </button>
                        <button type="reset" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 py-3 rounded-lg font-bold transition">
                            রিসেট করুন
                        </button>
                    </div>
                </form>
            </div>

            <!-- Booking Summary -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900">বুকিং সারাংশ</h3>
                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span>মূল্য (প্রতি টিকেট):</span>
                        <span class="font-semibold">৳ 250</span>
                    </div>
                    <div class="flex justify-between">
                        <span>প্রসেসিং ফি:</span>
                        <span class="font-semibold">৳ 50</span>
                    </div>
                    <div class="border-t pt-2 flex justify-between text-lg font-bold">
                        <span>মোট:</span>
                        <span class="text-green-600">৳ 300</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
