<?php
include BASE_PATH . 'layouts/header.php';
?>

<div class="conditions-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">শর্তাবলী</span>
        </div>
    </div>

    <!-- Content Section -->
    <section class="conditions-section py-16 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            <h1 class="text-4xl font-bold mb-12 text-gray-900">শর্তাবলী এবং নীতি</h1>

            <!-- Section 1 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">১. বুকিং শর্তাবলী</h2>
                <p class="text-gray-700 leading-relaxed mb-4">এডমিশন বাস প্ল্যাটফর্মে বুকিং করার সময় আপনি নিম্নলিখিত শর্তাবলী মেনে চলতে সম্মত হন:</p>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li>সকল তথ্য সঠিক এবং সত্য</li>
                    <li>বয়স কমপক্ষে ১৮ বছর হতে হবে</li>
                    <li>বৈধ পরিচয়পত্র থাকতে হবে</li>
                    <li>কোনো জাল তথ্য প্রদান করা যাবে না</li>
                </ul>
            </div>

            <!-- Section 2 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">২. বাতিলকরণ নীতি</h2>
                <p class="text-gray-700 leading-relaxed">যাত্রার ৭ দিন আগে বাতিল করলে সম্পূর্ণ অর্থ ফেরত দেওয়া হবে।</p>
            </div>

            <!-- Section 3 -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">৩. নিরাপত্তা এবং গোপনীয়তা</h2>
                <p class="text-gray-700 leading-relaxed">আপনার সমস্ত তথ্য SSL এনক্রিপশন দ্বারা সুরক্ষিত এবং গোপনীয় রাখা হয়।</p>
            </div>

            <button onclick="window.print()" class="mt-8 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                প্রিন্ট করুন
            </button>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
