<?php


$s           = $schedule ?? [];
$curSlot     = $s['slot_capacity'] ?? '';
$curOpen     = isset($s['open_time'])  ? substr($s['open_time'],  0, 5) : '';
$curClose    = isset($s['close_time']) ? substr($s['close_time'], 0, 5) : '';
$hasSchedule = !empty($s);

?>

<?php require __DIR__ . '/../layouts/sidebar-admin.php'; ?>

<title>Form Jadwal</title>
<div class="flex-1 px-6 py-8 w-full mx-auto">

    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/admin/jadwal" class="hover:text-zinc-700 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-700 font-medium">Daftar Booking</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 tracking-tight">Jadwal Operasional</h1>
                <p class="text-sm text-zinc-500 mt-0.5">Atur jam buka, jam tutup, dan kapasitas slot harian.</p>
            </div>
        </div>
    </div>
    <!-- Header -->

    <!-- Current Status Card -->
    <?php if ($hasSchedule): ?>
        <div class="mb-6 bg-blue-50 border border-blue-100 rounded-lg p-5">
            <p class="text-xs font-semibold text-blue-400 uppercase tracking-wide mb-3">Jadwal Aktif Saat Ini</p>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-md border border-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-blue-400">Jam Operasional</p>
                        <p class="text-sm font-bold text-slate-800"><?= $curOpen ?> – <?= $curClose ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-md border border-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-blue-400">Kuota per Hari</p>
                        <p class="text-sm font-bold text-slate-800"><?= $curSlot ?> slot</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-lg border border-zinc-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-base font-semibold text-slate-900">
                <?= $hasSchedule ? 'Ubah Jadwal' : 'Atur Jadwal Pertama' ?>
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">Perubahan langsung berlaku untuk booking baru.</p>
        </div>

        <form action="/admin/jadwal/create-update" method="POST" class="px-6 py-6 space-y-5">

            <!-- Kuota Slot -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="slot_capacity">
                    Kuota Slot per Hari <span class="text-red-500">*</span>
                </label>
                <input
                    type="number"
                    id="slot_capacity"
                    name="slot_capacity"
                    min="1" max="100"
                    placeholder="Contoh: 10"
                    value="<?= htmlspecialchars($_POST['slot_capacity'] ?? $curSlot) ?>"
                    required
                    class="w-full px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                <p class="text-xs text-slate-400 mt-1">Jumlah maksimal booking yang diterima setiap hari.</p>
            </div>

            <!-- Jam Buka & Tutup -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="open_time">
                        Jam Buka <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="open_time" name="open_time" required
                            class="w-full appearance-none px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all cursor-pointer">
                            <option value="" disabled <?= empty($_POST['open_time'] ?? $curOpen) ? 'selected' : '' ?>>Pilih jam</option>
                            <?php for ($h = 6; $h < 18; $h++): ?>
                                <?php $v = sprintf('%02d:00', $h); ?>
                                <option value="<?= $v ?>" <?= (($_POST['open_time'] ?? $curOpen) === $v) ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="close_time">
                        Jam Tutup <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="close_time" name="close_time" required
                            class="w-full appearance-none px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all cursor-pointer">
                            <option value="" disabled <?= empty($_POST['close_time'] ?? $curClose) ? 'selected' : '' ?>>Pilih jam</option>
                            <?php for ($h = 7; $h <= 22; $h++): ?>
                                <?php $v = sprintf('%02d:00', $h); ?>
                                <option value="<?= $v ?>" <?= (($_POST['close_time'] ?? $curClose) === $v) ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="/admin/dashboard"
                    class="text-sm px-4 py-2 rounded-md border border-zinc-200 bg-white font-medium text-zinc-700 hover:bg-zinc-50 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="text-sm px-4 py-2 rounded-md bg-zinc-900 font-medium text-white hover:bg-zinc-800 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

</div>

<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>