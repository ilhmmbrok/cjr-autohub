<?php

use App\Core\Auth;

$user = Auth::user('customer');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Mobile menu transition */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease, opacity 0.2s ease;
            opacity: 0;
        }

        #mobile-menu.open {
            max-height: 400px;
            opacity: 1;
        }

        /* Active nav link */
        .nav-link-active {
            color: #18181b;
            background-color: #f4f4f5;
        }

        #desktop-nav .nav-pill {
            position: relative;
            transition: color .18s ease;
            -webkit-tap-highlight-color: transparent;
        }

        .nav-pill::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 8px;
            background: #f4f4f5;
            opacity: 0;
            transform: scale(.88);
            transition: opacity .18s ease, transform .2s cubic-bezier(.34, 1.4, .64, 1);
        }

        #desktop-nav .nav-pill:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        #desktop-nav .nav-pill:active::before {
            transform: scale(.94);
            transition-duration: .08s;
        }

        #desktop-nav .nav-pill span {
            position: relative;
            z-index: 1;
        }

        /* ── User Dropdown ── */
        #user-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            min-width: 210px;
            background: #ffffff;
            border: 0.5px solid #e4e4e7;
            border-radius: 12px;
            padding: 6px;
            z-index: 100;

            /* hidden state */
            opacity: 0;
            transform: translateY(-6px) scale(0.97);
            pointer-events: none;
            transition: opacity 0.15s ease, transform 0.15s cubic-bezier(.34, 1.4, .64, 1);

            box-shadow:
                0 4px 16px rgba(0, 0, 0, 0.08),
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        #user-dropdown.open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        #user-chevron {
            transition: transform 0.15s ease;
        }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            font-size: 12px;
            font-weight: 500;
            color: #dc2626;
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: left;
            transition: background-color 0.12s ease, color 0.12s ease;
        }

        .btn-logout:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }
    </style>
</head>

<body class="bg-zinc-50 min-h-screen">

    <!-- Top Navbar -->
    <header class="sticky top-0 z-50 w-full bg-white border-b border-zinc-200">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">

                <!-- Brand -->
                <a href="/customer" class="flex items-center gap-2.5 flex-shrink-0">
                    <div class="w-7 h-7 rounded-lg bg-zinc-900 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-zinc-900 tracking-tight">AutoHub</span>
                </a>

                <!-- Desktop Nav Links (center) -->
                <nav id="desktop-nav" class="hidden md:flex items-center gap-1">
                    <?php
                    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $navItems = [
                        ['href' => '/dashboard',         'label' => 'Dashboard'],
                        ['href' => '/create-booking',    'label' => 'Buat Booking'],
                        ['href' => '/history-booking',   'label' => 'History Booking'],
                    ];
                    foreach ($navItems as $item):
                        $isActive = $currentPath === $item['href'];
                    ?>
                        <a href="<?= $item['href'] ?>"
                            class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors
                                   <?= $isActive
                                        ? 'text-zinc-900 bg-zinc-100'
                                        : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' ?>">
                            <?= $item['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <!-- Right side: User + Mobile Toggle -->
                <div class="flex items-center gap-2">

                    <!-- User pill (desktop) -->
                    <div class="hidden md:block relative">
                        <button id="user-pill-btn" type="button"
                            class="flex items-center gap-2.5 h-8 pl-1 pr-2.5 rounded-full border border-zinc-200 bg-white cursor-pointer text-left hover:bg-zinc-50 transition-colors">
                            <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-white text-[10px] font-semibold flex-shrink-0">
                                <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                            </div>
                            <span class="text-xs font-medium text-zinc-700 max-w-[120px] truncate">
                                <?= htmlspecialchars($user['fullname'] ?? '') ?>
                            </span>
                            <svg id="user-chevron" class="w-3 h-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="user-dropdown">
                            <!-- User info row -->
                            <div style="display:flex; align-items:center; gap:10px; padding:8px; margin-bottom:4px;">
                                <div style="width:32px; height:32px; border-radius:50%; background:#18181b; display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:600; flex-shrink:0;">
                                    <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div style="min-width:0;">
                                    <p style="font-size:12px; font-weight:600; color:#18181b; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        <?= htmlspecialchars($user['fullname'] ?? '') ?>
                                    </p>
                                    <p style="font-size:11px; color:#a1a1aa; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        <?= htmlspecialchars($user['email'] ?? '') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div style="height:0.5px; background:#f4f4f5; margin:0 2px 4px;"></div>

                            <!-- Logout -->
                            <form method="POST" action="/logout">
                                <button type="submit" class="btn-logout">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile hamburger -->
                    <button id="menu-toggle" type="button"
                        class="md:hidden flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors"
                        aria-label="Toggle menu">
                        <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="md:hidden border-t border-zinc-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <?php foreach ($navItems as $item):
                    $isActive = $currentPath === $item['href'];
                ?>
                    <a href="<?= $item['href'] ?>"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                               <?= $isActive
                                    ? 'text-zinc-900 bg-zinc-100'
                                    : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' ?>">
                        <?= $item['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- User row on mobile -->
            <div class="px-4 pb-3 pt-1 border-t border-zinc-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-zinc-800 flex items-center justify-center text-white text-[10px] font-semibold">
                        <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                    </div>
                    <span class="text-sm font-medium text-zinc-700">
                        <?= htmlspecialchars($user['fullname'] ?? 'Pengguna') ?>
                    </span>
                </div>
                <form method="POST" action="/logout">
                    <button type="submit"
                        class="text-xs font-medium px-2.5 py-1.5 rounded-md border border-zinc-200 text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <script>
        // ── Mobile menu toggle ──
        const toggle   = document.getElementById('menu-toggle');
        const menu     = document.getElementById('mobile-menu');
        const iconOpen  = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('open');
            iconOpen.classList.toggle('hidden', isOpen);
            iconClose.classList.toggle('hidden', !isOpen);
        });

        // ── User dropdown toggle ──
        const userBtn      = document.getElementById('user-pill-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userChevron  = document.getElementById('user-chevron');

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = userDropdown.classList.toggle('open');
            userChevron.style.transform = isOpen ? 'rotate(180deg)' : '';
        });

        // Close when clicking anywhere else
        document.addEventListener('click', () => {
            userDropdown.classList.remove('open');
            userChevron.style.transform = '';
        });

        // Prevent dropdown from closing when clicking inside it
        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    </script>

    <!-- Page content goes here -->
</body>

</html>