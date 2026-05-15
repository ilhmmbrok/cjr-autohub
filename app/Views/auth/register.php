<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/autohub.webp" type="image/x-icon" />
    <link rel="stylesheet" href="/css/app.css">
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');
        * { font-family: 'Instrument Sans', sans-serif; }

        .login-bg {
            background-image: url('/assets/background.webp');
            background-size: cover;
            background-position: center;
        }
         @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .anim-fade { opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .anim-slide { opacity: 0; animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .anim-scale { opacity: 0; animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.12s; }
        .delay-3 { animation-delay: 0.2s; }
        .delay-4 { animation-delay: 0.28s; }
        .delay-5 { animation-delay: 0.36s; }
    </style>
    <title>Sign Up - AutoHub</title>
</head>

<body class="bg-zinc-50">
    <div class="flex min-h-screen">

        <!-- Left: Background Panel -->
        <div class="hidden lg:flex lg:w-1/2 login-bg relative flex-col justify-between p-10">
            <div class="absolute inset-0 bg-zinc-950/60"></div>

            <!-- Top brand -->
            <div class="relative z-10 flex items-center gap-2.5 anim-slide delay-1">
                <img src="/assets/autohub.webp" alt="AutoHub" class="w-8 h-8 rounded-lg" />
                <span class="text-white/90 text-base font-semibold tracking-tight">AutoHub</span>
            </div>

            <!-- Bottom testimonial -->
            <div class="relative z-10 anim-slide delay-3">
                <blockquote class="text-lg text-white/90 font-medium leading-relaxed mb-4">
                    "Daftar dalam hitungan detik dan langsung bisa booking servis kendaraan secara online. Sangat praktis!"
                </blockquote>
                <p class="text-sm text-white/60">AutoHub</p>
            </div>
        </div>

        <!-- Right: Form Panel -->
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-8 bg-white">
            <div class="w-full max-w-[360px]">

                <!-- Mobile brand -->
                <div class="lg:hidden flex items-center justify-center gap-2 mb-8 anim-scale">
                    <img src="/assets/autohub.webp" alt="AutoHub" class="w-9 h-9 rounded-lg" />
                    <span class="text-zinc-950 text-lg font-semibold tracking-tight">AutoHub</span>
                </div>

                <!-- Header -->
                <div class="mb-6 anim-fade delay-1">
                    <h1 class="text-2xl font-semibold text-zinc-950 tracking-tight">Buat akun</h1>
                    <p class="text-sm text-zinc-500 mt-1">Isi data berikut untuk membuat akun baru</p>
                </div>

                <!-- Form -->
                <form class="space-y-4" method="POST" action="/register">
                    <?= csrf_field() ?>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-zinc-950 leading-none anim-fade delay-2" for="fullname">Nama Lengkap</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Nama lengkap Anda" required
                            class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-zinc-400 focus:outline-none focus:ring-1 focus:ring-zinc-950 anim-fade delay-2">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-zinc-950 leading-none anim-fade delay-3" for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="nama@email.com" required
                            class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-zinc-400 focus:outline-none focus:ring-1 focus:ring-zinc-950 anim-fade delay-3">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-zinc-950 leading-none anim-fade delay-4" for="password">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required
                                class="flex h-9 w-full rounded-md border border-zinc-200 bg-transparent px-3 pr-9 py-1 text-sm shadow-xs transition-colors placeholder:text-zinc-400 focus:outline-none focus:ring-1 focus:ring-zinc-950 anim-fade delay-5">
                            <button type="button" class="pw-toggle absolute right-0 top-0 h-9 w-9 flex items-center justify-center text-zinc-400 hover:text-zinc-600 transition-colors" data-target="password" tabindex="-1">
                                <svg class="eye-show w-4 h-4 anim-fade delay-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-hide w-4 h-4 hidden anim-fade delay-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center justify-center h-9 w-full rounded-md bg-zinc-950 px-4 text-sm font-medium text-white shadow-xs hover:bg-zinc-800 transition-colors active:scale-[0.98] cursor-pointer anim-fade delay-4">
                        Buat Akun
                    </button>
                </form>

                <!-- Footer -->
                <p class="mt-6 text-center text-sm text-zinc-500 anim-fade delay-5">
                    Sudah punya akun?
                    <a href="/login" class="text-zinc-950 font-medium underline underline-offset-4 hover:text-zinc-700 transition-colors">Login</a>
                </p>
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