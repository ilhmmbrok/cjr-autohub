<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoHub — Booking Bengkel Online</title>
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <link rel="stylesheet" href="/css/app.css" />

    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900');

        * {
            font-family: 'Instrument Sans', sans-serif;
            box-sizing: border-box;
        }

        :root {
            --green: #25bf33;
            --green-dark: #1ea52b;
            --green-rgb: 37, 191, 51;
        }

        /* ── Body background ── */
        body {
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.72)),
                url('/assets/background.webp');
            background-color: white;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* ── Navbar pill glass ── */
        .nav-pill {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            transition: background .25s, box-shadow .25s;
        }

        .nav-pill:hover {
            background: rgba(255, 255, 255, 0.09);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.28);
        }

        /* ── Phone float ── */
        @keyframes floatA {

            0%,
            100% {
                transform: rotate(-4deg) translateY(-20px);
            }

            50% {
                transform: rotate(-4deg) translateY(-34px);
            }
        }

        @keyframes floatB {

            0%,
            100% {
                transform: rotate(3deg) translateY(0);
            }

            50% {
                transform: rotate(3deg) translateY(-14px);
            }
        }

        .phone-back {
            animation: floatA 5s ease-in-out infinite;
        }

        .phone-front {
            animation: floatB 5s ease-in-out 0.8s infinite;
        }

        /* ── Badge dot pulse ── */
        @keyframes pulseDot {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(var(--green-rgb), 0.55);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(var(--green-rgb), 0);
            }
        }

        .badge-dot {
            animation: pulseDot 2s ease-in-out infinite;
        }

        /* ── Hero stagger ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-1 {
            animation: fadeUp .65s .05s both;
        }

        .hero-2 {
            animation: fadeUp .65s .15s both;
        }

        .hero-3 {
            animation: fadeUp .65s .25s both;
        }

        .hero-4 {
            animation: fadeUp .65s .35s both;
        }

        .hero-5 {
            animation: fadeUp .65s .55s both;
        }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .65s ease, transform .65s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Card shine sweep ── */
        .card-shine {
            position: relative;
            overflow: hidden;
        }

        .card-shine::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 38%, rgba(255, 255, 255, 0.045) 50%, transparent 62%);
            transform: translateX(-100%);
            transition: transform .55s ease;
        }

        .card-shine:hover::after {
            transform: translateX(100%);
        }
    </style>
</head>

<body class="min-h-screen text-white antialiased">

    <!-- ════════════════════════════════════════
     NAVBAR
