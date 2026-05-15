<?php

use App\Core\Auth;

$user = Auth::user('customer');
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$navItems = [
    ['href' => '/dashboard',         'label' => 'Dashboard'],
    ['href' => '/history-booking',   'label' => 'History'],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/app.css" rel="stylesheet" />
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }

        /* Active nav link */
        .nav-link-active {
            color: #09090b;
            background-color: #f4f4f5;
        }
    </style>
</head>

<body class="min-h-screen bg-white">

    <!-- Top Navbar -->
    <header class="sticky top-0 z-50 w-full bg-white border-b border-zinc-200 print:hidden">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">

                <!-- Brand -->
                <a href="/customer" class="flex items-center gap-2.5 flex-shrink-0">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                    </div>
                    <span class="text-base font-semibold text-zinc-950 tracking-tight">AutoHub</span>
                </a>

                <!-- Right side: Nav + User + Mobile Toggle -->
                <div class="flex items-center gap-2 md:gap-4">

                    <!-- Desktop Nav Links -->
                    <nav id="desktop-nav" class="hidden md:flex items-center gap-1">
                        <?php
                        foreach ($navItems as $item):
                            $isActive = $currentPath === $item['href'];
                        ?>
                            <a href="<?= $item['href'] ?>"
                                class="px-3 py-1.5 text-sm font-medium rounded-md transition-all active:scale-95
                                    <?= $isActive
                                        ? 'text-zinc-950 bg-zinc-100'
                                        : 'text-zinc-700 hover:text-zinc-950 hover:bg-zinc-50' ?>">
                                <?= $item['label'] ?>
                            </a>
                        <?php endforeach; ?>
                    </nav>

                    <!-- User pill (desktop) -->
                    <div class="hidden md:block relative">
                        <button id="user-pill-btn" type="button"
                            class="flex items-center gap-2.5 h-8 pl-1 pr-2.5 rounded-full border border-zinc-200 bg-white cursor-pointer text-left hover:bg-zinc-50 transition-all active:scale-95">
                            <div class="w-6 h-6 rounded-full bg-zinc-950 flex items-center justify-center text-white text-[10px] font-semibold flex-shrink-0">
                                <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                            </div>
                            <svg id="user-chevron" class="w-3 h-3 text-zinc-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="user-dropdown" class="absolute top-full right-0 mt-1.5 min-w-[210px] bg-white border border-zinc-200 rounded-2xl p-1.5 z-[100] opacity-0 invisible -translate-y-2 scale-95 transition-all duration-200 pointer-events-none shadow-xl">
                            <!-- User info row -->
                            <div class="flex items-center gap-2.5 p-2 mb-1">
                                <div class="w-8 h-8 rounded-full bg-zinc-900 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                    <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-zinc-950 truncate m-0 leading-tight">
                                        <?= htmlspecialchars($user['fullname'] ?? '') ?>
                                    </p>
                                    <p class="text-xs text-zinc-500 truncate m-0">
                                        <?= htmlspecialchars($user['email'] ?? '') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="h-px bg-zinc-100 mx-0.5 mb-1"></div>

                            <!-- Logout -->
                            <form method="POST" action="/logout">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors active:scale-[0.98] text-left">
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
                        class="md:hidden flex items-center justify-center w-8 h-8 rounded-md text-zinc-400 hover:bg-zinc-50 hover:text-zinc-950 transition-colors"
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
        <div id="mobile-menu" class="md:hidden border-t border-zinc-200 bg-white overflow-hidden max-h-0 opacity-0 transition-all duration-300">
            <div class="px-4 py-3 space-y-1">
                <?php foreach ($navItems as $item):
                    $isActive = $currentPath === $item['href'];
                ?>
                    <a href="<?= $item['href'] ?>"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                            <?= $isActive
                                ? 'text-zinc-950 bg-zinc-100'
                                : 'text-zinc-700 hover:text-zinc-950 hover:bg-zinc-50' ?>">
                        <?= $item['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- User row on mobile -->
            <div class="px-4 pb-3 pt-1 border-t border-zinc-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-zinc-950 flex items-center justify-center text-white text-[10px] font-semibold">
                        <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                    </div>
                    <span class="text-sm font-medium text-zinc-900">
                        <?= htmlspecialchars($user['fullname'] ?? 'Pengguna') ?>
                    </span>
                </div>
                <form method="POST" action="/logout">
                    <?= csrf_field() ?>
                    <button type="submit"
                        class="text-xs font-medium px-2.5 py-1.5 rounded-md border border-zinc-200 text-zinc-400 hover:bg-zinc-50 hover:text-zinc-950 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <script>
        // ── Mobile menu toggle ──
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.contains('!max-h-[400px]');
            if (isOpen) {
                menu.classList.remove('!max-h-[400px]', '!opacity-100', 'pb-4');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            } else {
                menu.classList.add('!max-h-[400px]', '!opacity-100', 'pb-4');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
        });

        // ── User dropdown toggle ──
        const userBtn = document.getElementById('user-pill-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userChevron = document.getElementById('user-chevron');

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = userDropdown.classList.contains('!opacity-100');
            if (isOpen) {
                userDropdown.classList.remove('!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto');
                userChevron.classList.remove('rotate-180');
            } else {
                userDropdown.classList.add('!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto');
                userChevron.classList.add('rotate-180');
            }
        });

        // Close when clicking anywhere else
        document.addEventListener('click', () => {
            userDropdown.classList.remove('!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto');
            userChevron.classList.remove('rotate-180');
        });

        // Prevent dropdown from closing when clicking inside it
        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    </script>