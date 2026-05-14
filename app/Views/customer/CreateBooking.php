<?php
$openHour  = !empty($schedule['open_time'])  ? (int) substr($schedule['open_time'],  0, 2) : 0;
$closeHour = !empty($schedule['close_time']) ? (int) substr($schedule['close_time'], 0, 2) : 23;
?>

<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Buat Booking</title>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div class="w-full bg-white min-h-[calc(100vh-56px)] px-4 sm:px-6 lg:px-8 py-8 animate-fadeInUp">
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-3">
            <a href="/dashboard" class="hover:text-zinc-950 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-zinc-900 font-medium">Buat Booking</span>
        </div>
        <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Form Booking Online</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Silahkan isi form dibawah ini.</p>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white overflow-hidden pb-4 shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
        <form action="/create-booking" method="POST">
            <?= csrf_field() ?>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="phone">
                            Phone <span class="text-red-600">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone"
                            placeholder="0812345678"
                            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                            required
                            class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all placeholder:text-zinc-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="address">
                            Alamat <span class="text-red-600">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3" placeholder="Alamat Lengkap" required
                            class="w-full px-3 py-2 rounded-lg border text-sm border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all resize-none placeholder:text-zinc-400"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="date">
                            Tanggal Booking <span class="text-red-600">*</span>
                        </label>
                        <input type="date" id="date" name="date"
                            min="<?= date('Y-m-d') ?>"
                            value="<?= htmlspecialchars($_POST['date'] ?? '') ?>"
                            required
                            class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="checkin_time">
                            Jam Kedatangan <span class="text-red-600">*</span>
                        </label>
                        <div class="relative custom-select" id="checkin-time-select">
                            <button type="button"
                                class="dropdown-btn w-full flex items-center justify-between h-10 px-3 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:ring-4 focus:ring-zinc-950/5 focus:border-zinc-950 hover:border-zinc-300 transition-all cursor-pointer">
                                <span class="selected-label">Pilih jam kedatangan</span>
                                <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="dropdown-menu absolute bottom-full z-50 mb-1 w-full max-h-60 overflow-auto bg-white border border-zinc-200 rounded-lg shadow-xl p-1 opacity-0 invisible translate-y-2 scale-95 transition-all duration-200 pointer-events-none" data-direction="up">
                                <?php if (empty($schedule)): ?>
                                    <p class="text-sm text-zinc-400 px-3 py-2">Jadwal operasional belum diatur.</p>
                                <?php else: ?>
                                    <?php for ($hour = $openHour; $hour <= $closeHour; $hour++): ?>
                                        <?php $value = sprintf('%02d:00', $hour); ?>
                                        <button type="button"
                                            data-value="<?= $value ?>"
                                            data-label="<?= $value ?>"
                                            class="dropdown-item w-full flex items-center px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors">
                                            <?= $value ?>
                                        </button>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="checkin_time" id="checkin_time" value="" required>
                        </div>
                        <p class="text-xs text-zinc-400 mt-1">Pilih jam kedatangan sesuai jam operasional.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="vehicle_type">
                                Jenis Kendaraan <span class="text-red-600">*</span>
                            </label>
                            <div class="relative custom-select" id="vehicle-type-select">
                                <button type="button"
                                    class="dropdown-btn w-full flex items-center justify-between h-10 px-3 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:ring-4 focus:ring-zinc-950/5 focus:border-zinc-950 hover:border-zinc-300 transition-all cursor-pointer">
                                    <?php
                                    $vt = $_POST['vehicle_type'] ?? '';
                                    $vtLabel = ($vt === 'mobil' ? 'Mobil' : ($vt === 'motor' ? 'Motor' : 'Pilih jenis kendaraan'));
                                    ?>
                                    <span class="selected-label"><?= $vtLabel ?></span>
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="dropdown-menu absolute z-50 mt-1 w-full bg-white border border-zinc-200 rounded-lg shadow-xl p-1 opacity-0 invisible -translate-y-2 scale-95 transition-all duration-200 pointer-events-none" data-direction="down">
                                    <button type="button" data-value="motor" data-label="Motor" class="dropdown-item w-full flex items-center px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors">Motor</button>
                                    <button type="button" data-value="mobil" data-label="Mobil" class="dropdown-item w-full flex items-center px-3 py-2 rounded-md text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-950 transition-colors">Mobil</button>
                                </div>
                                <input type="hidden" name="vehicle_type" id="vehicle_type" value="<?= $_POST['vehicle_type'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="plate_number">
                                Nomor Polisi <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="plate_number" name="plate_number"
                                placeholder="ABC 1234 XY"
                                value="<?= htmlspecialchars($_POST['plate_number'] ?? '') ?>"
                                required
                                oninput="this.value = this.value.toUpperCase()"
                                class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all placeholder:text-zinc-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="model_year">
                            Model dan Tahun Kendaraan <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="model_year" name="model_year"
                            placeholder="Contoh: Honda Vario 150"
                            value="<?= htmlspecialchars($_POST['model_year'] ?? '') ?>"
                            required
                            class="h-9 w-full px-3 py-2 rounded-lg border text-sm border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all placeholder:text-zinc-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="customer_complaint">
                            Keluhan Anda <span class="text-red-600">*</span>
                        </label>
                        <textarea name="customer_complaint" id="customer_complaint" rows="5"
                            placeholder="Servis Rutin, Ganti Oli, dll." required
                            class="w-full h-20 md:h-41 px-3 py-2 rounded-lg border text-sm border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 hover:border-zinc-300 transition-all resize-none placeholder:text-zinc-400"><?= htmlspecialchars($_POST['customer_complaint'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 flex justify-end gap-3 border-t border-zinc-50">
                <a href="/dashboard">
                    <button type="button" class="h-9 text-xs px-4 py-2 rounded-md border border-zinc-200 bg-white font-medium text-zinc-700 hover:bg-zinc-100 active:scale-95 transition-all duration-200">
                        Batal
                    </button>
                </a>
                <button type="submit" class="h-9 text-xs px-4 py-2 rounded-md bg-zinc-950 font-medium text-white hover:bg-zinc-800 hover:shadow-lg active:scale-95 transition-all duration-200">
                    Submit Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function setupCustomSelect(containerId) {
        const container = document.getElementById(containerId);
        const btn = container.querySelector('.dropdown-btn');
        const menu = container.querySelector('.dropdown-menu');
        const input = container.querySelector('input[type="hidden"]');
        const label = container.querySelector('.selected-label');

        const direction = menu.dataset.direction || 'up';
        const offsetClass = direction === 'up' ? 'translate-y-2' : '-translate-y-2';

        btn.onclick = (e) => {
            e.stopPropagation();
            const isOpen = !menu.classList.contains('invisible');

            // Close other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) {
                    const mDir = m.dataset.direction || 'up';
                    const mOffset = mDir === 'up' ? 'translate-y-2' : '-translate-y-2';
                    m.classList.add('opacity-0', 'invisible', mOffset, 'scale-95', 'pointer-events-none');
                    m.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                }
            });

            if (isOpen) {
                menu.classList.add('opacity-0', 'invisible', offsetClass, 'scale-95', 'pointer-events-none');
                menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
            } else {
                menu.classList.remove('opacity-0', 'invisible', offsetClass, 'scale-95', 'pointer-events-none');
                menu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
            }
        };

        container.querySelectorAll('.dropdown-item').forEach(item => {
            item.onclick = () => {
                const val = item.dataset.value;
                const text = item.dataset.label;
                input.value = val;
                label.textContent = text;
                menu.classList.add('opacity-0', 'invisible', offsetClass, 'scale-95', 'pointer-events-none');
                menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                input.dispatchEvent(new Event('change'));
            };
        });
    }

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            const mDir = m.dataset.direction || 'up';
            const mOffset = mDir === 'up' ? 'translate-y-2' : '-translate-y-2';
            m.classList.add('opacity-0', 'invisible', mOffset, 'scale-95', 'pointer-events-none');
            m.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
        });
    });

    setupCustomSelect('checkin-time-select');
    setupCustomSelect('vehicle-type-select');
</script>

<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>