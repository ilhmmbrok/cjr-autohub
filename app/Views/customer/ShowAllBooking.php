<?php require __DIR__ . '/../components/action-dropdown-customer.php'; ?>
<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Riwayat Booking</title>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
</style>

<div class="w-full bg-white min-h-[calc(100vh-56px)] px-4 sm:px-6 lg:px-8 py-8 animate-fadeInUp">

    <!-- Breadcrumb + Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/dashboard" class="hover:text-zinc-950 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-900 font-medium">Riwayat Booking</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Riwayat Booking</h1>
                <p class="text-sm text-zinc-500 mt-0.5">Daftar semua booking kendaraan Anda.</p>
            </div>
        </div>
    </div>

    <?php if (empty($bookings)): ?>
        <div class="group relative rounded-2xl border border-zinc-200 bg-white p-8 overflow-hidden hover:border-zinc-300 transition-all duration-500 hover:shadow-lg hover:shadow-zinc-100/50">
            <!-- Background Decoration -->
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-zinc-50 rounded-full blur-3xl opacity-50 group-hover:bg-blue-50 transition-colors duration-700"></div>
            
            <div class="relative text-center max-w-xs mx-auto">
                <div class="relative inline-flex items-center justify-center w-16 h-16 mb-5 transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-blue-50 rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500"></div>
                    <div class="absolute inset-0 bg-white border border-zinc-100 rounded-2xl shadow-sm"></div>
                    <!-- <svg class="relative w-7 h-7 text-zinc-300 group-hover:text-blue-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg> -->
                    <svg class="relative w-7 h-7 text-zinc-300 group-hover:text-blue-500 transition-colors duration-500" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-icon lucide-clipboard"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                </div>
                
                <h2 class="text-lg font-bold text-zinc-900 tracking-tight mb-1.5">Riwayat Masih Kosong</h2>
                <p class="text-xs text-zinc-500 leading-relaxed mb-6">
                    Mulai reservasi sekarang untuk menjaga performa kendaraan Anda.
                </p>
                
                <a href="/create-booking" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border-2 border-zinc-200 text-zinc-950 text-xs font-bold hover:bg-zinc-950 hover:text-white transition-all duration-300 active:scale-95 group/btn">
                    Mulai Booking Sekarang
                    <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
<?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($bookings as $booking): ?>
                <?php
                $status = $booking['progress_status'];
                $badge  = match ($status) {
                    'Pending'        => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                    'Admin Approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'In Progress'    => 'bg-orange-50 text-orange-700 border-orange-200',
                    'Completed'      => 'bg-green-50 text-green-700 border-green-200',
                    'Cancelled'      => 'bg-red-50 text-red-700 border-red-200',
                    default          => 'bg-zinc-50 text-zinc-700 border-zinc-200',
                };
                ?>
                <div class="group relative bg-white border border-zinc-200 rounded-2xl p-5 hover:shadow-lg hover:border-zinc-300 transition-all duration-300 hover-lift">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center gap-1.5 text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-md border <?= $badge ?> <?= $status === 'In Progress' ? 'pulse-green' : '' ?>">
                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70 <?= $status === 'In Progress' ? 'animate-pulse' : '' ?>"></span>
                            <?= htmlspecialchars($status) ?>
                        </span>
                        <p class="text-xs text-zinc-400 font-mono uppercase"><?= htmlspecialchars($booking['plate_number']) ?></p>
                    </div>

                    <!-- Main Info -->
                    <div class="mb-4">
                        <h3 class="text-sm font-bold text-zinc-950 truncate "><?= htmlspecialchars($booking['model_year']) ?></h3>
                        <p class="text-sm text-zinc-500 capitalize"><?= htmlspecialchars($booking['vehicle_type']) ?></p>
                    </div>

                    <!-- Date & Time -->
                    <div class="flex items-center gap-4 mb-6 py-3 border-y border-zinc-50 group-hover:border-zinc-100 transition-colors">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-zinc-400 uppercase font-medium">Tanggal</span>
                            <span class="text-sm font-semibold text-zinc-900"><?= htmlspecialchars(date('d M Y', strtotime($booking['booking_date']))) ?></span>
                        </div>
                        <div class="w-px h-6 bg-zinc-100"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-zinc-400 uppercase font-medium">Jam Kedatangan</span>
                            <span class="text-sm font-semibold text-zinc-900"><?= htmlspecialchars(date('H:i', strtotime($booking['checkin_time']))) ?></span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between gap-3">
                        <a href="/detail-booking/<?= $booking['booking_id'] ?>" class="flex-1 text-center text-xs font-semibold py-2 rounded-lg border border-zinc-200 text-zinc-700 hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition-all active:scale-95 shadow-sm">
                            Lihat Detail
                        </a>
                        <?php if ($status === 'Pending'): ?>
                            <button onclick="openDialog({
                                title: 'Batalkan Booking',
                                description: 'Apakah Anda yakin ingin membatalkan booking ini?',
                                action: '/history-booking/<?= $booking['booking_id'] ?>/cancel',
                                confirmText: 'Ya, Batalkan'
                            })" class="flex-1 text-xs font-semibold py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all active:scale-95 text-center cursor-pointer border border-transparent hover:border-red-600">
                                Batalkan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../components/dialog.php'; ?>
<?php require __DIR__ . '/../components/toast.php'; ?>
<?php renderBookingActionDropdownAssets(); ?>

</body>

</html>