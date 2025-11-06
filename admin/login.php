<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/security.php';
require_once BASE_PATH . 'includes/helpers.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = Security::sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'ব্যবহারকারীনাম এবং পাসওয়ার্ড প্রবেশ করুন';
    } else {
        // Query admin user
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM admin_users WHERE username = ? AND is_active = 1", [$username]);
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            
            // Verify password
            if (Security::verifyPassword($password, $admin['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];
                
                // Update last login
                $db->query("UPDATE admin_users SET last_login = NOW() WHERE id = ?", [$admin['id']]);

                redirect('/admin/index.php?page=dashboard');
            } else {
                $error = 'পাসওয়ার্ড ভুল';
            }
        } else {
            $error = 'ব্যবহারকারী খুঁজে পাওয়া যায়নি';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন - এডমিশন বাস</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">এডমিন প্যানেল</h1>
                    <p class="text-gray-600 mt-2">এডমিশন বাস ম্যানেজমেন্ট সিস্টেম</p>
                </div>

                <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">ব্যবহারকারীনাম</label>
                        <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="আপনার ব্যবহারকারীনাম">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">পাসওয়ার্ড</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="আপনার পাসওয়ার্ড">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4">
                        <label for="remember" class="text-gray-700 text-sm">আমাকে মনে রাখুন</label>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition">
                        লগইন করুন
                    </button>
                </form>

                <p class="text-center text-gray-600 text-sm mt-6">
                    সমস্যা? <a href="<?php echo SITE_URL; ?>/admin/forgot-password.php" class="text-green-600 hover:text-green-700">পাসওয়ার্ড রিসেট করুন</a>
                </p>
            </div>

            <p class="text-center text-gray-600 text-sm mt-6">
                <a href="<?php echo SITE_URL; ?>" class="text-green-600 hover:text-green-700">হোমে ফিরুন</a>
            </p>
        </div>
    </div>
</body>
</html>
