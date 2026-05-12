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
            transition: width 220ms cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
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

<body class="bg-zinc-50 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 shrink-0 bg-white border-r border-slate-200 flex flex-col relative">

            <!-- Logo + Toggle -->
            <div class="px-4 py-5 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5 sidebar-label">
                    <div class="w-8 h-8 rounded-lg  flex items-center justify-center shrink-0">
                        <?php echo '<img src="/assets/autohub.webp" alt="AutoHub Logo"/>' ?>
                    </div>
                    <span class="text-base font-bold text-slate-900 tracking-tight">AutoHub</span>
                </div>

                <!-- Collapsed: show only logo icon -->
                <div class="hidden-when-expanded w-7 h-7 rounded-lg bg-blue-600 items-center justify-center shrink-0" style="display:none">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>

                <!-- Toggle Button -->
                <button id="toggle-btn"
                    class="ml-auto p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors shrink-0"
                    title="Toggle sidebar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-4 space-y-0.5">

                <p class="sidebar-section-label px-3 pt-2 pb-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu</p>

                <a href="/admin/dashboard"
                    data-tooltip="Dashboard"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                    <?= $path === '/admin' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <a href="/admin/daftar-booking"
                    data-tooltip="Daftar Booking"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                    <?= $path === '/admin/booking' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="sidebar-label">Daftar Booking</span>
                </a>
                <a href="/admin/jadwal"
                    data-tooltip="Jadwal Operasional"
                    class="nav-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                    <?= $path === '/admin/jadwal' ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="sidebar-label">Jadwal Operasional</span>
                </a>

            </nav>

            <!-- User & Logout -->
            <div class="px-3 py-4 border-t border-slate-200">
                <div id="user-footer" class="flex items-center gap-3 px-3 py-2 rounded-lg">
                    <!-- Avatar — hidden when collapsed -->
                    <div id="user-avatar" class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-semibold shrink-0">
                            <?= strtoupper(substr($user['fullname'] ?? 'A', 0, 1)) ?>
                        </div>
                        <div id="user-info" class="flex-1 min-w-0 sidebar-label">
                            <p class="text-sm font-medium text-slate-900 truncate"><?= htmlspecialchars($user['fullname'] ?? 'Admin') ?></p>
                            <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                        </div>
                    </div>
                    <form method="POST" action="/logout">
                        <button type="submit" title="Logout"
                            class="p-1.5 rounded-md text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors cursor-pointer shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">

            <script>
                (function() {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('toggle-btn');
                    const STORAGE_KEY = 'autohub_sidebar_collapsed';

                    // Restore state from localStorage
                    const isCollapsed = localStorage.getItem(STORAGE_KEY) === 'true';
                    if (isCollapsed) {
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