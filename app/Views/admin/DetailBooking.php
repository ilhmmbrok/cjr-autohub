<?php
require __DIR__ . '/../layouts/sidebar-admin.php';

$day = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$date = $booking['booking_date'];
$dayOfWeek = date('l', strtotime($date));
$formattedDate = $day[$dayOfWeek] . ', ' . date('d F Y', strtotime($date));

$statusMap = [
    'Pending'        => ['badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'label' => 'Pending'],
    'Admin Approved' => ['badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'label' => 'Approved'],
    'In Progress'    => ['badge' => 'bg-orange-50 text-orange-700 border-orange-200', 'label' => 'In Progress'],
    'Completed'     => ['badge' => 'bg-green-50 text-green-700 border-green-200', 'label' => 'Completed'],
    'Cancelled'     => ['badge' => 'bg-red-50 text-red-700 border-red-200', 'label' => 'Cancelled'],
];

$cfg = $statusMap[$booking['progress_status']] ?? ['badge' => 'bg-zinc-50 text-zinc-700 border-zinc-200', 'label' => $booking['progress_status']];
?>

<title>Detail Booking - Admin</title>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
</style>

<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-8 print:p-0 animate-fadeIn">
    <!-- Web View Content (Hidden when printing) -->
    <div class="print:hidden">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
                <a href="/admin/dashboard" class="hover:text-zinc-950 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="/admin/daftar-booking" class="hover:text-zinc-950 transition-colors">Daftar Booking</a>
                <span>/</span>
                <span class="text-zinc-900 font-medium">Detail Booking</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-950 tracking-tight">Detail Booking #<?= $booking['booking_id'] ?></h1>
                    <p class="text-sm text-zinc-500 mt-0.5">Customer: <span class="font-medium text-zinc-900"><?= htmlspecialchars($booking['customer_name']) ?></span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Kendaraan & Layanan -->
                <div class="rounded-2xl border border-zinc-200 bg-white overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50 flex justify-between items-center">
                        <h2 class="text-sm font-semibold text-zinc-950">Informasi Kendaraan & Layanan</h2>
                        <div class="flex gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border <?= $cfg['badge'] ?>">
                                <?= $cfg['label'] ?>
                            </span>
                            <button onclick="window.print()" class="p-2 text-zinc-500 hover:text-zinc-950 hover:bg-zinc-50 border border-zinc-200 rounded-lg transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9" />
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <rect x="6" y="14" width="12" height="8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Model & Tahun</label>
                                <p class="text-sm font-medium text-zinc-950 mt-1"><?= htmlspecialchars($booking['model_year']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Nomor Plat</label>
                                <p class="text-sm font-mono font-medium text-zinc-950 mt-1 uppercase"><?= htmlspecialchars($booking['plate_number']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Jenis Kendaraan</label>
                                <p class="text-sm font-medium text-zinc-950 mt-1"><?= htmlspecialchars($booking['vehicle_type']) ?></p>
                            </div>
                            <div>
                                <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Waktu Check-in</label>
                                <p class="text-sm font-medium text-zinc-950 mt-1">
                                    <?= $formattedDate ?> • <?= substr($booking['checkin_time'], 0, 5) ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-zinc-100">
                            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-wider">Keluhan / Catatan</label>
                            <div class="mt-2 p-4 rounded-xl bg-zinc-50 border border-zinc-100">
                                <p class="text-sm text-zinc-600 italic leading-relaxed">
                                    "<?= nl2br(htmlspecialchars($booking['customer_complaint'])) ?>"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="rounded-2xl border border-zinc-200 bg-white overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100 bg-zinc-50/50">
                        <h2 class="text-sm font-semibold text-zinc-950">Informasi Kontak</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-zinc-400 uppercase font-medium tracking-wider">Telepon</p>
                                    <p class="text-sm font-medium text-zinc-950"><?= htmlspecialchars($booking['phone']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-zinc-400 uppercase font-medium tracking-wider">Alamat</p>
                                    <p class="text-sm font-medium text-zinc-950 truncate max-w-[200px]"><?= htmlspecialchars($booking['address']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-4">
                <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-6">
                    <h3 class="text-sm font-semibold text-zinc-950 mb-4">Kelola Status</h3>
                    <form action="/admin/daftar-booking/<?= $booking['booking_id'] ?>/status" method="POST" class="space-y-4">
                        <?= csrf_field() ?>
                        <div class="relative" id="status-select-container">
                            <label class="text-xs font-medium text-zinc-500 mb-1.5 block">Status Booking</label>

                            <!-- Custom Select Button -->
                            <button type="button"
                                id="status-dropdown-btn"
                                onclick="toggleStatusDropdown()"
                                class="w-full flex items-center justify-between h-11 px-4 rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-950 focus:outline-none focus:ring-4 focus:ring-zinc-950/5 focus:border-zinc-950 transition-all group active:scale-[0.98]">
                                <div class="flex items-center gap-2.5">
                                    <span id="status-dot" class="w-2 h-2 rounded-full <?= explode(' ', $cfg['badge'])[0] ?>"></span>
                                    <span id="selected-status-label"><?= $cfg['label'] ?></span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-zinc-400 group-hover:text-zinc-600 transition-colors">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="status-dropdown-menu"
                                class="absolute left-0 right-0 z-50 mt-2 bg-white border border-zinc-200 rounded-xl shadow-xl shadow-zinc-200/50 p-1.5 opacity-0 invisible -translate-y-2 scale-95 transition-all duration-200 pointer-events-none">
                                <?php foreach ($statusMap as $val => $m): ?>
                                    <button type="button"
                                        onclick="selectStatus('<?= $val ?>', '<?= $m['label'] ?>', '<?= $m['badge'] ?>')"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950 transition-colors">
                                        <span class="w-2 h-2 rounded-full <?= explode(' ', $m['badge'])[0] ?>"></span>
                                        <?= $m['label'] ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <input type="hidden" name="status" id="status-input" value="<?= $booking['progress_status'] ?>">
                        </div>
                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium rounded-xl text-zinc-900 border border-zinc-200  hover:bg-zinc-950 hover:text-white hover:border-zinc-950 transition-all">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Danger Zone -->
                <div class="rounded-2xl border border-red-100 bg-red-50/30 p-6">
                    <h3 class="text-sm font-semibold text-red-950 mb-4">Danger Zone</h3>
                    <button
                        onclick="openDialog({
                            title: 'Hapus Booking',
                            description: 'Tindakan ini tidak dapat dibatalkan. Booking akan dihapus permanen dari sistem.',
                            action: '/admin/daftar-booking/<?= $booking['booking_id'] ?>/delete',
                            confirmText: 'Hapus Permanen'
                        })"
                        class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-red-500 border border-zinc-200 rounded-xl hover:bg-red-600  hover:text-white transition-all active:scale-95 shadow-sm">
                        Hapus Booking
                    </button>
                </div>
            </div>
        </div>
    </div> <!-- End of print:hidden -->

    <!-- Receipt Component -->
    <?php require __DIR__ . '/../components/BookingPdf.php'; ?>
</div> <!-- End of main container -->

<script>
    (function() {
        const btn = document.getElementById('status-dropdown-btn');
        const menu = document.getElementById('status-dropdown-menu');
        const input = document.getElementById('status-input');
        const label = document.getElementById('selected-status-label');
        const dot = document.getElementById('status-dot');

        window.toggleStatusDropdown = function() {
            const isOpen = !menu.classList.contains('invisible');
            if (isOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        };

        function openDropdown() {
            menu.classList.remove('opacity-0', 'invisible', '-translate-y-2', 'scale-95', 'pointer-events-none');
            menu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
        }

        function closeDropdown() {
            menu.classList.add('opacity-0', 'invisible', '-translate-y-2', 'scale-95', 'pointer-events-none');
            menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
        }

        window.selectStatus = function(val, text, bgClass) {
            input.value = val;
            label.textContent = text;

            // Update dot color
            dot.className = 'w-2 h-2 rounded-full ' + bgClass;

            closeDropdown();
        };

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#status-select-container')) {
                closeDropdown();
            }
        });
    })();
</script>

<?php require __DIR__ . '/../components/dialog.php'; ?>
<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>