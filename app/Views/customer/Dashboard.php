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
        'label'      => 'Booked',
        'badge'      => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'iconBg'     => 'bg-yellow-50 border border-yellow-200',
        'iconStroke' => '#ca8a04',
        'iconPath'   => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>',
        'hint'       => 'Menunggu konfirmasi dari admin autohub',
    ],
    'Admin Approved' => [
        'label'      => 'Approved',
        'badge'      => 'bg-blue-50 text-blue-700 border-blue-200',
        'iconBg'     => 'bg-blue-50 border border-blue-200',
        'iconStroke' => '#2563eb',
        'iconPath'   => '<path d="M20 6 9 17l-5-5"/>',
        'hint'       => 'Booking disetujui, silakan datang sesuai jadwal',
    ],
    'In Progress'    => [
        'label'      => 'Working',
        'badge'      => 'bg-orange-50 text-orange-700 border-orange-200',
        'iconBg'     => 'bg-orange-50 border border-orange-200',
        'iconStroke' => '#ea580c',
        'iconPath'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.106-3.105c.32-.322.863-.22.983.218a6 6 0 0 1-8.259 7.057l-7.91 7.91a1 1 0 0 1-2.999-3l7.91-7.91a6 6 0 0 1 7.057-8.259c.438.12.54.662.219.984z"/>',
        'hint'       => 'Kendaraan Anda sedang dikerjakan oleh mekanik',
    ],
    'Completed'      => [
        'label'      => 'Done',
        'badge'      => 'bg-green-50 text-green-700 border-green-200',
        'iconBg'     => 'bg-green-50 border border-green-200',
        'iconStroke' => '#16a34a',
        'iconPath'   => '<path d="M6 22V2.8a.8.8 0 0 1 1.17-.71l11.38 5.69a.8.8 0 0 1 0 1.44L6 15.5"/>',
        'hint'       => 'Servis telah selesai, silakan ambil kendaraan Anda',
    ],
];

$slot   = $slotInfo[0] ?? null;
$isFull = $slot && $slot['available'] <= 0;
$pct    = ($slot && $slot['max'] > 0) ? round(($slot['booked'] / $slot['max']) * 100) : 0;
$cfg    = $activeBooking ? ($statusMap[$activeBooking['progress_status']] ?? null) : null;
$stepKeys = array_keys($statusMap);

?>

