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
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #25bf33;
            --green-dark: #1ea52b;
            --green-light: #d1fad5;
            --green-mid: #a3f0a9;
        }

        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.72)), url('/assets/background.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .green { color: var(--green); }
        .bg-green-custom { background-color: var(--green); }
        .hover-green:hover { background-color: var(--green-dark); }
        .hover-outline:hover { border-color: var(--green); color: var(--green); }

        /* ===== NAVBAR ===== */
        nav {
            background: transparent;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .logo-wrap { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .logo-wrap img { width: 40px; height: 40px; }
        .logo-wrap h1 { font-size: 1.05rem; font-weight: 800; color: #fff; line-height: 1.2; }
        .logo-wrap p { font-size: 0.70rem; color: #c8c8c8; margin-top: -2px; }

        .nav-btns { display: flex; gap: 8px; flex-shrink: 0; }
        .btn-outline {
            padding: 8px 18px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            border-radius: 14px;
            border: 1.5px solid rgba(255,255,255,0.22);
            background: transparent;
            text-decoration: none;
            transition: background 0.18s;
            white-space: nowrap;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.10); }
        .btn-solid {
            padding: 8px 18px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            border-radius: 14px;
            background: var(--green);
            border: none;
            text-decoration: none;
            transition: background 0.18s;
            white-space: nowrap;
        }
        .btn-solid:hover { background: var(--green-dark); }

        /* ===== HERO ===== */
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 48px 24px 60px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.20);
            color: #fff;
            font-size: 0.80rem;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green);
            flex-shrink: 0;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.6rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.10;
            letter-spacing: -1.5px;
        }
        .hero-title .accent { color: var(--green); }

        .hero-desc {
            margin-top: 20px;
            font-size: 1rem;
            color: #d4d4d4;
            line-height: 1.7;
            max-width: 480px;
        }

        .hero-cta {
            margin-top: 32px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-hero-primary {
            padding: 13px 28px;
            font-size: 0.90rem;
            font-weight: 700;
            color: #fff;
            border-radius: 18px;
            background: var(--green);
            text-decoration: none;
            transition: background 0.18s, transform 0.15s;
        }
        .btn-hero-primary:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-hero-secondary {
            padding: 13px 28px;
            font-size: 0.90rem;
            font-weight: 700;
            color: #fff;
            border-radius: 18px;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.22);
            text-decoration: none;
            backdrop-filter: blur(8px);
            transition: background 0.18s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.16); }

        /* ===== HERO MOCKUP ===== */
        .hero-right { display: flex; 
            justify-content: center; 
            position: relative; 
        }

        .glow-1 {
            position: absolute; top: 30px; right: 20px;
            width: 160px; height: 160px;
            background: rgba(37, 191, 51, 0.18);
            border-radius: 50%; filter: blur(48px);
            pointer-events: none;
        }
        
        .glow-2 {
            position: absolute; bottom: 0; left: 0;
            width: 140px; height: 140px;
            background: rgba(37, 191, 51, 0.12);
            border-radius: 50%; filter: blur(44px);
            pointer-events: none;
        }

        .mockup-wrap {
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            height: 480px;
            width: 100%;
            max-width: 420px;
        }

        .phone { position: absolute; }
        .phone-back {
            left: 0;
            bottom: 0;
            transform: rotate(-4deg) translateY(-20px);
            z-index: 1;
        }
        .phone-front {
            right: 0;
            bottom: 0;
            transform: rotate(3deg);
            z-index: 2;
        }
        .phone-frame {
            width: 195px;
            background: transparent;
            border-radius: 36px;
            padding: 0;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .phone-screen {
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            min-height: 390px;
        }
        .phone-screen::after { display: none !important; }
        .phone-screen-img {
            background: transparent !important;
            padding: 0;
            overflow: hidden;
            border-radius: 28px;
            min-height: unset;
            line-height: 0;
        }
        .mockup-screen-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            border-radius: 28px;
            display: block;
        }

        /* ===== DIVIDER ===== */
        .section-divider { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .divider-line { border: none; border-top: 1px solid rgba(255,255,255,0.10); margin: 0; }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 24px 56px;
        }

        .section-header { text-align: center; margin-bottom: 44px; }
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37,191,51,0.13);
            border: 1px solid rgba(37,191,51,0.25);
            border-radius: 999px;
            padding: 5px 16px;
            font-size: 0.78rem;
            font-weight: 700;
            color: #6ee87a;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(1.6rem, 3.5vw, 2.6rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
            line-height: 1.15;
        }
        .section-title .accent { color: var(--green); }
        .section-desc {
            margin-top: 12px;
            color: #a0a0a0;
            font-size: 0.95rem;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.65;
        }

        /* Feature Grid — 4 cards: 2x2 */
        .feat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 960px;
            margin: 0 auto;
        }

        .feat-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 22px;
            padding: 28px 24px;
            transition: background 0.22s, border-color 0.22s, transform 0.18s;
            cursor: default;
        }
        .feat-card:hover {
            background: rgba(37,191,51,0.07);
            border-color: rgba(37,191,51,0.30);
            transform: translateY(-3px);
        }
        .feat-card-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: rgba(37,191,51,0.14);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
        }
        .feat-card-icon svg { color: var(--green); width: 24px; height: 24px; }
        .feat-card-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .feat-card-desc { font-size: 0.85rem; color: #9ca3af; line-height: 1.65; }

        /* ===== STEPS SECTION ===== */
        .steps-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px 60px;
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .step-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 22px;
            padding: 28px 18px;
            text-align: center;
            transition: background 0.2s, border-color 0.2s;
        }
        .step-card:hover { background: rgba(37,191,51,0.06); border-color: rgba(37,191,51,0.22); }
        .step-num {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: var(--green);
            color: #fff;
            font-size: 1rem;
            font-weight: 900;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .step-title { font-size: 0.92rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
        .step-desc { font-size: 0.81rem; color: #9ca3af; line-height: 1.6; }

        /* ===== CTA BANNER ===== */
        .cta-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px 56px;
        }
        .cta-banner {
            background: linear-gradient(135deg, rgba(37,191,51,0.18) 0%, rgba(37,191,51,0.06) 100%);
            border: 1px solid rgba(37,191,51,0.28);
            border-radius: 28px;
            padding: 52px 40px;
            text-align: center;
        }
        .cta-title { font-size: clamp(1.4rem, 3vw, 2.1rem); font-weight: 900; color: #fff; margin-bottom: 12px; }
        .cta-desc { color: #b0b0b0; font-size: 0.95rem; max-width: 600px; margin: 0 auto 28px; line-height: 1.6; }
        .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* ===== FOOTER ===== */
        footer {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 20px 24px;
            text-align: center;
        }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-text { color: #666; font-size: 0.82rem; }
        .footer-text span { color: var(--green); font-weight: 700; }

        /* ===== RESPONSIVE ===== */

        /* Tablet landscape */
        @media (max-width: 1024px) {
            .hero { gap: 40px; }
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* Tablet portrait / large mobile */
        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 36px;
                padding: 36px 20px 48px;
                text-align: center;
            }
            .hero-desc { max-width: 100%; margin-left: auto; margin-right: auto; }
            .hero-cta { justify-content: center; }
            .badge { display: inline-flex; }
            .hero-right { justify-content: center; }

            .mockup-wrap { height: 380px; max-width: 340px; }
            .phone-frame { width: 155px; }
            .phone-screen { min-height: 310px; }

            .feat-grid { max-width: 100%; }
        }

        /* Mobile */
        @media (max-width: 600px) {
            /* Navbar */
            .logo-wrap p { display: none; }
            .btn-outline { padding: 7px 14px; font-size: 0.78rem; }
            .btn-solid  { padding: 7px 14px; font-size: 0.78rem; }

            /* Hero */
            .hero { padding: 28px 16px 40px; gap: 28px; }
            .badge { font-size: 0.74rem; padding: 6px 13px; }
            .hero-cta { gap: 10px; }
            .btn-hero-primary,
            .btn-hero-secondary { width: 100%; text-align: center; padding: 13px 20px; }

            /* Mockup */
            .mockup-wrap { height: 300px; max-width: 280px; }
            .phone-frame { width: 125px; }
            .phone-screen { min-height: 250px; }

            /* Features */
            .features-section { padding: 40px 16px 40px; }
            .feat-grid { grid-template-columns: 1fr; gap: 14px; }
            .section-header { margin-bottom: 32px; }

            /* Steps */
            .steps-section { padding: 0 16px 48px; }
            .steps-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
            .step-card { padding: 22px 14px; }

            /* CTA */
            .cta-section { padding: 0 16px 44px; }
            .cta-banner { padding: 36px 20px; border-radius: 20px; }
            .cta-btns { flex-direction: column; align-items: center; }
            .cta-btns .btn-hero-primary,
            .cta-btns .btn-hero-secondary { width: 100%; max-width: 320px; }

            /* Footer */
            footer { padding: 16px 16px; }
        }

        /* Very small phones */
        @media (max-width: 380px) {
            .steps-grid { grid-template-columns: 1fr; }
            .mockup-wrap { height: 260px; max-width: 240px; }
            .phone-frame { width: 108px; }
            .phone-screen { min-height: 220px; }
        }
    </style>

    <title>AutoHub — Booking Bengkel Online</title>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav>
        <div class="nav-inner">
            <div class="logo-wrap">
                <div>
                    <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                </div>
                <div>
                    <h1>AutoHub</h1>
                    <p>Booking Online</p>
                </div>
            </div>
            <div class="nav-btns">
                <a href="/login" class="btn-outline">Sign In</a>
                <a href="/register" class="btn-solid">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero">

        <!-- Left -->
        <div>
            <div class="badge">
                <div class="badge-dot"></div>
                Layanan Booking Online AutoHub
            </div>

            <h2 class="hero-title">
                Booking Servis
                <span class="accent">Lebih Mudah</span>
                &amp; Cepat
            </h2>

            <p class="hero-desc">
               AutoHub menghadirkan kemudahan booking servis kendaraan secara online tanpa perlu antre, 
               dengan sistem yang modern, praktis, dan mudah digunakan.
            </p>

            <div class="hero-cta">
                <a href="/register" class="btn-hero-primary">Daftar Sekarang</a>
                <a href="/login" class="btn-hero-secondary">Masuk</a>
            </div>
        </div>

        <!-- Right — Mockup -->
        <div class="hero-right">
            <div class="glow-1"></div>
            <div class="glow-2"></div>

            <div class="mockup-wrap">
                <div class="phone phone-back">
                    <div class="phone-frame">
                        <div class="phone-screen phone-screen-img">
                            <?php echo '<img src="/assets/dashboard.png" alt="Dashboard AutoHub" class="mockup-screen-img"/>' ?>
                        </div>
                    </div>
                </div>
                <div class="phone phone-front">
                    <div class="phone-frame">
                        <div class="phone-screen phone-screen-img">
                            <?php echo '<img src="/assets/detailBooking.png" alt="Detail Booking AutoHub" class="mockup-screen-img"/>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="section-divider"><hr class="divider-line"/></div>

    <!-- ===== CARA BOOKING ===== -->
    <section class="steps-section" style="padding-top: 48px;">
        <div class="section-header">
            <div class="section-eyebrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Cara Mudah Booking
            </div>
            <h2 class="section-title">Servis dalam <span class="accent">4 Langkah</span></h2>
            <p class="section-desc">Proses booking yang simpel, cepat, dan bisa dilakukan dari mana saja.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <div class="step-title">Daftar Akun</div>
                <p class="step-desc">Buat akun gratis dengan email atau nomor HP-mu dalam hitungan detik.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <div class="step-title">Pilih Layanan</div>
                <p class="step-desc">Tentukan jenis servis yang dibutuhkan kendaraanmu dari daftar layanan yang tersedia.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <div class="step-title">Atur Jadwal</div>
                <p class="step-desc">Pilih tanggal dan jam yang paling cocok dengan aktivitas harianmu.</p>
            </div>
            <div class="step-card">
                <div class="step-num">4</div>
                <div class="step-title">Datang & Selesai</div>
                <p class="step-desc">Datang tepat waktu, kendaraanmu langsung diproses tanpa antre panjang.</p>
            </div>
        </div>
    </section>

    <!-- ===== FITUR CUSTOMER ===== -->
    <section class="features-section">
        <div class="section-header">
            <div class="section-eyebrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/></svg>
                Fitur untuk Customer
            </div>
            <h2 class="section-title">Semua yang Kamu Butuhkan <span class="accent">Ada di Sini</span></h2>
            <p class="section-desc">
                Dari booking hingga cek status servis, AutoHub hadir
                lengkap untuk memudahkan pengalaman servis kendaraanmu.
            </p>
        </div>

        <div class="feat-grid">
            <div class="feat-card">
                <div class="feat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="feat-card-title">Booking Servis Online</div>
                <p class="feat-card-desc">Atur jadwal servis kendaraanmu dengan cepat tanpa harus datang langsung ke bengkel.</p>
            </div>
            <div class="feat-card">
                <div class="feat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div class="feat-card-title">Status Booking</div>
                <p class="feat-card-desc"> Lihat perkembangan servis kendaraanmu secara langsung dari proses awal hingga selesai.</p>
            </div>
            <div class="feat-card">
                <div class="feat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <div class="feat-card-title">Riwayat Servis</div>
                <p class="feat-card-desc">Semua riwayat servis tersimpan rapi untuk memudahkan pemantauan perawatan kendaraanmu.</p>
            </div>
            <div class="feat-card">
                <div class="feat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="feat-card-title">Pilih Jadwal Fleksibel</div>
                <p class="feat-card-desc">Sesuaikan waktu booking dengan aktivitasmu. Tersedia berbagai slot waktu yang bisa dipilih bebas.</p>
            </div>
        </div>
    </section>

    <div class="section-divider"><hr class="divider-line"/></div>

    <!-- ===== CTA BANNER ===== -->
    <section class="cta-section">
        <div class="cta-banner">
            <h2 class="cta-title">Siap Booking Servis Sekarang?</h2>
            <p class="cta-desc">
                Bergabung bersama AutoHub dan kelola booking servis bengkel anda dengan lebih mudah, 
                cepat, dan praktis. Daftar sekarang dan rasakan kemudahan booking online untuk kendaraanmu!
            </p>
            <div class="cta-btns">
                <a href="/register" class="btn-hero-primary">Daftar Gratis</a>
                <a href="/login" class="btn-hero-secondary">Sudah Punya Akun</a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="footer-inner">
            <span class="footer-text">© 2026 <span>AutoHub</span> — Booking Online. All rights reserved. Developed by CJR Team (Kelompok 2 - Golongan E - Teknik Informatika)</p>
        </div>
    </footer>

</body>

</html>
