<?php
/**
 * Footer Layout
 * Includes links, contact info, social media, copyright
 */
?>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">এডমিশন বাস</h3>
                    <p class="text-sm leading-relaxed">আমরা দেশের শিক্ষার্থীদের জন্য নিরাপদ, স্বচ্ছ এবং সহজ বাস টিকেট বুকিং সেবা প্রদান করি।</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">দ্রুত লিংক</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="?page=home" class="hover:text-green-400 transition">হোম</a></li>
                        <li><a href="?page=find-invoice" class="hover:text-green-400 transition">ইনভয়েস খুঁজুন</a></li>
                        <li><a href="?page=conditions" class="hover:text-green-400 transition">শর্তাবলী</a></li>
                        <li><a href="?page=blog" class="hover:text-green-400 transition">ব্লগ</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">সহায়তা</h3>
                    <ul class="text-sm space-y-2">
                        <li>📞 <a href="tel:+8801234567890" class="hover:text-green-400 transition">+88 01234 567890</a></li>
                        <li>📧 <a href="mailto:support@admissionbus.com" class="hover:text-green-400 transition">support@admissionbus.com</a></li>
                        <li>💬 <a href="https://wa.me/88" target="_blank" class="hover:text-green-400 transition">WhatsApp সাপোর্ট</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">আমাদের অনুসরণ করুন</h3>
                    <div class="flex gap-4">
                        <a href="https://facebook.com" target="_blank" class="text-2xl hover:text-green-400 transition">f</a>
                        <a href="https://twitter.com" target="_blank" class="text-2xl hover:text-green-400 transition">𝕏</a>
                        <a href="https://instagram.com" target="_blank" class="text-2xl hover:text-green-400 transition">📷</a>
                        <a href="https://youtube.com" target="_blank" class="text-2xl hover:text-green-400 transition">▶️</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                    <p>&copy; <?php echo date('Y'); ?> এডমিশন বাস। সকল অধিকার সংরক্ষিত।</p>
                    <div class="text-right">
                        <a href="#" class="hover:text-green-400 transition">গোপনীয়তা নীতি</a> • 
                        <a href="#" class="hover:text-green-400 transition">সেবার শর্তাবলী</a>
                    </div>
                </div>
                <p class="text-center text-xs text-gray-500">আপনার ডেটা SSL এনক্রিপশন দ্বারা সুরক্ষিত</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html>
