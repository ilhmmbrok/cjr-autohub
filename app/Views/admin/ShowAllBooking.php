<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>
<?php require __DIR__ . '/../components/action-dropdown.php'; ?>

<title>Daftar Booking</title>
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

    .booking-row td {
        transition: background 100ms;
    }

    .booking-row:hover td {
        background: #fafafa;
    }

    #searchInput:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
    }

    .filter-btn {
        transition: all 120ms;
        cursor: pointer;
    }

    .filter-btn.active {
        background: #18181b;
        color: #fff;
        border-color: #18181b;
    }

    .filter-btn:hover:not(.active) {
        background: #f4f4f5;
    }
</style>

<div class="flex-1 px-6 py-8 bg-white min-h-screen">

    <!-- Breadcrumb + Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/admin" class="hover:text-zinc-700 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-700 font-medium">Daftar Booking</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Daftar Booking</h1>
                <p class="text-sm text-zinc-500 mt-0.5">Kelola dan pantau semua booking kendaraan.</p>
            </div>
            <!-- Hapus Semua Cancelled -->
            <button type="button"
                onclick="openDialog({title:'Hapus Semua Cancelled',description:'Semua booking berstatus Cancelled akan dihapus permanen. Lanjutkan?',action:'/admin/booking/delete-cancelled',confirmText:'Hapus Semua'})"
                class="text-xs font-medium px-3 py-1.5 rounded-md border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                Hapus Semua Cancelled
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="rounded-lg border border-zinc-200 bg-white">
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-zinc-100">
            <!-- Search -->
            <div class="relative w-full sm:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                </svg>
                <input id="searchInput" type="text" placeholder="Cari customer, plat, keluhan…"
                    class="w-full pl-9 pr-4 py-2 text-sm border border-zinc-200 rounded-lg bg-white text-zinc-900 placeholder:text-zinc-400">
            </div>
            <!-- Filter Buttons -->
            <div class="flex items-center gap-1.5 flex-wrap">
                <button onclick="filterStatus('')" class="filter-btn active text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="">Semua</button>
                <button onclick="filterStatus('Pending')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="Pending">Pending</button>
                <button onclick="filterStatus('Admin Approved')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="Admin Approved">Approved</button>
                <button onclick="filterStatus('In Progress')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="In Progress">In Progress</button>
                <button onclick="filterStatus('Completed')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="Completed">Completed</button>
                <button onclick="filterStatus('Cancelled')" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-md border border-zinc-200" data-status="Cancelled">Cancelled</button>
            </div>
        </div>

        <!-- Table -->
        <?php if (empty($bookings)): ?>
            <div class="flex flex-col items-center justify-center py-20 text-zinc-400">
                <svg class="w-9 h-9 mb-3 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-sm font-medium text-zinc-500">Belum ada booking</p>
                <p class="text-xs mt-1">Data booking akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-sm" id="bookingTable">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">No. Telepon</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Customer</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">No. Polisi</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Check-in</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bookingBody" class="divide-y divide-zinc-100">
                        <?php foreach ($bookings as $b): ?>
                            <?php
                            $status   = $b['progress_status'] ?? '-';
                            $badge    = match ($status) {
                                'Pending'        => 'badge-pending',
                                'Admin Approved' => 'badge-approved',
                                'In Progress'    => 'badge-progress',
                                'Completed'      => 'badge-completed',
                                'Cancelled'      => 'badge-cancelled',
                                default          => 'badge-default',
                            };
                            $customer  = htmlspecialchars($b['customer_name'] ?? 'Customer #' . $b['customer_id']);
                            $plate     = htmlspecialchars($b['plate_number'] ?? '-');
                            $modelType = htmlspecialchars($b['model_year'] ?? '-');
                            ?>
                            <tr class="booking-row"
                                data-status="<?= htmlspecialchars($status) ?>"
                                data-search="<?= strtolower($customer . ' ' . $plate . ' ' . $modelType) ?>">
                                <td class="px-5 py-3.5 text-zinc-600 whitespace-nowrap">
                                    <?= date('d M Y', strtotime($b['booking_date'])) ?>
                                </td>
                                <td class="px-5 py-3.5">
                                    <?= htmlspecialchars($b['phone'] ?? '—') ?>
                                </td>
                                <td class="px-5 py-3.5 font-medium text-zinc-900"><?= $customer ?></td>
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-zinc-800"><?= htmlspecialchars($b['model_year'] ?? '-') ?></div>
                                    <div class="text-xs text-zinc-400 capitalize mt-0.5"><?= htmlspecialchars($b['vehicle_type'] ?? '-') ?></div>
                                </td>
                                <td class="px-5 py-3.5 font-mono text-sm text-zinc-700 uppercase"><?= $plate ?></td>
                                <td class="px-5 py-3.5 text-zinc-600 whitespace-nowrap">
                                    <?= htmlspecialchars(substr($b['checkin_time'] ?? '-', 0, 5)) ?>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="badge <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <?php renderBookingActionDropdown($b['booking_id']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="emptyFilter" class="hidden py-14 text-center">
                <p class="text-sm font-medium text-zinc-500">Tidak ada hasil ditemukan</p>
                <p class="text-xs mt-1 text-zinc-400">Coba ubah filter atau kata kunci pencarian.</p>
            </div>

            <!-- Footer -->
            <div class="px-5 py-3 border-t border-zinc-100">
                <p class="text-xs text-zinc-400" id="rowCount">Menampilkan <?= count($bookings) ?> dari <?= count($bookings) ?> booking</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    let activeStatus = '';

    function filterStatus(status) {
        activeStatus = status;
        document.querySelectorAll('.filter-btn').forEach(btn =>
            btn.classList.toggle('active', btn.dataset.status === status)
        );
        applyFilters();
    }

    document.getElementById('searchInput')?.addEventListener('input', applyFilters);

    function applyFilters() {
        const q = (document.getElementById('searchInput')?.value ?? '').toLowerCase().trim();
        const rows = [...document.querySelectorAll('#bookingBody tr.booking-row')];
        let visible = 0;

        rows.forEach(row => {
            const ok = (!activeStatus || row.dataset.status === activeStatus) &&
                (!q || row.dataset.search.includes(q));
            row.style.display = ok ? '' : 'none';
            if (ok) visible++;
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

</body>

</html>