<title>Riwayat Booking</title>

<body>
    <?php require __DIR__ . '/../layouts/sidebar-customer.php'; ?>

    <div class="flex-1 px-6 py-8 bg-white min-h-screen">
        <div class="mb-7">
            <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
                <a href="/customer" class="hover:text-zinc-700 transition-colors">Dashboard</a>
                <span>/</span>
                <span class="text-zinc-700 font-medium">Riwayat Booking</span>
            </div>
        </div>
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-zinc-900 tracking-tight">Riwayat Booking</h2>
            <p class="text-sm text-zinc-500 mt-0.5">Daftar semua booking kendaraan Anda.</p>
        </div>



        <div class="rounded-lg border border-zinc-200 bg-white overflow-hidden">
            <?php if (empty($bookings)): ?>
                <div class="text-center py-16 text-zinc-400">
                    <p class="font-medium text-zinc-500 text-base">Belum ada booking</p>
                    <p class="text-xs mt-1">Buat booking pertama Anda sekarang.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Jam Datang</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">No Antrian</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Kendaraan</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">No. Polisi</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="hover:bg-zinc-50/50 transition-colors">
                                    <td class="px-5 py-3.5 text-zinc-600 whitespace-nowrap">
                                        <?= htmlspecialchars(date('d M Y', strtotime($booking['booking_date']))) ?>
                                    </td>
                                    <td class="px-5 py-3.5 text-zinc-600">
                                        <?= htmlspecialchars(date('H:i', strtotime($booking['checkin_time']))) ?>
                                    </td>
                                    <td class="px-5 py-3.5 text-zinc-600">
                                        <?= htmlspecialchars($booking['queue_id']) ?>
                                    </td>
                                    <td class="px-5 py-3.5 text-zinc-800 font-medium">
                                        <div><?= htmlspecialchars($booking['model_year']) ?></div>
                                        <div class="text-xs text-zinc-400 font-normal capitalize"><?= htmlspecialchars($booking['vehicle_type']) ?></div>
                                    </td>
                                    <td class="px-5 py-3.5 text-zinc-600 font-mono uppercase">
                                        <?= htmlspecialchars($booking['plate_number']) ?>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <?php
                                        $status = $booking['progress_status'];
                                        $badge  = match ($status) {
                                            'Pending'        => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                            'Admin Approved' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                            'In Progress'    => 'bg-orange-50 text-orange-700 border border-orange-200',
                                            'Completed'      => 'bg-green-50 text-green-700 border border-green-200',
                                            'Cancelled'      => 'bg-red-50 text-red-700 border border-red-200',
                                            default          => 'bg-zinc-50 text-zinc-600 border border-zinc-200',
                                        };
                                        ?>
                                        <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full <?= $badge ?>">
                                            <?= htmlspecialchars($status) ?>
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <?php if ($status === 'Pending'): ?>
                                            <button type="button"
                                                onclick="openDialog({title:'Batalkan Booking',description:'Booking ini akan dibatalkan. Lanjutkan?',action:'/customer/booking/<?= $booking['booking_id'] ?>/cancel',confirmText:'Batalkan'})"
                                                class="text-xs font-medium px-3 py-1.5 rounded-md border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                                                Cancel
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php require __DIR__ . '/../components/dialog.php'; ?>
<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>