<?php
// Homepage - English code, Bengali UI text
include BASE_PATH . 'layouts/header.php';
?>

<div class="home-page">
    <!-- Top Banner -->
    <div class="top-banner bg-green-600 text-white py-2">
        <div class="container mx-auto px-4 flex justify-center gap-6 text-sm flex-wrap">
            <a href="https://facebook.com" target="_blank" class="hover:opacity-80 transition">
                👍 আমাদের পেজে লাইক দিন
            </a>
            <span class="text-green-200">•</span>
            <a href="https://wa.me/88<?php echo SUPPORT_PHONE; ?>" target="_blank" class="hover:opacity-80 transition">
                💬 সাপোর্ট পেতে ক্লিক করুন
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero bg-gradient-to-r from-blue-900 to-blue-800 text-white py-20">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">এডমিশন বাস টিকেট</h1>
                    <p class="text-xl mb-8 text-gray-100 leading-relaxed">
                        স্বপ্নের বিশ্ববিদ্যালয়ে ভর্তি পরিক্ষা দিতে যাওয়ার নিরাপদ ও সহজ মাধ্যম।
                    </p>
                    <div class="flex gap-4 flex-wrap">
                        <!-- Converted onclick to use data attributes for CSP compliance -->
                        <button class="scroll-to-routes bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition" data-target="#routes">
                            এখনই বুক করুন
                        </button>
                        <button class="go-to-invoice border-2 border-white text-white hover:bg-white hover:text-blue-900 px-8 py-3 rounded-lg font-semibold transition">
                            ইনভয়েস খুঁজুন
                        </button>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="/placeholder.svg?height=400&width=500" alt="Student" class="w-full rounded-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-900">কেন আমাদের বেছে নিন?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-5xl mb-4">🔒</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">সম্পূর্ণ নিরাপদ</h3>
                    <p class="text-gray-600">SSL এনক্রিপশন সহ সম্পূর্ণ নিরাপদ লেনদেন।</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">তাৎক্ষণিক বুকিং</h3>
                    <p class="text-gray-600">মাত্র কয়েক মিনিটে টিকেট বুক করুন।</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="text-5xl mb-4">💳</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">নিরাপদ পেমেন্ট</h3>
                    <p class="text-gray-600">bKash, Nagad, Rocket সহ সব পদ্ধতি।</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Routes Section -->
    <section id="routes" class="routes py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-4xl font-bold text-center mb-4 text-gray-900">আপনার বিশ্ববিদ্যালয় নির্বাচন করুন</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $universities = get_all_universities();
                foreach ($universities as $uni):
                ?>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-xl transition">
                    <img src="/placeholder.svg?height=300&width=400" alt="<?php echo htmlspecialchars($uni['name_en']); ?>" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($uni['name_bn']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($uni['name_en']); ?></p>
                        <!-- Converted onclick to use class for CSP compliance -->
                        <button class="select-university w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition" data-university="<?php echo htmlspecialchars($uni['name_en']); ?>">
                            এখনই বুক করুন
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- Added external script instead of inline for CSP compliance -->
<script src="/assets/js/main.js"></script>
<script nonce="<?php echo isset($nonce) ? $nonce : ''; ?>">
    // Home page event listeners
    document.querySelectorAll('.scroll-to-routes').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById('routes');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    document.querySelectorAll('.go-to-invoice').forEach(btn => {
        btn.addEventListener('click', () => {
            window.location.href = '<?php echo SITE_URL; ?>?page=find-invoice';
        });
    });

    document.querySelectorAll('.select-university').forEach(btn => {
        btn.addEventListener('click', function() {
            const university = this.getAttribute('data-university');
            sessionStorage.setItem('selectedUniversity', university);
            window.location.href = '<?php echo SITE_URL; ?>?page=booking';
        });
    });
</script>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
