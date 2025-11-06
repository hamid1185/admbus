<?php
include BASE_PATH . 'layouts/header.php';
?>

<div class="gallery-page">
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">গ্যালারি</span>
        </div>
    </div>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <h1 class="text-4xl font-bold mb-12 text-gray-900 text-center">আমাদের বাস ফ্লিট</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $bus_images = [
                    ['name' => 'এক্সপ্রেস বাস ১', 'image' => '/placeholder.svg?height=300&width=400'],
                    ['name' => 'এক্সপ্রেস বাস ২', 'image' => '/placeholder.svg?height=300&width=400'],
                    ['name' => 'এক্সপ্রেস বাস ৩', 'image' => '/placeholder.svg?height=300&width=400'],
                    ['name' => 'এক্সপ্রেস বাস ৪', 'image' => '/placeholder.svg?height=300&width=400'],
                    ['name' => 'এক্সপ্রেস বাস ৫', 'image' => '/placeholder.svg?height=300&width=400'],
                    ['name' => 'এক্সপ্রেস বাস ৬', 'image' => '/placeholder.svg?height=300&width=400'],
                ];

                foreach ($bus_images as $bus):
                ?>
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-lg h-64 bg-gray-200">
                        <img src="<?php echo $bus['image']; ?>" alt="<?php echo $bus['name']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                            <button class="bg-white text-gray-900 px-6 py-2 rounded-lg font-semibold opacity-0 group-hover:opacity-100 transition-opacity">দেখুন</button>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mt-4"><?php echo $bus['name']; ?></h3>
                    <p class="text-gray-600">সিট সংখ্যা: ৫০</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