════════════════════════════════════════ -->
    <nav class="sticky top-3 z-50 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="nav-pill rounded-full flex items-center justify-between gap-3 px-5 py-3">

                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 flex-shrink-0">
                    <?php echo '<img src="/assets/autohub.webp" alt="AutoHub" class="w-8 h-8 rounded-full"/>' ?>
                    <div class="leading-tight">
                        <p class="text-white font-bold text-[0.95rem] tracking-tight">AutoHub</p>
                        <p class="hidden sm:block text-white/40 text-[0.60rem] font-medium">Booking Online</p>
                    </div>
                </a>

                <!-- Buttons -->
                <div class="flex items-center gap-2">
                    <a href="/login"
                        class="px-4 py-2 rounded-full text-[0.82rem] font-semibold text-white
                          border border-white/20 hover:bg-white/10 transition-all duration-200 whitespace-nowrap">
                        Sign In
                    </a>
                    <a href="/register"
                        class="px-4 py-2 rounded-full text-[0.82rem] font-semibold text-white
                          bg-[#25bf33] hover:bg-[#1ea52b] transition-all duration-200 whitespace-nowrap">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8
                pt-12 pb-16 sm:pt-16 sm:pb-20
                grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

        <!-- Left: copy -->
        <div>
            <!-- Badge -->
            <div class="hero-1 inline-flex items-center gap-2 px-4 py-2 rounded-full
                    border border-white/20 text-white text-[0.78rem] font-semibold mb-6">
                <span class="badge-dot w-2 h-2 rounded-full bg-[#25bf33] flex-shrink-0"></span>
                Politeknik Negeri Jember
            </div>

            <!-- Headline -->
            <h1 class="hero-2 text-[clamp(2rem,5vw,3.6rem)] font-black leading-[1.10]
                   tracking-[-1.5px] text-white">
                Booking Servis
                <span class="text-[#25bf33]">Lebih Mudah</span>
                &amp; Cepat
            </h1>

            <!-- Description -->
            <p class="hero-3 mt-5 text-white/65 text-base leading-[1.75] max-w-[480px]">
                AutoHub kini menghadirkan kemudahan booking servis kendaraan secara online
                tanpa perlu antre, dengan sistem yang modern, praktis, dan mudah digunakan.
            </p>

            <!-- CTA -->
            <div class="hero-4 mt-8 flex flex-col sm:flex-row gap-3">
                <a href="/register"
                    class="inline-flex items-center justify-center px-7 py-3.5 rounded-3xl
                      text-[0.90rem] font-bold text-white bg-[#25bf33] hover:bg-[#1ea52b]
                      transition-all duration-200 hover:-translate-y-0.5">
                    Daftar Sekarang
                </a>
                <a href="/login"
                    class="inline-flex items-center justify-center px-7 py-3.5 rounded-3xl
                      text-[0.90rem] font-bold text-white border border-white/20
                      bg-white/8 hover:bg-white/14
                      transition-all duration-200 hover:-translate-y-0.5">
                    Masuk
                </a>
            </div>
        </div>

        <!-- Right: mockup — hidden below lg -->
        <div class="hero-5 hidden lg:flex justify-center items-end relative">
            <!-- Glows -->
            <div class="absolute top-8 right-6 w-44 h-44 rounded-full blur-3xl pointer-events-none
                    bg-[rgba(37,191,51,0.18)]"></div>
            <div class="absolute bottom-0 left-0 w-36 h-36 rounded-full blur-3xl pointer-events-none
                    bg-[rgba(37,191,51,0.12)]"></div>

            <!-- Phones -->
            <div class="relative h-[460px] w-[360px]">
                <div class="phone-back absolute bottom-0 left-2 z-10">
                    <div class="w-[185px] rounded-[36px] shadow-[0_20px_60px_rgba(0,0,0,0.45)]">
                        <div class="rounded-[28px] overflow-hidden bg-white leading-[0]">
                            <?php echo '<img src="/assets/detailBooking.png" alt="Detail Booking AutoHub"
                             class="w-full object-cover object-top block"/>' ?>
                        </div>
                    </div>
                </div>
                <div class="phone-front absolute bottom-0 right-2 z-20">
                    <div class="w-[185px] rounded-[36px] shadow-[0_20px_60px_rgba(0,0,0,0.45)]">
                        <div class="rounded-[28px] overflow-hidden bg-white leading-[0]">
                            <?php echo '<img src="/assets/dashboard.png" alt="Dashboard AutoHub"
                             class="w-full object-cover object-top block"/>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-white/10" />
    </div>


    <!-- ════════════════════════════════════════
     CARA BOOKING — 4 Steps
════════════════════════════════════════ -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-16 sm:pt-16 sm:pb-20">

        <div class="text-center mb-12 reveal">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 mb-4
                    text-[0.76rem] font-bold uppercase tracking-widest
                    bg-[rgba(37,191,51,0.13)] border border-[rgba(37,191,51,0.25)] text-[#6ee87a]">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Cara Mudah Booking
            </div>
            <h2 class="text-[clamp(1.6rem,3.5vw,2.6rem)] font-black text-white tracking-tight leading-tight">
                Servis dalam <span class="text-[#25bf33]">4 Langkah</span>
            </h2>
            <p class="mt-3 text-white/45 text-[0.93rem] max-w-md mx-auto leading-relaxed">
                Proses booking yang simpel, cepat, dan bisa dilakukan dari mana saja.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            $steps = [
                ['1', 'Daftar Akun',      'Buat akun gratis dengan email dalam hitungan detik.'],
                ['2', 'Pilih Layanan',    'Isi formulir servis yang dibutuhkan kendaraanmu'],
                ['3', 'Atur Jadwal',      'Pilih tanggal dan jam yang paling cocok dengan aktivitas harianmu.'],
                ['4', 'Datang & Selesai', 'Datang tepat waktu, kendaraanmu langsung diproses tanpa antre panjang.'],
            ];
            foreach ($steps as $i => $s): ?>
                <div class="reveal card-shine text-center cursor-default p-7 rounded-[22px]
                    bg-white/[0.04] border border-white/[0.09]
                    hover:bg-[rgba(37,191,51,0.07)] hover:border-[rgba(37,191,51,0.30)]
                    transition-all duration-300 hover:-translate-y-1"
                    style="transition-delay: <?php echo $i * 80 ?>ms">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center mx-auto mb-4
                        text-white text-base font-black
                        bg-[#25bf33] shadow-[0_4px_16px_rgba(37,191,51,0.30)]">
                        <?php echo $s[0] ?>
                    </div>
                    <p class="text-white font-extrabold text-[0.92rem] mb-2"><?php echo $s[1] ?></p>
                    <p class="text-white/40 text-[0.80rem] leading-relaxed"><?php echo $s[2] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <!-- ════════════════════════════════════════
     FITUR CUSTOMER
════════════════════════════════════════ -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">

        <div class="text-center mb-12 reveal">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 mb-4
                    text-[0.76rem] font-bold uppercase tracking-widest
                    bg-[rgba(37,191,51,0.13)] border border-[rgba(37,191,51,0.25)] text-[#6ee87a]">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 7h-9" />
                    <path d="M14 17H5" />
                    <circle cx="17" cy="17" r="3" />
                    <circle cx="7" cy="7" r="3" />
                </svg>
                Fitur untuk Customer
            </div>
            <h2 class="text-[clamp(1.6rem,3.5vw,2.6rem)] font-black text-white tracking-tight leading-tight">
                Semua yang Kamu Butuhkan <span class="text-[#25bf33]">Ada di Sini</span>
            </h2>
            <p class="mt-3 text-white/45 text-[0.93rem] max-w-lg mx-auto leading-relaxed">
                Dari booking hingga cek status servis, AutoHub hadir lengkap untuk
                memudahkan pengalaman servis kendaraanmu.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-3xl mx-auto">
            <?php
            $features = [
                [
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-icon lucide-clipboard"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>',
                    'title' => 'Booking Servis Online',
                    'desc'  => 'Atur jadwal servis kendaraanmu dengan cepat tanpa harus datang langsung ke bengkel.',
                ],
                [
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                    'title' => 'Status Booking',
                    'desc'  => 'Lihat perkembangan servis kendaraanmu secara langsung dari proses awal hingga selesai.',
                ],
                [
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>',
                    'title' => 'Riwayat Servis',
                    'desc'  => 'Semua riwayat servis tersimpan rapi untuk memudahkan pemantauan perawatan kendaraanmu.',
                ],
                [
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>',
                    'title' => 'Pilih Jadwal Fleksibel',
                    'desc'  => 'Sesuaikan waktu booking dengan aktivitasmu. Tersedia berbagai slot waktu yang bisa dipilih bebas.',
                ],
            ];
            foreach ($features as $i => $f): ?>
                <div class="reveal card-shine cursor-default group p-7 rounded-[22px]
                    bg-white/[0.04] border border-white/[0.09]
                    hover:bg-[rgba(37,191,51,0.07)] hover:border-[rgba(37,191,51,0.30)]
                    transition-all duration-300 hover:-translate-y-1"
                    style="transition-delay: <?php echo ($i % 2) * 80 ?>ms">
                    <div class="w-12 h-12 rounded-[14px] flex items-center justify-center mb-5
                        bg-[rgba(37,191,51,0.14)]
                        group-hover:bg-[rgba(37,191,51,0.22)] group-hover:scale-105
                        transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#25bf33]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <?php echo $f['icon'] ?>
                        </svg>
                    </div>
                    <p class="text-white font-extrabold text-base mb-2"><?php echo $f['title'] ?></p>
                    <p class="text-white/40 text-[0.84rem] leading-relaxed"><?php echo $f['desc'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-white/10" />
    </div>


    <!-- ════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════ -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="reveal relative overflow-hidden rounded-[28px] text-center
                border border-[rgba(37,191,51,0.28)]
                bg-gradient-to-br from-[rgba(37,191,51,0.18)] via-[rgba(37,191,51,0.07)] to-transparent
                px-6 py-14 sm:px-12 sm:py-16">

            <!-- Glow -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-72 h-28 rounded-full blur-3xl
                    pointer-events-none bg-[rgba(37,191,51,0.15)]"></div>

            <h2 class="relative text-[clamp(1.4rem,3vw,2.1rem)] font-black text-white mb-3">
                Siap Booking Servis Sekarang?
            </h2>
            <p class="relative text-white/50 text-[0.93rem] max-w-xl mx-auto leading-relaxed mb-8">
                Bergabung bersama AutoHub dan kelola booking servis bengkel anda dengan lebih mudah,
                cepat, dan praktis. Daftar sekarang dan rasakan kemudahan booking online untuk kendaraanmu!
            </p>
            <div class="relative flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a href="/register"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                      px-8 py-3.5 rounded-[18px] text-[0.90rem] font-bold text-white
                      bg-[#25bf33] hover:bg-[#1ea52b]
                      transition-all duration-200 hover:-translate-y-0.5">
                    Daftar Gratis
                </a>
                <a href="/login"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                      px-8 py-3.5 rounded-[18px] text-[0.90rem] font-bold text-white
                      border border-white/20 bg-white/8 hover:bg-white/14
                      transition-all duration-200 hover:-translate-y-0.5">
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>


    <!-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
    <footer class="border-t border-white/[0.08] py-6 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-white/30 text-[0.80rem]">
                © 2026 <span class="text-[#25bf33] font-bold">AutoHub</span> — Booking Online.
                All rights reserved.
                Developed by CJR Team (Kelompok 2 - Golongan E - Teknik Informatika)
            </p>
        </div>
    </footer>


    <script>
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.10
        });
        revealEls.forEach(el => observer.observe(el));
    </script>

</body>

</html>