<?php
include BASE_PATH . 'layouts/header.php';
?>

<div class="routes-page">
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4 max-w-6xl">
            <a href="?page=home" class="text-gray-600 hover:text-gray-900">হোম</a>
            <span class="text-gray-400 mx-2">/</span>
            <span class="text-gray-900 font-semibold">সব রুট</span>
        </div>
    </div>

    <!-- Routes List Section -->
    <section class="routes-list py-16 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <h1 class="text-4xl font-bold mb-8 text-gray-900">সমস্ত বিশ্ববিদ্যালয়ের রুট</h1>
            
            <!-- Filter and Search -->
            <div class="mb-8 flex gap-4 flex-wrap">
                <input type="text" id="searchInput" placeholder="বিশ্ববিদ্যালয় নাম খুঁজুন..." class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                <select id="divisionFilter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <option value="">সব বিভাগ</option>
                    <option value="dhaka">ঢাকা</option>
                    <option value="chittagong">চট্টগ্রাম</option>
                    <option value="khulna">খুলনা</option>
                    <option value="rajshahi">রাজশাহী</option>
                </select>
            </div>

            <!-- Routes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $routes = [
                    ['id' => 1, 'name' => 'ঢাকা বিশ্ববিদ্যালয়', 'division' => 'dhaka', 'price' => 250, 'seats' => 45],
                    ['id' => 2, 'name' => 'বাংলাদেশ প্রকৌশল বিশ্ববিদ্যালয়', 'division' => 'dhaka', 'price' => 250, 'seats' => 30],
                    ['id' => 3, 'name' => 'জাহাঙ্গীরনগর বিশ্ববিদ্যালয়', 'division' => 'dhaka', 'price' => 200, 'seats' => 25],
                    ['id' => 4, 'name' => 'চট্টগ্রাম বিশ্ববিদ্যালয়', 'division' => 'chittagong', 'price' => 400, 'seats' => 40],
                    ['id' => 5, 'name' => 'খুলনা বিশ্ববিদ্যালয়', 'division' => 'khulna', 'price' => 350, 'seats' => 20],
                    ['id' => 6, 'name' => 'রাজশাহী বিশ্ববিদ্যালয়', 'division' => 'rajshahi', 'price' => 300, 'seats' => 35],
                ];

                foreach ($routes as $route):
                ?>
                <div class="route-card bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo $route['name']; ?></h3>
                    <div class="space-y-2 mb-4 text-sm text-gray-600">
                        <p>💰 মূল্য: <strong class="text-green-600"><?php echo formatBDT($route['price']); ?></strong></p>
                        <p>🚌 উপলব্ধ সিট: <strong><?php echo $route['seats']; ?></strong></p>
                        <p>📍 বিভাগ: <strong><?php echo ucfirst($route['division']); ?></strong></p>
                    </div>
                    <!-- Convert onclick to data attributes for CSP compliance -->
                    <button class="route-select-btn w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition" data-route-id="<?php echo $route['id']; ?>" data-route-name="<?php echo addslashes($route['name']); ?>">
                        টিকেট বুক করুন
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Route selection handler
    document.querySelectorAll('.route-select-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const routeId = this.getAttribute('data-route-id');
            const routeName = this.getAttribute('data-route-name');
            sessionStorage.setItem('selectedRoute', JSON.stringify({id: routeId, name: routeName}));
            window.location.href = '?page=booking';
        });
    });

    // Search and filter functionality
    const searchInput = document.getElementById('searchInput');
    const divisionFilter = document.getElementById('divisionFilter');

    if (searchInput) {
        searchInput.addEventListener('keyup', filterRoutes);
    }
    if (divisionFilter) {
        divisionFilter.addEventListener('change', filterRoutes);
    }

    function filterRoutes() {
        const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const division = document.getElementById('divisionFilter')?.value || '';
        const cards = document.querySelectorAll('.route-card');
        
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const divisionMatch = division === '' || card.textContent.includes(division);
            const searchMatch = text.includes(searchTerm);
            
            card.style.display = (divisionMatch && searchMatch) ? '' : 'none';
        });
    }
});
</script>

<?php include BASE_PATH . 'layouts/footer.php'; ?>
