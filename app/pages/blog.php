<?php
include BASE_PATH . 'layouts/header.php';
?>

<div class="blog-page">
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">ব্লগ</span>
        </div>
    </div>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-4xl font-bold mb-12 text-gray-900">ব্লগ এবং সংবাদ</h1>

            <div class="space-y-8">
                <?php
                $blog_posts = [
                    [
                        'title' => 'এডমিশন বাস সেবা চালু হয়েছে',
                        'date' => '২০২৫-০৬-১১',
                        'excerpt' => 'আমরা গর্বিত যে এডমিশন বাস সেবা আজ থেকে চালু হয়েছে। এটি শিক্ষার্থীদের জন্য একটি নতুন সুযোগ।',
                        'author' => 'এডমিশন বাস টিম'
                    ],
                    [
                        'title' => 'নিরাপদ যাত্রার টিপস',
                        'date' => '২০২৫-০৬-১০',
                        'excerpt' => 'বাসে নিরাপদ যাত্রার জন্য কিছু গুরুত্বপূর্ণ টিপস এবং পরামর্শ।',
                        'author' => 'নিরাপত্তা দল'
                    ],
                    [
                        'title' => 'পেমেন্ট পদ্ধতি সম্পর্কে জানুন',
                        'date' => '২০২৫-০৬-০৯',
                        'excerpt' => 'আমাদের সমর্থিত পেমেন্ট পদ্ধতি এবং কীভাবে নিরাপদে পেমেন্ট করতে হয় তা জানুন।',
                        'author' => 'টেকনিক্যাল টিম'
                    ],
                ];

                foreach ($blog_posts as $post):
                ?>
                <article class="bg-white rounded-lg shadow p-8 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                        <span>📅 <?php echo $post['date']; ?></span>
                        <span>✍️ <?php echo $post['author']; ?></span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3 hover:text-green-600 cursor-pointer transition"><?php echo $post['title']; ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo $post['excerpt']; ?></p>
                    <a href="#" class="text-green-600 hover:text-green-700 font-semibold">সম্পূর্ণ পড়ুন →</a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
