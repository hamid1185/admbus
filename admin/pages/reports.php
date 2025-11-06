<?php
$db = Database::getInstance();

// Get booking statistics
$booking_stats = $db->query("
    SELECT 
        DATE(created_at) as date,
        COUNT(*) as total_bookings,
        SUM(total_amount) as daily_revenue
    FROM bookings
    WHERE status = 'confirmed'
    GROUP BY DATE(created_at)
    ORDER BY date DESC
    LIMIT 30
");
$stats = $booking_stats->get_result();
?>

<div>
    <h1 class="text-4xl font-bold text-gray-900 mb-8">রিপোর্ট এবং বিশ্লেষণ</h1>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" class="flex gap-4 flex-wrap items-end">
            <input type="hidden" name="page" value="reports">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">শুরু তারিখ</label>
                <input type="date" name="start_date" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">শেষ তারিখ</label>
                <input type="date" name="end_date" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">ফিল্টার করুন</button>
            <button type="button" onclick="exportToCSV()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">CSV এ রপ্তানি করুন</button>
        </form>
    </div>

    <!-- Revenue Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">দৈনিক রাজস্ব</h3>
            <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <p class="text-gray-600">রাজস্ব চার্ট এখানে প্রদর্শিত হবে</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">বুকিং ট্রেন্ড</h3>
            <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <p class="text-gray-600">বুকিং ট্রেন্ড চার্ট এখানে প্রদর্শিত হবে</p>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-900">দৈনিক পরিসংখ্যান</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">তারিখ</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">বুকিং সংখ্যা</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">দৈনিক রাজস্ব</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">গড় বুকিং</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php while ($row = $stats->fetch_assoc()): 
                        $avg_booking = $row['total_bookings'] > 0 ? $row['daily_revenue'] / $row['total_bookings'] : 0;
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm"><?php echo formatDate($row['date']); ?></td>
                        <td class="px-6 py-4 text-sm font-bold"><?php echo $row['total_bookings']; ?></td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600"><?php echo formatBDT($row['daily_revenue']); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo formatBDT($avg_booking); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.querySelector('table');
    let csv = [];
    
    table.querySelectorAll('tr').forEach(row => {
        let rowData = [];
        row.querySelectorAll('td, th').forEach(cell => {
            rowData.push(cell.textContent);
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'report-' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
}
</script>
