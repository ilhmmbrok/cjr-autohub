<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>
<?php require __DIR__ . '/../components/action-dropdown-admin.php'; ?>

<title>Daftar Booking</title>
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Modern Thin Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e4e4e7;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d4d4d8;
    }
    
    /* Ensure table fits & looks good */
    .compact-table th, .compact-table td {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    .compact-table th:first-child, .compact-table td:first-child {
        padding-left: 2rem !important;
    }
    .compact-table th:last-child, .compact-table td:last-child {
        padding-right: 3.5rem !important;
    }
</style>

<div class="bg-white px-4 sm:px-6 lg:px-8 py-8 animate-fadeIn overflow-x-hidden max-w-full">

    <!-- Breadcrumb + Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/admin/dashboard" class="hover:text-zinc-950 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-900 font-medium">Daftar Booking</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Daftar Booking</h1>
                <p class="text-sm text-zinc-500 mt-0.5">Kelola dan pantau semua booking kendaraan.</p>
            </div>
            <!-- Hapus Semua Cancelled -->
            <button type="button"
                onclick="openDialog({title:'Hapus Semua Cancelled',description:'Semua booking berstatus Cancelled akan dihapus permanen. Lanjutkan?',action:'/admin/daftar-booking/delete-cancelled',confirmText:'Hapus Semua'})"
                class="text-xs font-medium px-3 py-1.5 rounded-md border border-red-200 text-red-600 hover:bg-red-50 active:scale-95 transition-all duration-200">
                Hapus Semua Cancelled
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="rounded-2xl border border-zinc-200 bg-white shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-zinc-200">
            <!-- Search -->
            <div class="relative w-full sm:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                </svg>
                <input id="searchInput" type="text" placeholder="Cari customer, plat, keluhan…"
                    class="w-full pl-9 pr-4 py-2 text-sm border border-zinc-200 rounded-lg bg-white text-zinc-950 placeholder:text-zinc-400 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all">
            </div>
            <!-- Filter Buttons -->
            <div class="flex items-center gap-1.5 flex-wrap">
                <button onclick="filterStatus('')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-950 bg-zinc-950 text-white" data-status="">Semua</button>
                <button onclick="filterStatus('Pending')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-200 hover:bg-zinc-50" data-status="Pending">Pending</button>
                <button onclick="filterStatus('Admin Approved')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-200 hover:bg-zinc-50" data-status="Admin Approved">Approved</button>
                <button onclick="filterStatus('In Progress')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-200 hover:bg-zinc-50" data-status="In Progress">In Progress</button>
                <button onclick="filterStatus('Completed')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-200 hover:bg-zinc-50" data-status="Completed">Completed</button>
                <button onclick="filterStatus('Cancelled')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border transition-all active:scale-95 border-zinc-200 hover:bg-zinc-50" data-status="Cancelled">Cancelled</button>
            </div>
        </div>

        <!-- Table -->
        <?php if (empty($bookings)): ?>
            <div class="flex flex-col items-center justify-center py-20 text-zinc-400">
                <svg class="w-9 h-9 mb-3 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-sm font-medium text-zinc-900">Belum ada booking</p>
                <p class="text-xs mt-1">Data booking akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <table class="w-full text-sm compact-table" id="bookingTable">
                <thead>
                    <tr class="border-b border-zinc-200 bg-zinc-50 text-left">
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider">Telepon</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider">Customer</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider">Plat</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Check-in</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 font-medium text-zinc-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookingBody" class="divide-y divide-zinc-200">
                    <?php foreach ($bookings as $b): ?>
                        <?php
                        $status   = $b['progress_status'] ?? '-';
                        $badge    = match ($status) {
                            'Pending'        => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                            'Admin Approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'In Progress'    => 'bg-orange-50 text-orange-700 border-orange-200',
                            'Completed'      => 'bg-green-50 text-green-700 border-green-200',
                            'Cancelled'      => 'bg-red-50 text-red-700 border-red-200',
                            default          => 'bg-zinc-50 text-zinc-700 border-zinc-200',
                        };
                        $customer  = htmlspecialchars($b['customer_name'] ?? 'Customer #' . $b['customer_id']);
                        $plate     = htmlspecialchars($b['plate_number'] ?? '-');
                        $modelType = htmlspecialchars($b['model_year'] ?? '-');
                        ?>
                        <tr class="booking-row group hover:bg-zinc-50/50 transition-colors"
                            data-status="<?= htmlspecialchars($status) ?>"
                            data-search="<?= strtolower($customer . ' ' . $plate . ' ' . $modelType) ?>">
                            <td class="py-3 text-zinc-700 whitespace-nowrap">
                                <?= date('d M Y', strtotime($b['booking_date'])) ?>
                            </td>
                            <td class="py-3">
                                <?= htmlspecialchars($b['phone'] ?? '—') ?>
                            </td>
                            <td class="py-3 font-medium text-zinc-950"><?= $customer ?></td>
                            <td class="py-3">
                                <div class="font-medium text-zinc-900"><?= htmlspecialchars($b['model_year'] ?? '-') ?></div>
                                <div class="text-[10px] text-zinc-400 capitalize"><?= htmlspecialchars($b['vehicle_type'] ?? '-') ?></div>
                            </td>
                            <td class="py-3 font-mono text-zinc-700 uppercase"><?= $plate ?></td>
                            <td class="py-3 text-zinc-700 whitespace-nowrap">
                                <?= htmlspecialchars(substr($b['checkin_time'] ?? '-', 0, 5)) ?>
                            </td>
                            <td class="py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium border <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                            </td>
                            <td class="py-3 text-right">
                                <?php renderBookingActionDropdown($b['booking_id']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="emptyFilter" class="hidden py-14 text-center">
                <p class="text-sm font-medium text-zinc-900">Tidak ada hasil ditemukan</p>
                <p class="text-xs mt-1 text-zinc-500">Coba ubah filter atau kata kunci pencarian.</p>
            </div>

            <!-- Footer -->
            <div class="px-5 py-3 border-t border-zinc-200">
                <p class="text-xs text-zinc-500" id="rowCount">Menampilkan <?= count($bookings) ?> dari <?= count($bookings) ?> booking</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let activeStatus = '';

        function filterStatus(status) {
            activeStatus = status;
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.dataset.status === status) {
                    btn.classList.add('border-zinc-950', 'bg-zinc-950', 'text-white');
                    btn.classList.remove('border-zinc-200', 'hover:bg-zinc-50');
                } else {
                    btn.classList.remove('border-zinc-950', 'bg-zinc-950', 'text-white');
                    btn.classList.add('border-zinc-200', 'hover:bg-zinc-50');
                }
            });
            applyFilters();
        }

        document.getElementById('searchInput')?.addEventListener('input', applyFilters);

        function applyFilters() {
            const q = (document.getElementById('searchInput')?.value ?? '').toLowerCase().trim();
            const rows = [...document.querySelectorAll('#bookingBody tr.booking-row')];
            let visible = 0;

            rows.forEach((row, index) => {
                const ok = (!activeStatus || row.dataset.status === activeStatus) &&
                    (!q || row.dataset.search.includes(q));
                
                if (ok) {
                    if (row.style.display === 'none') {
                        row.style.display = '';
                        row.animate([
                            { opacity: 0, transform: 'translateY(4px)' },
                            { opacity: 1, transform: 'translateY(0)' }
                        ], { 
                            duration: 400, 
                            delay: Math.min(visible * 30, 150),
                            easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
                            fill: 'forwards'
                        });
                    }
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            const total = rows.length;
            document.getElementById('rowCount').textContent =
                `Menampilkan ${visible} dari ${total} booking`;
            document.getElementById('emptyFilter')?.classList.toggle('hidden', visible > 0);
        }
    </script>

    <?php require __DIR__ . '/../components/dialog.php'; ?>
    <?php require __DIR__ . '/../components/toast.php'; ?>
    <?php renderBookingActionDropdownAssets(); ?>

</div>

</body>
</html>
