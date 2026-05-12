<?php

$activeBooking = null;
foreach ($bookings as $b) {
    if (in_array($b['progress_status'], ['Pending', 'Admin Approved', 'In Progress'])) {
        $activeBooking = $b;
        break;
    }
}

$statusMap = [
    'Pending'        => [
        'badge'      => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'iconBg'     => 'bg-yellow-50 border border-yellow-200',
        'iconStroke' => '#ca8a04',
        'iconPath'   => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'hint'       => 'Menunggu konfirmasi dari admin bengkel',
    ],
    'Admin Approved' => [
        'badge'      => 'bg-blue-50 text-blue-700 border-blue-200',
        'iconBg'     => 'bg-blue-50 border border-blue-200',
        'iconStroke' => '#2563eb',
        'iconPath'   => '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'hint'       => 'Booking disetujui, silakan datang sesuai jadwal',
    ],
    'In Progress'    => [
        'badge'      => 'bg-orange-50 text-orange-700 border-orange-200',
        'iconBg'     => 'bg-orange-50 border border-orange-200',
        'iconStroke' => '#ea580c',
        'iconPath'   => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
        'hint'       => 'Kendaraan Anda sedang dikerjakan oleh teknisi',
    ],
];

$slot   = $slotInfo[0] ?? null;
$isFull = $slot && $slot['available'] <= 0;
$pct    = ($slot && $slot['max'] > 0) ? round(($slot['booked'] / $slot['max']) * 100) : 0;
$cfg    = $activeBooking ? ($statusMap[$activeBooking['progress_status']] ?? null) : null;

?>

<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Dashboard</title>
<style>
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 2px 10px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.6;
        border: 1px solid;
    }

    .badge-pending {
        background: #fefce8;
        color: #854d0e;
        border-color: #fde047;
    }

    .badge-approved {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .badge-progress {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    .badge-completed {
        background: #f0fdf4;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .badge-cancelled {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .badge-default {
        background: #f4f4f5;
        color: #52525b;
        border-color: #e4e4e7;
    }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
    }

    .booking-row td {
        transition: all 0.2s ease;
    }

    .booking-row:hover td {
        background: #fafafa;
    }
</style>

<div class="w-full bg-white min-h-[calc(100vh-56px)] px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Dashboard</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Selamat datang di dashboard AutoHub.</p>
        </div>
    </div>

    <div class="space-y-4">
        <!-- ── Top 2-column grid: Booking Aktif + Jam Operasional ── -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">

            <!-- Card: Booking Aktif -->
            <div class="stat-card rounded-xl border border-zinc-200 bg-white p-5 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Booking Aktif</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Status kendaraan Anda saat ini</p>
                    </div>
                    <?php if ($activeBooking && $cfg): ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full border <?= $cfg['badge'] ?>">
                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                            <?= htmlspecialchars($activeBooking['progress_status']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="border-t border-zinc-100 -mx-5 mb-4"></div>

                <?php if ($activeBooking && $cfg): ?>
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 <?= $cfg['iconBg'] ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="<?= $cfg['iconStroke'] ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <?= $cfg['iconPath'] ?>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline gap-2 flex-wrap">
                                <span class="text-sm font-semibold text-zinc-900"><?= htmlspecialchars($activeBooking['model_year']) ?></span>
                                <span class="font-mono text-xs text-zinc-400 tracking-wide uppercase"><?= htmlspecialchars($activeBooking['plate_number']) ?></span>
                            </div>
                            <p class="text-xs text-zinc-400 mt-0.5">
                                <?= date('d M Y', strtotime($activeBooking['booking_date'])) ?>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 mt-4 pt-4 border-t border-zinc-100">
                        <svg class="w-3.5 h-3.5 text-zinc-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" stroke-linecap="round" />
                        </svg>
                        <p class="text-xs text-zinc-400"><?= $cfg['hint'] ?></p>
                    </div>

                <?php else: ?>
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-lg bg-zinc-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500">Tidak ada booking aktif</p>
                            <p class="text-xs text-zinc-400 mt-0.5">Buat booking baru untuk mulai servis kendaraan Anda.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Card: Jam Operasional & Slot -->
            <div class="stat-card rounded-xl border border-zinc-200 bg-white p-5 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900">Jam Operasional</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Jam buka bengkel & ketersediaan slot hari ini</p>
                    </div>
                    <?php if (!empty($schedule)): ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full border
                            <?= $isFull ? 'bg-red-50 text-red-700 border-red-200' : 'bg-green-50 text-green-700 border-green-200' ?>">
                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                            <?= $isFull ? 'Slot Penuh' : 'Tersedia' ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="border-t border-zinc-100 -mx-5 mb-4"></div>

                <?php if (empty($schedule)): ?>
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-lg bg-zinc-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500">Jadwal belum diatur</p>
                            <p class="text-xs text-zinc-400 mt-0.5">Admin belum mengatur jam operasional bengkel.</p>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="space-y-4">

                        <!-- Jam Buka -->
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-400">Jam Operasional</p>
                                <p class="text-sm font-semibold text-zinc-800 mt-0.5">
                                    <?= substr($schedule['open_time'], 0, 5) ?> – <?= substr($schedule['close_time'], 0, 5) ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($slot): ?>
                            <div class="border-t border-zinc-100"></div>

                            <!-- Slot bar -->
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg <?= $isFull ? 'bg-red-50' : 'bg-green-50' ?> flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 <?= $isFull ? 'text-red-500' : 'text-green-500' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <p class="text-xs text-zinc-400">Slot Hari Ini</p>
                                        <p class="text-xs font-semibold <?= $isFull ? 'text-red-600' : 'text-green-600' ?>">
                                            <?= $isFull ? 'Penuh' : "Sisa {$slot['available']} slot" ?>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-zinc-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-500
                                                <?= $isFull ? 'bg-red-500' : ($pct >= 75 ? 'bg-orange-500' : 'bg-blue-500') ?>"
                                                style="width: <?= min($pct, 100) ?>%"></div>
                                        </div>
                                        <p class="text-xs text-zinc-400 whitespace-nowrap tabular-nums">
                                            <?= $slot['booked'] ?>/<?= $slot['max'] ?> terisi
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</div>


<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>