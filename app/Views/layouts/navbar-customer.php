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
                <nav class="hidden md:flex items-center gap-1">
                    <?php
                    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $navItems = [
                        ['href' => '/dashboard',         'label' => 'Dashboard'],
                        ['href' => '/history', 'label' => 'Riwayat Booking'],
                        ['href' => '/create',           'label' => 'Buat Booking'],
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
                    <!-- User info (desktop) -->
                    <div class="px-3 py-4 border-t border-slate-200">
                <div id="user-footer" class="flex items-center gap-3 px-3 py-2 rounded-lg">
                    <div id="user-avatar" class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold shrink-0">
                            <?= strtoupper(substr($user['fullname'] ?? 'C', 0, 1)) ?>
                        </div>
                        <div id="user-info" class="flex-1 min-w-0 sidebar-label">
                            <p class="text-[12px] font-medium text-slate-900 truncate"><?= htmlspecialchars($user['fullname'] ?? '') ?></p>
                            <p class="text-[10px] text-slate-400 truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        </div>
                    </div>
                    <form method="POST" action="/logout">
                        <button type="submit" title="Logout"
                            class="p-1.5 rounded-md text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors cursor-pointer shrink-0">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
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
                    <div class="w-7 h-7 rounded-full bg-zinc-200 flex items-center justify-center">
                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-zinc-700">
                        <?= htmlspecialchars($_SESSION['name'] ?? 'Pengguna') ?>
                    </span>
                </div>
                <a href="/logout"
                    class="text-xs font-medium px-2.5 py-1.5 rounded-md border border-zinc-200 text-zinc-500 hover:bg-zinc-50 hover:text-zinc-700 transition-colors">
                    Keluar
                </a>
            </div>
        </div>
    </header>

    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('open');
            iconOpen.classList.toggle('hidden', isOpen);
            iconClose.classList.toggle('hidden', !isOpen);
        });
    </script>

    <!-- Page content goes here -->