<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Dashboard</title>
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .hover-lift {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-8 animate-fadeInUp">

    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Dashboard</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Selamat datang di dashboard AutoHub.</p>
        </div>
    </div>

    <div class="space-y-4">
        <!-- ── Top 2-column grid: Booking Aktif + Jam Operasional ── -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">

            <!-- Card: Booking Aktif -->
            <div class="group rounded-2xl border border-zinc-200 bg-white p-5 flex flex-col transition-all duration-300 hover:shadow-md hover:border-zinc-300 hover-lift">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-base font-semibold text-zinc-950">Booking Aktif</h2>
                        <p class="text-xs text-zinc-500 mt-0.5">Status kendaraan Anda saat ini</p>
                    </div>
                    <?php if ($activeBooking && $cfg): ?>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full border <?= $cfg['badge'] ?> <?= $activeBooking['progress_status'] === 'In Progress' ? 'pulse-green' : '' ?>">
                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70 <?= $activeBooking['progress_status'] === 'In Progress' ? 'animate-pulse' : '' ?>"></span>
                            <?= htmlspecialchars($activeBooking['progress_status']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="border-t border-zinc-100 -mx-5 mb-4"></div>

                <?php if ($activeBooking && $cfg): ?>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 <?= $cfg['iconBg'] ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="<?= $cfg['iconStroke'] ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <?= $cfg['iconPath'] ?>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-baseline gap-2 flex-wrap">
                                    <span class="text-sm font-bold text-zinc-950"><?= htmlspecialchars($activeBooking['model_year']) ?></span>
                                </div>
                                <p class="text-[11px] font-mono text-zinc-500 mt-0.5 uppercase tracking-wider">
                                    <?= htmlspecialchars($activeBooking['plate_number']) ?>
                                </p>
                            </div>
                        </div>
                        <a href="/detail-booking/<?= $activeBooking['booking_id'] ?>" class="p-2 rounded-lg border border-zinc-100 hover:bg-zinc-100 transition-colors group">
                            <svg class="w-4 h-4 text-zinc-400 group-hover:text-zinc-950 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Progress Tracker with Icons -->
                    <div class="relative mt-8 mb-8">
                        <!-- Progress line background -->
                        <div class="absolute top-[18px] left-0 w-full px-[18px]">
                            <div class="w-full h-0.5 bg-zinc-100"></div>
                        </div>

                        <?php
                        $currentStatus = $activeBooking['progress_status'];
                        $currentIndex = array_search($currentStatus, $stepKeys);
                        ?>

                        <!-- Progress line fill -->
                        <div class="absolute top-[18px] left-0 w-full px-[18px] z-0">
                            <div class="h-0.5 bg-blue-600 transition-all duration-1000 ease-in-out shadow-[0_0_8px_rgba(37,99,235,0.3)]"
                                style="width: <?= ($currentIndex / (count($stepKeys) - 1)) * 100 ?>%"></div>
                        </div>

                        <div class="relative flex justify-between">
                            <?php foreach ($statusMap as $key => $data): ?>
                                <?php
                                $index = array_search($key, $stepKeys);
                                $isPast = $index < $currentIndex;
                                $isCurrent = $index === $currentIndex;

                                $iconClass = $isPast ? 'bg-blue-600 text-white border-blue-600' : ($isCurrent ? 'bg-white text-blue-600 border-blue-600 ring-4 ring-blue-50' : 'bg-white text-zinc-300 border-zinc-200');
                                ?>
                                <div class="flex flex-col items-center">
                                    <div class="w-9 h-9 rounded-xl border-2 <?= $iconClass ?> z-10 flex items-center justify-center transition-all duration-500 shadow-sm md:w-9 md:h-9">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <?= $data['iconPath'] ?>
                                        </svg>
                                    </div>
                                    <span class="text-[10px] mt-2.5 font-bold tracking-tight <?= $isCurrent || $isPast ? 'text-zinc-900' : 'text-zinc-400' ?>">
                                        <?= $data['label'] ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-zinc-50 border border-zinc-100">
                        <svg class="w-3.5 h-3.5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4M12 8h.01" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <p class="text-[11px] text-zinc-500 leading-tight"><?= $cfg['hint'] ?></p>
                    </div>

                <?php else: ?>
                    <div class="flex flex-col items-center justify-center py-8 gap-3.5">
                        <div class="w-9 h-9 rounded-lg bg-zinc-50 border border-zinc-100 hover:bg-zinc-100 hover:border-zinc-300 transition-all flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </div>
                        <div class="text-center mb-12">
                            <p class="text-sm font-medium text-zinc-950">Tidak ada booking aktif</p>
                            <p class="text-xs text-zinc-800 md:text-sm">
                                hubungi admin untuk ketersediaan slot booking.
                            </p>
                            <a href="/create-booking" class="mt-4 text-xs md:text-sm inline-block px-4 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-950 focus:outline-none hover:bg-zinc-100 hover:border-zinc-300 transition-all active:scale-95">Buat Booking</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Card: Jam Operasional & Bantuan -->
            <div class="space-y-4">
                <!-- Card: Jam Operasional -->
                <div class="group rounded-2xl border border-zinc-200 bg-white p-5 flex flex-col transition-all duration-300 hover:shadow-md hover:border-zinc-300 hover-lift">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-base font-semibold text-zinc-950">Jam Operasional</h2>
                            <p class="text-xs text-zinc-500 mt-0.5">Jam buka bengkel & ketersediaan slot besok</p>
                        </div>
                        <?php if (!empty($schedule)): ?>
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full border
                                <?= $isFull ? 'bg-zinc-50 text-red-600 border-zinc-200' : 'bg-zinc-50 text-green-600 border-zinc-200' ?>">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                <?= $isFull ? 'Slot Penuh' : 'Tersedia' ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-zinc-100 -mx-5 mb-4"></div>

                    <?php if (empty($schedule)): ?>
                        <div class="flex items-center gap-3.5">
                            <div class="w-9 h-9 rounded-lg bg-zinc-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-zinc-950">Jadwal belum diatur</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Admin belum mengatur jam operasional bengkel.</p>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="space-y-4">

                            <!-- Jam Buka -->
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-zinc-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 6v6l4 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500">Jam Operasional</p>
                                    <p class="text-sm font-semibold text-zinc-950 mt-0.5">
                                        <?= substr($schedule['open_time'], 0, 5) ?> – <?= substr($schedule['close_time'], 0, 5) ?>
                                    </p>
                                </div>
                            </div>

                            <?php if ($slot): ?>
                                <?php
                                // Logic warna berdasarkan persentase
                                $statusColor = 'bg-green-600';
                                $textColor   = 'text-green-600';
                                $iconColor   = 'text-green-600';

                                if ($isFull || $pct >= 90) {
                                    $statusColor = 'bg-red-600';
                                    $textColor   = 'text-red-600';
                                    $iconColor   = 'text-red-600';
                                } elseif ($pct >= 60) {
                                    $statusColor = 'bg-yellow-500';
                                    $textColor   = 'text-yellow-600';
                                    $iconColor   = 'text-yellow-500';
                                }
                                ?>
                                <div class="border-t border-zinc-100"></div>

                                <!-- Slot bar -->
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-zinc-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 <?= $iconColor ?>" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-icon lucide-clipboard">
                                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <p class="text-xs text-zinc-500">Slot Besok</p>
                                            <p class="text-xs font-semibold <?= $textColor ?>">
                                                <?= $isFull ? 'Penuh' : "Sisa {$slot['available']} slot" ?>
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-zinc-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="h-full transition-all duration-500 <?= $statusColor ?>"
                                                    style="width: <?= min($pct, 100) ?>%"></div>
                                            </div>
                                            <p class="text-xs text-zinc-500 whitespace-nowrap tabular-nums">
                                                <?= $slot['booked'] ?>/<?= $slot['max'] ?> terisi
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Bantuan Box -->
                <div class="rounded-[14px] border border-zinc-200 bg-white p-6 shadow-[0px_1px_3px_rgba(0,0,0,0.1)] hover-lift">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-zinc-950">Butuh Bantuan?</h3>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed mb-4">
                        Hubungi admin kami jika terdapat kendala atau pertanyaan mengenai status booking anda.
                    </p>
                    <a href="https://wa.me/6281132211515" target="_blank" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
                        Hubungi via WhatsApp
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M7 7h10v10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>



<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>