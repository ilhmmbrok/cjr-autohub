<?php require __DIR__ . '/../layouts/navbar-customer.php'; ?>

<title>Profil</title>
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
</style>

<div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-8 animate-fadeInUp">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-zinc-950 tracking-tight">Profil</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card: Informasi Akun -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-zinc-950" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-pen-icon lucide-user-round-pen"><path d="M2 21a8 8 0 0 1 10.821-7.487"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="8" r="5"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-zinc-950">Informasi Akun</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Perbarui nama, email, dan nomor telepon Anda</p>
                </div>
            </div>

            <div class="border-t border-zinc-100 -mx-6 mb-5"></div>

            <form method="POST" action="/profile" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="fullname">
                        Nama Lengkap <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="fullname" name="fullname"
                        value="<?= htmlspecialchars($user['fullname'] ?? '') ?>"
                        required
                        class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="email">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input type="email" id="email" name="email"
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                        required
                        class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="phone">
                        Nomor Telepon
                    </label>
                    <input type="tel" id="phone" name="phone"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                        placeholder="08xxxxxxxxxx"
                        class="h-9 w-full px-3 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="h-9 px-4 text-sm rounded-md font-medium cursor-pointer text-white bg-zinc-950 hover:bg-zinc-900 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Card: Ubah Password -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-zinc-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-zinc-950">Ubah Password</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Pastikan menggunakan password yang kuat</p>
                </div>
            </div>

            <div class="border-t border-zinc-100 -mx-6 mb-5"></div>

            <form method="POST" action="/profile/password" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="old_password">
                        Password Lama <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="old_password" name="old_password"
                            placeholder="••••••••" required
                            class="h-9 w-full px-3 pr-10 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        <button type="button" class="pw-toggle absolute right-0 top-0 h-9 w-9 flex items-center justify-center text-zinc-400 hover:text-zinc-700 transition-colors" data-target="old_password" tabindex="-1">
                            <svg class="eye-show w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="new_password">
                        Password Baru <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password"
                            placeholder="Minimal 8 karakter" required
                            class="h-9 w-full px-3 pr-10 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        <button type="button" class="pw-toggle absolute right-0 top-0 h-9 w-9 flex items-center justify-center text-zinc-400 hover:text-zinc-700 transition-colors" data-target="new_password" tabindex="-1">
                            <svg class="eye-show w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-950 mb-1.5" for="confirm_password">
                        Konfirmasi Password Baru <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password"
                            placeholder="Ulangi password baru" required
                            class="h-9 w-full px-3 pr-10 py-2 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all placeholder:text-zinc-400">
                        <button type="button" class="pw-toggle absolute right-0 top-0 h-9 w-9 flex items-center justify-center text-zinc-400 hover:text-zinc-700 transition-colors" data-target="confirm_password" tabindex="-1">
                            <svg class="eye-show w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-hide w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="h-9 px-4 text-sm rounded-md font-medium cursor-pointer text-white bg-zinc-950 hover:bg-zinc-900 transition-all active:scale-95">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../components/toast.php'; ?>

<script>
    document.querySelectorAll('.pw-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const show = btn.querySelector('.eye-show');
            const hide = btn.querySelector('.eye-hide');
            if (input.type === 'password') {
                input.type = 'text';
                show.classList.add('hidden');
                hide.classList.remove('hidden');
            } else {
                input.type = 'password';
                show.classList.remove('hidden');
                hide.classList.add('hidden');
            }
        });
    });
</script>

</body>

</html>
