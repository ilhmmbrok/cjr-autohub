<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Form Booking Online</title>

<div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-8 bg-white min-h-[calc(100vh-56px)]">
    <div class="w-full">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-zinc-900 tracking-tight">Form Booking Online</h2>
            <p class="text-sm text-zinc-500 mt-0.5">Silahkan isi form dibawah ini.</p>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white overflow-hidden pb-4">
            <form action="/create-booking" method="POST">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="phone">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone"
                                placeholder="0812345678"
                                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                required
                                class="w-full px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="address">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" id="address" rows="3" placeholder="Alamat Lengkap" required
                                class="w-full px-3 py-2 rounded-md border text-sm border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all resize-none"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="date">
                                Tanggal Booking <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="date" name="date"
                                min="<?= date('Y-m-d') ?>"
                                value="<?= htmlspecialchars($_POST['date'] ?? '') ?>"
                                required
                                class="w-full px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="checkin_time">
                                Jam Kedatangan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="checkin_time" name="checkin_time" required
                                    class="w-full appearance-none px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all cursor-pointer">
                                    <option value="" disabled <?= empty($_POST['checkin_time']) ? 'selected' : '' ?>>Pilih jam kedatangan</option>
                                    <?php for ($hour = 0; $hour < 24; $hour++): ?>
                                        <?php $value = sprintf('%02d:00', $hour); ?>
                                        <option value="<?= $value ?>" <?= (($_POST['checkin_time'] ?? '') === $value) ? 'selected' : '' ?>>
                                            <?= $value ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-zinc-400 mt-1">Pilih jam kedatangan sesuai jam operasional.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="vehicle_type">
                                    Jenis Kendaraan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="vehicle_type" id="vehicle_type" required
                                        class="w-full appearance-none px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all cursor-pointer">
                                        <option value="motor" <?= (($_POST['vehicle_type'] ?? '') === 'motor') ? 'selected' : '' ?>>Motor</option>
                                        <option value="mobil" <?= (($_POST['vehicle_type'] ?? '') === 'mobil') ? 'selected' : '' ?>>Mobil</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="plate_number">
                                    Nomor Polisi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="plate_number" name="plate_number"
                                    placeholder="ABC 1234 XY"
                                    value="<?= htmlspecialchars($_POST['plate_number'] ?? '') ?>"
                                    required
                                    oninput="this.value = this.value.toUpperCase()"
                                    class="w-full px-3 py-2 rounded-md text-sm border border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="model_year">
                                Model dan Tahun Kendaraan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="model_year" name="model_year"
                                placeholder="Contoh: Honda Vario 150"
                                value="<?= htmlspecialchars($_POST['model_year'] ?? '') ?>"
                                required
                                class="w-full px-3 py-2 rounded-md border text-sm border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-900 mb-1.5" for="customer_complaint">
                                Keluhan Anda <span class="text-red-500">*</span>
                            </label>
                            <textarea name="customer_complaint" id="customer_complaint" rows="5"
                                placeholder="Servis Rutin, Ganti Oli, dll." required
                                class="w-full h-20 md:h-41 px-3 py-2 rounded-md border text-sm border-zinc-300 bg-white focus:outline-none focus:ring-2 focus:ring-zinc-950/10 focus:border-zinc-400 transition-all resize-none"><?= htmlspecialchars($_POST['customer_complaint'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 flex justify-end gap-3 border-t border-zinc-100">
                    <a href="/dashboard">
                        <button type="button" class="text-sm px-4 py-2 rounded-md border border-zinc-200 bg-white font-medium text-zinc-700 hover:bg-zinc-50 transition-all">
                            Batal
                        </button>
                    </a>
                    <button type="submit" class="text-sm px-4 py-2 rounded-md bg-zinc-900 font-medium text-white hover:bg-zinc-800 transition-all">
                        Submit Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../components/toast.php'; ?>

</body>

</html>
