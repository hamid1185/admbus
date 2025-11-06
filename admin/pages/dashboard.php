<?php
$db = Database::getInstance();

// Get statistics
$bookings_stmt = $db->query("SELECT COUNT(*) as total FROM bookings");
$bookings = $bookings_stmt->get_result()->fetch_assoc();

$users_stmt = $db->query("SELECT COUNT(*) as total FROM users");
$users = $users_stmt->get_result()->fetch_assoc();

$revenue_stmt = $db->query("SELECT SUM(total_amount) as total FROM payments WHERE status = 'success'");
$revenue = $revenue_stmt->get_result()->fetch_assoc();

$pending_stmt = $db->query("SELECT COUNT(*) as total FROM bookings WHERE status = 'pending'");
$pending = $pending_stmt->get_result()->fetch_assoc();

// Get recent bookings
$recent_stmt = $db->query("
    SELECT b.invoice_number, u.name, r.destination, b.total_amount, b.status, b.created_at
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN routes r ON b.route_id = r.id
    ORDER BY b.created_at DESC
    LIMIT 10
");
$recent_bookings = $recent_stmt->get_result();
?>

<div>
    <h1 class="text-4xl font-bold text-gray-900 mb-8">ড্যাশবোর্ড</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">মোট বুকিং</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo $bookings['total']; ?></p>
                </div>
                <div class="text-4xl">🎫</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">মোট ব্যবহারকারী</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo $users['total']; ?></p>
                </div>
                <div class="text-4xl">👥</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">মোট আয়</p>
                    <p class="text-3xl font-bold text-green-600"><?php echo formatBDT($revenue['total'] ?? 0); ?></p>
                </div>
                <div class="text-4xl">💰</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">অপেক্ষমাণ</p>
                    <p class="text-3xl font-bold text-yellow-600"><?php echo $pending['total']; ?></p>
                </div>
                <div class="text-4xl">⏳</div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">সর্বশেষ বুকিং</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ইনভয়েস</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">নাম</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">গন্তব্য</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">পরিমাণ</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">স্ট্যাটাস</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">তারিখ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php while ($booking = $recent_bookings->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-mono"><?php echo substr($booking['invoice_number'], 0, 20); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo Security::sanitize($booking['name']); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo Security::sanitize($booking['destination']); ?></td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600"><?php echo formatBDT($booking['total_amount']); ?></td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                <?php echo $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo $booking['status'] === 'confirmed' ? 'নিশ্চিত' : 'অপেক্ষমাণ'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm"><?php echo formatDate($booking['created_at']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
