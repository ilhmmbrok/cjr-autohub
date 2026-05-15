<?php

use App\Core\Auth;

$user = Auth::user('customer');
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$navItems = [
    ['href' => '/dashboard',       'label' => 'Dashboard', 'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
    ['href' => '/history-booking', 'label' => 'History',   'icon' => '<path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>'],
    ['href' => '/profile',         'label' => 'Profil',    'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
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

        .pill-dropdown {
            transform-origin: top right;
        }
    </style>
</head>

<body class="min-h-screen bg-white">

    <!-- Floating Capsule Navbar -->
    <header class="sticky top-0 z-50 w-full print:hidden">
        <div class="px-4 sm:px-6 lg:px-8 pt-3 pb-1">
            <div class="flex items-center justify-between h-12 px-3 bg-zinc-50/90 backdrop-blur-xl border border-zinc-200/70 rounded-full shadow-[0_1px_2px_rgba(0,0,0,0.04),0_2px_8px_rgba(0,0,0,0.02)]">

                <!-- Brand -->
                <a href="/dashboard" class="flex items-center gap-2 pl-0.5 group">
                    <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0 ring-1 ring-zinc-200/50">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub" class="w-7 h-7 object-cover"/>' ?>
                    </div>
                    <span class="text-[13px] font-semibold text-zinc-950 tracking-tight">AutoHub</span>
                </a>

                <!-- Right: User Pill -->
                <div class="relative">
                    <button id="user-pill-btn" type="button"
                        class="flex items-center gap-2 h-8 pl-1 pr-2.5 rounded-full bg-white border border-zinc-200/60 shadow-[0_1px_2px_rgba(0,0,0,0.04)] cursor-pointer hover:border-zinc-300 hover:shadow-[0_1px_4px_rgba(0,0,0,0.06)] transition-all duration-200 active:scale-[0.97]">
                        <div class="w-6 h-6 rounded-full bg-zinc-950 flex items-center justify-center text-white text-[10px] font-semibold flex-shrink-0">
                            <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                        </div>
                        <span class="text-[13px] font-medium text-zinc-700 max-w-[120px] truncate hidden sm:inline">
                            <?= htmlspecialchars(explode(' ', $user['fullname'] ?? 'User')[0]) ?>
                        </span>
                        <svg id="user-chevron" class="w-3 h-3 text-zinc-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-dropdown" class="pill-dropdown absolute top-full right-0 mt-2.5 w-[240px] bg-white border border-zinc-200/80 rounded-2xl z-[100] opacity-0 invisible -translate-y-1.5 scale-[0.97] transition-all duration-200 ease-out pointer-events-none shadow-[0_8px_30px_rgba(0,0,0,0.08),0_2px_8px_rgba(0,0,0,0.04)]">

                        <!-- User Info -->
                        <div class="flex items-center gap-3 p-3.5 pb-3">
                            <div class="w-9 h-9 rounded-full bg-zinc-950 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                <?= strtoupper(substr($user['fullname'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[13px] font-semibold text-zinc-950 truncate leading-tight">
                                    <?= htmlspecialchars($user['fullname'] ?? '') ?>
                                </p>
                                <p class="text-[11px] text-zinc-400 truncate mt-0.5">
                                    <?= htmlspecialchars($user['email'] ?? '') ?>
                                </p>
                            </div>
                        </div>

                        <div class="h-px bg-zinc-100 mx-3"></div>

                        <!-- Navigation Links -->
                        <div class="p-1.5">
                            <?php foreach ($navItems as $item):
                                $isActive = $currentPath === $item['href'];
                            ?>
                                <a href="<?= $item['href'] ?>"
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] font-medium transition-all duration-150
                                        <?= $isActive
                                            ? 'text-zinc-950 bg-zinc-50'
                                            : 'text-zinc-500 hover:text-zinc-950 hover:bg-zinc-50' ?>">
                                    <svg class="w-4 h-4 flex-shrink-0 <?= $isActive ? 'text-zinc-700' : 'text-zinc-400' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                        <?= $item['icon'] ?>
                                    </svg>
                                    <?= $item['label'] ?>
                                    <?php if ($isActive): ?>
                                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-zinc-950"></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <div class="h-px bg-zinc-100 mx-3"></div>

                        <!-- Logout -->
                        <div class="p-1.5">
                            <form method="POST" action="/logout">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] font-medium text-red-500 hover:bg-red-50 transition-all duration-150 active:scale-[0.98] text-left">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        // ── User dropdown toggle ──
        const userBtn = document.getElementById('user-pill-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userChevron = document.getElementById('user-chevron');

        const openClasses = ['!opacity-100', '!visible', '!translate-y-0', '!scale-100', '!pointer-events-auto'];

        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = userDropdown.classList.contains('!opacity-100');
            if (isOpen) {
                userDropdown.classList.remove(...openClasses);
                userChevron.classList.remove('rotate-180');
            } else {
                userDropdown.classList.add(...openClasses);
                userChevron.classList.add('rotate-180');
            }
        });

        document.addEventListener('click', () => {
            userDropdown.classList.remove(...openClasses);
            userChevron.classList.remove('rotate-180');
        });

        userDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    </script>