<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/security.php';
require_once BASE_PATH . 'includes/helpers.php';

// Check admin session
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['admin_id'])) {
    redirect('/admin/login.php');
}

$page = isset($_GET['page']) ? Security::sanitize($_GET['page']) : 'dashboard';
$valid_pages = ['dashboard', 'bookings', 'routes', 'users', 'payments', 'reports', 'settings'];

if (!in_array($page, $valid_pages)) {
    $page = 'dashboard';
}

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন ড্যাশবোর্ড - এডমিশন বাস</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gray-900 text-white sticky top-0 z-40 shadow-lg">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            <a href="?page=dashboard" class="text-2xl font-bold">এডমিশন বাস</a>
            <div class="flex items-center gap-4">
                <span class="text-sm">স্বাগতম, <?php echo Security::sanitize($_SESSION['admin_username']); ?></span>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition">লগআউট</a>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="font-bold text-lg mb-6">মেনু</h2>
                <nav class="space-y-2">
                    <a href="?page=dashboard" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'dashboard' ? 'bg-green-600' : ''; ?>">
                        📊 ড্যাশবোর্ড
                    </a>
                    <a href="?page=bookings" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'bookings' ? 'bg-green-600' : ''; ?>">
                        🎫 বুকিং ম্যানেজমেন্ট
                    </a>
                    <a href="?page=routes" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'routes' ? 'bg-green-600' : ''; ?>">
                        🚌 রুট ম্যানেজমেন্ট
                    </a>
                    <a href="?page=users" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'users' ? 'bg-green-600' : ''; ?>">
                        👥 ব্যবহারকারী ব্যবস্থাপনা
                    </a>
                    <a href="?page=payments" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'payments' ? 'bg-green-600' : ''; ?>">
                        💳 পেমেন্ট ট্র্যাকিং
                    </a>
                    <a href="?page=reports" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'reports' ? 'bg-green-600' : ''; ?>">
                        📈 রিপোর্ট এবং বিশ্লেষণ
                    </a>
                    <a href="?page=settings" class="block px-4 py-3 rounded-lg hover:bg-gray-700 transition <?php echo $page === 'settings' ? 'bg-green-600' : ''; ?>">
                        ⚙️ সেটিংস
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="p-8 max-w-7xl mx-auto">
                <?php
                $page_file = BASE_PATH . 'admin/pages/' . $page . '.php';
                if (file_exists($page_file)) {
                    include $page_file;
                } else {
                    include BASE_PATH . 'admin/pages/dashboard.php';
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>
