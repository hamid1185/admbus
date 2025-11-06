<?php
$db = Database::getInstance();
$page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$per_page = 20;
$offset = ($page_num - 1) * $per_page;

// Get bookings
$stmt = $db->query("
    SELECT b.*, u.name, u.phone, r.destination, r.price
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN routes r ON b.route_id = r.id
    ORDER BY b.created_at DESC
    LIMIT ? OFFSET ?
", [$per_page, $offset]);
$bookings = $stmt->get_result();

// Get total count
$count_stmt = $db->query("SELECT COUNT(*) as total FROM bookings");
$total = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total / $per_page);
?>

<div>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">বুকিং ম্যানেজমেন্ট</h1>
        <div class="text-gray-600">মোট: <span class="font-bold text-2xl"><?php echo $total; ?></span></div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="flex gap-4 flex-wrap">
            <input type="hidden" name="page" value="bookings">
            <input type="text" name="search" placeholder="ইনভয়েস বা নাম খুঁজুন..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">সব স্ট্যাটাস</option>
                <option value="pending">অপেক্ষমাণ</option>
                <option value="confirmed">নিশ্চিত</option>
                <option value="cancelled">বাতিল</option>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">খুঁজুন</button>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ইনভয়েস</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">যাত্রী</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ফোন</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">গন্তব্য</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">পরিমাণ</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">স্ট্যাটাস</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php while ($booking = $bookings->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-mono"><?php echo substr($booking['invoice_number'], 0, 20); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo Security::sanitize($booking['name']); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo Security::sanitize($booking['phone']); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo Security::sanitize($booking['destination']); ?></td>
                        <td class="px-6 py-4 text-sm font-bold"><?php echo formatBDT($booking['total_amount']); ?></td>
                        <td class="px-6 py-4 text-sm">
                            <select class="px-2 py-1 border border-gray-300 rounded text-sm" onchange="updateBookingStatus(<?php echo $booking['id']; ?>, this.value)">
                                <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>অপেক্ষমাণ</option>
                                <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>নিশ্চিত</option>
                                <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>বাতিল</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-blue-600 hover:text-blue-700 mr-3">দেখুন</button>
                            <button class="text-red-600 hover:text-red-700">মুছুন</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center gap-2">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=bookings&page_num=<?php echo $i; ?>" 
           class="px-4 py-2 rounded-lg border <?php echo $page_num === $i ? 'bg-green-600 text-white' : 'border-gray-300 text-gray-700'; ?>">
            <?php echo $i; ?>
        </a>
        <?php endfor; ?>
    </div>
</div>

<script>
function updateBookingStatus(id, status) {
    // This would call an API endpoint to update the booking
    console.log('Updating booking', id, 'to', status);
}
</script>
