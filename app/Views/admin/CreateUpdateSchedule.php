<?php


$s           = $schedule ?? [];
$curSlot     = $s['slot_capacity'] ?? '';
$curOpen     = isset($s['open_time'])  ? substr($s['open_time'],  0, 5) : '';
$curClose    = isset($s['close_time']) ? substr($s['close_time'], 0, 5) : '';
$hasSchedule = !empty($s);

?>

<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>

<title>Form Jadwal</title>
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
<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-8 animate-fadeIn">

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/admin/dashboard" class="hover:text-zinc-950 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-900 font-medium">Jadwal Operasional</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Jadwal Operasional</h1>
                <p class="text-sm text-zinc-500 mt-0.5">Atur jam buka, jam tutup, dan kapasitas slot harian.</p>
            </div>
        </div>
    </div>
    <!-- Header -->

    <!-- Current Status Card -->
    <?php if ($hasSchedule): ?>
        <div class="mb-6 bg-zinc-50 border border-zinc-200 rounded-2xl p-5 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <p class="text-xs font-semibold text-zinc-900 uppercase tracking-wide mb-3">Jadwal Aktif Saat Ini</p>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-lg border border-zinc-200 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">Jam Operasional</p>
                        <p class="text-sm font-bold text-zinc-950"><?= $curOpen ?> – <?= $curClose ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-lg border border-zinc-200 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8" />
                            <path d="M7 14h.01" />
                            <path d="M17 14h.01" />
                            <rect width="18" height="8" x="3" y="10" rx="2" />
                            <path d="M5 18v2" />
                            <path d="M19 18v2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500">Kuota per Hari</p>
                        <p class="text-sm font-bold text-zinc-950"><?= $curSlot ?> slot</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
        <div class="px-6 py-5 border-b border-zinc-50">
            <h2 class="text-base font-semibold text-zinc-950">
                <?= $hasSchedule ? 'Ubah Jadwal' : 'Atur Jadwal Pertama' ?>
            </h2>
            <p class="text-xs text-zinc-400 mt-0.5">Perubahan langsung berlaku untuk booking baru.</p>
        </div>

        <form action="/admin/jadwal/create-update" method="POST" class="px-6 py-6 space-y-5">
            <?= csrf_field() ?>

            <!-- Kuota Slot -->
            <div>
                <label class="block text-sm font-semibold text-zinc-900 mb-1.5" for="slot_capacity">
                    Kuota Slot per Hari <span class="text-red-600">*</span>
                </label>
                <input
                    type="number"
                    id="slot_capacity"
                    name="slot_capacity"
                    min="1" max="100"
                    placeholder="Contoh: 10"
                    value="<?= htmlspecialchars($_POST['slot_capacity'] ?? $curSlot) ?>"
                    required
                    class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                <p class="text-xs text-zinc-400 mt-1">Jumlah maksimal booking yang diterima setiap hari.</p>
            </div>

            <!-- Jam Buka & Tutup -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-zinc-900 mb-1.5" for="open_time">
                        Jam Buka <span class="text-red-600">*</span>
                    </label>
                    <div class="relative custom-select" id="open-time-select">
                        <button type="button"
                            class="dropdown-btn w-full flex items-center justify-between h-10 px-3 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all cursor-pointer">
                            <?php $ot = $_POST['open_time'] ?? $curOpen; ?>
                            <span class="selected-label"><?= !empty($ot) ? $ot : 'Pilih jam' ?></span>
                            <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute bottom-full z-50 mb-1 w-full max-h-60 overflow-auto bg-white border border-zinc-200 rounded-lg shadow-xl p-1 opacity-0 invisible translate-y-2 scale-95 transition-all duration-200 pointer-events-none">
                            <?php for ($h = 0; $h < 24; $h++): ?>
                                <?php $v = sprintf('%02d:00', $h); ?>
                                <button type="button" data-value="<?= $v ?>" data-label="<?= $v ?>" class="dropdown-item w-full flex items-center px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors"><?= $v ?></button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="open_time" id="open_time" value="<?= $ot ?>" required>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-zinc-900 mb-1.5" for="close_time">
                        Jam Tutup <span class="text-red-600">*</span>
                    </label>
                    <div class="relative custom-select" id="close-time-select">
                        <button type="button"
                            class="dropdown-btn w-full flex items-center justify-between h-10 px-3 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all cursor-pointer">
                            <?php $ct = $_POST['close_time'] ?? $curClose; ?>
                            <span class="selected-label"><?= !empty($ct) ? $ct : 'Pilih jam' ?></span>
                            <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute bottom-full z-50 mb-1 w-full max-h-60 overflow-auto bg-white border border-zinc-200 rounded-lg shadow-xl p-1 opacity-0 invisible translate-y-2 scale-95 transition-all duration-200 pointer-events-none">
                            <?php for ($h = 0; $h < 24; $h++): ?>
                                <?php $v = sprintf('%02d:00', $h); ?>
                                <button type="button" data-value="<?= $v ?>" data-label="<?= $v ?>" class="dropdown-item w-full flex items-center px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors"><?= $v ?></button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="close_time" id="close_time" value="<?= $ct ?>" required>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-2 border-t border-zinc-50">
                <a href="/admin/dashboard"
                    class="h-9 flex items-center text-sm px-4 py-2 rounded-md border border-zinc-200 bg-white font-medium text-zinc-700 hover:bg-zinc-50 transition-all active:scale-95">
                    Batal
                </a>
                <button type="submit"
                    class="h-9 text-sm px-4 py-2 rounded-md bg-zinc-950 font-medium text-white hover:bg-zinc-900 active:scale-95 transition-all duration-200 flex items-center gap-2">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

    <script>
        function setupCustomSelect(containerId) {
            const container = document.getElementById(containerId);
            const btn = container.querySelector('.dropdown-btn');
            const menu = container.querySelector('.dropdown-menu');
            const input = container.querySelector('input[type="hidden"]');
            const label = container.querySelector('.selected-label');

            btn.onclick = (e) => {
                e.stopPropagation();
                const isOpen = !menu.classList.contains('invisible');

                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    if (m !== menu) {
                        m.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95', 'pointer-events-none');
                        m.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    }
                });

                if (isOpen) {
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95', 'pointer-events-none');
                    menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                } else {
                    menu.classList.remove('opacity-0', 'invisible', 'translate-y-2', 'scale-95', 'pointer-events-none');
                    menu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                }
            };

            container.querySelectorAll('.dropdown-item').forEach(item => {
                item.onclick = () => {
                    const val = item.dataset.value;
                    const text = item.dataset.label;
                    input.value = val;
                    label.textContent = text;
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95', 'pointer-events-none');
                    menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    input.dispatchEvent(new Event('change'));
                };
            });
        }

        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                m.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95', 'pointer-events-none');
                m.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
            });
        });

        setupCustomSelect('open-time-select');
        setupCustomSelect('close-time-select');
    </script>

    <?php require __DIR__ . '/../components/toast.php'; ?>
    </div> <!-- flex-1 content -->

</body>

</html>