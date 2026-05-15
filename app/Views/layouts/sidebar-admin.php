<?php

use App\Core\Auth;

$user = Auth::user('admin');
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php echo '<link rel="icon" href="/assets/autohub.webp" type="image/x-icon"/>' ?>
    <link href="/css/app.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.bunny.net/css?family=instrument-sans:400,500,600');

        * {
            font-family: 'Instrument Sans', sans-serif;
        }

        /* Sidebar transition */
        #sidebar {
            width: 256px;
            transition: width 220ms cubic-bezier(0.4, 0, 0.2, 1);
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #sidebar.collapsed {
            width: 64px !important;
        }

        /* Labels & text fade */
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

        #sidebar.collapsed .sidebar-section-label {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .sidebar-section-label {
            transition: opacity 150ms ease, height 150ms ease, padding 150ms ease;
        }

        /* Tooltip on collapsed */
        .nav-item {
            position: relative;
        }

        #sidebar.collapsed .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #09090b;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 100ms ease;
            z-index: 50;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        #sidebar.collapsed .nav-item:hover::after {
            opacity: 1;
        }

        /* Toggle button spin */
        #toggle-btn svg {
            transition: transform 220ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar.collapsed #toggle-btn svg {
            transform: rotate(180deg);
        }

        /* User info fade */
        #sidebar.collapsed #user-info {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        #user-info {
            transition: opacity 150ms ease, width 150ms ease;
            overflow: hidden;
        }

        /* Logout button adjustment when collapsed */
        #sidebar.collapsed #user-footer {
            justify-content: center;
        }

        #user-footer {
            transition: justify-content 220ms ease;
        }

        /* Hide avatar when collapsed */
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

<body class="bg-zinc-50 text-zinc-950">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 shrink-0 bg-white border-r border-zinc-200 flex flex-col print:hidden" style="position: sticky; top: 0; height: 100vh; overflow-y: auto; overflow-x: hidden; flex-shrink: 0;">

            <!-- Logo + Toggle -->
            <div class="px-4 py-5 border-b border-zinc-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5 sidebar-label">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                    </div>
                    <span class="text-base font-bold text-zinc-950 tracking-tight">AutoHub</span>
                </div>

                <!-- Collapsed: show only logo icon -->
                <div class="hidden-when-expanded w-7 h-7 rounded-lg bg-blue-600 items-center justify-center shrink-0" style="display:none">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>

                <!-- Toggle Button -->
                <button id="toggle-btn"
                    class="ml-auto p-1.5 rounded-md text-zinc-400 hover:text-zinc-950 hover:bg-zinc-100 transition-colors shrink-0"
                    title="Toggle sidebar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-4 space-y-1">

                <p class="sidebar-section-label px-3 pt-2 pb-1 text-xs font-semibold text-zinc-400 uppercase tracking-wider">Menu</p>

                <a href="/admin/dashboard"
                    data-tooltip="Dashboard"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 active:scale-[0.98]
                    <?= $path === '/admin/dashboard' ? 'bg-zinc-100 text-zinc-950' : 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-950' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <a href="/admin/daftar-booking"
                    data-tooltip="Daftar Booking"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 active:scale-[0.98]
                    <?= $path === '/admin/daftar-booking' ? 'bg-zinc-100 text-zinc-950' : 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-950' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                    </svg>

                    <span class="sidebar-label">Daftar Booking</span>
                </a>
                <a href="/admin/jadwal"
                    data-tooltip="Jadwal Operasional"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 active:scale-[0.98]
                    <?= $path === '/admin/jadwal' ? 'bg-zinc-100 text-zinc-950' : 'text-zinc-700 hover:bg-zinc-100 hover:text-zinc-950' ?>">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>

                    <span class="sidebar-label">Jadwal Operasional</span>
                </a>

            </nav>

            <!-- User & Logout -->
            <div class="px-3 py-4 border-t border-zinc-200">
                <div id="user-footer" class="flex items-center gap-3 px-3 py-2 rounded-lg">
                    <!-- Avatar — hidden when collapsed -->
                    <div id="user-avatar" class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-zinc-950 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                            <?= strtoupper(substr($user['fullname'] ?? 'A', 0, 1)) ?>
                        </div>
                        <div id="user-info" class="flex-1 min-w-0 sidebar-label">
                            <p class="text-sm font-medium text-zinc-950 truncate"><?= htmlspecialchars($user['fullname'] ?? 'Admin') ?></p>
                            <p class="text-xs text-zinc-400 truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        </div>
                    </div>
                    <form method="POST" action="/logout">
                        <?= csrf_field() ?>
                        <button type="submit" title="Logout"
                            class="p-1.5 rounded-md text-zinc-400 hover:text-red-600 hover:bg-zinc-100 transition-colors cursor-pointer shrink-0">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Content Wrapper -->
        <div id="main-content-area" class="flex-1 flex flex-col min-w-0">

            <script>
                (function() {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('toggle-btn');
                    const STORAGE_KEY = 'autohub_sidebar_collapsed';

                    // Restore state dari localStorage
                    try {
                        const isCollapsed = localStorage.getItem(STORAGE_KEY) === 'true';
                        if (isCollapsed) sidebar.classList.add('collapsed');
                    } catch(e) {}

                    toggleBtn.addEventListener('click', () => {
                        const collapsed = sidebar.classList.toggle('collapsed');
                        try { localStorage.setItem(STORAGE_KEY, collapsed); } catch(e) {}
                    });
                })();
            </script>