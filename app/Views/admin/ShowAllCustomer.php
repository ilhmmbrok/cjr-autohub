<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>

<title>Daftar Customer</title>
<div class="flex-1 px-6 py-8 bg-white min-h-screen">

    <!-- Breadcrumb + Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/admin" class="hover:text-zinc-700 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-700 font-medium">Daftar Customer</span>
        </div>
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Daftar Customer</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Semua customer yang terdaftar di sistem.</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="rounded-lg border border-zinc-200 bg-white overflow-hidden">

        <!-- Search -->
        <div class="px-5 py-4 border-b border-zinc-100">
            <div class="relative w-full sm:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                </svg>
                <input id="searchInput" type="text" placeholder="Cari nama, email…"
                    class="w-full pl-9 pr-4 py-2 text-sm border border-zinc-200 rounded-lg bg-white text-zinc-900 placeholder:text-zinc-400"
                    oninput="filterCustomers()">
            </div>
        </div>

        <?php if (empty($customers)): ?>
            <div class="flex flex-col items-center justify-center py-20 text-zinc-400">
                <svg class="w-9 h-9 mb-3 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-sm font-medium text-zinc-500">Belum ada customer</p>
                <p class="text-xs mt-1">Customer akan muncul setelah registrasi.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">No</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Email</th>
                            <th class="px-5 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider whitespace-nowrap">Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody id="customerBody" class="divide-y divide-zinc-100">
                        <?php foreach ($customers as $i => $c): ?>
                            <tr class="customer-row hover:bg-zinc-50/50 transition-colors"
                                data-search="<?= strtolower(htmlspecialchars($c['fullname'] . ' ' . $c['email'])) ?>">
                                <td class="px-5 py-3.5 text-zinc-400 text-xs"><?= $i + 1 ?></td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold shrink-0">
                                            <?= strtoupper(substr($c['fullname'], 0, 1)) ?>
                                        </div>
                                        <span class="font-medium text-zinc-900"><?= htmlspecialchars($c['fullname']) ?></span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-zinc-600"><?= htmlspecialchars($c['email']) ?></td>
                                <td class="px-5 py-3.5 text-zinc-400 text-xs whitespace-nowrap">
                                    <?= date('d M Y', strtotime($c['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="px-5 py-3 border-t border-zinc-100">
                <p class="text-xs text-zinc-400" id="rowCount">Total <?= count($customers) ?> customer</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function filterCustomers() {
        const q = (document.getElementById('searchInput')?.value ?? '').toLowerCase().trim();
        const rows = [...document.querySelectorAll('#customerBody .customer-row')];
        let visible = 0;

        rows.forEach(row => {
            const ok = !q || row.dataset.search.includes(q);
            row.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });

        document.getElementById('rowCount').textContent =
            `Menampilkan ${visible} dari ${rows.length} customer`;
    }
</script>

</body>

</html>
