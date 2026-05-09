<?php

use App\Core\Auth;

$user = Auth::user('customer');
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }

        #sidebar {
            transition: width 220ms cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar-label {
            transition: opacity 150ms ease, width 150ms ease;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-label {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        .sidebar-section-label {
            transition: opacity 150ms ease, height 150ms ease, padding 150ms ease;
        }

        #sidebar.collapsed .sidebar-section-label {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .nav-item {
            position: relative;
        }

        #sidebar.collapsed .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #f8fafc;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 100ms ease;
            z-index: 50;
        }

        #sidebar.collapsed .nav-item:hover::after {
            opacity: 1;
        }

        #toggle-btn svg {
            transition: transform 220ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar.collapsed #toggle-btn svg {
            transform: rotate(180deg);
        }

        #user-info {
            transition: opacity 150ms ease, width 150ms ease;
            overflow: hidden;
        }

        #sidebar.collapsed #user-info {
            opacity: 0;
            width: 0;
        }

        #user-footer {
            transition: justify-content 220ms ease;
        }

        #sidebar.collapsed #user-footer {
            justify-content: center;
        }

        #user-avatar {
            transition: opacity 150ms ease, width 150ms ease, margin 150ms ease;
        }

        #sidebar.collapsed #user-avatar {
            opacity: 0;
            width: 0;
            overflow: hidden;
            margin: 0;
        }
    </style>
</head>

<body class="bg-zinc-50 min-h-screen">
    <div class="flex min-h-screen">

        <aside id="sidebar" class="w-64 shrink-0 bg-white border-r border-slate-200 flex flex-col relative">

            <div class="px-4 py-5 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5 sidebar-label">
                    <div class="w-8 h-8 rounded-lg  flex items-center justify-center shrink-0">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                    </div>
                    <span class="text-base font-bold text-slate-900 tracking-tight">AutoHub</span>
                </div>
                <button id="toggle-btn"
                    class="ml-auto p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors shrink-0"
                    title="Toggle sidebar">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-0.5">
                <p class="sidebar-section-label px-3 pt-2 pb-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu</p>

                <a href="/dashboard"
                    data-tooltip="Dashboard"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                <?= $currentPath === '/dashboard' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <a href="/create"
                    data-tooltip="Create Booking"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                <?= $currentPath === '/create' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    <span class="sidebar-label">Buat Booking</span>
                </a>

                <a href="/history"
                    data-tooltip="History"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                <?= $currentPath === '/history' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="sidebar-label">Riwayat</span>
                </a>
            </nav>

            <div class="px-3 py-4 border-t border-slate-200">
                <div id="user-footer" class="flex items-center gap-3 px-3 py-2 rounded-lg">
                    <div id="user-avatar" class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold shrink-0">
                            <?= strtoupper(substr($user['fullname'] ?? 'C', 0, 1)) ?>
                        </div>
                        <div id="user-info" class="flex-1 min-w-0 sidebar-label">
                            <p class="text-sm font-medium text-slate-900 truncate"><?= htmlspecialchars($user['fullname'] ?? '') ?></p>
                            <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
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

        </aside>

        <div class="flex-1 flex flex-col min-w-0">

            <script>
                (function() {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('toggle-btn');
                    const STORAGE_KEY = 'autohub_sidebar_collapsed';
                    if (localStorage.getItem(STORAGE_KEY) === 'true') {
                        sidebar.classList.add('collapsed');
                        sidebar.style.width = '64px';
                    }
                    toggleBtn.addEventListener('click', () => {
                        const collapsed = sidebar.classList.toggle('collapsed');
                        sidebar.style.width = collapsed ? '64px' : '256px';
                        localStorage.setItem(STORAGE_KEY, collapsed);
                    });
                })();
            </script>