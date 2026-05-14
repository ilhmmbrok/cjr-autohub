<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/app.css">

    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>

    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }

        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/background.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .green {
            color: #25bf33;
        }

        .bg-green-custom {
            background-color: #25bf33;
        }

        .hover-green:hover {
            background-color: #1ea52b;
        }

        .hover-outline:hover {
            border-color: #25bf33;
            color: #25bf33;
        }
    </style>

    <title>AutoHub</title>
</head>

<body>

    <div class="min-h-screen">

        <!-- Navbar -->
        <nav class="bg-transparent border-b border-white/10 backdrop-blur-sm">

            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

                <!-- Logo -->
                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 flex items-center justify-center">

                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo" class="w-11 h-11"/>' ?>

                    </div>

                    <div>

                        <h1 class="text-lg font-bold text-white">
                            AutoHub
                        </h1>

                        <p class="text-xs text-zinc-300 -mt-1">
                            Booking Bengkel Online
                        </p>

                    </div>

                </div>

                <!-- Button -->
                <div class="flex gap-3">

                    <a href="/login"
                        class="px-5 py-2 text-sm font-medium text-white rounded-xl border border-white/20 transition-all hover:bg-white/10">

                        Sign In

                    </a>

                    <a href="/register"
                        class="px-5 py-2 text-sm font-medium text-white rounded-xl bg-green-custom transition-all hover-green">

                        Sign Up

                    </a>

                </div>

            </div>

        </nav>

        <!-- Hero -->
        <section class="max-w-7xl mx-auto px-6 py-20">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Left -->
                <div>

                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full  border border-white/20 text-white text-sm font-medium mb-6">

                        <div class="w-2 h-2 rounded-full bg-green-custom"></div>

                        Layanan Booking Bengkel Autohub

                    </div>

                    <h2 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">

                        Booking Servis
                        <span class="green">Lebih Mudah</span>
                        & Cepat

                    </h2>

                    <p class="mt-6 text-lg text-zinc-200 leading-relaxed max-w-xl">

                        AutoHub membantu pelanggan melakukan booking servis kendaraan
                        secara online tanpa perlu antre. Sistem dibuat modern,
                        praktis, dan mudah digunakan.

                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">

                        <a href="/register"
                            class="px-7 py-3 text-sm font-semibold text-white rounded-2xl bg-green-600 transition-all hover:bg-green-700">

                            Daftar Sekarang

                        </a>

                        <a href="/login"
                            class="px-7 py-3 text-sm font-semibold text-white rounded-2xl bg-transparent border border-white/20 transition-all hover:bg-white/20 backdrop-blur-xl">

                            Masuk

                        </a>

                    </div>

                </div>

                <!-- Right -->
                <div class="flex justify-center relative">

                    <!-- Background -->
                    <div
                        class="absolute top-10 right-10 w-40 h-40 bg-green-100 rounded-full blur-3xl opacity-50">
                    </div>

                    <div
                        class="absolute bottom-0 left-0 w-40 h-40 bg-red-100 rounded-full blur-3xl opacity-40">
                    </div>

                    <!-- Card -->
                    <div
                        class="relative bg-white border border-zinc-200 rounded-[36px] p-8 shadow-xl w-full max-w-xl overflow-hidden">

                        <!-- Top Accent -->

                        <!-- Header -->
                        <div class="flex items-center gap-5">

                            <div
                                class="w-24 h-24 rounded-3xl bg-zinc-50 border border-zinc-200 flex items-center justify-center shrink-0">

                                <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo" class="w-16 h-16"/>' ?>

                            </div>

                            <div>

                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-500 text-xs font-semibold">

                                    Sistem Booking Modern

                                </span>

                                <h3 class="text-3xl font-extrabold text-zinc-900 mt-3">
                                    AutoHub
                                </h3>

                                <p class="text-zinc-500 mt-2 leading-relaxed text-sm">

                                    Platform booking bengkel online yang membantu
                                    proses servis kendaraan menjadi lebih efisien.

                                </p>

                            </div>

                        </div>

                        <!-- Features -->
                        <div class="grid grid-cols-3 gap-4 mt-8">

                            <!-- Item -->
                            <div
                                class="p-5 rounded-2xl border border-zinc-200 hover:border-green-300 hover:bg-green-50 transition-all text-center">

                                <div
                                    class="w-12 h-12 mx-auto rounded-2xl bg-green-100 flex items-center justify-center mb-3">

                                    <div class="w-6 h-6 text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor-smartphone-icon lucide-monitor-smartphone"><path d="M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8"/><path d="M10 19v-3.96 3.15"/><path d="M7 19h5"/><rect width="6" height="10" x="16" y="12" rx="2"/></svg>
                                    </div>

                                </div>

                                <h4 class="font-bold text-zinc-800 text-sm">
                                    Booking Online
                                </h4>

                                <p class="text-xs text-zinc-500 mt-1">
                                    Tanpa antre
                                </p>

                            </div>

                            <!-- Item -->
                            <div
                                class="p-5 rounded-2xl border border-zinc-200 hover:border-red-300 hover:bg-red-50 transition-all text-center">

                                <div
                                    class="w-12 h-12 mx-auto rounded-2xl bg-red-100 flex items-center justify-center mb-3">

                                    <div class="w-5 h-5 rounded-full bg-red-500"></div>

                                </div>

                                <h4 class="font-bold text-zinc-800 text-sm">
                                    Jadwal Rapi
                                </h4>

                                <p class="text-xs text-zinc-500 mt-1">
                                    Lebih efisien
                                </p>

                            </div>

                            <!-- Item -->
                            <div
                                class="p-5 rounded-2xl border border-zinc-200 hover:border-green-300 hover:bg-green-50 transition-all text-center">

                                <div
                                    class="w-12 h-12 mx-auto rounded-2xl bg-green-100 flex items-center justify-center mb-3">

                                    <div class="w-5 h-5 rounded-full bg-green-500"></div>

                                </div>

                                <h4 class="font-bold text-zinc-800 text-sm">
                                    Cepat
                                </h4>

                                <p class="text-xs text-zinc-500 mt-1">
                                    Mudah dipakai
                                </p>

                            </div>

                        </div>

                        <!-- Footer -->
                        <div
                            class="mt-7 pt-5 border-t border-zinc-100 flex items-center justify-between">

                            <div>

                                <p class="text-xs text-zinc-400">
                                    Powered by
                                </p>

                                <p class="font-semibold text-zinc-800 text-sm">
                                    Kelompok 
                                </p>

                            </div>

                            <div class="flex gap-2">

                                <div class="w-3 h-3 rounded-full bg-green-400"></div>

                                <div class="w-3 h-3 rounded-full bg-red-400"></div>

                                <div class="w-3 h-3 rounded-full bg-zinc-300"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</body>

</html>